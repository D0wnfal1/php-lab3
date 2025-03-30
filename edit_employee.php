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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $surname = $_POST['surname'];
    $room_number = $_POST['room_number'];

    $sql = "UPDATE employees SET surname='$surname', room_number='$room_number' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Помилка: " . $conn->error;
    }
}

$sql = "SELECT * FROM employees WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<h2>Редагувати співробітника</h2>
<form method="POST">
    Прізвище: <input type="text" name="surname" value="<?php echo $row['surname']; ?>" required><br>
    Номер кімнати: <input type="number" name="room_number" value="<?php echo $row['room_number']; ?>" required><br>
    <input type="submit" value="Оновити">
</form>

<?php $conn->close(); ?>
