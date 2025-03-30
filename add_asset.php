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
    $employee_id = $_POST['employee_id'];
    $item = $_POST['item'];
    $issue_date = $_POST['issue_date'];

    $sql = "INSERT INTO assets (employee_id, item, issue_date) VALUES ('$employee_id', '$item', '$issue_date')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit; 
    } else {
        echo "Помилка: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<h2>Додати нову матеріальну цінність</h2>
<form method="POST">
    <label for="employee_id">Співробітник:</label>
    <select name="employee_id" required>
        <?php
        $conn = new mysqli($servername, $username, $password, $dbname);
        $result = $conn->query("SELECT id, surname FROM employees");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['surname'] . "</option>";
        }
        ?>
    </select><br><br>

    <label for="item">Виріб:</label>
    <input type="text" name="item" required><br><br>

    <label for="issue_date">Дата видачі:</label>
    <input type="date" name="issue_date" required><br><br>

    <button type="submit">Додати</button>
</form>
