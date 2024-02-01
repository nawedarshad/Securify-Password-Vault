<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page or perform any other action
    header("Location: login.php");
    exit();
}

// Connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "password_manager";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create the table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS bills (
    id INT NOT NULL,
    bill_name VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    due_date DATE NOT NULL,
    payment_date DATE
)";

// Execute the query
if ($conn->query($sql) === TRUE) {
    // echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process the form data and store the bill details
    $billName = $_POST["bill_name"];
    $amount = $_POST["amount"];
    $dueDate = $_POST["due_date"];

    // Additional logic for paid bills
    $paymentDate = $_POST["payment_date"];

    // SQL query to insert bill details into the database
    $insertSql = "INSERT INTO bills (id, bill_name, amount, due_date, payment_date) 
                  VALUES (?, ?, ?, ?, ?)";

    // Use prepared statements for security
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("isiss", $_SESSION["user_id"], $billName, $amount, $dueDate, $paymentDate);
    $stmt->execute();
    $stmt->close();

    echo "Bill details saved successfully.<br>";
    echo "User ID: " . $_SESSION["user_id"] . "<br>";
    sleep(2);
    header("Location: menus.php");


    // You can add further logic or redirect the user after saving the data
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Manager - Store Bills</title>
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
            width: 600px;
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
        .qinput-group{
            display: flex;
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
            <h2>Store Bill Details</h2>
            <form action="" method="post">
                <div class="input-group">
                    <label for="bill_name">Bill Name:</label>
                    <input type="text" id="bill_name" name="bill_name" required>
                </div>
                <div class="input-group">
                    <label for="amount">Amount:</label>
                    <input type="number" id="amount" name="amount" step="0.01" required>
                </div>
                <div class="input-group">
                    <label for="due_date">Due Date:</label>
                    <input type="date" id="due_date" name="due_date" required>
                </div>
                <div class="input-group">
                    <label for="payment_date">Payment Date:</label>
                    <input type="date" id="payment_date" name="payment_date">
                </div>
                <button class="button" type="submit">Save Bill Details</button>
            </form>
        </div>
    </div>
</body>

</html>
