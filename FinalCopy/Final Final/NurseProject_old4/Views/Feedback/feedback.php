<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nurseId = intval($_GET['nurseId'] ?? 0);
$patientId = intval($_GET['patientId'] ?? 0);

$recipientType = '';
$recipientId = 0;

if ($nurseId > 0) {
    $recipientType = 'nurse';
    $recipientId = $nurseId;
} elseif ($patientId > 0) {
    $recipientType = 'patient';
    $recipientId = $patientId;
}

if ($recipientId === 0) {
    echo "<p style='color:red; font-weight:bold;'>❌ Invalid recipient ID — please access this page from a profile.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Page</title>
    <link rel="stylesheet" href="/NurseProject/Views/styles/feedbackstyle.css">
</head>
<body>
<div class="feedback-container">
    <h2>Feedback Page</h2>
    <p class="feedback-subtitle">
        <?php echo ($recipientType === 'nurse') ? 'Give feedback to your nurse' : 'Give feedback to your patient'; ?>
    </p>

    <form action="/NurseProject/index.php?controller=feedback&action=submit" method="POST">
        <?php if ($recipientType === 'nurse'): ?>
            <input type="hidden" name="nurseId" value="<?php echo $recipientId; ?>">
        <?php elseif ($recipientType === 'patient'): ?>
            <input type="hidden" name="patientId" value="<?php echo $recipientId; ?>">
        <?php endif; ?>

        <!-- ✅ Pass user_id in case session is lost -->
        <input type="hidden" name="clientId" value="<?php echo $_SESSION['user_id'] ?? 0; ?>">

        <div class="form-group">
            <label for="starReview">Star Rating</label>
            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5" required><label for="star5">★</label>
                <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
            </div>
        </div>

        <div class="form-group">
            <label for="writtenReview">Written Review (Optional)</label>
            <textarea name="writtenReview" id="writtenReview" rows="6"></textarea>
        </div>

        <div class="form-actions">
            <button type="submit">Submit Feedback</button>
            <button type="button" onclick="history.back()" class="secondary-btn">Cancel</button>
        </div>
    </form>
</div>
</body>
</html>
