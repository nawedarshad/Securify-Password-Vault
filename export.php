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

// User ID
$userId = $_SESSION['user_id'];

// Fetch data from 'bills' table
$billsSql = "SELECT * FROM bills WHERE id = $userId";
$billsResult = $conn->query($billsSql);

// Fetch data from 'card_details' table
$cardDetailsSql = "SELECT * FROM card_details WHERE id = $userId";
$cardDetailsResult = $conn->query($cardDetailsSql);

// Fetch data from 'credentials' table
$credentialsSql = "SELECT * FROM credentials WHERE id = $userId";
$credentialsResult = $conn->query($credentialsSql);

// Fetch data from 'identity_details' table
$identityDetailsSql = "SELECT * FROM identity_details WHERE id = $userId";
$identityDetailsResult = $conn->query($identityDetailsSql);

// Fetch data from 'notes' table
$notesSql = "SELECT * FROM notes WHERE id = $userId";
$notesResult = $conn->query($notesSql);

// Create a file handle for writing to CSV
$filename = "exported_data.csv";

// Use output buffering to prevent any accidental output before download
ob_start();

// Write headers to the CSV file
$headers = array("Table", "Column1", "Column2", /* Add columns as needed */);
echo implode(',', $headers) . "\n";

// Write data from 'bills' table to the CSV file
while ($row = $billsResult->fetch_assoc()) {
    echo "bills,{$row['bill_name']},{$row['amount']},{$row['due_date']},{$row['payment_date']}\n";
}

// Write data from 'card_details' table to the CSV file
while ($row = $cardDetailsResult->fetch_assoc()) {
    echo "card_details,{$row['name']},{$row['cardholder_name']},{$row['brand']},{$row['number']},{$row['expiration_month']},{$row['expiration_year']},{$row['notes']}\n";
}

// Write data from 'credentials' table to the CSV file
while ($row = $credentialsResult->fetch_assoc()) {
    echo "credentials,{$row['label']},{$row['username']},{$row['password']}\n";
}

// Write data from 'identity_details' table to the CSV file
while ($row = $identityDetailsResult->fetch_assoc()) {
    echo "identity_details,{$row['first_name']},{$row['middle_name']},{$row['last_name']},{$row['username']},{$row['company']},{$row['ssn']},{$row['passport_number']},{$row['licence_number']},{$row['email']},{$row['phone']},{$row['address_1']},{$row['address_2']},{$row['address_3']},{$row['city']},{$row['state']},{$row['zip']},{$row['country']}\n";
}

// Write data from 'notes' table to the CSV file
while ($row = $notesResult->fetch_assoc()) {
    echo "notes,{$row['title']},{$row['content']}\n";
}

// Close the file handle
ob_end_flush();

// Provide the file for download
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

// Delete the file after download (optional)
unlink($filename);
?>
