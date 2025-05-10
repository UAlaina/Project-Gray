<?php
$PATH = $_SERVER['SCRIPT_NAME'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Page</title>
    <link rel="stylesheet" href="../../Views/styles/feedbackstyle.css">
</head>
<body>
<div class="feedback-container">
    <h2>Feedback Page</h2>

    <form action="submit_feedback.php" method="POST">
        <div class="form-group">
            <label for="starReview">Star Review</label>
            <div class="star-rating">
                <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
            </div>
        </div>

        <div class="form-group">
            <label for="writtenReview">Written Review</label>
            <textarea name="writtenReview" id="writtenReview" rows="6" required></textarea>
        </div>

        <div class="form-actions">
            <button type="submit">Submit</button>
        </div>
    </form>
</div>
</body>
</html>
