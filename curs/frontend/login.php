<?php
session_save_path("C:/xampp/htdocs/curs/sessions");  
session_start();  

$error_message = "";
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'invalid_password') {
        $error_message = "Неверный пароль!";
    } elseif ($_GET['error'] === 'user_not_found') {
        $error_message = "Пользователь не найден!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="/curs/frontend/css/style.css">
    <link rel="stylesheet" href="/curs/frontend/css/reg.css"><!-- Include log.css -->
</head>
<body>
<header>
        <h1>Заправки Москвы</h1>
        <nav>
            <ul>
                <li><a href="/curs/frontend/index.php">Главная</a></li>
                <li><a href="/curs/frontend/map.php">Карта</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/curs/frontend/user_map.php">Карта с пользовательскими заправками</a></li>
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
        <h2>Вход</h2>
        <form action="/curs/backend/login.php" method="POST">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Войти</button>
        </form>
    </main>
    <!-- Custom Modal -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2><?php echo $error_message; ?></h2>
            <button class="modal-button" onclick="closeModal()">OK</button>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>© 2025 Заправки Москвы. Все права защищены</p>
    </footer>

    <script>

        var modal = document.getElementById("errorModal");

        <?php if ($error_message): ?>
            modal.style.display = "block";
        <?php endif; ?>


        var span = document.getElementsByClassName("close")[0];

        span.onclick = function() {
            modal.style.display = "none";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

<script src="/curs/frontend/js/script.js"></script>

</body>
</html>
