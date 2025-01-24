<?php
require_once '../db.php';

header('Content-Type: application/json');

$district = isset($_GET['district']) ? $_GET['district'] : 'all';

// Формируем запрос
$sql = "SELECT id, FullName AS name, Address AS address, geoData AS coordinates
        FROM user_good_gas_stations";

if ($district !== 'all') {
    $sql .= " WHERE AdmArea LIKE '%" . $conn->real_escape_string($district) . "%'";
}

// Выполняем запрос и проверяем результат
$result = $conn->query($sql);

if (!$result) {
    // Логируем ошибку и возвращаем сообщение об ошибке
    echo json_encode(["error" => "Ошибка выполнения SQL-запроса", "details" => $conn->error]);
    $conn->close();
    exit();
}

$stations = [];

// Обрабатываем результат запроса
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Проверяем, что поле coordinates не пустое
        if (!empty($row['coordinates'])) {
            preg_match('/\[(.*?)\]/', $row['coordinates'], $matches);
            if (isset($matches[1])) {
                $coords = explode(',', $matches[1]);
                $row['coordinates'] = [floatval($coords[0]), floatval($coords[1])];
            } else {
                $row['coordinates'] = null;
            }
        } else {
            $row['coordinates'] = null;
        }
        
        // Добавляем проверки для Violations
        $row['violations'] = !empty($row['violations']) ? $row['violations'] : 'Нет данных';

        $stations[] = $row;
    }
}

// Возвращаем данные в формате JSON
echo json_encode($stations);
$conn->close();
?>
