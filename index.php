<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "company_assets";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

echo "<p>
        <a href='infor.php'>Переглянути статистику</a> | 
        <a href='search.php'>Пошук інформації</a>
      </p>";

$order_by_employees = isset($_GET['order_by_employees']) ? $_GET['order_by_employees'] : 'surname'; 
$order_employees = isset($_GET['order_employees']) ? $_GET['order_employees'] : 'ASC'; 
$new_order_employees = ($order_employees == 'ASC') ? 'DESC' : 'ASC'; 

$order_by_assets = isset($_GET['order_by_assets']) ? $_GET['order_by_assets'] : 'item'; 
$order_assets = isset($_GET['order_assets']) ? $_GET['order_assets'] : 'ASC'; 
$new_order_assets = ($order_assets == 'ASC') ? 'DESC' : 'ASC'; 

$valid_order_columns_employees = ['surname', 'room_number'];
$valid_order_columns_assets = ['item', 'issue_date'];

if (!in_array($order_by_employees, $valid_order_columns_employees)) {
    $order_by_employees = 'surname'; 
}

if (!in_array($order_by_assets, $valid_order_columns_assets)) {
    $order_by_assets = 'item'; 
}

$sql_employees = "SELECT employees.id, employees.surname, employees.room_number
                  FROM employees ORDER BY employees.$order_by_employees $order_employees";

$sql_assets = "SELECT assets.id, assets.item, assets.issue_date, employees.surname AS employee_name
               FROM assets
               LEFT JOIN employees ON assets.employee_id = employees.id
               ORDER BY assets.$order_by_assets $order_assets"; 

$result_employees = $conn->query($sql_employees);
$result_assets = $conn->query($sql_assets);

echo "<h2>Список співробітників</h2>";
echo "<a href='add_employee.php'>Додати нового співробітника</a><br><br>";
echo "<a href='?order_by_employees=surname&order_employees=$new_order_employees'>Сортувати за прізвищем</a> | ";
echo "<a href='?order_by_employees=room_number&order_employees=$new_order_employees'>Сортувати за кімнатою</a>";
echo "<table border='1'><tr><th>Прізвище</th><th>Номер кімнати</th><th>Дії</th></tr>";

if ($result_employees->num_rows > 0) {
    while ($row = $result_employees->fetch_assoc()) {
        echo "<tr>";
        echo "<td><a href='employee_details.php?id=" . $row["id"] . "'>" . $row["surname"] . "</a></td>";
        echo "<td>" . $row["room_number"] . "</td>";
        echo "<td><a href='edit_employee.php?id=" . $row["id"] . "'>Редагувати</a> | 
                  <a href='delete_employee.php?id=" . $row["id"] . "'>Видалити</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>Немає даних</td></tr>";
}

echo "</table>";

echo "<h2>Список матеріальних цінностей</h2>";
echo "<a href='add_asset.php'>Додати нову матеріальну цінність</a><br><br>";
echo "<a href='?order_by_assets=item&order_assets=$new_order_assets'>Сортувати за виробом</a> | ";
echo "<a href='?order_by_assets=issue_date&order_assets=$new_order_assets'>Сортувати за датою видачі</a>";
echo "<table border='1'><tr><th>Виріб</th><th>Дата видачі</th><th>Співробітник</th><th>Дії</th></tr>";

if ($result_assets->num_rows > 0) {
    while ($row = $result_assets->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["item"] . "</td>";
        echo "<td>" . $row["issue_date"] . "</td>";
        echo "<td>" . ($row["employee_name"] ? $row["employee_name"] : "Немає даних") . "</td>";
        echo "<td><a href='edit_asset.php?id=" . $row["id"] . "'>Редагувати</a> | 
                  <a href='delete_asset.php?id=" . $row["id"] . "'>Видалити</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>Немає даних</td></tr>";
}

echo "</table>";

$conn->close();
?>
