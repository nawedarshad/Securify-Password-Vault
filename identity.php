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
    // Process the form data and store the identity details
    $firstName = $_POST["first_name"];
    $middleName = $_POST["middle_name"];
    $lastName = $_POST["last_name"];
    $username = $_POST["username"];
    $company = $_POST["company"];
    $ssn = $_POST["ssn"];
    $passportNumber = $_POST["passport_number"];
    $licenseNumber = $_POST["license_number"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address1 = $_POST["address_1"];
    $address2 = $_POST["address_2"];
    $address3 = $_POST["address_3"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $country = $_POST["country"];

    // Connect to your MySQL database (replace with your database credentials)
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "password_manager";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the "identity_details" table exists, if not, create it
    $createTableSql = "CREATE TABLE IF NOT EXISTS identity_details (
        id INT NOT NULL,
        first_name VARCHAR(255),
        middle_name VARCHAR(255),
        last_name VARCHAR(255),
        username VARCHAR(255),
        company VARCHAR(255),
        ssn VARCHAR(255),
        passport_number VARCHAR(255),
        license_number VARCHAR(255),
        email VARCHAR(255),
        phone VARCHAR(255),
        address_1 VARCHAR(255),
        address_2 VARCHAR(255),
        address_3 VARCHAR(255),
        city VARCHAR(255),
        state VARCHAR(255),
        zip VARCHAR(255),
        country VARCHAR(255)
    )";

    if ($conn->query($createTableSql) === TRUE) {
        // Table created successfully or already exists

        // Insert identity details into the "identity_details" table
        $insertSql = "INSERT INTO identity_details (id, first_name, middle_name, last_name, username, company, ssn, passport_number, license_number, email, phone, address_1, address_2, address_3, city, state, zip, country) VALUES ('$user_id', '$firstName', '$middleName', '$lastName', '$username', '$company', '$ssn', '$passportNumber', '$licenseNumber', '$email', '$phone', '$address1', '$address2', '$address3', '$city', '$state', '$zip', '$country')";

        if ($conn->query($insertSql) === TRUE) {
            echo "Identity details saved successfully!";
            sleep(2);
            header("Location: menus.php");

        } else {
            echo "Error: " . $insertSql . "<br>" . $conn->error;
        }
    } else {
        echo "Error creating table: " . $createTableSql . "<br>" . $conn->error;
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
    <title>Password Manager - Store Identity Details</title>
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
            height: 100%;
            
            justify-content: center;
        }

        #form-container {
            background-color: #2c2c2c;
            border-radius: 8px;
            padding: 30px;
            width: 1300px;
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
            justify-content: center;
            align-items: center;
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
            <h2>Store Identity Details</h2>
            <form action="" method="post">
                <div class="input-group">
                    <label for="first_name">First_Name:</label>
                    <input type="text" id="first_name" name="first_name" required>
                    <label for="middle_name">Middle_Name:</label>
                    <input type="text" id="middle_name" name="middle_name">
                    <label for="last_name">Last_Name:</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username">
                    <label for="company">Company:</label>
                    <input type="text" id="company" name="company">
                </div>
                <div class="input-group">
                    <label for="ssn">Social_Security_Number:</label>
                    <input type="text" id="ssn" name="ssn">
                    <label for="passport_number">Passport_Number:</label>
                    <input type="text" id="passport_number" name="passport_number">
                    <label for="license_number">License_Number:</label>
                    <input type="text" id="license_number" name="license_number">
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone">
                </div>
                <div class="input-group">
                    <label for="address_1">Address_1:</label>
                    <input type="text" id="address_1" name="address_1">
                    <label for="address_2">Address_2:</label>
                    <input type="text" id="address_2" name="address_2">
                    <label for="address_3">Address_3:</label>
                    <input type="text" id="address_3" name="address_3">
                </div>
                <div class="input-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city">
                    <label for="state">State:</label>
                    <input type="text" id="state" name="state">
                    <label for="zip">Postal_Code:</label>
                    <input type="text" id="zip" name="zip">
                    <label for="country">Country:</label>
                    <input type="text" id="country" name="country">
                </div>
                <button class="button" type="submit">Save Identity Details</button>
            </form>
        </div>
    </div>
</body>

</html>
