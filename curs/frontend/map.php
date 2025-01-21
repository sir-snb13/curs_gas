<?php
session_save_path("C:/xampp/htdocs/curs/sessions");  // Указываем путь к папке для сессий
session_start();  // Стартуем сессию
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Интерактивная карта заправок</title>
    <link rel="stylesheet" href="/curs/frontend/css/style.css">
    <link rel="stylesheet" href="/curs/frontend/css/map.css">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=562e7800-42c7-4ae4-8712-c49daaf4fb77&lang=ru_RU"></script>
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
        <h2>Карта заправок</h2>

        <!-- Выпадающий список для выбора административного округа -->
        <div class="district-selector">
            <label for="district-select">Выберите административный округ:</label>
            <select id="district-select">
                <option value="all">Все административные округа</option>
                <option value="Центральный">Центральный</option>
                <option value="Северный">Северный</option>
                <option value="Северо-Восточный">Северо-Восточный</option>
                <option value="Восточный">Восточный</option>
                <option value="Юго-Восточный">Юго-Восточный</option>
                <option value="Южный">Южный</option>
                <option value="Юго-Западный">Юго-Западный</option>
                <option value="Западный">Западный</option>
                <option value="Северо-Западный">Северо-Западный</option>
                <option value="Зеленоградский">Зеленоградский</option>
                <option value="Новомосковский">Новомосковский</option>
                <option value="Троицкий">Троицкий</option>
            </select>
        </div>

        <!-- Карта -->
        <div id="map"></div>

        <!-- Чекбоксы для фильтров -->
        <div class="checkbox-container">
            <label class="custom-checkbox">
                <input type="checkbox" id="showBadStations" checked>
                <span class="checkbox-label">Плохие заправки</span>
            </label>
            <label class="custom-checkbox">
                <input type="checkbox" id="showGoodStations" checked>
                <span class="checkbox-label">Хорошие заправки</span>
            </label>
        </div>
    </main>

    <footer>
        <p>© 2025 Заправки Москвы. Все права защищены</p>
    </footer>

    <script src="/curs/frontend/js/map_script.js"></script>
</body>
</html>
