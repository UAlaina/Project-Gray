<?php
include_once "Controllers/Controller.php";
include_once "Models/ServiceForm.php";
include_once "Views/ServiceForm/NotificationMail/NotificationMailer.php";

class ServiceController extends Controller {

    public function route() {
        $action = $_GET['action'] ?? "list";
        global $controller;
        switch ($action) {
            case "list":
                $services = ServiceForm::list();
                $this->render($controller, "services", ["services" => $services]);
                break;

                  case "form":
            $this->showForm();
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

    private function showForm() {
    $patientId = intval($_GET['id'] ?? 0);

    if ($patientId <= 0) {
        echo "<p style='color:red;'>Invalid patient ID for service form.</p>";
        return;
    }

    $this->render("ServiceForm", "servicePopUp", ["patientId" => $patientId]);
    
}

    private function handleFormSubmission() {
        $result = ServiceForm::submitForm($_POST);

        if ($result['success']) {
            echo "<p>Form submitted to database successfully.</p>";
            echo "<p>Preparing to send email to: <strong>{$result['email']}</strong></p>";
            echo "<p>Service Code: <strong>{$result['serviceCode']}</strong></p>";

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

            $sent = $email->sendEmail($result['email'], 'Your Service Code', $emailBody);

            if ($sent) {
                echo "<p>Email sent successfully!</p>";
            } else {
                echo "<p>Failed to send email.</p>";
            }

            echo "<p><a href='/NurseProject/default/home'>Click here to go to confirmation page</a></p>";
            
        } else {
            echo "<p>Failed to submit form to database.</p>";
            echo "<p><strong>Error:</strong> " . htmlspecialchars($result['error']) . "</p>";
            echo "<p><a href='javascript:history.back()'>Go back and try again</a></p>";
        }
    }
}
?>
