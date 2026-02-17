<?php
// Script para gerar hash bcrypt correto
// ACESSE ESTE ARQUIVO APÓS O DEPLOY!

echo "<h1>Gerador de Hash - CENTRAL21</h1>";
echo "<hr>";

$senha = "102030";
$hash_gerado = password_hash($senha, PASSWORD_BCRYPT);

echo "<h2>Hash Gerado com Sucesso!</h2>";
echo "<p><strong>Senha:</strong> " . $senha . "</p>";
echo "<p><strong>Hash Bcrypt:</strong></p>";
echo "<textarea style='width: 100%; height: 100px; font-family: monospace;'>" . $hash_gerado . "</textarea>";

echo "<hr>";
echo "<h3>Como usar:</h3>";
echo "<ol>";
echo "<li>Copie o hash acima</li>";
echo "<li>Abra o arquivo: <code>5ddd2e45147066c4399b5fcd4cb63e68.json</code></li>";
echo "<li>Substitua o valor do campo 'password' pelo hash copiado</li>";
echo "<li>Salve o arquivo</li>";
echo "<li>Tente fazer login novamente</li>";
echo "</ol>";

echo "<hr>";
echo "<h3>Teste de Verificação:</h3>";

// Ler o JSON atual
$json_file = "5ddd2e45147066c4399b5fcd4cb63e68.json";
if (file_exists($json_file)) {
    $data = json_decode(file_get_contents($json_file), true);
    
    if (isset($data[0])) {
        $user = $data[0];
        echo "<p><strong>Usuário no JSON:</strong> " . $user['username'] . "</p>";
        echo "<p><strong>Hash atual no JSON:</strong></p>";
        echo "<textarea style='width: 100%; height: 100px; font-family: monospace;'>" . $user['password'] . "</textarea>";
        
        // Testar se a senha funciona com o hash atual
        if (password_verify($senha, $user['password'])) {
            echo "<p style='color: green; font-size: 20px;'>✅ SENHA ATUAL FUNCIONA! O problema não é o hash.</p>";
            echo "<p>Verifique:</p>";
            echo "<ul>";
            echo "<li>Se você está digitando exatamente: <strong>Gold21</strong> (com G maiúsculo e 21)</li>";
            echo "<li>Se você está digitando exatamente: <strong>102030</strong></li>";
            echo "<li>Se não há espaços antes ou depois</li>";
            echo "<li>Veja os logs de erro abaixo</li>";
            echo "</ul>";
        } else {
            echo "<p style='color: red; font-size: 20px;'>❌ HASH INCORRETO NO JSON!</p>";
            echo "<p><strong>SOLUÇÃO:</strong> Copie o hash gerado acima e substitua no arquivo JSON.</p>";
        }
        
        // Mostrar dados completos do JSON
        echo "<hr>";
        echo "<h3>Dados completos do usuário:</h3>";
        echo "<pre>";
        print_r($user);
        echo "</pre>";
    }
} else {
    echo "<p style='color: red;'>❌ Arquivo JSON não encontrado!</p>";
}

echo "<hr>";
echo "<h3>Debug do Login:</h3>";
echo "<p>Crie um arquivo de teste chamado <code>test_login.php</code> com este código:</p>";
echo "<textarea style='width: 100%; height: 200px; font-family: monospace;'>";
echo '<?php
$username = "Gold21";
$password = "102030";

$filename = "5ddd2e45147066c4399b5fcd4cb63e68.json";
$data = json_decode(file_get_contents($filename), true);

foreach ($data as $user) {
    echo "Comparando...\n";
    echo "Username digitado: [$username]\n";
    echo "Username no JSON: [" . $user["username"] . "]\n";
    echo "Match username: " . ($user["username"] === $username ? "SIM" : "NÃO") . "\n\n";
    
    if ($user["username"] === $username) {
        echo "Verificando senha...\n";
        $verifica = password_verify($password, $user["password"]);
        echo "Senha correta: " . ($verifica ? "SIM" : "NÃO") . "\n";
    }
}
?>';
echo "</textarea>";

echo "<hr>";
echo "<p><strong>IMPORTANTE:</strong> Delete este arquivo (gerar_hash.php) após corrigir o problema!</p>";
?>
