<?php
session_start();

$servername = "127.0.0.1";
$dbusername = "root";
$dbpassword = "";
$dbname = "wecare";

if (isset($_POST['username']) && isset($_POST['password'])) {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sqllogin = "SELECT * FROM `users` WHERE `name` = :username";
    $stmt = $conn->prepare($sqllogin);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password'])) {
            $_SESSION["name"] = $username;
            echo "<script>alert('Login Success');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Login Failed: Incorrect password');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        }
    } else {
        echo "<script>alert('Login Failed: User not found');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - WeCare Clinic</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    body {
        background-color: white;
        margin: 0;
        font-family: Arial, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 20px;
    }

    .form-container {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        max-width: 500px;
        width: 100%;
        margin: 20px auto;
    }

    input[type="text"],
    input[type="password"] {
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
    }

    .field-icon {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .centered {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .login-btn {
        font-size: 1em;
        background-color: #0056b3;
        border-color: #0056b3;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        width: 100%;
    }

    .login-btn:hover {
        background-color: #004085;
    }

    .register-link {
        font-size: 0.9em;
        color: #0056b3;
        text-decoration: underline;
        cursor: pointer;
        margin-top: 15px;
    }

    .register-link:hover {
        color: #004085;
    }

    h1 {
        font-size: 2.5em;
        font-family: 'Arial Black', sans-serif;
        margin-bottom: 20px;
        text-align: center;
    }

    .carousel-inner img {
        width: 100%;
        height: auto;
        margin: auto;
        border-radius: 10px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
    }

    @media (max-width: 768px) {
        body {
            padding: 10px;
        }

        h1 {
            font-size: 2em;
        }

        .form-container {
            padding: 15px;
        }

        .login-btn {
            padding: 10px 15px;
        }
    }

    @media (max-width: 576px) {
        .carousel-inner img {
            width: 100%;
            height: auto;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="wecare1.png" alt="Image1">
                        </div>
                        <div class="carousel-item">
                            <img src="wecare.png" alt="Image2">
                        </div>
                        <div class="carousel-item">
                            <img src="wecare2.png" alt="Image3">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 form-container">
                <h1>WeCare Clinic</h1>
                <form id="loginForm" action="login.php" method="POST">
                    <input type="text" name="username" placeholder="Username" required autocomplete="username">
                    <div class="password-container">
                        <input type="password" name="password" placeholder="Password" required
                            autocomplete="current-password">
                        <i class="fas fa-eye field-icon" id="togglePassword"></i>
                    </div>
                    <div class="centered">
                        <button type="submit" class="login-btn">Login</button>
                        <a href="register.php" class="register-link">Register</a> <!-- Add this line -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    document.getElementById("togglePassword").addEventListener("click", function() {
        var passwordField = document.querySelector('input[name="password"]');
        var type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);
        this.classList.toggle("fa-eye-slash");
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
