<?php
session_save_path("C:/xampp/htdocs/curs/sessions");  // Указываем путь к папке для сессий
session_start();  // Стартуем сессию
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заправки Москвы</title>
    <link rel="stylesheet" href="/curs/frontend/css/style.css">
    <link rel="stylesheet" href="/curs/frontend/css/map.css">
</head>
<body>
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

    <main>
        <h2>О проекте</h2>
        <p>Данный проект представляет собой интерактивную карту заправок Москвы. Вы можете просматривать как хорошие, так и плохие заправки на карте, а также фильтровать их по типу. Данные для карты получены из открытых источников, доступных через платформу Msc.ru.</p>
        <p>Источники данных:</p>
        <ul>
            <li><a href="https://example.com/bad">Датасет с плохими заправками</a></li>
            <li><a href="https://example.com/good">Датасет с хорошими заправками</a></li>
        </ul>
    </main>

    <footer>
        <p>© 2025 Заправки Москвы. Все права защищены.</p>
    </footer>

    <script src="/curs/frontend/js/script.js"></script>
</body>
</html>
