<?php
include_once "Models/Users.php";
include_once "Models/Patients.php";
include_once "Controllers/Controller.php";

class NurseMainPageController extends Controller {
    private $conn;
    
    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: nurselogin.php");
            exit();
        }
        $this->conn = Model::connect();
    }

    public function index() {
        $sql = "SELECT u.firstName, u.lastName, u.zipCode, p.problem 
                FROM patients p
                JOIN users u ON p.patientID = u.Id";
        $result = $this->conn->query($sql);
        
        $this->render('NurseMainPage', 'NurseMainPage', [
            'result' => $result,
            'conn' => $this->conn
        ]);
    }

    public function logout() {
        session_destroy();
        header("Location: nurselogin.php");
        exit();
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>

