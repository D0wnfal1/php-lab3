<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "company_assets";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $surname = $_POST['surname'];
    $room_number = $_POST['room_number'];

    $sql = "INSERT INTO employees (surname, room_number) VALUES ('$surname', '$room_number')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Помилка: " . $conn->error;
    }
}

$conn->close();
?>

<h2>Додати співробітника</h2>
<form method="POST">
    Прізвище: <input type="text" name="surname" required><br>
    Номер кімнати: <input type="number" name="room_number" required><br>
    <input type="submit" value="Додати">
</form>
