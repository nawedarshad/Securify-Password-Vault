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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credential Viewer</title>
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

        .container {
            margin-bottom: 30px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .button {
            background-color: #1976D2;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .button:hover {
            background-color: #1565C0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>View Credentials of:</h1>
    </div>

    <div class="button-container">
        <button class="button" onclick="location.href='login_view.php'">Login Details</button>
        <button class="button" onclick="location.href='card_view.php'">Identity Details</button>
        <button class="button" onclick="location.href='card_view.php'">Credit Cards</button>
        <button class="button" onclick="location.href='secure_notes.php'">Secure Notes</button>
        <button class="button" onclick="location.href='bill.php'">Bills Vault</button>
    </div>
</body>

</html>
