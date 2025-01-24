<?php
session_save_path("C:/xampp/htdocs/curs/sessions");
session_start();

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $FullName = $conn->real_escape_string($_POST['FullName']);
    $ShortName = $conn->real_escape_string($_POST['ShortName']);
    $AdmArea = $conn->real_escape_string($_POST['AdmArea']);
    $District = $conn->real_escape_string($_POST['District']);
    $Address = $conn->real_escape_string($_POST['Address']);
    $Owner = $conn->real_escape_string($_POST['Owner']);
    $Violations = $conn->real_escape_string($_POST['Violations']);
    $TestDate = $conn->real_escape_string($_POST['TestDate']);
    $geoData = $_POST['geoData'];

    // Проверка координат
    if (!empty($geoData)) {
        $coordinates = explode(',', $geoData);

        if (count($coordinates) === 2) {
            $latitude = trim($coordinates[0]);
            $longitude = trim($coordinates[1]);
            if (is_numeric($latitude) && is_numeric($longitude)) {
                // Форматируем geoData как JSON-объект
                $geoDataFormatted = '{"coordinates":[' . (float)$longitude . ', ' . (float)$latitude . '], "type":"Point"}';
            } else {
                die("Неверный формат координат. Введите широту и долготу как числа.");
            }
        } else {
            die("Введите широту и долготу через запятую.");
        }
    } else {
        die("Введите координаты.");
    }

    $geodata_center = $geoDataFormatted;

    // Проверяем, авторизован ли пользователь
    if (!isset($_SESSION['user_id'])) {
        die("Ошибка: пользователь не авторизован.");
    }

    // SQL-запрос
    $sql = "INSERT INTO user_bad_gas_stations 
            (FullName, ShortName, AdmArea, District, Address, Owner, Violations, TestDate, geoData, geodata_center, user_id) 
            VALUES ('$FullName', '$ShortName', '$AdmArea', '$District', '$Address', '$Owner', '$Violations', '$TestDate', 
                    '$geoDataFormatted', '$geodata_center', " . intval($_SESSION['user_id']) . ")";

    if ($conn->query($sql)) {
        header("Location: /curs/frontend/map.php");
        exit();
    } else {
        echo "Ошибка при добавлении заправки: " . $conn->error;
    }
}
?>
