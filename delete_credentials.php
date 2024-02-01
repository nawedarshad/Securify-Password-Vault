<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    exit('User not logged in');
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "password_manager";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    exit('Connection failed: ' . $conn->connect_error);
}

// Check if credential ID is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $credentialId = $_POST['id'];

    // Validate user's ownership of the credential
    $user_id = $_SESSION['user_id'];
    $checkOwnershipSql = "SELECT id FROM credentials WHERE credential_id = $credentialId";
    $ownershipResult = $conn->query($checkOwnershipSql);

    if ($ownershipResult->num_rows > 0) {
        // Delete credential from the database
        $deleteSql = "DELETE FROM credentials WHERE credential_id = $credentialId";
        if ($conn->query($deleteSql) === TRUE) {
            exit('success');
        } else {
            exit('error');
        }
    } else {
        exit('Unauthorized access');
    }
} else {
    exit('Invalid request');
}
?>
