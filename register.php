<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "wecare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];
    $phoneno = $_POST['phone'];
    $address = $_POST['address'];

    // Check if passwords match
    if ($password !== $password1) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phoneno, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $phoneno, $address);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - WeCare Clinic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        background-color: white;
        margin: 0;
        font-family: Arial, sans-serif;
        color: black;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .container {
        display: flex;
        max-width: 100%;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 1;
    }

    .form-container {
        width: 100%;
        max-width: 600px;
        margin: 30px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    form {
        width: 100%;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="tel"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .password-container {
        position: relative;
        width: 100%;
        margin-bottom: 5px;
    }

    .field-icon {
        position: absolute;
        top: 40%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .centered {
        text-align: center;
        margin-top: 20px;
    }

    .login-btn {
        font-size: 1em;
        background-color: #0056b3;
        border-color: #0056b3;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 20px;
        cursor: pointer;
    }

    .login-btn:hover {
        background-color: #004085;
    }

    .footer {
        padding: 10px;
        background-color: #0056b3;
        text-align: center;
        color: white;
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    header {
        background-color: #0056b3;
        padding: 5px 0;
    }

    .navbar-nav .nav-link,
    .navbar-brand {
        color: white !important;
    }

    .navbar-toggler-icon {
        filter: invert(1);
    }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="#">WeCare Clinic</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="patients.php">Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="form-container">
            <form id="registerForm" action="register.php" method="POST">
                <h1 class="mb-4">Register New Patient</h1>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Password" required
                        autocomplete="current-password">
                    <i class="fas fa-eye field-icon" id="togglePassword"></i>
                </div>
                <div class="password-container">
                    <input type="password" id="password1" name="password1" placeholder="Re-type password" required
                        autocomplete="current-password">
                    <i class="fas fa-eye field-icon" id="togglePassword1"></i>
                </div>
                <input type="tel" name="phone" placeholder="Phone Number" required>
                <textarea name="address" rows="3" placeholder="Address" required></textarea>
                <div class="centered">
                    <button type="submit" class="login-btn">Register</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="container mt-0">
            © 2024 WeCare Clinic. All rights reserved.
        </div>
    </footer>

    <script>
    // Toggle password visibility for the first password field
    document.getElementById("togglePassword").addEventListener("click", function() {
        var passwordField = document.getElementById("password");
        var type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);
        this.classList.toggle("fa-eye-slash");
    });

    // Toggle password visibility for the second password field
    document.getElementById("togglePassword1").addEventListener("click", function() {
        var passwordField1 = document.getElementById("password1");
        var type1 = passwordField1.getAttribute("type") === "password" ? "text" : "password";
        passwordField1.setAttribute("type", type1);
        this.classList.toggle("fa-eye-slash");
    });

    document.getElementById("registerForm").addEventListener("submit", function(event) {
        event.preventDefault();
        // Prevent the default form submission behavior
        // Submit the form data via AJAX
        var formData = new FormData(this);
        fetch("register.php", {
                method: "POST",
                body: formData
            }).then(response => {
                if (response.ok) {
                    window.location.href = "patients.php";
                } else {
                    throw new Error("Error occurred while registering.");
                }
            })
            .catch(error => {
                console.error("Registration Error:", error);
            });
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
