<?php
session_start();

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: admin_login.php');
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input.form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
        }
        button.btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['username'])) {
            $usernameToEdit = $_GET['username'];

            $jsonContent = file_get_contents('5ddd2e45147066c4399b5fcd4cb63e68.json');
            $users = json_decode($jsonContent, true);

            foreach ($users as $key => $user) {
                if ($user['username'] === $usernameToEdit) {
                    echo "<h1>Editar Usuário: " . $user['username'] . "</h1>";
                    echo "<form method='post' action='salvar_edicao.php'>";
                    echo "<input type='hidden' name='username' value='" . $user['username'] . "'>";
                    echo "<div class='form-group'>";
                    echo "<label for='ip'>IP:</label>";
                    echo "<input type='text' class='form-control' id='ip' name='ip' value='" . $user['ip'] . "'>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='creationDate'>Creation Date:</label>";
                    echo "<input type='text' class='form-control' id='creationDate' name='creationDate' value='" . $user['creationDate'] . "'>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='expirationDate'>Expiration Date:</label>";
                    echo "<input type='text' class='form-control' id='expirationDate' name='expirationDate' value='" . $user['expirationDate'] . "'>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='lastLogin'>Last Login:</label>";
                    echo "<input type='text' class='form-control' id='lastLogin' name='lastLogin' value='" . $user['lastLogin'] . "'>";
                    echo "</div>";
                    echo "<button type='submit' class='btn btn-primary'>Salvar</button>";
                    echo "<a href='usuarios.php' class='btn btn-secondary ml-2'>Voltar</a>";
                    echo "</form>";
                    break;
                }
            }
        }
        ?>
    </div>
</body>
</html>
