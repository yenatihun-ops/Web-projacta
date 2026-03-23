<?php
// Connect to MySQL database
$conn = mysqli_connect("localhost", "root", "Bye@2709", "drugmanagement");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$message = ""; // Success or error message

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $phone   = trim($_POST['phone']);
    $email   = trim($_POST['email']);
    $service = trim($_POST['service']);
    $drug    = trim($_POST['drug_name']);
    $date    = trim($_POST['service_date']);
    $address = trim($_POST['address']);

    // -------- SERVER-SIDE VALIDATION --------
    if (empty($name) || empty($phone) || empty($email) || empty($service) || empty($drug) || empty($date) || empty($address)) {
        $message = "❌ All fields are required.";
    } elseif (!preg_match("/^[a-zA-Z ]{4,}$/", $name)) {
        $message = "❌ Name must contain only letters and be at least 4 characters.";
    } elseif (!preg_match("/^[0-9]{7,15}$/", $phone)) {
        $message = "❌ Phone number must contain only digits (7-15 digits).";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "❌ Invalid email format.";
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $drug)) {
        $message = "❌ Drug name must contain only letters.";
    } else {
        // Insert into database
        $sql = "INSERT INTO services (name, phone, email, service, drug_name, service_date, address)
                VALUES ('$name','$phone','$email','$service','$drug','$date','$address')";

        if (mysqli_query($conn, $sql)) {
            $message = "✅ Service request saved successfully!";
            // Clear form fields after successful submission
            $name = $phone = $email = $service = $drug = $date = $address = "";
        } else {
            $message = "❌ Database Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Drug Store Service Form</title>

<style>
* { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
body {
    min-height: 100vh;
    background: linear-gradient(135deg, #89f7fe, #66a6ff);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}
.form-card {
    background: #ffffffee;
    border-radius: 25px;
    padding: 40px 35px;
    max-width: 550px;
    width: 100%;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}
.form-card h2 { text-align: center; margin-bottom: 30px; font-size: 32px; color: #4a148c; }
.form-group { position: relative; margin-bottom: 25px; }
.form-group input,
.form-group select,
.form-group textarea { width: 100%; padding: 14px 16px; border-radius: 12px; border: 1px solid #ce93d8; background: transparent; }
.form-group label { position: absolute; top: -10px; left: 16px; background: #ffffffee; padding: 0 5px; color: #6a1b9a; font-size: 14px; }
.btn-group { display: flex; gap: 12px; }
button { flex: 1; padding: 14px; font-size: 16px; border: none; border-radius: 12px; cursor: pointer; }
button[type="submit"] { background: linear-gradient(45deg, #6a1b9a, #ab47bc); color: #fff; }
button[type="reset"] { background: linear-gradient(45deg, #ff7043, #ff8a65); color: #fff; }
.message { text-align: center; font-size: 16px; margin-bottom: 15px; }
.message.success { color: green; }
.message.error { color: red; }
</style>

<script>
// CLIENT-SIDE VALIDATION
function validateForm() {
    let name = document.forms["serviceForm"]["name"].value.trim();
    let phone = document.forms["serviceForm"]["phone"].value.trim();
    let email = document.forms["serviceForm"]["email"].value.trim();
    let drug = document.forms["serviceForm"]["drug_name"].value.trim();
    let service = document.forms["serviceForm"]["service"].value;
    let date = document.forms["serviceForm"]["service_date"].value.trim();
    let address = document.forms["serviceForm"]["address"].value.trim();

    // Name validation
    if (!/^[a-zA-Z ]{4,}$/.test(name)) {
        alert("Name must contain only letters and be at least 4 characters.");
        return false;
    }
    // Phone validation
    if (!/^[0-9]{7,15}$/.test(phone)) {
        alert("Phone number must contain only digits (7-15 digits).");
        return false;
    }
    // Email validation
    let emailPattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        alert("Invalid email format.");
        return false;
    }
    // Drug name validation
    if (!/^[a-zA-Z ]+$/.test(drug)) {
        alert("Drug name must contain only letters.");
        return false;
    }
    // Service selection
    if (service === "") {
        alert("Please select a service.");
        return false;
    }
    // Date and address
    if (date === "") { alert("Please select a service date."); return false; }
    if (address === "") { alert("Please enter your address."); return false; }

    return true; // All validations passed
}
</script>
</head>

<body>
<div class="form-card">
<h2>Drug Store Service</h2>

<?php
if ($message != "") {
    $class = strpos($message, "❌") !== false ? "error" : "success";
    echo "<div class='message $class'>$message</div>";
}
?>

<form name="serviceForm" method="POST" action="" onsubmit="return validateForm();">

    <div class="form-group">
        <input type="text" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>
        <label>Name</label>
    </div>

    <div class="form-group">
        <input type="tel" name="phone" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" required>
        <label>Phone</label>
    </div>

    <div class="form-group">
        <input type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
        <label>Email</label>
    </div>

    <div class="form-group">
        <select name="service" required>
            <option value="">Select Service</option>
            <option value="Prescription Filling" <?php if(isset($service) && $service=="Prescription Filling") echo "selected";?>>Prescription Filling</option>
            <option value="Medicine Refill" <?php if(isset($service) && $service=="Medicine Refill") echo "selected";?>>Medicine Refill</option>
            <option value="Home Delivery" <?php if(isset($service) && $service=="Home Delivery") echo "selected";?>>Home Delivery</option>
            <option value="Consultation" <?php if(isset($service) && $service=="Consultation") echo "selected";?>>Consultation</option>
        </select>
        <label>Service</label>
    </div>

    <div class="form-group">
        <input type="text" name="drug_name" value="<?php echo isset($drug) ? htmlspecialchars($drug) : ''; ?>" required>
        <label>Drug Name</label>
    </div>

    <div class="form-group">
        <input type="date" name="service_date" value="<?php echo isset($date) ? htmlspecialchars($date) : ''; ?>" required>
        <label>Service Date</label>
    </div>

    <div class="form-group">
        <textarea name="address" rows="3" required><?php echo isset($address) ? htmlspecialchars($address) : ''; ?></textarea>
        <label>Address</label>
    </div>

    <div class="btn-group">
        <button type="submit">Submit</button>
        <button type="reset">Clear</button>
    </div>
</form>

<a href="about.html.html"><h1 style="text-align:center;">Back</h1></a>
</div>
</body>
</html>
