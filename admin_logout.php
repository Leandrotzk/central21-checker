<?php
session_start();

// Destroi a sessão do admin
unset($_SESSION['admin_logged']);
unset($_SESSION['admin_username']);
session_destroy();

// Redireciona para a página de login do admin
header('Location: admin_login.php');
exit();
?>
