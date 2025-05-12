<?php
include_once "Controllers/Controller.php";
include_once "Models/Payment.php";
include_once "Models/Users.php";

class PaymentController extends Controller {
    public function route() {
        $path = $_SERVER['SCRIPT_NAME'];
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $action = $_GET['action'] ?? "form";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
        
        if($action == "register") {
            if (empty($_POST)) {
                $this->render("Payments", "register");
            } else {
                $userID = $_SESSION['user_id'] ?? null;
                if (!$userID) {
                    die ("User not logged in");
                }
                 $data = [
            'patientName' => $_POST['patientName'],
            'serviceCode' => $_POST['serviceCode'],
            'amount' => floatval($_POST['amount']),
            'paymentStatus' => 'Completed',
            'userID' => $userID
        ];

            Payment::createPayment($data);

            header('Location: ' . dirname($path) . "/payment/list");
            }
        }
        /*switch ($action) {
           case "register":
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $userID = $_SESSION['user_id'] ?? null;

         if (!$userID) {
                        $_SESSION['error'] = "You must be logged in to make a payment.";
                        header("Location: index.php?controller=patient&action=login");
                        exit();
                    }
        $data = [
                        'userID' => $userID,
                        'paymentID' => ($_POST['paymentID']),
                        'patientName' => ($_POST['patientName']),
                        'serviceCode' => trim($_POST['service_code']),
                        'amount' => floatval($_POST['amount']),
                        'paymentStatus' => 'Completed'
                    ];
        
        $success = Payment::createPayment($data);

        if ($success) {
            $_SESSION['success_message'] = "Payment registered successfully.";
            header("Location: index.php?controller=payment&action=paymentForm");
            exit();
        } else {
            $_SESSION['error_message'] = "Failed to register payment. Try again.";
            header("Location: index.php?controller=payment&action=paymentForm");
            exit();
        }
    } else {
        $this->render("PaymentPage", "register", []);
    }
    break;
    }*/
}

}
