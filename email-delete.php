<?php
require("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    // Check if the username exists in the database
    $check_query = "SELECT * FROM login WHERE username = :username";
    $check_statement = $pdo->prepare($check_query);
    $check_statement->bindParam(":username", $username, PDO::PARAM_STR);
    $check_statement->execute();

    if ($check_statement->rowCount() > 0) {
        // Perform the email deletion here
        $delete_query = "UPDATE login SET email = NULL WHERE username = :username";
        $delete_statement = $pdo->prepare($delete_query);
        $delete_statement->bindParam(":username", $username, PDO::PARAM_STR);

        if ($delete_statement->execute()) {
            $message = "Email deleted successfully.";
        } else {
            $error_message = "Error: Something went wrong while deleting the email.";
        }
    } else {
        $error_message = "Username not found.";
    }
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Deletion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="delete-container">
        <h2>Delete Email</h2>
        <?php
        if (isset($message)) {
            echo "<p class='success-message'>$message</p>";
        } elseif (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>
        <form method="POST" action="email-delete.php">
            <label for="username"><b>Username:</b></label>
            <input type="text" name="username" required>
            <label for="confirm"><b>Confirm Deletion:</b></label>
            <input type="checkbox" name="confirm" required>
            <button type="submit">Delete Email</button>
        </form>
        
        
        <a href="/Website%20final/index.html" class="back-button">main page</a>
       
    </div>
</body>
</html>
