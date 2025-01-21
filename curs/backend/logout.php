<?php
session_save_path("C:/xampp/htdocs/curs/sessions");  // Указываем полный путь для хранения сессий
session_start();  // Запуск сессии // Запуск сессии

// Уничтожаем сессионные данные
session_unset();
session_destroy();

// Перенаправляем на страницу входа
header("Location: /curs/frontend/index.php");  // Путь с учетом структуры проекта
exit();
?>
