<?php
session_start();

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameToDelete = $_POST['username'];
    
    $jsonContent = file_get_contents('5ddd2e45147066c4399b5fcd4cb63e68.json');
    $users = json_decode($jsonContent, true);

    foreach ($users as $key => $user) {
        if ($user['username'] === $usernameToDelete) {
            unset($users[$key]);
            break;
        }
    }

    $updatedJson = json_encode(array_values($users), JSON_PRETTY_PRINT);
    file_put_contents('5ddd2e45147066c4399b5fcd4cb63e68.json', $updatedJson);

    header('Location: usuarios.php');
    exit();
}
?>