<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "company_assets";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

$sql = "CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    surname VARCHAR(50) NOT NULL,
    room_number INT NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Таблиця 'employees' створена успішно";
} else {
    echo "Помилка створення таблиці: " . $conn->error;
}

$conn->close();
?>
