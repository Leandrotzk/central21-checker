<?php
session_start();

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameToEdit = $_POST['username'];
    $ip = $_POST['ip'];
    $creationDate = $_POST['creationDate'];
    $expirationDate = $_POST['expirationDate'];
    $lastLogin = $_POST['lastLogin'];

    $jsonContent = file_get_contents('5ddd2e45147066c4399b5fcd4cb63e68.json');
    $users = json_decode($jsonContent, true);

    foreach ($users as &$user) {
        if ($user['username'] === $usernameToEdit) {
            $user['ip'] = $ip;
            $user['creationDate'] = $creationDate;
            $user['expirationDate'] = $expirationDate;
            $user['lastLogin'] = $lastLogin;
            break;
        }
    }

    $updatedJson = json_encode($users, JSON_PRETTY_PRINT);
    file_put_contents('5ddd2e45147066c4399b5fcd4cb63e68.json', $updatedJson);

    header('Location: usuarios.php');
    exit();
}
?>