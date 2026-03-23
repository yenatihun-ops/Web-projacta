<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "Bye@2709";
$dbname = "drugmanagement";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $drug_name       = trim($_POST['drug_name']);
    $category        = trim($_POST['category']);
    $dosage          = trim($_POST['dosage']);
    $quantity        = trim($_POST['quantity']);
    $manufacture_date = trim($_POST['manufacture_date']);
    $expiry_date      = trim($_POST['expiry_date']);
    $prescription    = trim($_POST['prescription']);
    $side_effects    = trim($_POST['side_effects']);

    // Server-side validation
    if (empty($drug_name) || empty($category) || empty($dosage) || empty($quantity) || empty($manufacture_date) || empty($expiry_date) || empty($prescription) || empty($side_effects)) {
        $message = "❌ All fields are required.";
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $drug_name)) {
        $message = "❌ Drug name must contain only letters.";
    } elseif (!preg_match("/^[0-9]+$/", $dosage)) {
        $message = "❌ Dosage must be only numbers (mg).";
    } elseif (!preg_match("/^[0-9]+$/", $quantity)) {
        $message = "❌ Quantity must be only numbers.";
    } else {
        // Insert into database
        $sql = "INSERT INTO drugs (drug_name, category, dosage, quantity, manufacture_date, expiry_date, prescription, side_effects)
                VALUES ('$drug_name', '$category', '$dosage', '$quantity', '$manufacture_date', '$expiry_date', '$prescription', '$side_effects')";
        if ($conn->query($sql)) {
            $message = "✅ Drug registered successfully!";
            // Clear fields
            $drug_name = $category = $dosage = $quantity = $manufacture_date = $expiry_date = $prescription = $side_effects = "";
        } else {
            $message = "❌ Database Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Drug Registration</title>

<style>
/* Your previous styles (simplified) */
body { font-family: Arial, sans-serif; background: linear-gradient(135deg,#6dd5ed,#2193b0); margin:0; padding:0; color:#333; }
nav { background: rgba(0,0,0,0.6); padding:15px; text-align:center; }
nav a { color:#fff; text-decoration:none; margin:0 15px; font-weight:bold; transition:0.3s; }
nav a:hover { color:#ffeb3b; }
.drug-registration { max-width:700px; margin:40px auto; background:#ffffffdd; padding:30px; border-radius:15px; box-shadow:0 8px 20px rgba(0,0,0,0.3); }
.drug-registration h2 { text-align:center; margin-bottom:25px; color:#0d47a1; font-size:28px; }
.drug-form label { display:block; margin:12px 0 5px; font-weight:bold; color:#01579b; }
.drug-form input, .drug-form select, .drug-form textarea { width:100%; padding:10px; border-radius:8px; border:1px solid #81d4fa; font-size:14px; }
.drug-form input:focus, .drug-form select:focus, .drug-form textarea:focus { border-color:#0288d1; outline:none; }
.drug-form button { margin-top:20px; padding:12px 25px; border:none; border-radius:8px; font-weight:bold; cursor:pointer; font-size:16px; }
.drug-form button[type="submit"] { background:#0288d1; color:#fff; }
.drug-form button[type="submit"]:hover { background:#01579b; }
.drug-form button[type="reset"] { background:#f44336; color:#fff; margin-left:10px; }
.drug-form button[type="reset"]:hover { background:#d32f2f; }
.message { text-align:center; font-size:16px; margin-bottom:15px; }
.message.success { color:green; }
.message.error { color:red; }
</style>

<script>
// Client-side validation
function validateForm() {
    let drug_name = document.forms["drugForm"]["drug_name"].value.trim();
    let category = document.forms["drugForm"]["category"].value.trim();
    let dosage = document.forms["drugForm"]["dosage"].value.trim();
    let quantity = document.forms["drugForm"]["quantity"].value.trim();
    let manufacture_date = document.forms["drugForm"]["manufacture_date"].value.trim();
    let expiry_date = document.forms["drugForm"]["expiry_date"].value.trim();
    let prescription = document.forms["drugForm"]["prescription"].value.trim();
    let side_effects = document.forms["drugForm"]["side_effects"].value.trim();

    if (!drug_name || !category || !dosage || !quantity || !manufacture_date || !expiry_date || !prescription || !side_effects) {
        alert("All fields are required.");
        return false;
    }
    if (!/^[a-zA-Z ]+$/.test(drug_name)) {
        alert("Drug name must contain only letters.");
        return false;
    }
    if (!/^[0-9]+$/.test(dosage)) {
        alert("Dosage must be only numbers (mg).");
        return false;
    }
    if (!/^[0-9]+$/.test(quantity)) {
        alert("Quantity must be only numbers.");
        return false;
    }
    return true;
}
</script>
</head>
<body>

<nav style="padding-left: 120px;">
    <a href="myproject4.html">myproject</a>
    <a href="home.html.html">Home</a>
    <a href="about.html.html">About Us</a>
    <a href="contactus.html">Contact Us</a>
    <a href="service.php">Service</a>
    <a href="drugregistration.php">Register Drug</a>
    <a href="logout.php" >Logout</a>
</nav>

<section class="drug-registration">
    <h2>Drug Registration Form</h2>

    <?php
    if ($message != "") {
        $class = strpos($message, "❌") !== false ? "error" : "success";
        echo "<div class='message $class'>$message</div>";
    }
    ?>

    <form class="drug-form" name="drugForm" action="" method="post" onsubmit="return validateForm();">
        <label>Drug Name</label>
        <input type="text" name="drug_name" value="<?php echo isset($drug_name)?htmlspecialchars($drug_name):''; ?>" placeholder="Enter drug name">

        <label>Drug Category</label>
        <select name="category">
            <option value="">-- Select Category --</option>
            <option <?php if(isset($category) && $category=="Antibiotic") echo "selected";?>>Antibiotic</option>
            <option <?php if(isset($category) && $category=="Pain Killer") echo "selected";?>>Pain Killer</option>
            <option <?php if(isset($category) && $category=="Antipyretic") echo "selected";?>>Antipyretic</option>
            <option <?php if(isset($category) && $category=="Antiseptic") echo "selected";?>>Antiseptic</option>
            <option <?php if(isset($category) && $category=="Other") echo "selected";?>>Other</option>
        </select>

        <label>Dosage (mg)</label>
        <input type="text" name="dosage" value="<?php echo isset($dosage)?htmlspecialchars($dosage):''; ?>" placeholder="Enter dosage in mg">

        <label>Quantity in Stock</label>
        <input type="number" name="quantity" value="<?php echo isset($quantity)?htmlspecialchars($quantity):''; ?>" placeholder="Enter quantity">

        <label>Manufacture Date</label>
        <input type="date" name="manufacture_date" value="<?php echo isset($manufacture_date)?htmlspecialchars($manufacture_date):''; ?>">

        <label>Expiry Date</label>
        <input type="date" name="expiry_date" value="<?php echo isset($expiry_date)?htmlspecialchars($expiry_date):''; ?>">

        <label>Prescription Required</label>
        <select name="prescription">
            <option <?php if(isset($prescription) && $prescription=="Yes") echo "selected";?>>Yes</option>
            <option <?php if(isset($prescription) && $prescription=="No") echo "selected";?>>No</option>
        </select>

        <label>Side Effects</label>
        <textarea name="side_effects" rows="3"><?php echo isset($side_effects)?htmlspecialchars($side_effects):''; ?></textarea>

        <button type="submit">Register Drug</button>
        <button type="reset">Clear</button>
    </form>
</section>



</body>
</html>
