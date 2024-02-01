<!-- view_login_credentials.php -->

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

// Fetch login credentials for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM card_details WHERE id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Credentials</title>
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

        table {
            width: 80%;
            margin-top: 20px;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            color: #ffffff;
        }

        th {
            background-color: #1976D2;
        }

        tr:hover {
            background-color: #333;
        }

        .button {
            background-color: #1976D2;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .button:hover {
            background-color: #1565C0;
        }
    </style>
</head>

<body>
    <h1>Your Login Credentials</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Card Holder name</th>
            <th>Brand</th>
            <th>Number</th>
            <th>Exp Month</th>
            <th>Exp Year</th>
            <th>Security Code</th>
            <th>Action</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['credential_id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['cardholder_name'] . "</td>";
                echo "<td>" . $row['brand'] . "</td>";
                echo "<td>" . $row['number'] . "</td>";
                echo "<td>" . $row['expiration_month'] . "</td>";
                echo "<td>" . $row['expiration_year'] . "</td>";
                echo "<td>" . $row['security_code'] . "</td>";
                echo "<td>
                        <button class='button' onclick=\"editCredential('".$row['credential_id']."')\">Edit</button>
                        <button class='button' onclick=\"deleteCredential('".$row['credential_id']."')\">Delete</button>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No login credentials found.</td></tr>";
        }
        ?>

    </table>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function editCredential(credentialId) {
        window.location.href = 'edit_card_credentials.php?id=' + credentialId;
    }

    function deleteCredential(credentialId) {
        if (confirm('Are you sure you want to delete this credential?')) {
            console.log("hello");
            // AJAX request to delete_credential.php
            $.ajax({
                type: 'POST',
                url: 'delete_credentials.php',
                data: { id: credentialId },
                success: function (response) {
                    if (response === 'success') {
                        // Remove the corresponding table row
                        window.location.href = 'login_view.php';
                        $('tr[data-id="' + credentialId + '"]').remove();
                    } else {
                        console.log("hello1")
                        alert('Failed to delete credential. Please try again.');
                    }
                }
            });
        }
    }
</script>
</body>

</html>