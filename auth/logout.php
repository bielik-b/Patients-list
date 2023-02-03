<?php
    session_start();
    unset($_SESSION['user']);
    header('Location: /patients-list/auth/login.php');
?>
