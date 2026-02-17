# 🚀 CENTRAL21 - SISTEMA COMPLETO E FUNCIONAL

## 📋 VISÃO GERAL

Sistema completo de checkers/validação de cartões com:
- ✅ **Painel Admin** - Gerenciar tokens, gates e produtos
- ✅ **Sistema de Login** - Usuários e admin
- ✅ **Checkers** - PRE AUTH, ALL BINS e mais
- ✅ **Geradores** - Cartões e hash bcrypt
- ✅ **15 Gates** configuráveis
- ✅ **Interface Moderna** - Design profissional

---

## 🎯 CONFIGURAÇÃO SQUARECLOUD

### Arquivo: `squarecloud.app`

```
DISPLAY_NAME=CENTRAL21
DESCRIPTION=Sistema Checker CENTRAL21 - Painel de Gestão e Validação
SUBDOMAIN=center21
MEMORY=1024
VERSION=recommended
MAIN=index.php
START=php -S 0.0.0.0:80 -t .
```

**Para personalizar:**
1. Abra `squarecloud.app`
2. Altere:
   - `DISPLAY_NAME` - Nome do app
   - `SUBDOMAIN` - Subdomínio (exemplo: seu-nome.squareweb.app)
   - `MEMORY` - Memória (1024, 2048, etc)

---

## ⚡ INSTALAÇÃO RÁPIDA

### Opção 1: SquareCloud

```bash
# 1. Faça upload de TODOS os arquivos
# 2. Configure o squarecloud.app
# 3. Inicie o app
# 4. Acesse: https://center21.squareweb.app
```

### Opção 2: Servidor Web (Apache/Nginx)

```bash
# 1. Extraia todos os arquivos para o diretório web
cd /var/www/html/

# 2. Configure permissões
chmod 666 config.json
chmod 666 5ddd2e45147066c4399b5fcd4cb63e68.json

# 3. Acesse pelo navegador
http://seu-dominio.com
```

### Opção 3: Localhost (XAMPP/WAMP)

```bash
# 1. Copie para htdocs/www
# 2. Inicie Apache
# 3. Acesse: http://localhost/central21
```

---

## 🔐 CREDENCIAIS PADRÃO

### Usuário Normal
- **URL:** `login.php` ou `index.php`
- **Usuário:** `Gold21`
- **Senha:** `102030`

### Painel Admin
- **URL:** `admin_login.php`
- **Usuário:** `Cloudfast`
- **Senha:** `Cloud03@`

**⚠️ IMPORTANTE: Mude as senhas após primeiro acesso!**

---

## 📁 ESTRUTURA DO SISTEMA

### 🎛️ PAINEL ADMIN
```
admin_panel.php         → Painel administrativo completo
admin_login.php         → Login do admin
admin_logout.php        → Logout do admin
config.json            → Configurações (tokens, gates, produtos)
config_helper.php      → Helper PHP para integração
```

### 🏠 SISTEMA BASE
```
index.php              → Página inicial
index.html             → Landing page
home.php              → Painel do usuário (após login)
login.php             → Login de usuários
loginApi.php          → API de login
validation.php        → Validação de sessão
```

### 💳 CHECKERS/GATES
```
checker.php           → Sistema de checker principal
pagseguro.php        → Gateway PagSeguro
paypal.php           → Gateway PayPal
```

### 👥 GERENCIAMENTO
```
usuarios.php         → Gerenciar usuários
editar_usuario.php   → Editar usuário
excluir_usuario.php  → Excluir usuário
banir_usuario.php    → Banir usuário
salvar_edicao.php    → Salvar edições
```

### 🛠️ FERRAMENTAS
```
gerador.php                 → Gerador integrado
gerador_cartoes.html        → Gerador standalone
gerador_hash_bcrypt.html    → Gerador de hash
gerar_hash.php             → Script de hash
corrigir_senha.php         → Corrigir senhas
```

### 📚 DOCUMENTAÇÃO
```
INDEX.html                 → Índice com instruções
GUIA_PAINEL_ADMIN.md      → Guia completo do admin
README_HASH.md            → Guia de hash/login
exemplo_integracao.php    → Exemplos de código
INSTALACAO_RAPIDA.txt     → Instalação rápida
CONFIG_SQUARECLOUD.txt    → Config SquareCloud
```

### 🗄️ DADOS
```
5ddd2e45147066c4399b5fcd4cb63e68.json  → Usuários
config.json                             → Configurações
cookie.txt                              → Cookies (checker)
```

### 🎨 RECURSOS
```
live.mp3              → Som de notificação
.htaccess            → Configuração Apache
squarecloud.app      → Config SquareCloud
```

---

## 🎯 COMO USAR

### 1️⃣ Primeiro Acesso

1. **Acesse o sistema:**
   - SquareCloud: `https://center21.squareweb.app`
   - Servidor: `http://seu-dominio.com`

2. **Faça login como usuário:**
   - Usuário: `Gold21`
   - Senha: `102030`

3. **Veja o painel com todas as gates**

### 2️⃣ Configurar Admin

1. **Acesse:** `admin_login.php`

2. **Login:**
   - Usuário: `Cloudfast`
   - Senha: `Cloud03@`

3. **No painel admin você pode:**
   - Adicionar tokens do PagBank
   - Configurar até 15 gates
   - Gerenciar produtos
   - Ativar/desativar gates

### 3️⃣ Adicionar Token PagBank

1. Vá em **"Tokens PagBank"**
2. Clique em **"Adicionar Novo Token"**
3. Preencha:
   - Nome: `Token Produção`
   - Token: `SEU_TOKEN_AQUI`
4. Salve

### 4️⃣ Criar Nova Gate

1. Vá em **"Gates/Checkers"**
2. Clique em **"Adicionar Nova Gate"**
3. Preencha:
   - Nome: `VISA PREMIUM`
   - Slug: `visapremium`
   - Ícone: `fa-gem`
   - Gateway: `pagseguro`
   - Descrição: `Gate exclusiva Visa`
   - Status: `Active`
4. Salve
5. **A gate aparece automaticamente no painel!**

### 5️⃣ Usar Gerador de Cartões

**Opção A: Integrado**
1. No painel, clique em **"Gerador"**
2. Configure BIN, quantidade, formato
3. Clique em **"Gerar Cartões"**

**Opção B: Standalone**
1. Abra `gerador_cartoes.html` no navegador
2. Use offline

### 6️⃣ Usar Checker

1. No painel, clique em uma gate
2. Cole os cartões
3. Clique em **"Iniciar Check"**
4. Veja os resultados em tempo real

---

## 🔧 PERSONALIZAÇÃO

### Mudar Nome do Sistema

1. Abra `config.json`
2. Localize:
```json
"system": {
    "site_name": "CENTRAL21"
}
```
3. Mude para o nome desejado
4. Salve

### Mudar Subdomain (SquareCloud)

1. Abra `squarecloud.app`
2. Mude:
```
SUBDOMAIN=seu-nome
```
3. Redeploy na SquareCloud

### Mudar Senha Admin

1. Abra `gerador_hash_bcrypt.html`
2. Digite nova senha
3. Copie a hash gerada
4. Abra `config.json`
5. Cole no campo `admin_password_hash`
6. Salve

### Adicionar Logo/Marca

1. Adicione seu logo como `logo.png`
2. No `home.php`, adicione:
```html
<img src="logo.png" alt="Logo" style="height: 50px;">
```

---

## 🎨 RECURSOS DO PAINEL ADMIN

### Dashboard
- Total de tokens configurados
- Total de produtos
- Total de gates
- Gates ativas vs inativas

### Tokens PagBank
- ➕ Adicionar token
- 🔄 Ativar/desativar
- 🗑️ Deletar
- 👁️ Ver token completo
- 📊 Último uso

### Gates/Checkers (até 15)
- ➕ Adicionar gate
- ✏️ Editar nome, descrição, ícone
- 🔄 Ativar/desativar
- 🗑️ Deletar
- 🎨 Personalizar com FontAwesome
- 🔗 Suporta múltiplos gateways

### Produtos
- ➕ Adicionar produto
- 💰 Definir preço
- 📝 Descrição
- 🔄 Status ativo/inativo
- 🗑️ Deletar

---

## 🔗 INTEGRAÇÃO COM CÓDIGO

### Usar Token do Config

```php
<?php
require_once 'config_helper.php';

// Obter token automaticamente
$token = ConfigHelper::getPagBankToken();
$publicKey = ConfigHelper::getPagBankPublicKey();

// Usar nas requisições
// ...
?>
```

### Carregar Gates Dinamicamente

```php
<?php
require_once 'config_helper.php';

// Obter todas as gates
$gates = ConfigHelper::getAllGates();

// Obter apenas gates ativas
$activeGates = ConfigHelper::getActiveGates();

// Obter gate específica
$gate = ConfigHelper::getGateBySlug('preauth');
?>
```

### Integrar no PagSeguro.php

No início do arquivo `pagseguro.php`:

```php
require_once 'config_helper.php';

try {
    $PUBLIC_KEY_BASE64 = ConfigHelper::getPagBankPublicKey();
    // Token se necessário
    $TOKEN = ConfigHelper::getPagBankToken();
} catch (Exception $e) {
    echo json_encode(['error' => 'Config error']);
    exit;
}
```

---

## 🛠️ SOLUÇÃO DE PROBLEMAS

### ❌ Erro: "Arquivo de configuração não encontrado"

```bash
# Verifique se config.json existe
ls -la config.json

# Configure permissões
chmod 666 config.json
```

### ❌ Não consigo fazer login

1. Verifique credenciais:
   - Gold21 / 102030 (usuário)
   - Cloudfast / Cloud03@ (admin)

2. Verifique arquivo de usuários:
```bash
cat 5ddd2e45147066c4399b5fcd4cb63e68.json
```

3. Regere hash se necessário:
   - Abra `gerador_hash_bcrypt.html`
   - Digite senha
   - Copie hash
   - Cole no JSON

### ❌ Gates não aparecem

1. Verifique `config.json`:
```bash
cat config.json | grep -A 5 "gates"
```

2. Certifique-se que `home.php` está atualizado

3. Limpe cache do navegador

### ❌ Checker não funciona

1. Verifique token no admin panel
2. Certifique-se que token está ativo
3. Teste token diretamente na API
4. Veja logs do servidor

### ❌ Erro de permissão

```bash
# Arquivos que precisam de escrita
chmod 666 config.json
chmod 666 5ddd2e45147066c4399b5fcd4cb63e68.json
chmod 666 cookie.txt
```

---

## 📊 ESTATÍSTICAS DO SISTEMA

- **Arquivos PHP:** 25+
- **Arquivos HTML:** 5
- **Arquivos de Config:** 4
- **Documentação:** 6 arquivos
- **Recursos:** Sons, cookies, etc
- **Total:** 40+ arquivos
- **Tamanho:** ~300KB

---

## 🔒 SEGURANÇA

### Boas Práticas

1. **Mude senhas padrão**
2. **Use HTTPS**
3. **Faça backup do config.json**
4. **Proteja admin_panel.php** (IP whitelist)
5. **Atualize tokens regularmente**
6. **Monitore logs**

### .htaccess (Apache)

```apache
# Proteger arquivos sensíveis
<Files "config.json">
    Order allow,deny
    Deny from all
</Files>

<Files "5ddd2e45147066c4399b5fcd4cb63e68.json">
    Order allow,deny
    Deny from all
</Files>
```

---

## 📱 URLS DO SISTEMA

### Usuário
- `/` ou `/index.php` - Página inicial
- `/login.php` - Login
- `/home.php` - Painel (após login)
- `/checker.php?gate=preauth` - Checker
- `/gerador.php` - Gerador

### Admin
- `/admin_login.php` - Login admin
- `/admin_panel.php` - Painel admin
- `/usuarios.php` - Gerenciar usuários

### Ferramentas
- `/gerador_cartoes.html` - Gerador standalone
- `/gerador_hash_bcrypt.html` - Gerador de hash
- `/INDEX.html` - Documentação

---

## 🎯 ROADMAP

### Futuras Melhorias
- [ ] Sistema de pagamento integrado
- [ ] API REST
- [ ] Logs de atividade
- [ ] 2FA (autenticação dois fatores)
- [ ] Mais gateways (Stripe, MercadoPago)
- [ ] Sistema de notificações
- [ ] Dashboard com gráficos
- [ ] Export de relatórios

---

## 💡 DICAS AVANÇADAS

### Adicionar 15 Gates Rapidamente

1. Acesse admin panel
2. Use o formulário de adição
3. Preencha com variações:
   - VISA PREMIUM
   - MASTERCARD GOLD
   - AMEX VIP
   - ELO VALIDATOR
   - DISCOVER CHECK
   - etc...

### Integrar com Telegram Bot

```php
// Enviar notificação para Telegram
function sendTelegram($message) {
    $token = "SEU_BOT_TOKEN";
    $chat_id = "SEU_CHAT_ID";
    
    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $message
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_exec($ch);
    curl_close($ch);
}

// Usar no checker
sendTelegram("✅ Card APPROVED: 4567***1234");
```

### Backup Automático

```bash
# Script de backup (backup.sh)
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
tar -czf backup_$DATE.tar.gz *.json *.php *.html
echo "Backup criado: backup_$DATE.tar.gz"
```

---

## 📞 SUPORTE

### Arquivos de Ajuda
- `INDEX.html` - Início rápido
- `GUIA_PAINEL_ADMIN.md` - Guia completo admin
- `README_HASH.md` - Problemas com login/hash
- `exemplo_integracao.php` - Exemplos de código

### Checklist de Problemas
- [ ] Verifiquei credenciais
- [ ] Arquivo config.json existe
- [ ] Permissões corretas (666)
- [ ] Token válido
- [ ] Gates ativas
- [ ] Cache limpo
- [ ] Logs verificados

---

## ✨ RECURSOS DESTACADOS

### O Que Torna Este Sistema Único:

1. **100% Configurável** - Tudo pelo painel admin
2. **Sem Editar Código** - Mudanças via interface
3. **15 Gates** - Máximo suportado
4. **Design Moderno** - Interface profissional
5. **Documentação Completa** - Tudo explicado
6. **Exemplos Prontos** - Código de exemplo
7. **Geradores Incluídos** - Cartões + hash
8. **Múltiplos Gateways** - PagBank, PayPal, etc
9. **Responsivo** - Funciona em mobile
10. **Open Source** - Customize à vontade

---

## 🚀 COMEÇE AGORA!

```bash
# 1. Extraia os arquivos
unzip central21_completo.zip

# 2. Configure permissões
chmod 666 config.json

# 3. Acesse no navegador
# http://seu-dominio.com

# 4. Faça login
# Usuário: Gold21
# Senha: 102030

# 5. Configure no admin
# admin_login.php
# Usuário: Cloudfast
# Senha: Cloud03@

# 6. Pronto! 🎉
```

---

✨ **SISTEMA COMPLETO E PRONTO PARA USO!**

*Desenvolvido para CENTRAL21*  
*Versão: 2.0*  
*Data: 16/02/2026*

---

## 📄 LICENÇA

Este sistema é fornecido "como está" para uso pessoal e comercial.
Modifique e adapte conforme necessário.

---

**💚 Bom uso e sucesso com seu projeto!**
