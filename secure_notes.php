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
    // Process the form data and store the notes
    $title = $_POST["title"];
    $content = $_POST["content"];

    // You can add additional validation and database storage logic here

    // Establish a connection to the database (replace with your database credentials)
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "password_manager";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the notes table exists, if not, create it
    $createTableQuery = "CREATE TABLE IF NOT EXISTS notes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";

    $conn->query($createTableQuery);

    // Store the notes data in the database
    $insertQuery = "INSERT INTO notes (user_id, title, content) VALUES ('$user_id', '$title', '$content')";
    $conn->query($insertQuery);

    // Close the database connection
    $conn->close();

    // For demonstration purposes, you can redirect or perform any other action after storing the notes
    echo "Notes saved successfully!";
    sleep(2);
    header("Location: menus.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Manager - Notes</title>
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
            flex-direction: column;
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            margin-bottom: 8px;
            color: #ffffff;
            font-size: 16px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #1976D2;
            border-radius: 4px;
            background-color: #121212;
            color: #ffffff;
            font-size: 16px;
            margin-bottom: 10px;
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
            <h2>Notes</h2>
            <form action="" method="post">
                <div class="input-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="input-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" rows="5" required></textarea>
                </div>
                <button class="button" type="submit">Save Notes</button>
            </form>
        </div>
    </div>
</body>

</html>
