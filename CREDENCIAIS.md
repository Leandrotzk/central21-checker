# 🔑 CREDENCIAIS DO SISTEMA - ATUALIZADO

## ✅ **CREDENCIAIS UNIFICADAS**

Agora você pode usar **Gold21 / 102030** em AMBOS os sistemas!

---

## 🎯 **ACESSO AO SISTEMA**

### **Login de Usuário (Painel Normal)**
- **URL:** `login.php` ou `index.php`
- **Usuário:** `Gold21`
- **Senha:** `102030`
- **Acessa:** Painel de checkers, geradores

### **Painel Administrativo**
- **URL:** `admin_login.php` ou `admin_panel.php`
- **Usuário:** `Gold21` ✅ (MESMAS CREDENCIAIS!)
- **Senha:** `102030` ✅ (MESMAS CREDENCIAIS!)
- **Acessa:** Gerenciar tokens, gates, produtos, usuários

---

## 🔐 **ADMINS DISPONÍVEIS**

O sistema agora suporta **múltiplos admins**:

### Admin 1: Gold21
- **Usuário:** `Gold21`
- **Senha:** `102030`
- **Status:** ✅ Ativo

### Admin 2: Cloudfast
- **Usuário:** `Cloudfast`
- **Senha:** `Cloud03@`
- **Status:** ✅ Ativo

**Ambos têm acesso total ao painel admin!**

---

## 📋 **RESUMO**

| Sistema | Usuário | Senha | URL |
|---------|---------|-------|-----|
| **Painel Normal** | Gold21 | 102030 | login.php |
| **Painel Admin** | Gold21 | 102030 | admin_login.php |
| **Painel Admin** | Cloudfast | Cloud03@ | admin_login.php |

---

## 🚀 **COMO ACESSAR**

### **1. Login Normal:**
```
1. Acesse: http://seu-site.com/login.php
2. Digite: Gold21
3. Digite: 102030
4. Clique em: Entrar
5. ✅ Você está no painel de checkers!
```

### **2. Painel Admin:**
```
1. Acesse: http://seu-site.com/admin_login.php
2. Digite: Gold21
3. Digite: 102030
4. Clique em: Entrar como Admin
5. ✅ Você está no painel administrativo!
```

---

## 💡 **O QUE MUDOU**

### **ANTES:**
- Login Normal: Gold21 / 102030 ✅
- Painel Admin: Cloudfast / Cloud03@ ✅

### **AGORA:**
- Login Normal: Gold21 / 102030 ✅
- Painel Admin: Gold21 / 102030 ✅ **NOVO!**
- Painel Admin: Cloudfast / Cloud03@ ✅ (ainda funciona)

---

## 🔧 **CONFIGURAÇÃO TÉCNICA**

### Arquivo: `admin_login.php`

O sistema foi atualizado para aceitar múltiplos admins:

```php
$ADMIN_USERS = [
    "Cloudfast" => "Cloud03@",
    "Gold21" => "102030"  // Adicionado!
];
```

### Arquivo: `config.json`

```json
"admins": [
    {
        "username": "Cloudfast",
        "password": "Cloud03@"
    },
    {
        "username": "Gold21",
        "password": "102030"
    }
]
```

---

## ✨ **VANTAGENS**

1. ✅ **Única Credencial** - Memorize apenas Gold21/102030
2. ✅ **Acesso Total** - Mesma conta nos dois painéis
3. ✅ **Flexibilidade** - Cloudfast ainda funciona se precisar
4. ✅ **Simplicidade** - Não precisa lembrar múltiplas senhas

---

## 🔒 **SEGURANÇA**

### **Para Mudar a Senha:**

1. **Opção 1: Via Código**
   - Abra `admin_login.php`
   - Mude o array `$ADMIN_USERS`
   - Salve

2. **Opção 2: Via Config**
   - Abra `config.json`
   - Mude em `"admins"`
   - Salve

3. **Opção 3: Usar Hash (Mais Seguro)**
   - Abra `gerador_hash_bcrypt.html`
   - Digite nova senha
   - Copie a hash
   - Use no sistema

---

## 📱 **FLUXO DE USO**

### **Usuário Comum:**
```
1. Acessa login.php
2. Gold21 / 102030
3. Usa checkers
4. Gera cartões
5. Faz logout
```

### **Administrador:**
```
1. Acessa admin_login.php
2. Gold21 / 102030 (mesma credencial!)
3. Configura tokens
4. Adiciona gates
5. Gerencia usuários
6. Faz logout
```

### **Tudo com a mesma conta!** 🎉

---

## 🆘 **SOLUÇÃO DE PROBLEMAS**

### ❌ "Usuário ou senha incorretos"

**Verifique:**
1. Digitou exatamente: `Gold21` (com G maiúsculo)
2. Digitou exatamente: `102030` (sem espaços)
3. Está no arquivo correto:
   - `login.php` para painel normal
   - `admin_login.php` para admin

### ❌ Não consigo acessar admin

**Solução:**
1. Verifique se o arquivo `admin_login.php` foi atualizado
2. Verifique se o array `$ADMIN_USERS` contém Gold21
3. Limpe cache do navegador
4. Tente com Cloudfast/Cloud03@ para testar

---

## 📞 **INFORMAÇÕES IMPORTANTES**

### **Arquivos Atualizados:**
- ✅ `admin_login.php` - Login admin com múltiplos usuários
- ✅ `config.json` - Lista de admins
- ✅ `5ddd2e45...json` - Usuário Gold21 ativo

### **Não Foi Alterado:**
- ✅ `login.php` - Login normal (já funcionava)
- ✅ `home.php` - Painel de checkers
- ✅ `validation.php` - Validação de sessão

---

## 🎯 **TESTE RÁPIDO**

### **1. Teste Login Normal:**
```bash
URL: login.php
User: Gold21
Pass: 102030
Resultado: ✅ Deve entrar no painel de checkers
```

### **2. Teste Admin:**
```bash
URL: admin_login.php
User: Gold21
Pass: 102030
Resultado: ✅ Deve entrar no painel admin
```

### **3. Teste Admin Alternativo:**
```bash
URL: admin_login.php
User: Cloudfast
Pass: Cloud03@
Resultado: ✅ Deve entrar no painel admin
```

---

## ✅ **CHECKLIST DE VERIFICAÇÃO**

- [ ] Arquivo `admin_login.php` atualizado
- [ ] Arquivo `config.json` atualizado
- [ ] Testei login normal com Gold21/102030
- [ ] Testei admin com Gold21/102030
- [ ] Testei admin com Cloudfast/Cloud03@
- [ ] Mudei as senhas para senhas seguras
- [ ] Sistema funcionando 100%

---

## 🎉 **CONCLUSÃO**

Agora você tem:
- ✅ **Uma única credencial** para tudo
- ✅ **Gold21 / 102030** funciona em ambos
- ✅ **Cloudfast** ainda disponível como backup
- ✅ **Sistema 100% funcional**

**Simplifique sua vida: use apenas Gold21/102030 para tudo!** 🚀

---

✨ **Sistema Atualizado e Pronto!**

*Última atualização: 16/02/2026*
