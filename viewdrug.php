<?php
// Database connection
$conn = new mysqli("localhost", "root", "Bye@2709", "drugmanagement");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all drugs
$sql = "SELECT * FROM drugs ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Drugs</title>
<style>
body { font-family: Arial, sans-serif; background:#e0f7fa; color:#333; margin:0; padding:0; }
nav { background:#00796b; padding:15px; text-align:center; }
nav a { color:#fff; margin:0 15px; text-decoration:none; font-weight:bold; }
nav a:hover { color:#ffeb3b; }
.container { max-width:900px; margin:30px auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.2); }
h2 { text-align:center; color:#004d40; }
table { width:100%; border-collapse:collapse; margin-top:20px; }
table, th, td { border:1px solid #004d40; }
th, td { padding:10px; text-align:center; }
th { background:#004d40; color:#fff; }
tr:nth-child(even) { background:#e0f2f1; }
</style>
</head>
<body>

<nav>
    <a href="drugregistration.php">Add Drug</a>
    <a href="viewdrug.php">View Drugs</a>
    <a href="selldrug.php">Sell Drug</a>
</nav>

<div class="container">
    <h2>Registered Drugs</h2>
    <?php if($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Dosage (mg)</th>
            <th>Quantity</th>
            <th>Manufacture Date</th>
            <th>Expiry Date</th>
            <th>Prescription</th>
            <th>Side Effects</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['drug_name']) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td><?= $row['dosage'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['manufacture_date'] ?></td>
            <td><?= $row['expiry_date'] ?></td>
            <td><?= $row['prescription'] ?></td>
            <td><?= htmlspecialchars($row['side_effects']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
    <p style="text-align:center; color:red;">No drugs registered yet.</p>
    <?php endif; ?>
</div>
<a href="about.html.html"><h1 style="text-align:center;">Back</h1></a>

</body>
</html>
