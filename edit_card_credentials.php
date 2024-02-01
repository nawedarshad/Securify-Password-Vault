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
$sql = "SELECT * FROM card_details WHERE credential_id = $credentialId AND id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // No matching credential found
    header('Location: card_view.php');
    exit();
}

// Handle form submission for updating credential
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs (not implemented in this example)
    $newname = $_POST['new_name'];
    $newcardholder = $_POST['new_cardholder'];
    $newbrand = $_POST['new_brand'];
    $newnumber = $_POST['new_number'];
    $newexpmonth = $_POST['new_expmonth'];
    $newexpyear = $_POST['new_expyear'];
    $newssc = $_POST['new_ssc'];
    $newnotes = $_POST['new_notes'];

    // Update credential in the database
    $updateSql = "UPDATE card_details SET name = '$newname', cardholder_name = '$newcardholder', brand = '$newbrand', number = '$newnumber', 
    expiration_month = '$newexpmonth', security_code = '$newssc', notes = '$newnotes' WHERE credential_id = $credentialId";
    if ($conn->query($updateSql) === TRUE) {
        // Redirect to view_login_credentials.php after successful update
        sleep(2);
        header('Location: card_view.php');
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
        <label for="new_label">Name:</label>
        <input type="text" id="new_label" name="new_name" value="<?php echo $row['name']; ?>" required>

        <label for="new_username">Cardholder_Name:</label>
        <input type="text" id="new_username" name="new_cardholder" value="<?php echo $row['cardholder_name']; ?>" required>

        <label for="new_password">Brand:</label>
        <input type="text" id="new_password" name="new_brand" value="<?php echo $row['brand']; ?>" required>
        <label for="new_password">Number:</label>
        <input type="text" id="new_password" name="new_number" value="<?php echo $row['number']; ?>" required>
        <label for="new_password">Expiration Month:</label>
        <input type="text" id="new_password" name="new_expmonth" value="<?php echo $row['expiration_month']; ?>" required>
        <label for="new_password">Expiration Year:</label>
        <input type="text" id="new_password" name="new_expyear" value="<?php echo $row['expiration_year']; ?>" required>
        <label for="new_password">Security Code:</label>
        <input type="text" id="new_password" name="new_ssc" value="<?php echo $row['security_code']; ?>" required>
        <label for="new_password">Notes:</label>
        <input type="text" id="new_password" name="new_notes" value="<?php echo $row['notes']; ?>" required>

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
