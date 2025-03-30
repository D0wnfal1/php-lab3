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

$sql = "DELETE FROM employees WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Запис видалено успішно!";
} else {
    echo "Помилка: " . $conn->error;
}

$conn->close();
?>

<a href="index.php">Назад</a>
