<?php
session_save_path("C:/xampp/htdocs/curs/sessions");  // Указываем полный путь для хранения сессий
session_start();  // Запуск сессии

require_once 'db.php';  // Подключение к базе данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверяем, есть ли такой пользователь в базе данных
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Проверяем, совпадает ли введенный пароль с паролем в базе данных
        if ($password === $user['password']) {
            // Устанавливаем сессионные переменные
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Перенаправляем на главную страницу
            header("Location: /curs/frontend/index.php");  // Путь с учетом структуры проекта
            exit();
        } else {
            echo "Неверный пароль!";
        }
    } else {
        echo "Пользователь не найден!";
    }
}
?>
