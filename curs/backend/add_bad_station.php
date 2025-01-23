<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /curs/frontend/login.php");  // Перенаправляем на страницу входа
    exit();
}

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

    if (!empty($geoData)) {
        $coordinates = explode(',', $geoData);
        
        if (count($coordinates) === 2) {
            $latitude = trim($coordinates[0]);
            $longitude = trim($coordinates[1]);
            if (is_numeric($latitude) && is_numeric($longitude)) {
                $geoDataFormatted = '{coordinates=[' . (float)$longitude . ', ' . (float)$latitude . '], type=Point}';
            } else {
                die("Invalid coordinates format. Please enter latitude and longitude as numbers.");
            }
        } else {
            die("Пожалуйса, введите координаты через запятую.");
        }
    } else {
        die("Введите данные координат.");
    }
    $geodata_center = $geoDataFormatted;

    // SQL Query
    $sql = "INSERT INTO bad_gas_stations (FullName, ShortName, AdmArea, District, Address, Owner, Violations, TestDate, geoData, geodata_center) 
            VALUES ('$FullName', '$ShortName', '$AdmArea', '$District', '$Address', '$Owner', '$Violations', '$TestDate', '$geoDataFormatted', '$geodata_center')";

    if ($conn->query($sql)) {
        header("Location: /curs/frontend/map.php");
        exit();
    } else {
        echo "Ошибка при добавлении заправки: " . $conn->error;
    }
}
?>
