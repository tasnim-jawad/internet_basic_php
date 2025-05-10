<?php

session_start();
// Database connection
$conn = new mysqli("localhost", "root", "", "test_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn't exist
$conn->query("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    number VARCHAR(20) NOT NULL
)
");

// Fetch data
$result = $conn->query("SELECT * FROM users");


$errors = $_SESSION['form_errors'] ?? [];
$old = $_SESSION['old_input'] ?? [];
$success = $_SESSION['success'] ?? null;

unset($_SESSION['form_errors'], $_SESSION['old_input'], $_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f1f1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2, h3 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            margin-bottom: 40px;
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 90%;
            max-width: 800px;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            text-align: left;
            padding: 14px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        @media (max-width: 600px) {
            form, table {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- <?php if (!empty($errors)): ?>
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif (!empty($success)): ?>
        <div style="color: green; margin-bottom: 15px;">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?> -->

    <h2>Submit your Info</h2>
    <form action="submit.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
        <?php if (!empty($errors) && in_array("Name is required.", $errors)): ?>
            <div style="color:red; margin-bottom:10px;">Name is required.</div>
        <?php endif; ?>
        <input type="email" name="email" placeholder="Your Email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
        <?php if (!empty($errors) && in_array("Invalid email.", $errors)): ?>
            <div style="color:red; margin-bottom:10px;">Invalid email.</div>
        <?php endif; ?>
        <input type="text" name="number" placeholder="Your Number" value="<?= htmlspecialchars($old['number'] ?? '') ?>" required>
        <?php if (!empty($errors) && in_array("Number must be 10-15 digits.", $errors)): ?>
            <div style="color:red; margin-bottom:10px;">Number must be 10–15 digits.</div>
        <?php endif; ?>
        <input type="date" name="date" id="date" required>
        <div id="date-error" style="color: red; margin-bottom: 10px;"></div>
        <button type="submit">Submit</button>
    </form>

    <h3>Submitted Data</h3>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Number</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['number']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const dateInput = document.getElementById('date');
            const errorDiv = document.getElementById('date-error');
            const selectedDate = dateInput.value;
            const today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD

            if (selectedDate !== today) {
                e.preventDefault(); // Stop form submission
                errorDiv.textContent = "Date must match today's date.";
            } else {
                errorDiv.textContent = ""; // Clear any previous error
            }
        });
    </script>
</body>
</html>
