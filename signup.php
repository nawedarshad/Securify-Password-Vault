<?php

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the action is for signup
    if (isset($_POST["action"]) && $_POST["action"] === "signup") {
        // Get the user input
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Validate the input (you may add more validation)
        if (empty($username) || empty($password)) {
            echo "error";
            exit;
        }

        // Hash the password (for better security, use password_hash instead)
        $hashedPassword = md5($password); // You should use a more secure hashing method

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

        // Insert user data into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "error";
        }

        // Close the database connection
        $conn->close();
    }
}

?>
