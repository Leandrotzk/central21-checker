<?php
session_start();
error_reporting(0);

// Se já estiver logado, redireciona para home
if (isset($_SESSION["username"])) {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - CENTRAL21</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .auth-container {
            max-width: 450px;
            width: 100%;
        }
        
        .auth-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .auth-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #4CAF50, #45a049);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
        }
        
        .auth-logo i {
            font-size: 40px;
            color: white;
        }
        
        .auth-title {
            color: white;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .auth-subtitle {
            color: #b8b8b8;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            color: white;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: white;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background: rgba(0, 0, 0, 0.4);
            border-color: #4CAF50;
            box-shadow: 0 0 15px rgba(76, 175, 80, 0.3);
            color: white;
            outline: none;
        }
        
        .form-control::placeholder {
            color: #666;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #b8b8b8;
            z-index: 10;
        }
        
        .form-control.with-icon {
            padding-left: 45px;
        }
        
        .btn-auth {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            border: none;
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
        }
        
        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.6);
        }
        
        .auth-divider {
            text-align: center;
            margin: 25px 0;
            color: #b8b8b8;
            font-size: 14px;
        }
        
        .auth-link {
            text-align: center;
            color: #b8b8b8;
            font-size: 14px;
        }
        
        .auth-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .auth-link a:hover {
            color: #45a049;
            text-decoration: underline;
        }
        
        .alert {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-danger {
            background: rgba(244, 67, 54, 0.1);
            border-color: rgba(244, 67, 54, 0.3);
            color: #ff6b6b;
        }
        
        .alert-success {
            background: rgba(76, 175, 80, 0.1);
            border-color: rgba(76, 175, 80, 0.3);
            color: #4CAF50;
        }
        
        .alert-warning {
            background: rgba(255, 152, 0, 0.1);
            border-color: rgba(255, 152, 0, 0.3);
            color: #ffa726;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-user-lock"></i>
                </div>
                <h1 class="auth-title">Bem-vindo de volta!</h1>
                <p class="auth-subtitle">Entre com suas credenciais para continuar</p>
            </div>
<?php
if (isset($_GET["error"])) {
    echo '<div class="alert alert-danger text-center" role="alert">Usuário ou senha incorretos.</div>';
} elseif (isset($_GET["success"]) && $_GET["success"] == "true") {
    echo '<div class="alert alert-success text-center" role="alert">Login realizado com sucesso!</div>';
    echo '<script>
        setTimeout(function() {
            window.location.href = "checker?accessKey=dedf0fcff631caf4b5d5164191020f6e14e5e69c";
        }, 5000);
    </script>';
} elseif (isset($_GET["expired"]) && $_GET["expired"] == "true") {
    echo '<div class="alert alert-warning text-center" role="alert">Acesso expirado - Contate o @CENTRAL21 para renovar!</div>';
} elseif (isset($_GET["banned_user"]) && $_GET["banned_user"] == "true") {
    echo '<div class="alert alert-danger text-center" role="alert">Usuário banido, contate o suporte!</div>';
}
?>

            <form action="loginApi.php" method="post">
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-user"></i> Usuário</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-user"></i>
                        <input type="text" class="form-control with-icon" name="username" placeholder="Digite seu usuário" required autocomplete="username">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-lock"></i> Senha</label>
                    <div class="input-group">
                        <i class="input-icon fas fa-lock"></i>
                        <input type="password" class="form-control with-icon" name="password" placeholder="Digite sua senha" required autocomplete="current-password">
                    </div>
                </div>
                
                <button type="submit" class="btn-auth">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>