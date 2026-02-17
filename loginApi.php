<?php
session_start();
error_reporting(0);

date_default_timezone_set('America/Sao_Paulo');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filename = "5ddd2e45147066c4399b5fcd4cb63e68.json";
    
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    
    $data = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];
    $loginSuccess = false;

    foreach ($data as &$user) {
        if ($user["username"] === $username && password_verify($password, $user["password"])) {
            // Verificar se usuário está ativo
            if ($user["status"] !== "Active") {
                header("Location: login?banned_user=true");
                exit();
            }
            
            // Verificar data de expiração (se existir)
            if (isset($user["expirationDate"])) {
                $expirationTime = strtotime($user["expirationDate"]);
                $currentTime = time();
                
                if ($expirationTime < $currentTime) {
                    header("Location: login?expired=true");
                    exit();
                }
            }
            
            // Login bem-sucedido
            $user["lastLogin"] = date("Y-m-d H:i:s");
            $user["ip"] = $_SERVER['REMOTE_ADDR'];
            file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
            
            $_SESSION["username"] = $user["username"];
            $_SESSION["expirationDate"] = $user["expirationDate"] ?? "N/A";
            $_SESSION["lastLogin"] = $user["lastLogin"];
            
            $loginSuccess = true;
            break;
        }
    }
    
    if ($loginSuccess) {
        header("Location: home.php");
    } else {
        header("Location: login.php?error=true");
    }
}
?>