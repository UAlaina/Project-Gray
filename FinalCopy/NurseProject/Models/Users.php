<?php
include_once __DIR__ . "/Model.php";

class Users extends Model {
    public $id;
    public $email;
    public $password;
    public $firstName;
    public $lastName;
    public $zipCode;
    public $createdAt;
    public $updateAt;

    function __construct($param = null) {
        if (is_object($param) || is_array($param)) {
            $this->setProperties($param);
        } elseif (is_int($param)) {
            $conn = self::connect();
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->bind_param("i", $param);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_object();
            $this->setProperties($row);
        }
    }

    private function setProperties($param) {
        if (is_object($param)) {
            $this->id = isset($param->id) ? $param->id : ($param->Id ?? null);
            $this->email = $param->email;
            $this->password = $param->password;
            $this->firstName = $param->firstName;
            $this->lastName = $param->lastName;
            $this->zipCode = $param->zipCode;
            $this->createdAt = $param->createdAt;
            $this->updateAt = $param->updatedAt;
        } elseif (is_array($param)) {
            $this->id = isset($param['id']) ? $param['id'] : ($param['Id'] ?? null);
            $this->email = htmlspecialchars($param['email']);
            $this->password = htmlspecialchars($param['password']);
            $this->firstName = htmlspecialchars($param['firstName']);
            $this->lastName = htmlspecialchars($param['lastName']);
            $this->zipCode = htmlspecialchars($param['zipCode']);
            $this->createdAt = $param['createdAt'] ?? null;
            $this->updateAt = $param['updatedAt'] ?? null;
        }
    }

    public static function authenticate($email, $password) {
        $conn = self::connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $hashedPassword = sha1($password);
        $stmt->bind_param("ss", $email, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_object()) {
            return new Users($row);
        }

        return null;
    }

    public static function list() {
        $conn = self::connect();
        $result = $conn->query("SELECT * FROM users");
        $list = [];

        while ($row = $result->fetch_object()) {
            $list[] = new Users($row);
        }

        return $list;
    }
}
