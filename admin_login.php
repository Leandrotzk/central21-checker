<?php
session_start();
error_reporting(0);

// Credenciais do admin - APENAS Gold21
$ADMIN_USERS = [
    "Gold21" => "102030"
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Verifica se o usuário existe e a senha está correta
    if (isset($ADMIN_USERS[$username]) && $ADMIN_USERS[$username] === $password) {
        $_SESSION["admin_logged"] = true;
        $_SESSION["admin_username"] = $username;
        header("Location: usuarios.php?admin=true");
        exit();
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Administrativo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #343a40;
            color: white;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            background-color: #222;
            border: none;
            border-radius: 10px;
        }
        .card-header {
            background-color: #dc3545;
            border-bottom: none;
            color: white;
        }
        .form-control {
            background-color: #343a40;
            color: white;
            border: 1px solid #555;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .alert {
            margin-top: 20px;
        }
        .admin-icon {
            font-size: 60px;
            color: #dc3545;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center"><i class="fas fa-user-shield"></i> Login Administrativo</h2>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="admin-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                        </div>
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger text-center" role="alert">
                                Usuário ou senha administrativos incorretos!
                            </div>
                        <?php endif; ?>

                        <form action="admin_login.php" method="post">
                            <div class="form-group">
                                <label for="username"><i class="fas fa-user"></i> Usuário Admin:</label>
                                <input type="text" class="form-control" name="username" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock"></i> Senha Admin:</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-sign-in-alt"></i> Entrar como Admin
                            </button>
                        </form>
                        
                        <p class="text-center mt-3">
                            <a href="login?accessKey=dedf0fcff631caf4b5d5164191020f6e14e5e69c" style="color: #dc3545;">
                                <i class="fas fa-arrow-left"></i> Voltar ao login normal
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
