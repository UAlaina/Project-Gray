<?php
include_once "Controllers/Controller.php";
include_once "Models/ServiceForm.php";
include_once "Views/ServiceForm/NotificationMail/NotificationMailer.php";

class ServiceController extends Controller {

    public function route() {
        //global $controller;
        $action = $_GET['action'] ?? "list";

        switch ($action) {
            case "list":
                $services = ServiceForm::list();
                $this->render($controller, "services", ["services" => $services]);
                break;

            case "submitServiceForm":
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->handleFormSubmission();
                } else {
                    $this->render($controller, "serviceForm", []);
                }
                break;

            case "confirmation":
                $this->render($controller, "confirmation", []);
                break;

            default:
                header("Location: index.php?action=list");
                exit();
        }
    }

    private function handleFormSubmission() {
        $result = ServiceForm::submitForm($_POST);

        if ($result['success']) {
            $email = new NotificationMailer();
            
            $emailBody = "
                <html>
                <body>
                    <h2>Your Service Request Confirmation</h2>
                    <p>Thank you for your service request. Your service code is:</p>
                    <h3>{$result['serviceCode']}</h3>
                    <p>Please keep this code for your records.</p>
                </body>
                </html>
            ";
            
            $email->sendEmail($result['email'], 'Your Service Code', $emailBody);
            
            //error_log("Email sent to: {$result['email']} with service code: {$result['serviceCode']}");
            
            header("Location: index.php?action=confirmation");
            exit();
        } else {
            //echo $result['error'];
        }
    }
}
?>
