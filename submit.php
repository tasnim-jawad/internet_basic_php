<?php
// Step 1: Database connection
$conn = new mysqli("localhost", "root", "", "test_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Ensure table exists
$create_table_sql = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    number VARCHAR(20) NOT NULL
) ENGINE=InnoDB;
";
$conn->query($create_table_sql); // silently try to create

// Step 3: Basic validation
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$number = trim($_POST['number']);

$errors = [];

if (empty($name)) $errors[] = "Name is required.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email.";
if (!preg_match('/^\d{10,15}$/', $number)) $errors[] = "Number must be 10-15 digits.";

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
    echo '<a href="index.php">Go back</a>';
    exit;
}

// Step 4: Insert into database
$stmt = $conn->prepare("INSERT INTO users (name, email, number) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $number);
$stmt->execute();
$stmt->close();

// Step 5: Redirect back to form
header("Location: index.php");
exit;
