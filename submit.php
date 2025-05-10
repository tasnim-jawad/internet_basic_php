<?php
session_start();
$conn = new mysqli("localhost", "root", "", "test_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$create_table_sql = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    number VARCHAR(20) NOT NULL
) ENGINE=InnoDB;
";
$conn->query($create_table_sql); 


$name = trim($_POST['name']);
$email = trim($_POST['email']);
$number = trim($_POST['number']);

$errors = [];

if (empty($name)) $errors[] = "Name is required.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email.";
if (!preg_match('/^\d{5,15}$/', $number)) $errors[] = "Number must be 5-15 digits.";

if (!empty($errors)) {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['old_input'] = ['name' => $name, 'email' => $email, 'number' => $number];
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("INSERT INTO users (name, email, number) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $number);
$stmt->execute();
$stmt->close();

unset($_SESSION['old_input']);
$_SESSION['success'] = "Form submitted successfully!";
header("Location: index.php");
exit;
