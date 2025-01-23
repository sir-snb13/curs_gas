<?php
session_save_path("C:/xampp/htdocs/curs/sessions");  
session_start();

session_unset();
session_destroy();

header("Location: /curs/frontend/index.php");  
exit();
?>
