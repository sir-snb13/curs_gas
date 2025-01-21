<?php
session_save_path("C:/xampp/htdocs/curs/sessions");  // Указываем полный путь для хранения сессий
session_start();  // Запуск сессии

require_once 'db.php';  // Подключаем базу данных

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Проверяем, есть ли уже такой пользователь
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Пользователь с таким именем уже существует!";
    } else {
        // Вставляем нового пользователя
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $email);
        $stmt->execute();

        // Устанавливаем сессионные переменные
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['username'] = $username;

        // Перенаправляем на главную страницу
        header("Location: /curs/frontend/index.php");
        exit();
    }
}
?>
