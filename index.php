<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "test_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Prevent error by ensuring table exists
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Submission</title>
</head>
<body>
    <h2>Submit your Info</h2>
    <form action="submit.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" required><br><br>
        <input type="email" name="email" placeholder="Your Email" required><br><br>
        <input type="text" name="number" placeholder="Your Number" required><br><br>
        <button type="submit">Submit</button>
    </form>

    <h3>Submitted Data:</h3>
    <table border="1" cellpadding="5">
        <tr><th>Name</th><th>Email</th><th>Number</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['number']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
