<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "company_assets";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

echo "<h2>Пошук інформації в базі даних</h2>";
?>

<form method="GET" action="">
    <label for="keyword">Ключове слово (виріб):</label>
    <input type="text" name="keyword" id="keyword"><br>
    
    <label for="pattern">Шаблон (наприклад, '%Item%'):</label>
    <input type="text" name="pattern" id="pattern"><br>
    
    <label for="start_date">Дата початку (YYYY-MM-DD):</label>
    <input type="date" name="start_date" id="start_date"><br>
    
    <label for="end_date">Дата кінця (YYYY-MM-DD):</label>
    <input type="date" name="end_date" id="end_date"><br>
    
    <input type="submit" name="search" value="Пошук">
</form>

<?php
if (isset($_GET['search'])) {
    $keyword = $conn->real_escape_string(trim($_GET['keyword']));
    $pattern = $conn->real_escape_string(trim($_GET['pattern']));
    $start_date = $conn->real_escape_string(trim($_GET['start_date']));
    $end_date = $conn->real_escape_string(trim($_GET['end_date']));

    $where = [];
    if (!empty($keyword)) {
        $where[] = "assets.item LIKE '%$keyword%'";
    }
    if (!empty($pattern)) {
        $where[] = "assets.item LIKE '$pattern'";
    }
    if (!empty($start_date) && !empty($end_date)) {
        $where[] = "assets.issue_date BETWEEN '$start_date' AND '$end_date'";
    } elseif (!empty($start_date)) {
        $where[] = "assets.issue_date >= '$start_date'";
    } elseif (!empty($end_date)) {
        $where[] = "assets.issue_date <= '$end_date'";
    }
    
    $where_clause = "";
    if (count($where) > 0) {
        $where_clause = "WHERE " . implode(" AND ", $where);
    }

    $sql_search = "SELECT assets.id, assets.item, assets.issue_date, employees.surname AS employee_name 
                   FROM assets 
                   LEFT JOIN employees ON assets.employee_id = employees.id 
                   $where_clause
                   ORDER BY assets.issue_date DESC";
    $result_search = $conn->query($sql_search);

    echo "<h3>Результати пошуку</h3>";
    if ($result_search && $result_search->num_rows > 0) {
        echo "<table border='1'><tr><th>Виріб</th><th>Дата видачі</th><th>Співробітник</th></tr>";
        while ($row = $result_search->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["item"] . "</td>";
            echo "<td>" . $row["issue_date"] . "</td>";
            echo "<td>" . ($row["employee_name"] ? $row["employee_name"] : "Немає даних") . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>За заданими критеріями записів не знайдено.</p>";
    }
}

echo "<p><a href='index.php'>Повернутися на головну сторінку</a></p>";

$conn->close();
?>
