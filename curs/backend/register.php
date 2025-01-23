<?php
session_save_path("C:/xampp/htdocs/curs/sessions");  
session_start();  

require_once 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];  
    $email = $_POST['email'];

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        header("Location: /curs/frontend/register.php?error=username_exists");
        exit();
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";
        
        if (mysqli_query($conn, $sql)) {
            $user_id = mysqli_insert_id($conn); 

            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;

            header("Location: /curs/frontend/index.php");
            exit();
        } else {
            echo "Ошибка: " . mysqli_error($conn);
        }
    }
}
?>
