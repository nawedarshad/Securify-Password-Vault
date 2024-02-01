<?php
session_start();

// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "password_manager";

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function storeCredentials($label, $username, $password, $userId) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO credentials (label, username, password, id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $label, $username, $password, $userId);

    if ($stmt->execute()) {
        return "success";
    } else {
        return "error";
    }
}

function storeCreditCard($cardName, $cardholderName, $cardBrand, $cardNumber, $expirationMonth, $expirationYear, $securityCode, $userId) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO credit_cards (card_name, cardholder_name, card_brand, card_number, expiration_month, expiration_year, security_code, id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssi", $cardName, $cardholderName, $cardBrand, $cardNumber, $expirationMonth, $expirationYear, $securityCode, $userId);

    if ($stmt->execute()) {
        return "success";
    } else {
        return "error";
    }
}

function getAllCredentials($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT label, username, password FROM credentials WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $credentials = array();

        while ($row = $result->fetch_assoc()) {
            $credentials[] = $row;
        }

        return json_encode($credentials);
    } else {
        return "error";
    }
}

function getAllCreditCards($userId) {
    global $conn;

    $stmt = $conn->prepare("SELECT card_name, cardholder_name, card_brand, card_number, expiration_month, expiration_year, security_code FROM credit_cards WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $creditCards = array();

        while ($row = $result->fetch_assoc()) {
            $creditCards[] = $row;
        }

        return json_encode($creditCards);
    } else {
        return "error";
    }
}

// Add other functions as needed

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Retrieve user ID from the session
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        switch ($action) {
            case 'storeCredentials':
                $label = $_POST['label'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                echo storeCredentials($label, $username, $password, $userId);
                break;

            case 'storeCreditCard':
                $cardName = $_POST['cardName'];
                $cardholderName = $_POST['cardholderName'];
                $cardBrand = $_POST['cardBrand'];
                $cardNumber = $_POST['cardNumber'];
                $expirationMonth = $_POST['expirationMonth'];
                $expirationYear = $_POST['expirationYear'];
                $securityCode = $_POST['securityCode'];
                echo storeCreditCard($cardName, $cardholderName, $cardBrand, $cardNumber, $expirationMonth, $expirationYear, $securityCode, $userId);
                break;

            case 'getAllCredentials':
                echo getAllCredentials($userId);
                break;

            case 'getAllCreditCards':
                echo getAllCreditCards($userId);
                break;

            case 'logout':
                echo logout();
                break;

            default:
                echo "Invalid action";
        }
    } else {
        echo "User ID not found in the session.";
    }
} else {
    echo "No action specified";
}

// Close the database connection
$conn->close();
?>
