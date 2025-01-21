<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: curs/frontend/login.html");  // Перенаправляем на страницу входа
    exit();
}

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $FullName = $_POST['FullName'];
    $Address = $_POST['Address'];
    $AdmArea = $_POST['AdmArea'];
    $District = $_POST['District'];
    $geoData = $_POST['geoData'];

    // Вставляем данные о плохой заправке в базу данных
    $sql = "INSERT INTO bad_gas_stations (FullName, Address, AdmArea, District, geoData) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $FullName, $Address, $AdmArea, $District, $geoData);

    if ($stmt->execute()) {
        echo "Плохая заправка успешно добавлена!";
    } else {
        echo "Ошибка при добавлении заправки!";
    }
}
?>
