<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "password_manager";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$userId = $_SESSION['user_id'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted for changing password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    // Validate and sanitize inputs (not implemented in this example)
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    // Get the user's current hashed password from the database
    $userId = $_SESSION['user_id'];
    $getUserPasswordSql = "SELECT password FROM users WHERE id = $userId";
    $result = $conn->query($getUserPasswordSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedOldPassword = $row['password'];

        // Verify the old password
        if (md5($oldPassword) === $hashedOldPassword) {
            // Old password is correct, proceed to update the password
            $hashedNewPassword = md5($newPassword);

            // Update password in the database
            $updateSql = "UPDATE users SET password = '$hashedNewPassword' WHERE id = $userId";

            if ($conn->query($updateSql) === TRUE) {
                // Password updated successfully
                $passwordUpdateMessage = "Password updated successfully!";
            } else {
                // Handle error
                $passwordUpdateMessage = "Error updating password: " . $conn->error;
            }
        } else {
            // Old password is incorrect
            $passwordUpdateMessage = "Incorrect old password. Please try again.";
        }
    }
}

// Check if the form is submitted for deleting all data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_data'])) {
    // Delete all data associated with the user
    $deleteUserDataSql = "DELETE FROM users WHERE id = $userId";
    if ($conn->query($deleteUserDataSql) === TRUE) {
        // User data deleted successfully
        $deleteDataMessage = "All user data deleted successfully!";
    } else {
        // Handle error
        $deleteDataMessage = "Error deleting user data: " . $conn->error;
    }

    // Logout the user after deleting data
    session_destroy();
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- ... (head content) ... -->
</head>

<body>
    <!-- Display form for changing password -->
    <h1>Account Settings</h1>
    <form method="post" action="">
        <label for="old_password">Old Password:</label>
        <input type="password" id="old_password" name="old_password" required>

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>

        <button type="submit" name="change_password">Change Password</button>
        <?php
        if (isset($passwordUpdateMessage)) {
            echo "<p>$passwordUpdateMessage</p>";
        }
        ?>
    </form>

    <!-- Display form for deleting all data -->
    <form method="post" action="">
        <button type="submit" id="buttonred" name="delete_data">Delete All Data</button>
        <?php
        if (isset($deleteDataMessage)) {
            echo "<p>$deleteDataMessage</p>";
        }
        ?>
    </form>
</body>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #121212;
        color: #ffffff;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    form {
        width: 300px;
        margin-top: 20px;
    }

    label {
        display: block;
        margin-top: 10px;
        margin-bottom: 5px;
        color: #ffffff;
    }

    input {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        margin-bottom: 15px;
    }

    button {
        background-color: #1976D2;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    #buttonred {
        background-color: red;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    button:hover {
        background-color: #1565C0;
    }

    p {
        margin-top: 15px;
        font-size: 14px;
        color: #ff5252;
    }
</style>
</html>
