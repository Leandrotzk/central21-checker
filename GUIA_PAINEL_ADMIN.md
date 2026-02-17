# 🎯 PAINEL ADMIN COMPLETO - GUIA DE INSTALAÇÃO

## 📋 ÍNDICE
1. [Visão Geral](#visao-geral)
2. [Arquivos do Sistema](#arquivos)
3. [Instalação Rápida](#instalacao)
4. [Configuração Inicial](#configuracao)
5. [Como Usar o Painel Admin](#uso)
6. [Integração com Código Existente](#integracao)
7. [Recursos do Painel](#recursos)
8. [Exemplos Práticos](#exemplos)
9. [Solução de Problemas](#problemas)

---

## 🎯 VISÃO GERAL

Este sistema permite gerenciar **TUDO** através de um painel web sem precisar editar código:

- ✅ **Tokens PagBank** - Adicione, edite, ative/desative tokens
- ✅ **Produtos** - Gerencie seus produtos e preços
- ✅ **Gates/Checkers** - Até 15 gates diferentes configuráveis
- ✅ **Interface Moderna** - Dashboard intuitivo e responsivo
- ✅ **Configuração JSON** - Tudo centralizado em um arquivo

---

## 📦 ARQUIVOS DO SISTEMA

### Arquivos Principais:

1. **config.json** 📄
   - Arquivo de configuração central
   - Armazena tokens, produtos, gates
   - Editável pelo painel ou manualmente

2. **admin_panel.php** 🎛️
   - Painel administrativo completo
   - Interface para gerenciar tudo
   - Login protegido

3. **config_helper.php** 🔧
   - Helper PHP para acessar configurações
   - Facilita integração com código existente
   - Funções prontas para uso

4. **home_updated.php** 🏠
   - Home page atualizada
   - Lê gates do config.json
   - Exibe dinamicamente todas as gates

5. **admin_login.php** 🔐
   - Sistema de login do admin
   - Já existe no seu projeto

6. **exemplo_integracao.php** 📚
   - Exemplos de como integrar
   - Documentação de uso
   - Código de exemplo

---

## ⚡ INSTALAÇÃO RÁPIDA

### Passo 1: Upload dos Arquivos

Copie estes arquivos para o seu servidor:

```
/seu-projeto/
├── config.json                 ← NOVO
├── admin_panel.php            ← NOVO
├── config_helper.php          ← NOVO
├── home_updated.php           ← NOVO (substitui home.php)
├── gerador.php                ← Gerador de cartões
├── admin_login.php            ← Já existe
├── pagseguro.php              ← Atualizar (veja integração)
└── ... (outros arquivos)
```

### Passo 2: Renomear Arquivos

```bash
# Backup do home.php original
mv home.php home_old.php

# Usar a nova versão
mv home_updated.php home.php
```

### Passo 3: Configurar Permissões

```bash
# Dar permissão de escrita no config.json
chmod 666 config.json
```

### Passo 4: Primeiro Acesso

1. Acesse: `http://seusite.com/admin_login.php`
2. Login:
   - **Usuário:** Cloudfast
   - **Senha:** Cloud03@
3. Você será redirecionado para o painel admin

---

## ⚙️ CONFIGURAÇÃO INICIAL

### 1️⃣ Mudar Senha do Admin

Abra `config.json` e localize:

```json
"system": {
    "admin_username": "Cloudfast",
    "admin_password_hash": "$2y$10$..."
}
```

Para gerar uma nova senha:
1. Use o `gerador_hash_bcrypt.html`
2. Digite sua nova senha
3. Copie a hash gerada
4. Cole no campo `admin_password_hash`

### 2️⃣ Adicionar Primeiro Token PagBank

1. Acesse o painel admin
2. Vá em "Tokens PagBank"
3. Clique em "Adicionar Novo Token"
4. Preencha:
   - **Nome:** Token Principal
   - **Token:** Cole seu token do PagBank
5. Salve

### 3️⃣ Configurar Gates

As gates já vêm pré-configuradas, mas você pode:
- Adicionar novas (até 15 no total)
- Editar existentes
- Ativar/desativar
- Mudar ícones e descrições

---

## 🎛️ COMO USAR O PAINEL ADMIN

### Dashboard 📊

Exibe estatísticas rápidas:
- Total de tokens
- Total de produtos
- Total de gates
- Gates ativas

### Tokens PagBank 🔑

**Adicionar Token:**
1. Clique em "Adicionar Novo Token"
2. Preencha nome e token
3. Salve

**Gerenciar Tokens:**
- 🔄 **Toggle** - Ativar/desativar token
- 🗑️ **Deletar** - Remover token
- 👁️ **Visualizar** - Ver token completo

**Status:**
- 🟢 **Active** - Token em uso
- 🔴 **Inactive** - Token desativado

### Produtos 📦

**Adicionar Produto:**
1. Clique em "Adicionar Novo Produto"
2. Preencha:
   - Nome do produto
   - Preço (R$)
   - Descrição
3. Salve

**Gerenciar:**
- Deletar produtos
- Ver lista completa

### Gates/Checkers 💳

**Adicionar Nova Gate:**
1. Clique em "Adicionar Nova Gate"
2. Preencha:
   - **Nome:** Ex: VISA CHECKER
   - **Slug:** Ex: visachecker (usado na URL)
   - **Ícone:** Ex: fa-credit-card (FontAwesome)
   - **Gateway:** pagseguro, paypal, etc
   - **Descrição:** Descrição da gate
   - **Status:** Active ou Disabled
3. Salve

**Gerenciar Gates:**
- 🔄 **Toggle Status** - Ativar/desativar
- 🗑️ **Deletar** - Remover gate
- 👁️ **Visualizar** - Ver detalhes

**Limite:**
- Máximo de **15 gates** configuráveis
- Exibido no topo da página

**Ícones Disponíveis (FontAwesome):**
- `fa-credit-card` - Cartão de crédito
- `fa-check-circle` - Check circular
- `fa-shield-alt` - Escudo
- `fa-lock` - Cadeado
- `fa-star` - Estrela
- `fa-bolt` - Raio
- `fa-fire` - Fogo
- `fa-gem` - Diamante
- `fa-crown` - Coroa
- Veja mais em: https://fontawesome.com/icons

---

## 🔗 INTEGRAÇÃO COM CÓDIGO EXISTENTE

### Método 1: Usar o Helper (Recomendado)

**No início do seu arquivo PHP:**

```php
<?php
require_once 'config_helper.php';

// Obter token automaticamente
try {
    $PAGBANK_TOKEN = ConfigHelper::getPagBankToken();
    $PUBLIC_KEY = ConfigHelper::getPagBankPublicKey();
} catch (Exception $e) {
    die('Erro: ' . $e->getMessage());
}

// Continua seu código normal...
```

### Método 2: Integrar no pagseguro.php

**ANTES:**
```php
$PUBLIC_KEY_BASE64 = 'MIIBIjANBg...'; // Hardcoded
```

**DEPOIS:**
```php
require_once 'config_helper.php';

try {
    $PUBLIC_KEY_BASE64 = ConfigHelper::getPagBankPublicKey();
    $PAGBANK_TOKEN = ConfigHelper::getPagBankToken();
} catch (Exception $e) {
    echo json_encode(['error' => 'Config error']);
    exit;
}
```

### Método 3: Carregar Gates Dinamicamente

**ANTES (no home.php):**
```php
$gates = [
    ['name' => 'PRE AUTH', 'slug' => 'preauth', ...],
    ['name' => 'ALL BINS', 'slug' => 'allbins', ...],
];
```

**DEPOIS:**
```php
require_once 'config_helper.php';
$gates = ConfigHelper::getAllGates();
```

---

## 🎨 RECURSOS DO PAINEL

### Interface Moderna
- ✅ Design dark mode
- ✅ Animações suaves
- ✅ Responsivo (mobile-friendly)
- ✅ Icons FontAwesome
- ✅ Gradientes modernos

### Funcionalidades
- ✅ CRUD completo (Create, Read, Update, Delete)
- ✅ Toggle rápido de status
- ✅ Confirmação antes de deletar
- ✅ Mensagens de sucesso/erro
- ✅ Dashboard com estatísticas
- ✅ Breadcrumb de navegação

### Segurança
- ✅ Login protegido
- ✅ Sessões PHP
- ✅ Senha com hash bcrypt
- ✅ Validação de dados

---

## 📚 EXEMPLOS PRÁTICOS

### Exemplo 1: Adicionar Token PagBank

1. Acesse: `admin_panel.php`
2. Clique em "Tokens PagBank"
3. Clique em "Adicionar Novo Token"
4. Preencha:
   ```
   Nome: Token de Produção
   Token: T0K3N_D0_P4GB4NK_4QU1
   ```
5. Clique em "Adicionar Token"
6. ✅ Token adicionado!

### Exemplo 2: Criar Nova Gate

1. Vá em "Gates/Checkers"
2. Clique em "Adicionar Nova Gate"
3. Preencha:
   ```
   Nome: MASTERCARD PREMIUM
   Slug: mcpremium
   Ícone: fa-gem
   Gateway: pagseguro
   Descrição: Gate exclusiva para Mastercard
   Status: Active
   ```
4. Salve
5. ✅ Gate aparece no home automaticamente!

### Exemplo 3: Trocar Token

1. Vá em "Tokens PagBank"
2. Desative o token antigo (clique no toggle)
3. Adicione novo token
4. ✅ Sistema usa automaticamente o token ativo!

### Exemplo 4: Adicionar 5 Gates Novas

```
Gate 1:
Nome: AMEX CHECKER
Slug: amex
Ícone: fa-star
Status: Active

Gate 2:
Nome: ELO VALIDATOR
Slug: elo
Ícone: fa-shield-alt
Status: Active

Gate 3:
Nome: HIPERCARD AUTH
Slug: hipercard
Ícone: fa-bolt
Status: Active

Gate 4:
Nome: DISCOVER CHECK
Slug: discover
Ícone: fa-fire
Status: Disabled

Gate 5:
Nome: DINNERS PREMIUM
Slug: dinners
Ícone: fa-crown
Status: Active
```

---

## 🚀 FLUXO DE USO COMPLETO

### Cenário: Adicionando um novo site de checker

1. **Obtenha o token do novo gateway**
   - Ex: Token do PagBank, PayPal, Stripe

2. **Adicione o token no painel**
   ```
   Admin Panel → Tokens PagBank → Adicionar Novo Token
   Nome: Token Gateway X
   Token: seu_token_aqui
   ```

3. **Crie a gate**
   ```
   Admin Panel → Gates/Checkers → Adicionar Nova Gate
   Nome: NOVA GATE X
   Slug: gatex
   Gateway: pagseguro
   Status: Active
   ```

4. **Integre com código**
   ```php
   // No seu arquivo gatex.php
   require_once 'config_helper.php';
   $token = ConfigHelper::getPagBankToken();
   ```

5. **Teste**
   - Acesse home.php
   - Veja a nova gate aparecer
   - Clique e teste o checker

6. **Pronto!** ✅

---

## 🔧 SOLUÇÃO DE PROBLEMAS

### ❌ Erro: "Arquivo de configuração não encontrado"

**Solução:**
- Verifique se `config.json` está no mesmo diretório
- Verifique as permissões do arquivo
- Execute: `chmod 666 config.json`

### ❌ Não consigo salvar configurações

**Solução:**
1. Verifique permissões:
   ```bash
   chmod 666 config.json
   ```
2. Verifique se o servidor tem permissão de escrita

### ❌ Token não funciona no checker

**Solução:**
1. Verifique se o token está ativo (verde)
2. Verifique se o token é válido
3. Teste o token diretamente na API do PagBank
4. Verifique logs do servidor

### ❌ Gates não aparecem no home

**Solução:**
1. Certifique-se que o `home.php` foi atualizado
2. Verifique se as gates estão ativas
3. Limpe o cache do navegador
4. Verifique se `config_helper.php` está presente

### ❌ Não consigo fazer login no admin

**Solução:**
1. Credenciais padrão:
   - Usuário: `Cloudfast`
   - Senha: `Cloud03@`
2. Se mudou a senha, gere nova hash com `gerador_hash_bcrypt.html`
3. Cole a nova hash no `config.json`

---

## 📊 ESTRUTURA DO config.json

```json
{
    "pagbank": {
        "tokens": [
            {
                "id": 1,
                "name": "Nome do Token",
                "token": "SEU_TOKEN_AQUI",
                "status": "active",
                "created_at": "2026-02-16",
                "last_used": "2026-02-16 14:30:00"
            }
        ],
        "public_key": "Chave pública RSA"
    },
    "produtos": [
        {
            "id": 1,
            "name": "Nome do Produto",
            "price": "10.00",
            "description": "Descrição",
            "status": "active",
            "created_at": "2026-02-16"
        }
    ],
    "gates": [
        {
            "id": 1,
            "name": "Nome da Gate",
            "slug": "slug-url",
            "icon": "fa-credit-card",
            "description": "Descrição da gate",
            "status": "active",
            "gateway": "pagseguro",
            "created_at": "2026-02-16"
        }
    ],
    "system": {
        "site_name": "CENTRAL21",
        "max_gates": 15,
        "admin_username": "Cloudfast",
        "admin_password_hash": "$2y$10$..."
    }
}
```

---

## 🎯 DICAS E BOAS PRÁTICAS

### Segurança
- ✅ Mude a senha padrão do admin
- ✅ Use senhas fortes
- ✅ Faça backup do `config.json` regularmente
- ✅ Proteja o acesso ao painel admin (.htaccess)

### Performance
- ✅ O helper carrega config em cache
- ✅ Atualização automática do último uso
- ✅ JSON otimizado para leitura rápida

### Organização
- ✅ Use nomes descritivos para tokens
- ✅ Mantenha gates organizadas por tipo
- ✅ Desative gates não usadas em vez de deletar
- ✅ Documente mudanças importantes

### Backup
```bash
# Backup do config.json
cp config.json config.json.backup-$(date +%Y%m%d)
```

---

## 📞 RESUMO EXECUTIVO

### ⚡ O que você pode fazer:

1. **Gerenciar até 15 gates diferentes**
   - Adicionar, editar, deletar
   - Ativar/desativar com um clique
   - Personalizar ícones e descrições

2. **Trocar tokens sem editar código**
   - Múltiplos tokens configuráveis
   - Ativação/desativação fácil
   - Rastreamento de uso

3. **Adicionar produtos**
   - Nome, preço, descrição
   - Gerenciamento simples

4. **Interface moderna e intuitiva**
   - Dashboard com estatísticas
   - Navegação simples
   - Responsivo

### 🔑 Credenciais Padrão:
- **Usuário:** Cloudfast
- **Senha:** Cloud03@

### 📁 Arquivos Essenciais:
- `config.json` - Configurações
- `admin_panel.php` - Painel admin
- `config_helper.php` - Helper PHP
- `home.php` - Home atualizada

### 🚀 Para Começar:
1. Upload dos arquivos
2. Acesse admin_login.php
3. Configure seus tokens
4. Adicione suas gates
5. Pronto!

---

✨ **Sistema completo e pronto para uso!**

*Desenvolvido para CENTRAL21*
*Última atualização: 16/02/2026*
