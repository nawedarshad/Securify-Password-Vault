<!-- edit_credential.php -->

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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if credential ID is provided
if (!isset($_GET['id'])) {
    header('Location: login_view.php');
    exit();
}

$credentialId = $_GET['id'];

// Fetch credential details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM credentials WHERE credential_id = $credentialId AND id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // No matching credential found
    header('Location: login_view.php');
    exit();
}

// Handle form submission for updating credential
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs (not implemented in this example)
    $newLabel = $_POST['new_label'];
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];

    // Update credential in the database
    $updateSql = "UPDATE credentials SET label = '$newLabel', username = '$newUsername', password = '$newPassword' WHERE credential_id = $credentialId";
    if ($conn->query($updateSql) === TRUE) {
        // Redirect to view_login_credentials.php after successful update
        sleep(2);
        header('Location: login_view.php');
        exit();
    } else {
        // Handle error
        $error = "Error updating credential: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Credential</title>
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
            margin-bottom: 5px;
            color: #ffffff;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            background-color: #333;
            color: #ffffff;
            border: 1px solid #555;
            border-radius: 4px;
        }

        button {
            background-color: #1976D2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #1565C0;
        }

        p {
            color: red;
        }
    </style>
</head>

<body>
    <!-- Display form for editing credential -->
    <h1>Edit Credential</h1>
    <form method="post" action="">
        <label for="new_label">Label:</label>
        <input type="text" id="new_label" name="new_label" value="<?php echo $row['label']; ?>" required>

        <label for="new_username">Username:</label>
        <input type="text" id="new_username" name="new_username" value="<?php echo $row['username']; ?>" required>

        <label for="new_password">Password:</label>
        <input type="text" id="new_password" name="new_password" value="<?php echo $row['password']; ?>" required>

        <button type="submit">Update Credential</button>
    </form>

    <?php
    if (isset($error)) {
        echo "<p>$error</p>";
    }
    ?>

    <!-- ... (remaining body content) ... -->

</body>

</html>
