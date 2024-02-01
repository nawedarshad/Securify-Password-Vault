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
    <title>Password Manager</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #121212;
            color: #ffffff;
            text-align: center;
        }

        #all {
            display: flex;
            height: 40vh;
            align-items: center;
            justify-content: center;
        }

        #left-frame,
        #right-frame {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            align-items: center;
            padding: 20px;
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
            text-align: center;
            margin-bottom: 10px;
            width: 100%;
            /* Make buttons take full width */
        }

        #tools,
        #account {
            text-align: center;
            width: 100%;
            /* Make title take full width */
            margin-bottom: 20px;
        }
        #qright-frame{
            margin-left: 25px;
            width: 700px;
        }
        .button:hover {
            background-color: #1565C0;
        }
        .all2{
         gap:20px;   
        }
    </style>
</head>

<body>
    <h1>Securify Password Manager</h1>
    <div id="all">
        <div>
            <h2 id="tools">Vault</h2>
            <div id="left-frame">
                <button class="button" onclick="location.href='view_credentials.php'">View Credentials</button>
                <button class="button" onclick="location.href='login_credentials.php'">Login Details</button>
                <button class="button" onclick="location.href='identity.php'">Identity Details</button>
                <button class="button" onclick="location.href='credit_cards.php'">Credit Cards</button>
                <button class="button" onclick="location.href='secure_notes.php'">Secure Notes</button>
                <button class="button" onclick="location.href='bill.php'">Bills Vault</button>
            </div>
        </div>
        <div>
            <h2 id="account">Account</h2>
            <div id="right-frame">
                <button class="button" onclick="location.href='account_setting.php'">Account Settings</button>
                <button class="button" onclick="location.href='export.php'">Export User Data</button>
                <a href="https://www.haveibeenpwned.com" target="_blank"><button class="button">Data Breach</button></a>
                <a href="mailto:nawedarshad25@gmail.com?subject=Subject%20Here&body=Hello%20recipient,">
                    <button class="button" onclick="location.href='settings.php'">Get Help</button></a>
                <button class="button" onclick="location.href='settings.php'">Trash</button>
                <button class="button" onclick="location.href='logout.php'">Logout</button>
            </div>
        </div>
    </div>
    <div id="all" class="all2">
        <div>
            <h2 id="tools">Tools</h2>
            <div id="qleft-frame">
                <button class="button" onclick="location.href='generate_password.php'">Generate Password</button>
                <button class="button" onclick="location.href='pass_check.php'">Password Strength</button>
            </div>
        </div>
        <div>
            <h2 id="account">Reports</h2>
            <div id="qright-frame">
                <button class="button" onclick="location.href='account_settings.php'">Unlock with Subscription</button>
            </div>
        </div>
    </div>
</body>

</html>
