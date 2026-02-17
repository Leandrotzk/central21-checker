<?php
/**
 * EXEMPLO: Como usar os tokens do Painel Admin no seu código
 * 
 * Este arquivo mostra como integrar o sistema de configuração
 * no seu código de checkers/gateways
 */

// 1. Incluir o helper
require_once 'config_helper.php';

// 2. Obter o token do PagBank automaticamente
try {
    $PAGBANK_TOKEN = ConfigHelper::getPagBankToken();
    $PUBLIC_KEY_BASE64 = ConfigHelper::getPagBankPublicKey();
    
    echo "Token carregado com sucesso!\n";
    echo "Token: " . substr($PAGBANK_TOKEN, 0, 20) . "...\n";
    
} catch (Exception $e) {
    die("Erro ao carregar configurações: " . $e->getMessage());
}

// 3. Usar o token nas suas requisições
function fazerRequisicaoPagBank($endpoint, $data) {
    global $PAGBANK_TOKEN;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.pagseguro.com' . $endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $PAGBANK_TOKEN
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'response' => $response,
        'http_code' => $httpCode
    ];
}

// 4. Exemplo completo de uso em pagseguro.php
/*

// No início do seu arquivo pagseguro.php, adicione:
require_once 'config_helper.php';

// Depois, onde você define o token, substitua por:
try {
    $PAGBANK_TOKEN = ConfigHelper::getPagBankToken();
    $PUBLIC_KEY_BASE64 = ConfigHelper::getPagBankPublicKey();
} catch (Exception $e) {
    echo json_encode(['error' => 'Configuração inválida: ' . $e->getMessage()]);
    exit;
}

// O resto do código continua igual!
// Agora o token será carregado automaticamente do painel admin

*/

// 5. Exemplo de como listar gates disponíveis
$gates = ConfigHelper::getActiveGates();
echo "\nGates ativas:\n";
foreach ($gates as $gate) {
    echo "- " . $gate['name'] . " (" . $gate['slug'] . ")\n";
}

// 6. Exemplo de como obter informações de uma gate específica
$gateSlug = 'preauth'; // Pega da URL: ?gate=preauth
$gate = ConfigHelper::getGateBySlug($gateSlug);
if ($gate) {
    echo "\nGate selecionada:\n";
    echo "Nome: " . $gate['name'] . "\n";
    echo "Descrição: " . $gate['description'] . "\n";
    echo "Gateway: " . $gate['gateway'] . "\n";
}

// 7. Exemplo de como listar produtos
$produtos = ConfigHelper::getProducts();
echo "\nProdutos disponíveis:\n";
foreach ($produtos as $produto) {
    echo "- " . $produto['name'] . " (R$ " . $produto['price'] . ")\n";
}

?>

<!-- 
PASSOS PARA INTEGRAR NO SEU CÓDIGO EXISTENTE:

1. Copie o arquivo config_helper.php para o mesmo diretório do seu projeto

2. No início dos seus arquivos PHP (pagseguro.php, paypal.php, etc), adicione:
   
   require_once 'config_helper.php';
   
   try {
       $PAGBANK_TOKEN = ConfigHelper::getPagBankToken();
       $PUBLIC_KEY_BASE64 = ConfigHelper::getPagBankPublicKey();
   } catch (Exception $e) {
       die('Erro de configuração: ' . $e->getMessage());
   }

3. No home.php, substitua o array de gates hardcoded por:
   
   $gates = ConfigHelper::getAllGates();

4. Pronto! Agora você pode gerenciar tudo pelo painel admin sem editar código

BENEFÍCIOS:
✅ Gerenciar tokens pelo painel web
✅ Adicionar/remover gates sem editar código
✅ Ativar/desativar gates facilmente
✅ Centralizar todas as configurações
✅ Atualização automática do último uso do token
-->
