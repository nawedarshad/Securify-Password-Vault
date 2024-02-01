<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate the input (you may add more validation)
    if (empty($username) || empty($password)) {
        echo "error";
        exit;
    }

    // Connect to your MySQL database (update with your database credentials)
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "password_manager";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the password (for better security, use password_hash instead)
    $hashedPassword = md5($password); // You should use a more secure hashing method

    // Check user credentials
    $sql = "SELECT id FROM users WHERE username='$username' AND password='$hashedPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user ID from the result
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        // Store the user ID in the session
        $_SESSION["user_id"] = $user_id;

        echo "success";
    } else {
        echo "failure";
    }

    $conn->close();
}
?>
