<?php
include_once "Models/Users.php";
include_once "Models/Nurse.php";
include_once "Controllers/Controller.php";

class PatientMainPageController extends Controller {
    private $conn;
    
    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: patientlogin.php");
            exit();
        }
        $this->conn = Model::connect();
    }

    public function index() {
        $sql = "SELECT u.firstName, u.lastName, n.gender, u.zipCode, n.years_experience 
                FROM nurse n
                JOIN users u ON n.NurseID = u.Id";
        $result = $this->conn->query($sql);
        
        $this->render('PatientMainPage', 'PatientMainPage', [
            'result' => $result
        ]);
    }

    public function logout() {
        session_destroy();
        header("Location: patientlogin.php");
        exit();
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>