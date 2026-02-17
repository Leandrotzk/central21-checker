<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema Checker</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Animated Background */
        .animated-bg {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            overflow: hidden;
        }
        
        .animated-bg span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            animation: animate 25s linear infinite;
            bottom: -150px;
        }
        
        .animated-bg span:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }
        
        .animated-bg span:nth-child(2) {
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }
        
        .animated-bg span:nth-child(3) {
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }
        
        .animated-bg span:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }
        
        .animated-bg span:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }
        
        .animated-bg span:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }
        
        .animated-bg span:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }
        
        .animated-bg span:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }
        
        .animated-bg span:nth-child(9) {
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }
        
        .animated-bg span:nth-child(10) {
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }
        
        @keyframes animate {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }
        
        /* Main Content */
        .content {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-section {
            text-align: center;
            color: white;
            padding: 40px 20px;
        }
        
        .logo {
            font-size: 80px;
            margin-bottom: 20px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        .main-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #4CAF50, #45a049, #81C784);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient 3s ease infinite;
        }
        
        .subtitle {
            font-size: 1.3rem;
            font-weight: 300;
            margin-bottom: 40px;
            color: #b8b8b8;
        }
        
        .features {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin: 50px 0;
            flex-wrap: wrap;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            width: 250px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(76, 175, 80, 0.3);
        }
        
        .feature-icon {
            font-size: 50px;
            margin-bottom: 20px;
            color: #4CAF50;
        }
        
        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .feature-desc {
            font-size: 0.9rem;
            color: #b8b8b8;
        }
        
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 40px;
        }
        
        .btn-custom {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary-custom {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.6);
            color: white;
            text-decoration: none;
        }
        
        .btn-secondary-custom {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary-custom:hover {
            background: white;
            color: #302b63;
            transform: translateY(-3px);
            text-decoration: none;
        }
        
        .stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-top: 60px;
            flex-wrap: wrap;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: #4CAF50;
        }
        
        .stat-label {
            font-size: 1rem;
            color: #b8b8b8;
            margin-top: 10px;
        }
        
        @media (max-width: 768px) {
            .main-title {
                font-size: 2.5rem;
            }
            .subtitle {
                font-size: 1rem;
            }
            .features {
                gap: 20px;
            }
            .feature-card {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    
    <!-- Main Content -->
    <div class="content">
        <div class="container">
            <div class="hero-section">
                <div class="logo">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h1 class="main-title">Sistema Checker</h1>
                <p class="subtitle">A melhor plataforma de validação de cartões do mercado</p>
                
                <!-- Features -->
                <div class="features">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="feature-title">Super Rápido</div>
                        <div class="feature-desc">Validação em tempo real com alta performance</div>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="feature-title">100% Seguro</div>
                        <div class="feature-desc">Seus dados protegidos com criptografia avançada</div>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="feature-title">Alta Precisão</div>
                        <div class="feature-desc">Resultados confiáveis e precisos</div>
                    </div>
                </div>
                
                <!-- CTA Buttons -->
                <div class="cta-buttons">
                    <a href="login.php" class="btn-custom btn-primary-custom">
                        <i class="fas fa-sign-in-alt"></i>
                        Acessar Sistema
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Taxa de Sucesso</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Disponibilidade</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">3</div>
                        <div class="stat-label">Gates Disponíveis</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    // Prevenir múltiplos cliques no botão de login
    document.addEventListener('DOMContentLoaded', function() {
        const loginBtn = document.querySelector('.btn-primary-custom');
        if (loginBtn) {
            loginBtn.addEventListener('click', function(e) {
                // Prevenir múltiplos cliques
                if (this.classList.contains('disabled')) {
                    e.preventDefault();
                    return false;
                }
                this.classList.add('disabled');
                this.style.opacity = '0.6';
                this.style.pointerEvents = 'none';
            });
        }
    });
    </script>
</body>
</html>