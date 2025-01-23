<?php
session_save_path("C:/xampp/htdocs/curs/sessions");  
session_start(); 

require_once 'db.php';  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) { 

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: /curs/frontend/index.php");  
            exit();
        } else {
            header("Location: /curs/frontend/login.php?error=invalid_password");
            exit();
        }
    } else {
        header("Location: /curs/frontend/login.php?error=user_not_found");
        exit();
    }
}
?>
