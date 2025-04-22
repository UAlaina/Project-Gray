<?php
include_once "Models/Model.php";

class Users {
    public $id;
    public $email;
    public $password;
    public $firstName;
    public $lastName;
    public $zipCode;
    public $gender;
    public $description;
    public $createdAt;
    public $updateAt;
    public $DOB;

    function __construct($param = null) {
        if (is_object($param)){
            $this->setProperties($param);
        }
  
        elseif (is_int($param)) {
            $conn = Model::connect();
  
            $sql = "SELECT * FROM `users";
            $stmt = $conn->prepare($sql);
  
            $stmt->bind_param("i",$param);
            $stmt->execute();
  
            $result = $stmt->get_result();
            $row = $result->fetch_object();
  
            $this->setProperties($row);
        }
       
    }
  
    private function setProperties($param) {
        $this->id = $param->id;
        $this->email = $param->email;
        $this->password = $param->password;
        $this->firstName = $param->firstName;
        $this->lastName = $param->lastName;
        $this->zipCode = $param->zipCode;
        $this->gender = $param->gender;
        $this->description = $param->description;
        $this->createdAt = $param->createdAt;
        $this->updateAt = $param->updateAt;
        $this->DOB = $param->DOB;
    }

    public static function authenticate($email, $password) {
        $conn = Model::connect();
        $sql = "SELECT * FROM `users` WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_object()) {
            if (password_verify($password, $row->password)) {
                $user = new Users();
                $user->id = $row->id;
                $user->email = $row->email;
                return $user;
            }
        }
        return null;
    }
  
    public static function list(){
        $list = [];
        $sql = "SELECT * FROM `users`";
  
        $connection = Model::connect();
        $result = $connection->query($sql);
  
        while($row = $result->fetch_object()){
            $users = new Users($row);
            array_push($list, $users);
        }
  
        return $list;
    }
}
?>