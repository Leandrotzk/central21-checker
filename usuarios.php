<?php
session_start();

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: admin_login.php');
    exit();
}

$jsonContent = file_get_contents('5ddd2e45147066c4399b5fcd4cb63e68.json');
$users = json_decode($jsonContent, true);

if ($users === null) {
    echo "<div class='alert alert-danger'>Erro ao carregar dados.</div>";
} else {
    $searchQuery = isset($_POST['search']) ? $_POST['search'] : '';
    $filteredUsers = [];

    foreach ($users as $key => $user) {
        $users[$key]['Status'] = 'Active';
        if (empty($searchQuery) || stripos($user['username'], $searchQuery) !== false) {
            $filteredUsers[] = $user;
        }
    }

    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    echo "<title>Lista de Usuários</title>";
    echo "<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>";
    echo "<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.15.1/css/all.css'>";
    echo "<style>";
    echo ".rounded-card {";
    echo "    border-radius: 10px;";
    echo "    background-color: #f8f9fa;"; // Cor de fundo do card
    echo "    margin-bottom: 20px;";
    echo "    padding: 15px;";
    echo "}";
    echo "</style>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "</head>";
    echo "<body>";
    echo "<div class='container mt-5'>";
    echo "<div class='d-flex justify-content-between align-items-center mb-4'>";
    echo "<div>";
    echo "<h1><i class='fas fa-users'></i> Lista de Usuários</h1>";
    echo "<p>Total de Usuários Cadastrados: " . count($users) . "</p>";
    echo "</div>";
    echo "<div>";
    echo "<a href='admin_logout.php' class='btn btn-danger'><i class='fas fa-sign-out-alt'></i> Sair (Admin)</a>";
    echo "</div>";
    echo "</div>";
    echo "<hr>";

    echo "<form method='post'>";
    echo "<div class='mb-3'>";
    echo "<label for='search' class='form-label'>Pesquisar Usuário:</label>";
    echo "<input type='text' class='form-control' id='search' name='search'>";
    echo "<button type='submit' class='btn btn-primary mt-2'>Pesquisar</button>";
    echo "</div>";
    echo "</form>";

    if (empty($filteredUsers)) {
        echo "<div class='alert alert-info'>Nenhum usuário encontrado.</div>";
    } else {
        foreach ($filteredUsers as $user) {
            echo "<div class='rounded-card card'>";
            echo "<div class='card-header'>Username: " . $user['username'] . "</div>";
            echo "<div class='card-body'>";
            echo "<p class='card-text'><strong>IP:</strong> " . $user['ip'] . "</p>";
            echo "<p class='card-text'><strong>Creation Date:</strong> " . $user['creationDate'] . "</p>";
            echo "<p class='card-text'><strong>Expiration Date:</strong> " . $user['expirationDate'] . "</p>";
            echo "<p class='card-text'><strong>Last Login:</strong> " . $user['lastLogin'] . "</p>";
            echo "<p class='card-text'><strong>Status:</strong> " . $user['status'] . "</p>";
            echo "<div class='btn-group'>";
            echo "<a class='btn btn-primary' href='editar_usuario.php?username=" . $user['username'] . "'>Editar Usuário</a>";
            echo "<form method='post' action='excluir_usuario.php' class='ml-2'>";
            echo "<input type='hidden' name='username' value='" . $user['username'] . "'>";
            echo "<button class='btn btn-danger' type='submit'>Excluir Usuário</button>";
            echo "</form>";

            echo "<form method='post' action='banir_usuario.php' class='ml-2'>";
            echo "<input type='hidden' name='username' value='" . $user['username'] . "'>";
            echo "<button class='btn btn-warning' type='submit'>Banir Usuário</button>";
            echo "</form>";
            
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }

    echo "</div>";
    echo "</body>";
    echo "</html>";
}
?>
