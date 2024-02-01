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
    // Process the form data and store the card details
    $name = $_POST["name"];
    $cardholderName = $_POST["cardholder_name"];
    $brand = $_POST["brand"];
    $number = $_POST["number"];
    $expirationMonth = $_POST["expiration_month"];
    $expirationYear = $_POST["expiration_year"];
    $securityCode = $_POST["security_code"];
    $notes = $_POST["notes"];

    // Connect to MySQL database (update with your database credentials)
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "password_manager";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the table exists, if not, create it
    $tableName = "card_details";
    $createTableQuery = "CREATE TABLE IF NOT EXISTS $tableName (
        id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        cardholder_name VARCHAR(255) NOT NULL,
        brand VARCHAR(255) NOT NULL,
        number VARCHAR(255) NOT NULL,
        expiration_month VARCHAR(10) NOT NULL,
        expiration_year VARCHAR(10) NOT NULL,
        security_code VARCHAR(10) NOT NULL,
        notes TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    $conn->query($createTableQuery);

    // Insert the data into the table
    $insertQuery = "INSERT INTO $tableName (id, name, cardholder_name, brand, number, expiration_month, expiration_year, security_code, notes)
        VALUES ('$user_id', '$name', '$cardholderName', '$brand', '$number', '$expirationMonth', '$expirationYear', '$securityCode', '$notes')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "Card details saved successfully.";
        sleep(2);
        header("Location: menus.php");
    } else {
        echo "Error: " . $insertQuery . "<br>" . $conn->error;
    }

    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Manager - Card Details</title>
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
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        #form-container {
            background-color: #2c2c2c;
            border-radius: 8px;
            padding: 30px;
            width: 1000px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .input-group {
            display: flex;
            gap: 30px;
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: flex;
            align-items:center;
            margin-bottom: 8px;
            color: #ffffff;
            font-size: 16px;
        }

        input {
            width: 100%;
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
            <h2>Card Details</h2>
            <form action="" method="post">
                <div class="input-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="cardholder_name">Cardholder_Name:</label>
                    <input type="text" id="cardholder_name" name="cardholder_name" required>
                </div>
                <div class="input-group">
                    <label for="brand">Brand:</label>
                    <input type="text" id="brand" name="brand" required>
                    <label for="number">Number:</label>
                    <input type="text" id="number" name="number" required>
                </div>
                <div class="input-group">
                    <label for="expiration_month">Expiration_Month:</label>
                    <input type="text" id="expiration_month" name="expiration_month" required>
                    <label for="expiration_year">Expiration_Year:</label>
                    <input type="text" id="expiration_year" name="expiration_year" required>
                    <label for="security_code">Security_Code_(CVV):</label>
                    <input type="text" id="security_code" name="security_code" required>
                </div>
                <div class="input-group">
                    <label for="notes">Notes:</label>
                    <input type="text" id="notes" name="notes">
                </div>
                <button class="button" type="submit">Save Card Details</button>
            </form>
        </div>
    </div>
</body>
</html>
