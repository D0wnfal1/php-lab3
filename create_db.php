<?php
$servername = "localhost";
$username = "admin";
$password = "admin";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

$sql = "CREATE DATABASE company_assets";
if ($conn->query($sql) === TRUE) {
    echo "База даних створена успішно";
} 
else {
    echo "Помилка створення бази даних: " . $conn->error;
}

$conn->close();
?>
