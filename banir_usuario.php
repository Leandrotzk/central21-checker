<?php
session_start();

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'])) {
        $usernameToBan = $_POST['username'];

        $jsonFile = '5ddd2e45147066c4399b5fcd4cb63e68.json';
        $jsonContent = file_get_contents($jsonFile);
        $users = json_decode($jsonContent, true);

        foreach ($users as &$user) {
            if ($user['username'] === $usernameToBan && $user['status'] === 'Active') {
                $user['status'] = 'Banned';
            }
        }

        if (file_put_contents($jsonFile, json_encode($users))) {
                header('Location: usuarios.php');
                exit();
        } else {
            echo "Erro ao atualizar o arquivo JSON.";
        }
    } else {
        echo "Erro: Nome de usuário não fornecido para banimento.";
    }
}

?>
