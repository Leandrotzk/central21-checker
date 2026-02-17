<?php
// Script de correção automática - CENTRAL21
// Este arquivo corrige o hash da senha automaticamente

echo "<h1>🔧 Correção Automática de Senha</h1>";
echo "<hr>";

$senha_correta = "102030";
$hash_correto = password_hash($senha_correta, PASSWORD_BCRYPT);
$json_file = "5ddd2e45147066c4399b5fcd4cb63e68.json";

echo "<h2>Gerando novo hash...</h2>";
echo "<p><strong>Senha:</strong> $senha_correta</p>";
echo "<p><strong>Novo Hash:</strong> $hash_correto</p>";

if (!file_exists($json_file)) {
    die("<p style='color: red;'>❌ Arquivo JSON não encontrado!</p>");
}

// Ler o JSON
$data = json_decode(file_get_contents($json_file), true);

if (!$data) {
    die("<p style='color: red;'>❌ Erro ao ler JSON!</p>");
}

echo "<hr>";
echo "<h2>Atualizando JSON...</h2>";

$atualizado = false;

// Atualizar TODOS os usuários com a senha 102030
foreach ($data as &$user) {
    $user['password'] = $hash_correto;
    echo "<p>✅ Usuário atualizado: <strong>" . $user['username'] . "</strong></p>";
    $atualizado = true;
}

if ($atualizado) {
    // Salvar o JSON
    $resultado = file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT));
    
    if ($resultado !== false) {
        echo "<hr>";
        echo "<h2 style='color: green;'>✅ JSON ATUALIZADO COM SUCESSO!</h2>";
        echo "<p>Permissão do arquivo: " . substr(sprintf('%o', fileperms($json_file)), -4) . "</p>";
        
        // Testar se a senha funciona agora
        echo "<hr>";
        echo "<h2>Testando senha...</h2>";
        
        $data_teste = json_decode(file_get_contents($json_file), true);
        foreach ($data_teste as $user) {
            echo "<p><strong>Testando usuário:</strong> " . $user['username'] . "</p>";
            
            if (password_verify($senha_correta, $user['password'])) {
                echo "<p style='color: green; font-size: 20px;'>✅ SENHA FUNCIONA!</p>";
                echo "<p><strong>Username:</strong> " . $user['username'] . "</p>";
                echo "<p><strong>Password:</strong> " . $senha_correta . "</p>";
            } else {
                echo "<p style='color: red;'>❌ Senha não funciona para este usuário</p>";
            }
        }
        
        echo "<hr>";
        echo "<h2 style='color: green;'>🎉 TUDO PRONTO!</h2>";
        echo "<div style='background: #e8f5e9; padding: 20px; border-radius: 10px; border: 2px solid #4caf50;'>";
        echo "<h3>Agora você pode fazer login:</h3>";
        echo "<p><strong>1. Vá para a página de login</strong></p>";
        echo "<p><strong>2. Username:</strong> Gold21</p>";
        echo "<p><strong>3. Password:</strong> 102030</p>";
        echo "<p><a href='login.php' style='display: inline-block; padding: 15px 30px; background: #4caf50; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 10px;'>IR PARA LOGIN</a></p>";
        echo "</div>";
        
        echo "<hr>";
        echo "<p style='color: red; font-weight: bold;'>⚠️ IMPORTANTE: DELETE este arquivo (corrigir_senha.php) agora!</p>";
        echo "<p>Para deletar via FTP ou painel da Squarecloud.</p>";
        
    } else {
        echo "<p style='color: red;'>❌ Erro ao salvar o arquivo!</p>";
        echo "<p>Verifique as permissões do arquivo. Precisa ser 666 ou 777.</p>";
        echo "<p>Comando: chmod 666 $json_file</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Nenhum usuário encontrado no JSON!</p>";
}

echo "<hr>";
echo "<h3>JSON Atualizado:</h3>";
echo "<pre>";
print_r($data);
echo "</pre>";
?>
