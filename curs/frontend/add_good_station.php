<?php
session_save_path("C:/xampp/htdocs/curs/sessions"); 
session_start(); 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить хорошую заправку</title>
    <link rel="stylesheet" href="/curs/frontend/css/style.css">
</head>
<body>
    <header>
        <h1>Заправки Москвы</h1>
        <nav>
            <ul>
                <li><a href="/curs/frontend/index.php">Главная</a></li>
                <li><a href="/curs/frontend/map.php">Карта</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/curs/frontend/add_good_station.php">Добавить хорошую заправку</a></li>
                    <li><a href="/curs/frontend/add_bad_station.php">Добавить плохую заправку</a></li>
                    <li><a href="/curs/frontend/edit_profile.php">Редактировать профиль</a></li>
                    <li><a href="/curs/backend/logout.php">Выйти</a></li>
                <?php else: ?>
                    <li><a href="/curs/frontend/register.php">Регистрация</a></li>
                    <li><a href="/curs/frontend/login.php">Вход</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Добавить хорошую заправку</h2>
        <form action="/curs/backend/add_good_station.php" method="POST">
            <label for="FullName">Полное название:</label>
            <input type="text" id="FullName" name="FullName" required><br><br>

            <label for="ShortName">Короткое название:</label>
            <input type="text" id="ShortName" name="ShortName" required><br><br>

            <label for="AdmArea">Административный округ:</label>
            <input type="text" id="AdmArea" name="AdmArea" required><br><br>

            <label for="District">Район:</label>
            <input type="text" id="District" name="District" required><br><br>

            <label for="Address">Адрес:</label>
            <input type="text" id="Address" name="Address" required><br><br>

            <label for="Owner">Владелец:</label>
            <input type="text" id="Owner" name="Owner" required><br><br>

            <label for="TestDate">Дата теста:</label>
            <input type="date" id="TestDate" name="TestDate" required><br><br>

            <label for="geoData">Координаты (широта, долгота):</label>
            <input type="text" id="geoData" name="geoData" required><br><br>

            <button type="submit">Добавить заправку</button>
        </form>
    </main>

    <script src="/curs/frontend/js/script.js"></script>
</body>
</html>
