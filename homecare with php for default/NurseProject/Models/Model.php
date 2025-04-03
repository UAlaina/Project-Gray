<?php
class Model{
    
    public static function connect(){
        $server = "localhost";
        $user = "root";
        $pass = "";
        $db = "nurserysystem";
        // $host = 3307;

        $conn = new mysqli($server,$user, $pass, $db);

        if($conn->connect_error){
            die("Connection error! I can't deal with anymore<br>" . $conn->connect_error);

        }
        
        return $conn;
    }
}
?>