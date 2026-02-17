<?php
error_reporting(0);
require_once "validation.php";

// Carregar configurações do sistema
$configFile = 'config.json';
if (!file_exists($configFile)) {
    die('Arquivo de configuração não encontrado!');
}

$config = json_decode(file_get_contents($configFile), true);
$gates = $config['gates'];
$siteName = $config['system']['site_name'];
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $siteName; ?> - Painel Principal</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .header-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .header-section h2 {
            color: white;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .header-section h2 i {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            padding: 12px;
            border-radius: 12px;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
        }
        
        .header-section span {
            color: #b8b8b8;
            font-size: 0.95rem;
            background: rgba(0, 0, 0, 0.2);
            padding: 12px 20px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 10px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .header-section span b {
            color: #4CAF50;
            font-weight: 600;
        }
        
        .logout-btn, .admin-btn, .generator-btn {
            background: linear-gradient(45deg, #f44336, #d32f2f);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(244, 67, 54, 0.4);
            margin-left: 10px;
        }
        
        .admin-btn {
            background: linear-gradient(45deg, #FF9800, #F57C00);
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.4);
        }
        
        .generator-btn {
            background: linear-gradient(45deg, #2196F3, #1976D2);
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.4);
        }
        
        .logout-btn:hover {
            background: linear-gradient(45deg, #d32f2f, #b71c1c);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(244, 67, 54, 0.6);
            text-decoration: none;
        }
        
        .admin-btn:hover {
            background: linear-gradient(45deg, #F57C00, #E65100);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 152, 0, 0.6);
            text-decoration: none;
        }
        
        .generator-btn:hover {
            background: linear-gradient(45deg, #1976D2, #1565C0);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(33, 150, 243, 0.6);
            text-decoration: none;
        }
        
        .checker-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 35px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            text-decoration: none;
            display: block;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .checker-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(76, 175, 80, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .checker-card:hover::before {
            opacity: 1;
        }
        
        .checker-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(76, 175, 80, 0.3);
            border-color: rgba(76, 175, 80, 0.3);
            color: white;
            text-decoration: none;
        }
        
        .checker-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #4CAF50, #45a049);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
            transition: all 0.3s ease;
        }
        
        .checker-card:hover .checker-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 12px 35px rgba(76, 175, 80, 0.6);
        }
        
        .checker-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: white;
            position: relative;
        }
        
        .checker-description {
            font-size: 14px;
            color: #b8b8b8;
            line-height: 1.6;
            position: relative;
        }
        
        .checker-card.disabled {
            cursor: not-allowed;
            opacity: 0.5;
        }
        
        .checker-card.disabled:hover {
            transform: none;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .checker-card.disabled .checker-icon {
            background: linear-gradient(45deg, #607D8B, #455A64);
            box-shadow: 0 8px 25px rgba(96, 125, 139, 0.4);
        }
        
        .checker-card.disabled:hover .checker-icon {
            transform: none;
        }
        
        .info-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .info-section h5 {
            color: white;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .info-section h5 i {
            color: #4CAF50;
        }
        
        .info-section p {
            color: #b8b8b8;
            margin-bottom: 0;
            font-size: 14px;
        }
        
        @media (max-width: 768px) {
            .header-section {
                padding: 20px;
            }
            
            .header-section h2 {
                font-size: 1.5rem;
                flex-direction: column;
                text-align: center;
            }
            
            .logout-btn, .admin-btn, .generator-btn {
                width: 100%;
                justify-content: center;
                margin: 5px 0;
            }
            
            .checker-card {
                padding: 25px;
            }
            
            .checker-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2>
                        <i class="fas fa-home"></i>
                        Painel de Checkers
                    </h2>
                    <span>
                        <b>Usuário:</b> <?php echo $username; ?> | 
                        <b>Expira em:</b> <?php echo $expira; ?> | 
                        <b>Último Login:</b> <?php echo $lastLogin; ?>
                    </span>
                </div>
                <div>
                    <a href="gerador.php" class="generator-btn">
                        <i class="fas fa-credit-card"></i> Gerador de Cartões
                    </a>
                    <a href="admin_panel.php" class="admin-btn">
                        <i class="fas fa-cog"></i> Admin
                    </a>
                    <a href="login?accessKey=dedf0fcff631caf4b5d5164191020f6e14e5e69c" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </a>
                </div>
            </div>
        </div>

        <!-- Checker Options (Carregadas do config.json) -->
        <div class="row">
            <?php foreach ($gates as $gate): ?>
                <div class="col-md-4 mb-3">
                    <?php if ($gate['status'] === 'active'): ?>
                        <a href="checker.php?gate=<?php echo $gate['slug']; ?>" class="checker-card">
                    <?php else: ?>
                        <div class="checker-card disabled">
                    <?php endif; ?>
                        <div class="text-center">
                            <div class="checker-icon">
                                <i class="fas <?php echo $gate['icon']; ?>"></i>
                            </div>
                            <div class="checker-title">
                                <?php echo $gate['name']; ?>
                            </div>
                            <div class="checker-description">
                                <?php echo $gate['description']; ?>
                            </div>
                        </div>
                    <?php if ($gate['status'] === 'active'): ?>
                        </a>
                    <?php else: ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Additional Info -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="info-section">
                    <h5>
                        <i class="fas fa-info-circle"></i>
                        Informações
                    </h5>
                    <p>DESENVOLVIDO POR <?php echo $siteName; ?></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
