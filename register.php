<?php
session_start();
$conn = mysqli_connect("localhost", "root", "Bye@2709", "drugmanagement");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // encrypt password

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    
    if(mysqli_query($conn, $sql)) {
        echo "✅ Registration successful. <a href='login.html'>Login here</a>";
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
} else {
    echo "Please fill in all fields.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Drug Management System</title>
    <style>
        /* Reuse same style as login.html */
        body { font-family: Arial; background: hsl(197, 74%, 71%); display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-container { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 350px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 8px 0; border-radius: 5px; border: 1px solid #ccc; }
        button { width: 100%; padding: 10px; background: #4CAF50; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #45a049; }
        .login-link { text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <div class="login-link">
            <p>Already have an account? <a href="login.html">Login</a></p>
        </div>
    </div>
</body>
</html>
