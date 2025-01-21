<?php
session_save_path("C:/xampp/htdocs/curs/sessions");  // Указываем путь к папке для сессий
session_start();  // Стартуем сессию
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
    <?php session_start(); ?>
    <header>
        <h1>Заправки Москвы</h1>
        <nav>
        <ul>
                <li><a href="/curs/frontend/index.php">Главная</a></li>
                <li><a href="/curs/frontend/map.php">Карта</a></li>

                <!-- Условие, чтобы показывать пункты только если пользователь авторизован -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/curs/frontend/add_good_station.php">Добавить хорошую заправку</a></li>
                    <li><a href="/curs/frontend/add_bad_station.php">Добавить плохую заправку</a></li>
                    <li><a href="/curs/backend/logout.php">Выйти</a></li>
                <?php else: ?>
                    <li><a href="/curs/frontend/register.php">Регистрация</a></li>
                    <li><a href="/curs/frontend/login.php">Вход</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <h2>Добавить хорошую заправку</h2>
    <form action="/curs/backend/add_good_station.php" method="POST">
        <label for="FullName">Полное название:</label>
        <input type="text" id="FullName" name="FullName" required><br><br>

        <label for="Address">Адрес:</label>
        <input type="text" id="Address" name="Address" required><br><br>

        <label for="AdmArea">Административный округ:</label>
        <input type="text" id="AdmArea" name="AdmArea" required><br><br>

        <label for="District">Район:</label>
        <input type="text" id="District" name="District" required><br><br>

        <label for="geoData">Координаты (широта, долгота):</label>
        <input type="text" id="geoData" name="geoData" required><br><br>

        <button type="submit">Добавить заправку</button>
    </form>

    <script src="/curs/frontend/js/script.js"></script>
</body>
</html>
