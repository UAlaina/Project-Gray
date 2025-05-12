<?php
$PATH = $_SERVER['SCRIPT_NAME'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile page of Client</title>
    <link rel="stylesheet" href="../../Views/styles/profilePage.css">
    
</head>
<body>
<div class="profile-container">
    <h4>Profile page of Client</h4>

    <form action="save_profile.php" method="POST">
        <div class="profile-header">
            <img src="user-icon.png" alt="User Icon" class="profile-image">
            <div class="profile-details">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Non-Binary">Non-Binary</option>
                        <option value="Prefer-not-to-say">Prefer not to say</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="zip">Zip Code</label>
                    <input type="text" id="zip" name="zip" required>
                </div>

                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" min="0" required>
                </div>

                <div class="form-group">
                    <label for="rating">Rating</label>
                    <select name="rating" id="rating">
                        <option value="5">★★★★★ 5 stars</option>
                        <option value="4">★★★★ 4 stars</option>
                        <option value="3">★★★ 3 stars</option>
                        <option value="2">★★ 2 stars</option>
                        <option value="1">★ 1 star</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="description-section">
            <h3>Description:</h3>
            <div class="form-group">
                <label for="description">Description of their Health issues or what they need help with</label>
                <textarea name="description" id="description" rows="6" required></textarea>
            </div>
        </div>

        <div class="actions">
            <p>Would you like to book an appointment with them?
                <button type="button" class="chat-btn">Chat</button>
            </p>
            <p>Would you like to give a feedback?
                <button type="button" class="feedback-btn">Feedback</button>
            </p>
        </div>

        <div class="form-actions">
            <button type="submit">Save Profile</button>
        </div>
    </form>
</div>
</body>
</html>
