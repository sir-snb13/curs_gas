<?php
session_save_path("C:/xampp/htdocs/curs/sessions");
session_start();

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $FullName = $conn->real_escape_string($_POST['FullName']);
    $ShortName = $conn->real_escape_string($_POST['ShortName']);
    $AdmArea = $conn->real_escape_string($_POST['AdmArea']);
    $District = $conn->real_escape_string($_POST['District']);
    $Address = $conn->real_escape_string($_POST['Address']);
    $Owner = $conn->real_escape_string($_POST['Owner']);
    $TestDate = $conn->real_escape_string($_POST['TestDate']);
    $geoData = $_POST['geoData'];

    if (!empty($geoData)) {
        $coordinates = explode(',', $geoData);
        
        if (count($coordinates) === 2) {
            $latitude = trim($coordinates[0]);
            $longitude = trim($coordinates[1]);

            if (is_numeric($latitude) && is_numeric($longitude)) {
                $geoDataFormatted = '{"coordinates":[' . (float)$longitude . ', ' . (float)$latitude . '], "type":"Point"}';
            } else {
                die("Неправильный формат координат");
            }
        } else {
            die("Напишите широту и долготу через запятую");
        }
    } else {
        die("Данные обязательны");
    }

    $geodata_center = $geoDataFormatted;

    // Подготовка запроса SQL
    $sql = "INSERT INTO user_good_gas_stations 
            (FullName, ShortName, AdmArea, District, Address, Owner, TestDate, geoData, geodata_center, user_id)
            VALUES ('$FullName', '$ShortName', '$AdmArea', '$District', '$Address', '$Owner', '$TestDate', 
                    '$geoDataFormatted', '$geodata_center', {$_SESSION['user_id']})";

    if ($conn->query($sql)) {
        header("Location: /curs/frontend/map.php");
        exit();
    } else {
        echo "Ошибка при добавлении заправки: " . $conn->error;
    }
}
?>
