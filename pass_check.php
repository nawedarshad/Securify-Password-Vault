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
    <title>Password Strength Checker</title>
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

        #password-input {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            width: 300px;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        #strength-text {
            margin-bottom: 20px;
            font-size: 36px;
        }

        #submit-button:hover {
            background-color: #1565C0;
        }

        .weak,.very-weak {
            color: red;
        }

        
        .moderate {
            color: yellow;
        }

        .strong,
        .very-strong {
            color: green;
        }
    </style>
</head>

<body>
    <div id="container">
        <h2>Password Strength Checker</h2>
        <input type="input" id="password-input" placeholder="Enter your password">
        <p id="strength-text"></p>
        
    </div>

    <script>
        var passwordInput = document.getElementById('password-input');
        var strengthText = document.getElementById('strength-text');

        passwordInput.addEventListener('input', function () {
            var password = passwordInput.value;
            var strength = calculatePasswordStrength(password);
            updatePasswordStrengthText(strength);
        });

        function calculatePasswordStrength(password) {
            // Implement your password strength calculation logic here
            // For example, you can check length, use of uppercase, lowercase, digits, and symbols
            let strength = 0;

            // Example: Check if the password contains at least 8 characters
            if (password.length >= 8) {
                strength += 25;
            }

            // Example: Check if the password contains uppercase and lowercase characters
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
                strength += 25;
            }

            // Example: Check if the password contains digits
            if (/\d/.test(password)) {
                strength += 25;
            }

            // Example: Check if the password contains symbols
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                strength += 25;
            }

            return strength;
        }

        function updatePasswordStrengthText(strength) {
            // Display strength text and apply color based on strength level
            var strengthMessage = '';

            if (strength === 0) {
                strengthMessage = 'Very Weak';
                strengthText.className = 'very-weak';
            } else if (strength <= 25) {
                strengthMessage = 'Weak';
                strengthText.className = 'weak';
            } else if (strength <= 50) {
                strengthMessage = 'Moderate';
                strengthText.className = 'moderate';
            } else if (strength <= 75) {
                strengthMessage = 'Strong';
                strengthText.className = 'strong';
            } else {
                strengthMessage = 'Very Strong';
                strengthText.className = 'very-strong';
            }

            strengthText.textContent = `Password Strength: ${strengthMessage}`;
        }

        function submitPassword() {
            // Add your logic to handle the submission of the password
            var password = passwordInput.value;

            // Example: Replace with your actual logic (e.g., sending to the server)
            alert('Password submitted: ' + password);
        }
    </script>
</body>

</html>
