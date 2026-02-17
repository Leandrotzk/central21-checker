<?php
session_start();
error_reporting(0);

// Verificar se está logado como admin
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('Location: admin_login.php');
    exit();
}

// Carregar configurações
$configFile = 'config.json';
if (!file_exists($configFile)) {
    die('Arquivo de configuração não encontrado!');
}

$config = json_decode(file_get_contents($configFile), true);

// Processar ações
$action = isset($_GET['action']) ? $_GET['action'] : '';
$section = isset($_GET['section']) ? $_GET['section'] : 'dashboard';

// Salvar configurações
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_config'])) {
    file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $success = "Configurações salvas com sucesso!";
}

// Adicionar Token
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_token'])) {
    $newToken = [
        'id' => count($config['pagbank']['tokens']) + 1,
        'name' => $_POST['token_name'],
        'token' => $_POST['token_value'],
        'status' => 'active',
        'created_at' => date('Y-m-d'),
        'last_used' => null
    ];
    $config['pagbank']['tokens'][] = $newToken;
    file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $success = "Token adicionado com sucesso!";
}

// Adicionar Produto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_produto'])) {
    $newProduto = [
        'id' => count($config['produtos']) + 1,
        'name' => $_POST['produto_name'],
        'price' => $_POST['produto_price'],
        'description' => $_POST['produto_description'],
        'status' => 'active',
        'created_at' => date('Y-m-d')
    ];
    $config['produtos'][] = $newProduto;
    file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $success = "Produto adicionado com sucesso!";
}

// Adicionar Gate
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_gate'])) {
    $newGate = [
        'id' => count($config['gates']) + 1,
        'name' => $_POST['gate_name'],
        'slug' => strtolower(str_replace(' ', '', $_POST['gate_slug'])),
        'icon' => $_POST['gate_icon'],
        'description' => $_POST['gate_description'],
        'status' => $_POST['gate_status'],
        'gateway' => $_POST['gate_gateway'],
        'created_at' => date('Y-m-d')
    ];
    $config['gates'][] = $newGate;
    file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $success = "Gate adicionada com sucesso!";
}

// Deletar Token
if ($action === 'delete_token' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    foreach ($config['pagbank']['tokens'] as $key => $token) {
        if ($token['id'] == $id) {
            unset($config['pagbank']['tokens'][$key]);
            $config['pagbank']['tokens'] = array_values($config['pagbank']['tokens']);
            file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $success = "Token deletado com sucesso!";
            break;
        }
    }
}

// Deletar Produto
if ($action === 'delete_produto' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    foreach ($config['produtos'] as $key => $produto) {
        if ($produto['id'] == $id) {
            unset($config['produtos'][$key]);
            $config['produtos'] = array_values($config['produtos']);
            file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $success = "Produto deletado com sucesso!";
            break;
        }
    }
}

// Deletar Gate
if ($action === 'delete_gate' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    foreach ($config['gates'] as $key => $gate) {
        if ($gate['id'] == $id) {
            unset($config['gates'][$key]);
            $config['gates'] = array_values($config['gates']);
            file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $success = "Gate deletada com sucesso!";
            break;
        }
    }
}

// Toggle Status Token
if ($action === 'toggle_token' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    foreach ($config['pagbank']['tokens'] as $key => $token) {
        if ($token['id'] == $id) {
            $config['pagbank']['tokens'][$key]['status'] = 
                ($token['status'] === 'active') ? 'inactive' : 'active';
            file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $success = "Status do token atualizado!";
            break;
        }
    }
}

// Toggle Status Gate
if ($action === 'toggle_gate' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    foreach ($config['gates'] as $key => $gate) {
        if ($gate['id'] == $id) {
            $config['gates'][$key]['status'] = 
                ($gate['status'] === 'active') ? 'disabled' : 'active';
            file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $success = "Status da gate atualizado!";
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - <?php echo $config['system']['site_name']; ?></title>
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
        }
        
        .sidebar {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }
        
        .sidebar-header h3 {
            color: white;
            font-size: 1.5rem;
            margin: 0;
        }
        
        .sidebar-header small {
            color: #b8b8b8;
            font-size: 0.85rem;
        }
        
        .nav-link {
            color: #b8b8b8;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .nav-link:hover, .nav-link.active {
            color: white;
            background: rgba(76, 175, 80, 0.1);
            border-left-color: #4CAF50;
        }
        
        .nav-link i {
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            padding: 30px;
        }
        
        .header-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .header-section h2 {
            color: white;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .header-section .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item {
            color: #b8b8b8;
        }
        
        .breadcrumb-item.active {
            color: #4CAF50;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .card-header {
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px 20px 0 0 !important;
            padding: 20px;
        }
        
        .card-header h5 {
            color: white;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .card-body {
            padding: 25px;
            color: white;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
        }
        
        .stat-card h3 {
            color: #4CAF50;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .stat-card p {
            color: #b8b8b8;
            margin: 0;
        }
        
        .table {
            color: white;
        }
        
        .table thead th {
            border-color: rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.2);
            color: #4CAF50;
        }
        
        .table td {
            border-color: rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }
        
        .badge-active {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            padding: 6px 12px;
            border-radius: 8px;
        }
        
        .badge-inactive {
            background: linear-gradient(45deg, #f44336, #d32f2f);
            padding: 6px 12px;
            border-radius: 8px;
        }
        
        .badge-disabled {
            background: linear-gradient(45deg, #607D8B, #455A64);
            padding: 6px 12px;
            border-radius: 8px;
        }
        
        .btn-sm {
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-success {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            border: none;
        }
        
        .btn-success:hover {
            background: linear-gradient(45deg, #45a049, #3d8b40);
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background: linear-gradient(45deg, #f44336, #d32f2f);
            border: none;
        }
        
        .btn-danger:hover {
            background: linear-gradient(45deg, #d32f2f, #b71c1c);
            transform: translateY(-2px);
        }
        
        .btn-warning {
            background: linear-gradient(45deg, #FF9800, #F57C00);
            border: none;
        }
        
        .btn-warning:hover {
            background: linear-gradient(45deg, #F57C00, #E65100);
            transform: translateY(-2px);
        }
        
        .btn-info {
            background: linear-gradient(45deg, #2196F3, #1976D2);
            border: none;
        }
        
        .btn-info:hover {
            background: linear-gradient(45deg, #1976D2, #1565C0);
            transform: translateY(-2px);
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 10px;
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #4CAF50;
            color: white;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
        
        select.form-control option {
            background: #302b63;
            color: white;
        }
        
        label {
            color: white;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .alert {
            border-radius: 15px;
            border: none;
        }
        
        .alert-success {
            background: rgba(76, 175, 80, 0.2);
            border: 1px solid rgba(76, 175, 80, 0.3);
            color: #4CAF50;
        }
        
        .modal-content {
            background: rgba(30, 30, 50, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
        }
        
        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .modal-title {
            color: white;
        }
        
        .close {
            color: white;
            opacity: 0.7;
        }
        
        .close:hover {
            color: white;
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="sidebar-header">
                    <h3><i class="fas fa-shield-alt"></i> Admin</h3>
                    <small><?php echo $_SESSION['admin_username']; ?></small>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link <?php echo $section === 'dashboard' ? 'active' : ''; ?>" href="?section=dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a class="nav-link <?php echo $section === 'tokens' ? 'active' : ''; ?>" href="?section=tokens">
                        <i class="fas fa-key"></i> Tokens PagBank
                    </a>
                    <a class="nav-link <?php echo $section === 'produtos' ? 'active' : ''; ?>" href="?section=produtos">
                        <i class="fas fa-box"></i> Produtos
                    </a>
                    <a class="nav-link <?php echo $section === 'gates' ? 'active' : ''; ?>" href="?section=gates">
                        <i class="fas fa-credit-card"></i> Gates/Checkers
                    </a>
                    <a class="nav-link <?php echo $section === 'usuarios' ? 'active' : ''; ?>" href="usuarios.php?admin=true">
                        <i class="fas fa-users"></i> Usuários
                    </a>
                    <a class="nav-link" href="admin_logout.php">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </a>
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <!-- Header -->
                <div class="header-section">
                    <h2>Painel Administrativo</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="?section=dashboard">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?php 
                                    $titles = [
                                        'dashboard' => 'Dashboard',
                                        'tokens' => 'Tokens PagBank',
                                        'produtos' => 'Produtos',
                                        'gates' => 'Gates/Checkers'
                                    ];
                                    echo isset($titles[$section]) ? $titles[$section] : 'Dashboard';
                                ?>
                            </li>
                        </ol>
                    </nav>
                </div>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Dashboard -->
                <?php if ($section === 'dashboard'): ?>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h3><?php echo count($config['pagbank']['tokens']); ?></h3>
                                <p>Tokens PagBank</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h3><?php echo count($config['produtos']); ?></h3>
                                <p>Produtos</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h3><?php echo count($config['gates']); ?></h3>
                                <p>Gates Configuradas</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <h3><?php echo count(array_filter($config['gates'], function($g) { return $g['status'] === 'active'; })); ?></h3>
                                <p>Gates Ativas</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-info-circle"></i> Bem-vindo ao Painel Admin</h5>
                        </div>
                        <div class="card-body">
                            <p>Use o menu lateral para navegar pelas diferentes seções:</p>
                            <ul>
                                <li><strong>Tokens PagBank:</strong> Gerenciar tokens de autenticação</li>
                                <li><strong>Produtos:</strong> Adicionar e gerenciar produtos</li>
                                <li><strong>Gates/Checkers:</strong> Configurar gates de pagamento (até 15)</li>
                                <li><strong>Usuários:</strong> Gerenciar usuários do sistema</li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Tokens PagBank -->
                <?php if ($section === 'tokens'): ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-key"></i> Gerenciar Tokens PagBank</h5>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addTokenModal">
                                <i class="fas fa-plus"></i> Adicionar Novo Token
                            </button>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Token</th>
                                            <th>Status</th>
                                            <th>Criado em</th>
                                            <th>Último Uso</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($config['pagbank']['tokens'] as $token): ?>
                                            <tr>
                                                <td><?php echo $token['id']; ?></td>
                                                <td><?php echo $token['name']; ?></td>
                                                <td>
                                                    <code style="color: #4CAF50;">
                                                        <?php echo substr($token['token'], 0, 20) . '...'; ?>
                                                    </code>
                                                </td>
                                                <td>
                                                    <span class="badge badge-<?php echo $token['status'] === 'active' ? 'active' : 'inactive'; ?>">
                                                        <?php echo $token['status']; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $token['created_at']; ?></td>
                                                <td><?php echo $token['last_used'] ?? 'Nunca'; ?></td>
                                                <td>
                                                    <a href="?section=tokens&action=toggle_token&id=<?php echo $token['id']; ?>" 
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fas fa-toggle-on"></i>
                                                    </a>
                                                    <a href="?section=tokens&action=delete_token&id=<?php echo $token['id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Tem certeza que deseja deletar este token?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Produtos -->
                <?php if ($section === 'produtos'): ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-box"></i> Gerenciar Produtos</h5>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addProdutoModal">
                                <i class="fas fa-plus"></i> Adicionar Novo Produto
                            </button>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Preço</th>
                                            <th>Descrição</th>
                                            <th>Status</th>
                                            <th>Criado em</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($config['produtos'] as $produto): ?>
                                            <tr>
                                                <td><?php echo $produto['id']; ?></td>
                                                <td><?php echo $produto['name']; ?></td>
                                                <td>R$ <?php echo $produto['price']; ?></td>
                                                <td><?php echo $produto['description']; ?></td>
                                                <td>
                                                    <span class="badge badge-<?php echo $produto['status'] === 'active' ? 'active' : 'inactive'; ?>">
                                                        <?php echo $produto['status']; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $produto['created_at']; ?></td>
                                                <td>
                                                    <a href="?section=produtos&action=delete_produto&id=<?php echo $produto['id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Tem certeza que deseja deletar este produto?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Gates -->
                <?php if ($section === 'gates'): ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-credit-card"></i> Gerenciar Gates/Checkers (<?php echo count($config['gates']) . '/' . $config['system']['max_gates']; ?>)</h5>
                        </div>
                        <div class="card-body">
                            <?php if (count($config['gates']) < $config['system']['max_gates']): ?>
                                <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addGateModal">
                                    <i class="fas fa-plus"></i> Adicionar Nova Gate
                                </button>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    Limite máximo de gates atingido (<?php echo $config['system']['max_gates']; ?>)
                                </div>
                            <?php endif; ?>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nome</th>
                                            <th>Slug</th>
                                            <th>Ícone</th>
                                            <th>Descrição</th>
                                            <th>Gateway</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($config['gates'] as $gate): ?>
                                            <tr>
                                                <td><?php echo $gate['id']; ?></td>
                                                <td><?php echo $gate['name']; ?></td>
                                                <td><code><?php echo $gate['slug']; ?></code></td>
                                                <td><i class="fas <?php echo $gate['icon']; ?>"></i></td>
                                                <td><?php echo substr($gate['description'], 0, 50) . '...'; ?></td>
                                                <td><?php echo $gate['gateway']; ?></td>
                                                <td>
                                                    <span class="badge badge-<?php echo $gate['status']; ?>">
                                                        <?php echo $gate['status']; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="?section=gates&action=toggle_gate&id=<?php echo $gate['id']; ?>" 
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fas fa-toggle-on"></i>
                                                    </a>
                                                    <a href="?section=gates&action=delete_gate&id=<?php echo $gate['id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Tem certeza que deseja deletar esta gate?')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Modal: Adicionar Token -->
    <div class="modal fade" id="addTokenModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Novo Token PagBank</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome do Token:</label>
                            <input type="text" name="token_name" class="form-control" required 
                                   placeholder="Ex: Token Principal">
                        </div>
                        <div class="form-group">
                            <label>Token (Chave API):</label>
                            <textarea name="token_value" class="form-control" rows="3" required 
                                      placeholder="Cole o token completo aqui"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="add_token" class="btn btn-success">Adicionar Token</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal: Adicionar Produto -->
    <div class="modal fade" id="addProdutoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Novo Produto</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nome do Produto:</label>
                            <input type="text" name="produto_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Preço (R$):</label>
                            <input type="number" step="0.01" name="produto_price" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Descrição:</label>
                            <textarea name="produto_description" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="add_produto" class="btn btn-success">Adicionar Produto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal: Adicionar Gate -->
    <div class="modal fade" id="addGateModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Nova Gate/Checker</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome da Gate:</label>
                                    <input type="text" name="gate_name" class="form-control" required 
                                           placeholder="Ex: VISA CHECKER">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Slug (URL):</label>
                                    <input type="text" name="gate_slug" class="form-control" required 
                                           placeholder="Ex: visachecker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ícone FontAwesome:</label>
                                    <input type="text" name="gate_icon" class="form-control" required 
                                           value="fa-credit-card" placeholder="Ex: fa-credit-card">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gateway:</label>
                                    <select name="gate_gateway" class="form-control" required>
                                        <option value="pagseguro">PagSeguro</option>
                                        <option value="paypal">PayPal</option>
                                        <option value="stripe">Stripe</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Descrição:</label>
                            <textarea name="gate_description" class="form-control" rows="3" required 
                                      placeholder="Descrição da gate..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Status Inicial:</label>
                            <select name="gate_status" class="form-control" required>
                                <option value="active">Ativo</option>
                                <option value="disabled">Desativado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="add_gate" class="btn btn-success">Adicionar Gate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
