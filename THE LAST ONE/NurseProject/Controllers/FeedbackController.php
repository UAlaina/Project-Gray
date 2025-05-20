<?php
include_once "Models/Feedback.php";
include_once "Controllers/Controller.php";

class FeedbackController extends Controller {

    public function route() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $action = $_GET['action'] ?? 'form';

        switch ($action) {
            case 'submit':
                $this->submitFeedback();
                break;
            case 'form':
                include "Views/Feedback/feedback.php";
                break;
            default:
                header("Location: index.php");
                break;
        }
    }

    private function submitFeedback() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $sessionUserId = $_SESSION['user_id'] ?? intval($_POST['clientId'] ?? 0);

        if ($sessionUserId === 0) {
            $_SESSION['error'] = "Session expired. Please log in again.";
            header("Location: index.php?controller=patient&action=login");
            exit();
        }

        $nurseId = intval($_POST['nurseId'] ?? 0);
        $rating = intval($_POST['rating'] ?? 0);
        $description = trim($_POST['writtenReview'] ?? '');

        if ($nurseId <= 0 || $rating < 1 || $rating > 5) {
            $_SESSION['error'] = "Invalid feedback submission.";
            header("Location: index.php");
            exit();
        }

        $feedbackData = [
            'clientId' => $sessionUserId,
            'nurseId' => $nurseId,
            'rating' => $rating,
            'description' => $description
        ];

        $result = Feedback::saveFeedback($feedbackData);

        if ($result) {
            $_SESSION['success'] = "Thank you for your feedback!";
        } else {
            $_SESSION['error'] = "Failed to submit feedback.";
        }

       header("Location: /NurseProject/patient/viewProfile/$nurseId");
        exit();
    }
}
?>
