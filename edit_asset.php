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
    $id = $_POST['id'];
    $employee_id = $_POST['employee_id'];
    $item = $_POST['item'];
    $issue_date = $_POST['issue_date'];

    $sql = "UPDATE assets SET employee_id='$employee_id', item='$item', issue_date='$issue_date' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Помилка: " . $sql . "<br>" . $conn->error;
    }
}

$id = $_GET['id'];
$sql = "SELECT * FROM assets WHERE id=$id";
$result = $conn->query($sql);
$asset = $result->fetch_assoc();

$conn->close();
?>

<h2>Редагувати матеріальну цінність</h2>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $asset['id']; ?>">

    <label for="employee_id">Співробітник:</label>
    <select name="employee_id" required>
        <?php
        $conn = new mysqli($servername, $username, $password, $dbname);
        $result = $conn->query("SELECT id, surname FROM employees");
        while ($row = $result->fetch_assoc()) {
            $selected = ($row['id'] == $asset['employee_id']) ? "selected" : "";
            echo "<option value='" . $row['id'] . "' $selected>" . $row['surname'] . "</option>";
        }
        ?>
    </select><br><br>

    <label for="item">Виріб:</label>
    <input type="text" name="item" value="<?php echo $asset['item']; ?>" required><br><br>

    <label for="issue_date">Дата видачі:</label>
    <input type="date" name="issue_date" value="<?php echo $asset['issue_date']; ?>" required><br><br>

    <button type="submit">Оновити</button>
</form>
