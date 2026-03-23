<?php
$conn = new mysqli("localhost", "root", "Bye@2709", "drugmanagement");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$message = "";
$total_price = "";

// Handle sale
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $drug_id = $_POST['drug_id'];
    $sell_quantity = $_POST['sell_quantity'];

    // Fetch current quantity and price
    $stmt = $conn->prepare("SELECT quantity, price FROM drugs WHERE id=?");
    $stmt->bind_param("i", $drug_id);
    $stmt->execute();
    $stmt->bind_result($current_quantity, $price);
    $stmt->fetch();
    $stmt->close();

    if ($sell_quantity <= 0) {
        $message = "❌ Quantity must be positive.";
    } elseif ($sell_quantity > $current_quantity) {
        $message = "❌ Not enough stock. Available: $current_quantity";
    } else {
        $new_quantity = $current_quantity - $sell_quantity;
        $stmt = $conn->prepare("UPDATE drugs SET quantity=? WHERE id=?");
        $stmt->bind_param("ii", $new_quantity, $drug_id);
        if($stmt->execute()) {
            $total_price = $sell_quantity * $price;
            $message = "✅ Sold $sell_quantity units successfully! Total: $total_price Birr";
        } else {
            $message = "❌ Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all drugs for selection
$drugs = $conn->query("SELECT * FROM drugs ORDER BY drug_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sell Drug</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #6dd5ed, #2193b0);
    margin:0;
    padding:0;
    color:#333;
}
.container {
    max-width: 500px;
    margin: 50px auto;
    background: #ffffffdd;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    text-align: left;
}
h2 {
    text-align: center;
    color: #0d47a1;
    margin-bottom: 20px;
}
form label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
}
form select, form input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border:1px solid #81d4fa;
    font-size: 14px;
}
form input:focus, form select:focus {
    border-color:#0288d1;
    outline:none;
}
button {
    margin-top:20px;
    padding:12px 25px;
    border:none;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
    font-size:16px;
    background:#0288d1;
    color:#fff;
}
button:hover { background:#01579b; }
.message {
    text-align:center;
    font-size:16px;
    margin-bottom:15px;
}
.message.success { color:green; }
.message.error { color:red; }
.total {
    font-weight:bold;
    color:#004d40;
    margin-top:15px;
    text-align:center;
}
a { display:block; text-align:center; margin-top:20px; color:#01579b; text-decoration:none; font-weight:bold; }
a:hover { color:#0288d1; }
</style>
<script>
function calculateTotal() {
    let drugSelect = document.getElementById("drug_id");
    let quantity = document.getElementById("sell_quantity").value;
    let price = drugSelect.selectedOptions[0].dataset.price || 0;
    let total = quantity * price;
    document.getElementById("total_price").innerText = total ? "Total: " + total + " Birr" : "";
}
</script>
</head>
<body>

<div class="container">
    <h2>Sell Drug</h2>
    <?php 
    if($message) {
        $class = strpos($message, "❌") !== false ? "error" : "success";
        echo "<div class='message $class'>$message</div>";
    }
    ?>
    <form method="post">
        <label>Select Drug:</label>
        <select name="drug_id" id="drug_id" onchange="calculateTotal()" required>
            <option value="">--Select Drug--</option>
            <?php while($row = $drugs->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>">
                    <?= htmlspecialchars($row['drug_name']) ?> (Available: <?= $row['quantity'] ?>, Price: <?= $row['price'] ?> Birr)
                </option>
            <?php endwhile; ?>
        </select>

        <label>Quantity to Sell:</label>
        <input type="number" name="sell_quantity" id="sell_quantity" min="1" oninput="calculateTotal()" required>

        <div id="total_price" class="total"><?= $total_price ? "Total: $total_price Birr" : "" ?></div>

        <button type="submit">Sell</button>
    </form>
    <a href="viewdrug.php">Back to Drug List</a>
</div>
<a href="about.html.html"><h1 style="text-align:center;">Back</h1></a>
</body>
</html>
