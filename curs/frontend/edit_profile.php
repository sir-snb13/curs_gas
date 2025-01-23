<?php
session_save_path("C:/xampp/htdocs/curs/sessions");
session_start();

require_once '../backend/db.php';

$error_message = "";
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'username_taken') {
        $error_message = "Это имя пользователя уже занято!";
    }
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    header("Location: /curs/frontend/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование профиля</title>
    <link rel="stylesheet" href="/curs/frontend/css/style.css">
    <link rel="stylesheet" href="/curs/frontend/css/edit_profile.css"> <!-- Include custom CSS -->
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
        <h2>Редактировать профиль</h2>
        <form action="/curs/backend/update_profile.php" method="POST">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" placeholder="Оставьте пустым, если не хотите менять"><br><br>

            <button type="submit">Сохранить изменения</button>
        </form>
    </main>

    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2><?php echo $error_message; ?></h2>
            <button class="modal-button" onclick="closeModal()">OK</button>
        </div>
    </div>

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

</body>
</html>
