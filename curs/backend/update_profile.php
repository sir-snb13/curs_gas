<?php
session_save_path("C:/xampp/htdocs/curs/sessions");
session_start();

require_once 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = '$username' AND id != $user_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            header("Location: /curs/frontend/edit_profile.php?error=username_taken");
            exit();
        } else {
            if (empty($password)) {
                $sql = "UPDATE users SET username = '$username', email = '$email' WHERE id = $user_id";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Hash the password
                $sql = "UPDATE users SET username = '$username', email = '$email', password = '$hashed_password' WHERE id = $user_id";
            }

            $conn->query($sql);

            header("Location: /curs/frontend/edit_profile.php?success=1");
            exit();
        }
    } else {
        header("Location: /curs/frontend/login.php");  
        exit();
    }
}
?>
