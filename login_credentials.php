<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page or perform any other action
    header("Location: login.php");
    exit();
}

// Retrieve the user ID from the session
$user_id = $_SESSION["user_id"];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process the form data and store the credentials
    $website = $_POST["website"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate the input (you can add more validation as needed)

    // Connect to the database
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "password_manager";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape input to prevent SQL injection
    $website = $conn->real_escape_string($website);
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Insert data into the credentials table
    $sql = "INSERT INTO credentials (id, label, username, password) VALUES ('$user_id', '$website', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Credentials saved successfully!";
        sleep(2);
        header("Location: menus.php");

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Manager - Store Credentials</title>
    <style>
       body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #121212;
    color: #ffffff;
    text-align: center;
}

#container {
    display: flex;
    height: 80vh;
    align-items: center;
    justify-content: center;
}

#form-container {
    background-color: #2c2c2c;
    border-radius: 8px;
    padding: 30px;
    width: 500px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.input-group {
    margin-bottom: 20px;
    text-align: left;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #ffffff;
    font-size: 16px;
}

input {
    width: 95%;
    padding: 12px;
    border: 1px solid #1976D2;
    border-radius: 4px;
    background-color: #121212;
    color: #ffffff;
    font-size: 16px;
}

.button {
    background-color: #1976D2;
    color: white;
    padding: 20px;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
    width: 100%;
}

.button:hover {
    background-color: #1565C0;
}
</style>
</head>

<body>
    <h1>Securify Password Manager</h1>
    <div id="container">
        <div id="form-container">
            <h2>Store Login Details</h2>
            <form action="" method="post">
                <div class="input-group">
                    <label for="website">Name:</label>
                    <input type="text" id="website" name="website" required>
                </div>
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button class="button" type="submit">Save Credentials</button>
            </form>
        </div>
    </div>
</body>

</html>
