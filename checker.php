<?php

error_reporting(0);
require_once "validation.php";

// Detecta qual gate foi selecionada
$gate = isset($_GET['gate']) ? $_GET['gate'] : 'preauth';

// Define o nome e ícone da gate
switch($gate) {
    case 'preauth':
        $gateName = 'PRE AUTH CC';
        $gateIcon = 'fa-credit-card';
        break;
    case 'allbins':
        $gateName = 'ALL BINS GG';
        $gateIcon = 'fa-check-circle';
        break;
    default:
        $gateName = 'PRE AUTH CC';
        $gateIcon = 'fa-credit-card';
}

?>

<script type="text/javascript">
	var custo = "0";
	var descricao_chk = "Checker <?php echo $gateName; ?>";
	var audio = new Audio('live.mp3');
</script>
<!DOCTYPE html>
<html>
<head>
	<title>CENTRAL21</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!-- bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- fontawesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
	<!-- toastr -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
	<style type="text/css">
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
		
		.header-card {
			background: rgba(255, 255, 255, 0.05);
			backdrop-filter: blur(10px);
			border: 1px solid rgba(255, 255, 255, 0.1);
			border-radius: 20px;
			padding: 30px;
			margin-bottom: 30px;
			box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
		}
		
		.btn-back {
			background: rgba(255, 255, 255, 0.1);
			border: 1px solid rgba(255, 255, 255, 0.2);
			color: white;
			padding: 12px 24px;
			border-radius: 12px;
			transition: all 0.3s ease;
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			gap: 8px;
			font-weight: 500;
			font-size: 14px;
		}
		
		.btn-back:hover {
			background: rgba(255, 255, 255, 0.2);
			color: white;
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
			text-decoration: none;
		}
		
		.checker-title {
			color: white;
			font-size: 2rem;
			font-weight: 700;
			margin-bottom: 15px;
			display: flex;
			align-items: center;
			gap: 12px;
		}
		
		.checker-title i {
			background: linear-gradient(45deg, #4CAF50, #45a049);
			padding: 12px;
			border-radius: 12px;
			font-size: 1.5rem;
			box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
		}
		
		.user-info {
			color: #b8b8b8;
			font-size: 0.95rem;
			background: rgba(0, 0, 0, 0.2);
			padding: 12px 20px;
			border-radius: 10px;
			border: 1px solid rgba(255, 255, 255, 0.05);
			display: inline-block;
		}
		
		.user-info .highlight {
			color: #4CAF50;
			font-weight: 600;
		}
		
		.action-buttons {
			display: flex;
			gap: 12px;
			flex-wrap: wrap;
			margin-top: 25px;
		}
		
		.btn-action {
			padding: 14px 28px;
			border-radius: 12px;
			font-weight: 600;
			font-size: 15px;
			transition: all 0.3s ease;
			border: none;
			color: white;
			cursor: pointer;
			display: inline-flex;
			align-items: center;
			gap: 8px;
		}
		
		.btn-start {
			background: linear-gradient(45deg, #4CAF50, #45a049);
			box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
		}
		
		.btn-start:hover:not(:disabled) {
			transform: translateY(-2px);
			box-shadow: 0 6px 20px rgba(76, 175, 80, 0.6);
		}
		
		.btn-pause {
			background: linear-gradient(45deg, #FF9800, #F57C00);
			box-shadow: 0 4px 15px rgba(255, 152, 0, 0.4);
		}
		
		.btn-pause:hover:not(:disabled) {
			transform: translateY(-2px);
			box-shadow: 0 6px 20px rgba(255, 152, 0, 0.6);
		}
		
		.btn-stop {
			background: linear-gradient(45deg, #f44336, #d32f2f);
			box-shadow: 0 4px 15px rgba(244, 67, 54, 0.4);
		}
		
		.btn-stop:hover:not(:disabled) {
			transform: translateY(-2px);
			box-shadow: 0 6px 20px rgba(244, 67, 54, 0.6);
		}
		
		.btn-clean {
			background: linear-gradient(45deg, #2196F3, #1976D2);
			box-shadow: 0 4px 15px rgba(33, 150, 243, 0.4);
		}
		
		.btn-clean:hover:not(:disabled) {
			transform: translateY(-2px);
			box-shadow: 0 6px 20px rgba(33, 150, 243, 0.6);
		}
		
		.btn-action:disabled {
			opacity: 0.5;
			cursor: not-allowed;
			transform: none !important;
		}
		
		.status-badge {
			padding: 10px 24px;
			border-radius: 25px;
			font-weight: 600;
			font-size: 14px;
			display: inline-flex;
			align-items: center;
			gap: 8px;
			margin-top: 20px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
		}
		
		.badge-warning {
			background: linear-gradient(45deg, #FF9800, #F57C00);
			color: white;
		}
		
		.badge-success {
			background: linear-gradient(45deg, #4CAF50, #45a049);
			color: white;
		}
		
		.badge-danger {
			background: linear-gradient(45deg, #f44336, #d32f2f);
			color: white;
		}
		
		.badge-info {
			background: linear-gradient(45deg, #2196F3, #1976D2);
			color: white;
		}
		
		.badge-secondary {
			background: linear-gradient(45deg, #607D8B, #455A64);
			color: white;
		}
		
		.nav-tabs {
			background: rgba(255, 255, 255, 0.05);
			border-radius: 20px 20px 0 0;
			border: none;
			padding: 15px;
			border-bottom: 1px solid rgba(255, 255, 255, 0.1);
		}
		
		.nav-tabs .nav-item {
			margin: 0 5px;
		}
		
		.nav-tabs .nav-link {
			color: #b8b8b8;
			border: none;
			border-radius: 12px;
			padding: 12px 24px;
			transition: all 0.3s ease;
			font-weight: 500;
			display: flex;
			align-items: center;
			gap: 8px;
		}
		
		.nav-tabs .nav-link:hover {
			background: rgba(255, 255, 255, 0.1);
			color: white;
			transform: translateY(-2px);
		}
		
		.nav-tabs .nav-link.active {
			background: linear-gradient(45deg, #4CAF50, #45a049);
			color: white;
			box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
		}
		
		.tab-content {
			background: rgba(255, 255, 255, 0.05);
			backdrop-filter: blur(10px);
			border: 1px solid rgba(255, 255, 255, 0.1);
			border-radius: 0 0 20px 20px;
			color: white;
			padding: 30px;
			box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
		}
		
		.stats-container {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
			gap: 15px;
			margin-bottom: 25px;
		}
		
		.stat-card {
			background: rgba(0, 0, 0, 0.3);
			border: 1px solid rgba(255, 255, 255, 0.1);
			border-radius: 15px;
			padding: 20px;
			text-align: center;
			transition: all 0.3s ease;
		}
		
		.stat-card:hover {
			transform: translateY(-2px);
			box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);
			background: rgba(0, 0, 0, 0.4);
		}
		
		.stat-label {
			font-size: 0.9rem;
			color: #b8b8b8;
			margin-bottom: 8px;
			font-weight: 500;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}
		
		.stat-value {
			font-size: 2rem;
			font-weight: 700;
			color: #4CAF50;
			text-shadow: 0 2px 10px rgba(76, 175, 80, 0.3);
		}
		
		textarea {
			background: rgba(0, 0, 0, 0.4);
			color: white;
			border: 1px solid rgba(255, 255, 255, 0.1);
			border-radius: 15px;
			width: 100%;
			padding: 18px;
			resize: none;
			font-family: 'Courier New', monospace;
			transition: all 0.3s ease;
			font-size: 14px;
			line-height: 1.6;
		}
		
		textarea:focus {
			outline: none;
			border-color: #4CAF50;
			box-shadow: 0 0 20px rgba(76, 175, 80, 0.3);
			background: rgba(0, 0, 0, 0.5);
		}
		
		textarea::placeholder {
			color: #666;
		}
		
		.results-container {
			background: rgba(0, 0, 0, 0.4);
			border: 1px solid rgba(255, 255, 255, 0.1);
			border-radius: 15px;
			padding: 18px;
			max-height: 450px;
			overflow-y: auto;
			font-family: 'Courier New', monospace;
			font-size: 0.9rem;
			line-height: 1.8;
		}
		
		.results-container::-webkit-scrollbar {
			width: 10px;
		}
		
		.results-container::-webkit-scrollbar-track {
			background: rgba(255, 255, 255, 0.05);
			border-radius: 10px;
		}
		
		.results-container::-webkit-scrollbar-thumb {
			background: linear-gradient(180deg, #4CAF50, #45a049);
			border-radius: 10px;
			box-shadow: 0 2px 6px rgba(76, 175, 80, 0.4);
		}
		
		.results-container::-webkit-scrollbar-thumb:hover {
			background: linear-gradient(180deg, #45a049, #4CAF50);
		}
		
		.result-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
			padding-bottom: 15px;
			border-bottom: 1px solid rgba(255, 255, 255, 0.1);
		}
		
		.result-title {
			font-size: 1.3rem;
			font-weight: 600;
			display: flex;
			align-items: center;
			gap: 10px;
		}
		
		.result-actions {
			display: flex;
			gap: 10px;
		}
		
		.btn-icon {
			background: rgba(255, 255, 255, 0.1);
			border: 1px solid rgba(255, 255, 255, 0.1);
			color: white;
			padding: 10px 16px;
			border-radius: 10px;
			cursor: pointer;
			transition: all 0.3s ease;
			font-size: 14px;
		}
		
		.btn-icon:hover {
			background: rgba(255, 255, 255, 0.2);
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
		}
		
		/* Badge styles for results */
		.badge-soft-success {
			background: rgba(76, 175, 80, 0.2);
			color: #4CAF50;
			padding: 4px 12px;
			border-radius: 6px;
			font-weight: 600;
			font-size: 12px;
			border: 1px solid rgba(76, 175, 80, 0.3);
		}
		
		.badge-soft-danger {
			background: rgba(244, 67, 54, 0.2);
			color: #f44336;
			padding: 4px 12px;
			border-radius: 6px;
			font-weight: 600;
			font-size: 12px;
			border: 1px solid rgba(244, 67, 54, 0.3);
		}
		
		/* Mobile responsive */
		@media (max-width: 768px) {
			.action-buttons {
				flex-direction: column;
			}
			
			.btn-action {
				width: 100%;
				justify-content: center;
			}
			
			.stats-container {
				grid-template-columns: repeat(2, 1fr);
			}
			
			.checker-title {
				font-size: 1.5rem;
			}
		}
	</style>
</head>
<body>
    
    <input type="hidden" value="<?php echo $base64Value; ?>" name="token_api" id="token_api">
    
	<div class="container">
		<a href="home?accessKey=dedf0fcff631caf4b5d5164191020f6e14e5e69c" class="btn-back shadow">
			<i class="fas fa-arrow-left"></i> Voltar
		</a>
	</div>
	
	<div class="container mt-3">
		<div class="header-card">
			<h3 class="checker-title">
				<i class="fas <?php echo $gateIcon; ?>"></i> <?php echo $gateName; ?>
			</h3>
			<div class="user-info">
				<span class="highlight"><?php echo $username; ?></span> | 
				Expira em: <span class="highlight"><?php echo $expira; ?></span> | 
				Último Login: <span class="highlight"><?php echo $lastLogin; ?></span>
			</div>
			
			<div class="action-buttons">
				<button class="btn-action btn-start" id="chk-start">
					<i class="fas fa-play"></i> Iniciar
				</button>
				<button class="btn-action btn-pause" id="chk-pause" disabled>
					<i class="fas fa-pause"></i> Pausar
				</button>
				<button class="btn-action btn-stop" id="chk-stop" disabled>
					<i class="fas fa-stop"></i> Parar
				</button>
				<button class="btn-action btn-clean" id="chk-clean">
					<i class="fas fa-trash-alt"></i> Limpar
				</button>
			</div>
			
			<div class="mt-3">
				<span class="badge badge-warning status-badge" id="estatus">Aguardando início...</span>
			</div>
		</div>
	</div>

	<!-- Seção de Códigos de Retorno LIVE -->
	<div class="container mt-3">
		<div class="header-card" style="background: linear-gradient(135deg, rgba(76, 175, 80, 0.1) 0%, rgba(76, 175, 80, 0.05) 100%); border: 1px solid rgba(76, 175, 80, 0.3);">
			<h4 style="color: #4CAF50; font-size: 1.3rem; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
				<i class="fas fa-info-circle"></i> 🎯 CÓDIGOS DE RETORNO - LIVE
			</h4>
			<div style="color: #e0e0e0; line-height: 1.8;">
				<div style="color: #e0e0e0; line-height: 1.8;">
					<p style="margin-bottom: 15px; font-size: 15px;">
						<strong style="color: #fff;">💳 Teste seus cartões e identifique os seguintes retornos aprovados:</strong>
					</p>
					
					<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px; margin-top: 15px;">
						<div style="background: rgba(255, 255, 255, 0.05); padding: 15px; border-radius: 12px; border-left: 4px solid #2196F3;">
							<div style="color: #2196F3; font-weight: 600; margin-bottom: 8px; font-size: 14px;">
								💠 VISA
							</div>
							<div style="color: #b8b8b8; font-size: 13px;">
								N7 • 54 • 1045 • 1001
							</div>
						</div>
						
						<div style="background: rgba(255, 255, 255, 0.05); padding: 15px; border-radius: 12px; border-left: 4px solid #FF9800;">
							<div style="color: #FF9800; font-weight: 600; margin-bottom: 8px; font-size: 14px;">
								💠 ELO
							</div>
							<div style="color: #b8b8b8; font-size: 13px;">
								63
							</div>
						</div>
						
						<div style="background: rgba(255, 255, 255, 0.05); padding: 15px; border-radius: 12px; border-left: 4px solid #F44336;">
							<div style="color: #F44336; font-weight: 600; margin-bottom: 8px; font-size: 14px;">
								💠 MASTERCARD
							</div>
							<div style="color: #b8b8b8; font-size: 13px;">
								83 • 12
							</div>
						</div>
						
						<div style="background: rgba(255, 255, 255, 0.05); padding: 15px; border-radius: 12px; border-left: 4px solid #9C27B0;">
							<div style="color: #9C27B0; font-weight: 600; margin-bottom: 8px; font-size: 14px;">
								💠 MASTER SICREDI
							</div>
							<div style="color: #b8b8b8; font-size: 13px;">
								VBV
							</div>
						</div>
						
						<div style="background: rgba(255, 255, 255, 0.05); padding: 15px; border-radius: 12px; border-left: 4px solid #FFEB3B;">
							<div style="color: #FFEB3B; font-weight: 600; margin-bottom: 8px; font-size: 14px;">
								💠 MASTER BB
							</div>
							<div style="color: #b8b8b8; font-size: 13px;">
								1015 - Pagar.me
							</div>
						</div>
						
						<div style="background: rgba(255, 255, 255, 0.05); padding: 15px; border-radius: 12px; border-left: 4px solid #00BCD4;">
							<div style="color: #00BCD4; font-weight: 600; margin-bottom: 8px; font-size: 14px;">
								💠 AMEX
							</div>
							<div style="color: #b8b8b8; font-size: 13px;">
								FA • A6 • 100 • 101
							</div>
						</div>
					</div>
				<div style="margin-top: 20px; padding: 15px; background: rgba(76, 175, 80, 0.1); border-radius: 10px; border: 1px solid rgba(76, 175, 80, 0.3);">
					<div style="display: flex; align-items: center; gap: 10px;">
						<i class="fas fa-check-circle" style="color: #4CAF50; font-size: 18px;"></i>
						<span style="color: #4CAF50; font-weight: 600; font-size: 14px;">
							✅ Estes códigos indicam cartões VÁLIDOS e APROVADOS!
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- tabs -->
	<div class="container">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#chk-home" role="tab">
					<i class="far fa-credit-card"></i> Lista
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="profile-tab" data-toggle="tab" href="#chk-lives" role="tab">
					<i class="fa fa-thumbs-up"></i> Aprovadas
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="contact-tab" data-toggle="tab" href="#chk-dies" role="tab">
					<i class="fa fa-thumbs-down"></i> Reprovadas
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="error-tab" data-toggle="tab" href="#chk-errors" role="tab">
					<i class="fas fa-times"></i> Erros
				</a>
			</li>
		</ul>
		
		<div class="tab-content" id="myTabContent">
			<!-- HOME DO CHECKER -->
			<div class="tab-pane fade show active" id="chk-home" role="tabpanel">
				<div class="stats-container">
					<div class="stat-card">
						<div class="stat-label">Aprovadas</div>
						<div class="stat-value val-lives">0</div>
					</div>
					<div class="stat-card">
						<div class="stat-label">Reprovadas</div>
						<div class="stat-value val-dies">0</div>
					</div>
					<div class="stat-card">
						<div class="stat-label">Erros</div>
						<div class="stat-value val-errors">0</div>
					</div>
					<div class="stat-card">
						<div class="stat-label">Testadas</div>
						<div class="stat-value val-tested">0</div>
					</div>
					<div class="stat-card">
						<div class="stat-label">Total</div>
						<div class="stat-value val-total">0</div>
					</div>
				</div>
				
				<div class="mt-3">
					<textarea id="lista_cartoes" placeholder="Cole sua lista de cartões aqui (um por linha)..." rows="12"></textarea>
				</div>
			</div>
			
			<script>
function apagarValoresLives() {
  var tabela = document.getElementById("lives");
  tabela.innerHTML = "";
}
</script>
			
			<!-- LIVES DO CHECKERS -->
			<div class="tab-pane fade" id="chk-lives" role="tabpanel">
				<div class="result-header">
					<div class="result-title">
						<i class="fas fa-check-circle" style="color: #4CAF50;"></i> Aprovadas
					</div>
					<div class="result-actions">
						<button class="btn-icon" id="copyButton" title="Copiar">
							<i class="fas fa-copy"></i>
						</button>
						<button class="btn-icon" onclick="apagarValoresLives()" title="Limpar">
							<i class="fas fa-trash-alt"></i>
						</button>
					</div>
				</div>
				<div>Total: <span class="val-lives" style="color: #4CAF50; font-weight: 600;">0</span></div>
				<div class="results-container mt-3" id="lives"></div>
			</div>
			
			<script>
        const copyButton = document.getElementById('copyButton');
        const livesDiv = document.getElementById('lives');

        copyButton.addEventListener('click', () => {
            const range = document.createRange();
            range.selectNode(livesDiv);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);

            try {
                const successful = document.execCommand('copy');
                const message = successful ? 'Copiado para a área de transferência!' : 'Não foi possível copiar.';
                toastr["success"](message);
            } catch (err) {
                console.error('Erro ao copiar: ', err);
            }

            window.getSelection().removeAllRanges();
        });
    </script>
			
			<script>
function apagarValoresDies() {
  var tabela = document.getElementById("dies");
  tabela.innerHTML = "";
}
</script>

			<script>
function apagarValoresErrors() {
  var tabela = document.getElementById("errors");
  tabela.innerHTML = "";
}
</script>
			
			<!-- DIES DO CHECKER -->
			<div class="tab-pane fade" id="chk-dies" role="tabpanel">
				<div class="result-header">
					<div class="result-title">
						<i class="fas fa-times-circle" style="color: #f44336;"></i> Reprovadas
					</div>
					<div class="result-actions">
						<button class="btn-icon" onclick="apagarValoresDies()" title="Limpar">
							<i class="fas fa-trash-alt"></i>
						</button>
					</div>
				</div>
				<div>Total: <span class="val-dies" style="color: #f44336; font-weight: 600;">0</span></div>
				<div class="results-container mt-3" id="dies"></div>
			</div>
			
			<!-- ERRORS DO CHECKER -->
			<div class="tab-pane fade" id="chk-errors" role="tabpanel">
				<div class="result-header">
					<div class="result-title">
						<i class="fas fa-exclamation-triangle" style="color: #FF9800;"></i> Erros
					</div>
					<div class="result-actions">
						<button class="btn-icon" onclick="apagarValoresErrors()" title="Limpar">
							<i class="fas fa-trash-alt"></i>
						</button>
					</div>
				</div>
				<div>Total: <span class="val-errors" style="color: #FF9800; font-weight: 600;">0</span></div>
				<div class="results-container mt-3" id="errors"></div>
			</div>
		</div>	
	</div>
	
	<!-- jquery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- bootstrap -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
	<!-- toastr -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	
<script type="text/javascript">
	$(document).ready(function() {
		// variaveis de informação
		var testadas = [];
		var total = 0;
		var tested = 0;
		var lives = 0;
		var dies = 0;
		var errors = 0;
		var stopped = true;
		var paused = true;
        var token_api = document.getElementById("token_api").value;

		function removelinha() {
			var lines = $("textarea").val().split('\n');
			lines.splice(0, 1);
			$("textarea").val(lines.join("\n"));
		}

		function testar(tested, total, lista) {
			// verifica se nao está parado o checker
			if (stopped == true) {
				return false;
			}

			// verifica se nao está pausado o checker
			if (paused == true) {
				return false;
			}

			// verifica se ja terminou de testar
			if (tested >= total) {
				console.log('finalizado ' + tested + " de " + total);
				$("#estatus").attr("class", "badge badge-success status-badge").text("Teste finalizado");
				toastr["success"]("Teste de " + total + " itens finalizado");
				$("#chk-start").removeAttr('disabled');
				$("#chk-clean").removeAttr('disabled');
				$("#chk-stop").attr("disabled", "true");
				$("#chk-pause").attr("disabled", "true");
				return false;
			}

			// conteudo que será testado
			var conteudo = lista[tested];
            var token_api = document.getElementById("token_api").value;
            var gate = '<?php echo $gate; ?>';
            var gateFile = gate === 'allbins' ? 'pagseguro.php' : 'paypal.php';

            $.ajax({
                url: gateFile,
                type: 'GET',
                data: { lista: conteudo, token_api: token_api },
			})
			.done(function(response) {
				// verifica se nao está parado o checker
				if (stopped == true) {
					return false;
				}

				// verifica se nao está pausado o checker
				if (paused == true) {
					return false;
				}

				tested++;

				// verifica o retorno
				if (response.indexOf("#APROVADA") >= 0) {
					lives++
					$("#estatus").attr("class", "badge badge-success status-badge").text(conteudo + " -> LIVE");
					toastr["success"]("Aprovada! " + conteudo);
					$("#lives").append(response + "<br>");
					audio.play();
				} else if (response.indexOf("#REPROVADA") >= 0) {
					dies++
					$("#estatus").attr("class", "badge badge-danger status-badge").text(conteudo + " -> DIE");
					toastr["error"]("Reprovada! " + conteudo);
					$("#dies").append(response + "<br>");
				} else {
					errors++;
					$("#estatus").attr("class", "badge badge-warning status-badge").text(conteudo + " -> ERROR");
					toastr["warning"]("Ocorreu um erro! " + conteudo);
					$("#errors").append(response + "<br>");
				}

				// atualiza resultados
				$(".val-total").text(total);
				$(".val-lives").text(lives);
				$(".val-dies").text(dies);
				$(".val-errors").text(errors);
				$(".val-tested").text(tested);

				// remove linha
				removelinha();
				console.log(response);

				// executa a função novamente
				testar(tested, total, lista);
			})
			.fail(function() {
				return false;
			})
		}

		// ========== START ========== //
		function start() {
			var lista = $("textarea").val().trim().split('\n');
			var total = lista.length;

			$(".val-total").text(total);
			stopped = false;
			paused = false;
			toastr["success"]("Checker Iniciado.");
			$("#estatus").attr("class", "badge badge-success status-badge").text("Checker iniciado, aguarde...");

			// Libera os botões
			$("#chk-stop").removeAttr('disabled');
			$("#chk-pause").removeAttr('disabled');
			$("#chk-start").attr("disabled", "true");
			$("#chk-clean").attr("disabled", "true");

			// Inicia o teste
			testar(tested, total, lista);
		}


		$("#chk-start").click(function() {
			if ($('textarea').val().trim() == "") {
				$('textarea').focus();
				toastr["error"]("Insira a lista de cartões!");
			} else {
				start();
			}
		});

		// ========== PAUSE ========== //
		function pause() {
			$("#chk-start").removeAttr('disabled');
			$("#chk-pause").attr("disabled", "true");
			paused = true;
			console.log('checker pausado');
			toastr["info"]("Checker Pausado!");
			$("#estatus").attr("class", "badge badge-info status-badge").text("Checker pausado...");
		}

		$("#chk-pause").click(function() {
			pause();
		});

		// ========== STOP ========== //
		function stop() {
			stopped = true;
			$("#chk-start").removeAttr('disabled');
			$("#chk-clean").removeAttr('disabled');
			$("#chk-stop").attr("disabled", "true");
			$("#chk-pause").attr("disabled", "true");
			console.log('checker parado');
			toastr["info"]("Checker Parado!");
			$("#estatus").attr("class", "badge badge-secondary status-badge").text("Checker parado...");
		}

		$("#chk-stop").click(function() {
			stop();
		});

		// ========== CLEAN ========== //
		function clean() {
			testadas = [];
			total = 0;
			tested = 0;
			lives = 0;
			dies = 0;
			errors = 0;
			stopped = true;

			// atualiza resultados
			$(".val-total").text(total);
			$(".val-lives").text(lives);
			$(".val-dies").text(dies);
			$(".val-errors").text(errors);
			$(".val-tested").text(tested);
			$("textarea").val("");
			toastr["info"]("Checker Limpo!");
		}

		$("#chk-clean").click(function() {
			clean();
		});
	});
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <script src="script.js"></script>

</body>
</html>
