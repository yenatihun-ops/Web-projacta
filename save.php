<?php
$conn = mysqli_connect("localhost", "root", "", "drugmanagement");

if (!$conn) {
    die("Database connection failed");
}

$drug = $_POST['drug_name'];
$cat = $_POST['category'];
$dosage = $_POST['dosage'];
$qty = $_POST['quantity'];
$mfg = $_POST['manufacture_date'];
$exp = $_POST['expiry_date'];
$pres = $_POST['prescription'];
$side = $_POST['side_effects'];

$sql = "INSERT INTO drugs 
(drug_name, category, dosage, quantity, manufacture_date, expiry_date, prescription, side_effects)
VALUES
('$drug','$cat','$dosage','$qty','$mfg','$exp','$pres','$side')";

mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Drug Registration</title>
    <style>
        body {
            background-color: lightblue;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h2>Drug registered successfully</h2>
</body>
</html>
