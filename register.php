<?php
require("connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email']; // Added email field

    // Check if the username is already taken
    $check_query = "SELECT * FROM login WHERE username = :username";
    $check_statement = $pdo->prepare($check_query);
    $check_statement->bindParam(":username", $username, PDO::PARAM_STR);
    $check_statement->execute();

    if ($check_statement->rowCount() > 0) {
        echo "Username already exists. Please choose a different one.";
    } else {
        // Insert the new user into the database
        $insert_query = "INSERT INTO login (username, password, email) VALUES (:username, :password, :email)";
        $insert_statement = $pdo->prepare($insert_query);
        $insert_statement->bindParam(":username", $username, PDO::PARAM_STR);
        $insert_statement->bindParam(":password", $password, PDO::PARAM_STR); 
        $insert_statement->bindParam(":email", $email, PDO::PARAM_STR);

        if ($insert_statement->execute()) {
            echo "New user is added successfully. Go to <a href='login.php'>Login</a>.";
        } else {
            echo "Error: Something went wrong.";
        }
    }

    $pdo = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form action="" method="POST">
    <div class="reg-container">
        <h2>Register Here</h2>
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" required>
        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>
        <!-- Add the email input field here -->
        <label for="email"><b>Email</b></label>
        <input type="email" placeholder="Used for ads(optional)" name="email">
        <!-- End of email input field -->
        <button type="submit" name="register">Register</button>

        <a class="reg-link" href="login.php">Login Here</a>
    </div>
</form>
</body>
</html>
