<?php
require_once '../db.php';

header('Content-Type: application/json');

$district = isset($_GET['district']) ? $_GET['district'] : 'all';

$sql = "SELECT id, FullName AS name, Address AS address, geoData AS coordinates, Violations AS violations 
        FROM bad_gas_stations";

if ($district !== 'all') {

    $sql .= " WHERE AdmArea LIKE '%$district%'";
}


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
        
        // Добавляем проверки для Violations
        $row['violations'] = !empty($row['violations']) ? $row['violations'] : 'Нет данных';

        $stations[] = $row;
    }
}

echo json_encode($stations);
$conn->close();
?>
