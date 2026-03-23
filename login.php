<?php
session_start();
$conn = mysqli_connect("localhost", "root", "Bye@2709", "drugmanagement");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if($row && password_verify($password, $row['password'])) {
        $_SESSION['username'] = $row['username'];
        header("Location: drugregistration.php"); // redirect to drug registration
        exit();
    } else {
        echo " Invalid username or password. <a href='login.html'>Try again</a>";
    }
} 
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Drug Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: lightblue;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <a href="home.html.html"><h1 style="text-align:center;">back</h1></a>
        </form>
    </div>
</body>
</html>

