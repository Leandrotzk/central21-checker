<?php

session_start();
date_default_timezone_set('America/Sao_Paulo');

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$filename = "5ddd2e45147066c4399b5fcd4cb63e68.json";
$data = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];

$username = $_SESSION["username"];

// Find user data in array
$userData = null;
foreach ($data as $user) {
    if ($user['username'] === $username) {
        $userData = $user;
        break;
    }
}

if ($userData === null) {
    header("Location: login.php");
    exit();
}

$expirationDateStr = $userData["expirationDate"] ?? null;
$expira = $expirationDateStr ? date("Y-m-d H:i:s", strtotime($expirationDateStr)) : "N/A";
$lastLogin = $userData["lastLogin"] ?? "Nunca realizado";

if ($expirationDateStr && strtotime($expirationDateStr) < time()) {
    // User expired - could add redirect or warning here
    // header("Location: login.php");
    // exit();
}

?>
