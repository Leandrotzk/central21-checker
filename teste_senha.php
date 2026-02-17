<?php
// Script de teste - verificar se a senha do Gold21 está correta
// REMOVER APÓS TESTE

$senha_digitada = "102030";
$hash_no_json = "$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy";

echo "<h1>Teste de Autenticação</h1>";
echo "<h2>CENTRAL21</h2>";
echo "<hr>";

echo "<strong>Senha digitada:</strong> " . $senha_digitada . "<br>";
echo "<strong>Hash no JSON:</strong> " . $hash_no_json . "<br><br>";

if (password_verify($senha_digitada, $hash_no_json)) {
    echo "<p style='color: green; font-size: 20px;'>✅ SENHA CORRETA! O login deve funcionar.</p>";
} else {
    echo "<p style='color: red; font-size: 20px;'>❌ SENHA INCORRETA! Problema no hash.</p>";
    echo "<br><strong>Gerando novo hash...</strong><br>";
    $novo_hash = password_hash($senha_digitada, PASSWORD_BCRYPT);
    echo "<strong>Novo hash gerado:</strong> " . $novo_hash . "<br>";
    echo "<p>Use este hash no arquivo JSON!</p>";
}

echo "<hr>";
echo "<h3>Dados do Usuário no JSON:</h3>";
$json_file = "5ddd2e45147066c4399b5fcd4cb63e68.json";
if (file_exists($json_file)) {
    $data = json_decode(file_get_contents($json_file), true);
    echo "<pre>";
    print_r($data);
    echo "</pre>";
} else {
    echo "<p style='color: red;'>Arquivo JSON não encontrado!</p>";
}

echo "<hr>";
echo "<p><strong>IMPORTANTE:</strong> Delete este arquivo (teste_senha.php) após verificar!</p>";
?>
