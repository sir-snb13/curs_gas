<?php
require_once '../db.php';

header('Content-Type: application/json');

// Получаем параметр округа из запроса (если передан)
$district = isset($_GET['district']) ? $_GET['district'] : 'all';

// Формируем SQL-запрос
$sql = "SELECT id, FullName AS name, Address AS address, District as district, geoData AS coordinates 
        FROM good_gas_stations"; // Исправили поле таблицы

if ($district !== 'all') {
    // Добавляем фильтрацию по округу
    $sql .= " WHERE AdmArea LIKE '%$district%'"; // Учитываем поле AdmArea
}

// Выполняем запрос
$result = $conn->query($sql);

$stations = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Проверяем, что поле coordinates не пустое
        if (!empty($row['coordinates'])) {
            // Убираем ненужные части строки и парсим координаты
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
        $stations[] = $row;
    }
}

echo json_encode($stations);
$conn->close();
?>
