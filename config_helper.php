<?php
/**
 * Helper para carregar configurações do sistema
 * Use este arquivo em qualquer página que precise acessar:
 * - Tokens PagBank
 * - Produtos
 * - Gates
 * - Configurações do sistema
 */

class ConfigHelper {
    private static $config = null;
    private static $configFile = 'config.json';
    
    /**
     * Carrega as configurações do arquivo JSON
     */
    public static function load() {
        if (self::$config === null) {
            if (!file_exists(self::$configFile)) {
                throw new Exception('Arquivo de configuração não encontrado!');
            }
            self::$config = json_decode(file_get_contents(self::$configFile), true);
        }
        return self::$config;
    }
    
    /**
     * Retorna um token ativo do PagBank
     * @return string Token do PagBank
     */
    public static function getPagBankToken() {
        self::load();
        $activeTokens = array_filter(self::$config['pagbank']['tokens'], function($token) {
            return $token['status'] === 'active';
        });
        
        if (empty($activeTokens)) {
            throw new Exception('Nenhum token ativo do PagBank encontrado!');
        }
        
        // Retorna o primeiro token ativo
        $token = reset($activeTokens);
        
        // Atualiza o último uso
        self::updateTokenLastUsed($token['id']);
        
        return $token['token'];
    }
    
    /**
     * Retorna a chave pública do PagBank
     */
    public static function getPagBankPublicKey() {
        self::load();
        return self::$config['pagbank']['public_key'];
    }
    
    /**
     * Retorna todas as gates ativas
     */
    public static function getActiveGates() {
        self::load();
        return array_filter(self::$config['gates'], function($gate) {
            return $gate['status'] === 'active';
        });
    }
    
    /**
     * Retorna todas as gates
     */
    public static function getAllGates() {
        self::load();
        return self::$config['gates'];
    }
    
    /**
     * Retorna uma gate específica pelo slug
     */
    public static function getGateBySlug($slug) {
        self::load();
        foreach (self::$config['gates'] as $gate) {
            if ($gate['slug'] === $slug) {
                return $gate;
            }
        }
        return null;
    }
    
    /**
     * Retorna todos os produtos
     */
    public static function getProducts() {
        self::load();
        return array_filter(self::$config['produtos'], function($produto) {
            return $produto['status'] === 'active';
        });
    }
    
    /**
     * Retorna o nome do site
     */
    public static function getSiteName() {
        self::load();
        return self::$config['system']['site_name'];
    }
    
    /**
     * Atualiza o último uso de um token
     */
    private static function updateTokenLastUsed($tokenId) {
        self::load();
        foreach (self::$config['pagbank']['tokens'] as $key => $token) {
            if ($token['id'] == $tokenId) {
                self::$config['pagbank']['tokens'][$key]['last_used'] = date('Y-m-d H:i:s');
                file_put_contents(self::$configFile, json_encode(self::$config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                break;
            }
        }
    }
    
    /**
     * Salva as configurações
     */
    public static function save() {
        file_put_contents(self::$configFile, json_encode(self::$config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

// Exemplo de uso:
/*
// Obter token do PagBank
$token = ConfigHelper::getPagBankToken();

// Obter chave pública
$publicKey = ConfigHelper::getPagBankPublicKey();

// Obter gates ativas
$gates = ConfigHelper::getActiveGates();

// Obter gate específica
$gate = ConfigHelper::getGateBySlug('preauth');

// Obter produtos
$produtos = ConfigHelper::getProducts();

// Obter nome do site
$siteName = ConfigHelper::getSiteName();
*/
?>
