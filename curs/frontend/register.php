<?php
session_save_path("C:/xampp/htdocs/curs/sessions");  // Указываем путь к папке для сессий
session_start();  // Стартуем сессию
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/curs/frontend/css/style.css">
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
        <h2>Регистрация</h2>
        <form action="/curs/backend/register.php" method="POST">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <button type="submit">Зарегистрироваться</button>
        </form>
    </main>

    <footer>
        <p>© 2025 Заправки Москвы. Все права защищены</p>
    </footer>

    <script src="/curs/frontend/js/script.js"></script>
</body>
</html>
