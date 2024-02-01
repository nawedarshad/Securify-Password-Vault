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
    <title>Password Generator</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .options-container {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .option {
            display: flex;
            gap: 20px;
            margin: 10px 0;
        }

        #generated-password {
            margin-top: 20px;
            font-size: 18px;
        }

        #generate-button {
            background-color: #1976D2;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        #generate-button:hover {
            background-color: #1565C0;
        }
    </style>
</head>

<body>
    <div id="container">
        <h2>Password Generator</h2>

        <div class="options-container">
            <div class="option">
                <label for="password-type">Password Type:</label>
                <select id="password-type" name="password-type">
                    <option value="password">Password</option>
                    <option value="passphrase">Passphrase</option>
                </select>
            </div>

            <div class="option">
                <label for="length">Length:</label>
                <input type="number" id="length" name="length" min="1" value="12">
            </div>

            <!-- Additional options (customize as needed) -->
            <div class="option">
                <label for="min-length">Min Length:</label>
                <input type="number" id="min-length" name="min-length" min="1" value="8">
            </div>

            <div class="option">
                <label for="min-numbers">Min Numbers:</label>
                <input type="number" id="min-numbers" name="min-numbers" min="0" value="1">
            </div>

            <div class="option">
                <label for="min-special">Min Special Characters:</label>
                <input type="number" id="min-special" name="min-special" min="0" value="1">
            </div>

            <div class="option">
                <div>
                <label for="option-uppercase">Include Uppercase:</label>
                <input type="checkbox" id="option-uppercase" name="option-uppercase" checked>
                </div><div>
                <label for="option-lowercase">Include Lowercase:</label>
                <input type="checkbox" id="option-lowercase" name="option-lowercase" checked>
                </div><div>
                <label for="option-numbers">Include Numbers:</label>
                <input type="checkbox" id="option-numbers" name="option-numbers" checked>
                </div>
            </div>
            <div class="option"> 
                <div>  
                <label for="option-special">Include Special Characters:</label>
                <input type="checkbox" id="option-special" name="option-special" checked>
                </div><div>
                <label for="option-avoid-ambiguous">Avoid Ambiguous Characters:</label>
                <input type="checkbox" id="option-avoid-ambiguous" name="option-avoid-ambiguous">
                </div>
            </div>
        </div>

        <button id="generate-button" onclick="generatePassword()">Generate Password</button>

        <p id="generated-password"></p>
    </div>

    <script>
        function generatePassword() {
            $("#input_cont").hide();

            const passwordType = $("#password-type").val();
            const length = parseInt($("#length").val());
            const minLength = parseInt($("#min-length").val());
            const minNumbers = parseInt($("#min-numbers").val());
            const minSpecial = parseInt($("#min-special").val());
            const includeUppercase = $("#option-uppercase").is(":checked");
            const includeLowercase = $("#option-lowercase").is(":checked");
            const includeNumbers = $("#option-numbers").is(":checked");
            const includeSpecial = $("#option-special").is(":checked");
            const avoidAmbiguous = $("#option-avoid-ambiguous").is(":checked");

            let charset = "";

            if (includeUppercase) {
                charset += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            }

            if (includeLowercase) {
                charset += "abcdefghijklmnopqrstuvwxyz";
            }

            if (includeNumbers) {
                charset += "0123456789";
            }

            if (includeSpecial) {
                charset += "!@#$%^&*()_-+=";
            }

            if (avoidAmbiguous) {
                // Remove ambiguous characters (e.g., l, 1, I, o, 0, O)
                charset = charset.replace(/[l1Io0O]/g, "");
            }

            let generatedPassword = "";

            if (passwordType === "password") {
                for (let i = 0; i < length; i++) {
                    const randomIndex = Math.floor(Math.random() * charset.length);
                    generatedPassword += charset[randomIndex];
                }
            } else if (passwordType === "passphrase") {
                // Implement passphrase generation logic based on specified options
                // This is a placeholder, and you can replace it with your own logic
                generatedPassword = "Passphrase123"; // Replace with your logic
            }

            // Display the generated password
            $("#generated-password").text("Generated Password: " + generatedPassword);
        }
    </script>
</body>

</html>
