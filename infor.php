<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "company_assets";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

$sql_total_employees = "SELECT COUNT(*) AS total FROM employees";
$result_total_employees = $conn->query($sql_total_employees);
$total_employees = ($result_total_employees && $row = $result_total_employees->fetch_assoc()) ? $row['total'] : 0;

$sql_total_assets = "SELECT COUNT(*) AS total FROM assets";
$result_total_assets = $conn->query($sql_total_assets);
$total_assets = ($result_total_assets && $row = $result_total_assets->fetch_assoc()) ? $row['total'] : 0;

$sql_lastmonth_assets = "SELECT COUNT(*) AS lastmonth FROM assets WHERE issue_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
$result_lastmonth_assets = $conn->query($sql_lastmonth_assets);
$lastmonth_assets = ($result_lastmonth_assets && $row = $result_lastmonth_assets->fetch_assoc()) ? $row['lastmonth'] : 0;

$sql_last_employee = "SELECT * FROM employees ORDER BY id DESC LIMIT 1";
$result_last_employee = $conn->query($sql_last_employee);
$last_employee = ($result_last_employee && $row = $result_last_employee->fetch_assoc()) ? $row : null;

$sql_employee_most_assets = "SELECT e.id, e.surname, COUNT(a.id) AS asset_count 
                             FROM employees e 
                             LEFT JOIN assets a ON e.id = a.employee_id 
                             GROUP BY e.id 
                             ORDER BY asset_count DESC 
                             LIMIT 1";
$result_employee_most_assets = $conn->query($sql_employee_most_assets);
$employee_most_assets = ($result_employee_most_assets && $row = $result_employee_most_assets->fetch_assoc()) ? $row : null;

echo "<h2>Статистика бази даних</h2>";
echo "<p>Загальна кількість співробітників: <strong>$total_employees</strong></p>";
echo "<p>Загальна кількість матеріальних цінностей: <strong>$total_assets</strong></p>";
echo "<p>Записів за останній місяць у матеріальних цінностях: <strong>$lastmonth_assets</strong></p>";

if ($last_employee) {
    echo "<p>Останній запис у співробітниках: <strong>ID: " . $last_employee['id'] . " | Прізвище: " . $last_employee['surname'] . "</strong></p>";
} else {
    echo "<p>Немає записів для визначення останнього співробітника.</p>";
}

if ($employee_most_assets) {
    echo "<p>Співробітник з найбільшою кількістю матеріальних цінностей: <strong>ID: " . $employee_most_assets['id'] . " | Прізвище: " . $employee_most_assets['surname'] . " (Кількість: " . $employee_most_assets['asset_count'] . ")</strong></p>";
} else {
    echo "<p>Немає даних для визначення співробітника з найбільшою кількістю цінностей.</p>";
}

echo "<p><a href='index.php'>Повернутися на головну сторінку</a></p>";

$conn->close();
?>
