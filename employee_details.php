<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "company_assets";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "SELECT * FROM employees WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo "<h2>Деталі про співробітника</h2>";
echo "Прізвище: " . $row["surname"] . "<br>";
echo "Номер кімнати: " . $row["room_number"] . "<br>";

$conn->close();
?>
<a href="index.php">Назад</a>
