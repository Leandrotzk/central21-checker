# 🚀 CENTRAL21 - DEPLOY SQUARECLOUD

## ⚡ PRONTO PARA USAR!

Este ZIP está **100% configurado** para upload direto na SquareCloud.

---

## 📤 COMO FAZER UPLOAD:

### **Passo 1: Acesse SquareCloud**
- Entre em: https://squarecloud.app
- Faça login na sua conta

### **Passo 2: Crie Nova Aplicação**
- Clique em "Nova Aplicação"
- Escolha "Upload de Arquivos"

### **Passo 3: Faça Upload**
- Selecione **TODOS** os arquivos deste ZIP
- Ou faça upload do ZIP completo
- Clique em "Criar Aplicação"

### **Passo 4: Aguarde Deploy**
- A SquareCloud vai processar os arquivos
- Aguarde o deploy completar (1-2 minutos)

### **Passo 5: Acesse Seu Sistema**
- URL: `https://center21.squareweb.app`
- Ou o subdomínio que você configurou

---

## 🔐 CREDENCIAIS:

### **Login Normal + Admin:**
- **Usuário:** `Gold21`
- **Senha:** `102030`

### **URLs de Acesso:**
- Login Normal: `https://center21.squareweb.app/login.php`
- Painel Admin: `https://center21.squareweb.app/admin_login.php`

---

## ⚙️ CONFIGURAÇÃO SQUARECLOUD:

### **Arquivo: squarecloud.app**

Já está configurado com:
```
DISPLAY_NAME=CENTRAL21
SUBDOMAIN=center21
MEMORY=1024
VERSION=recommended
MAIN=index.php
```

### **Para Personalizar:**

Se quiser mudar o subdomínio:
1. Abra `squarecloud.app`
2. Mude `SUBDOMAIN=center21` para `SUBDOMAIN=seu-nome`
3. Faça upload novamente

---

## ✅ O QUE ESTÁ INCLUÍDO:

- ✅ Sistema completo (45 arquivos)
- ✅ Credenciais configuradas (Gold21/102030)
- ✅ SquareCloud configurado (squarecloud.app)
- ✅ Painel Admin funcional
- ✅ Checkers integrados
- ✅ Geradores de cartões
- ✅ Hash bcrypt correta
- ✅ Tudo pronto para uso!

---

## 🎯 PRIMEIRO ACESSO:

### **1. Após Deploy:**
Acesse: `https://center21.squareweb.app`

### **2. Faça Login:**
- Usuário: `Gold21`
- Senha: `102030`

### **3. Configure Tokens:**
- Vá para: `admin_login.php`
- Entre com: `Gold21` / `102030`
- Adicione seus tokens do PagBank

### **4. Pronto!**
Sistema funcionando! 🎉

---

## 📊 ESTRUTURA:

```
/
├── index.php              → Página inicial
├── login.php             → Login de usuários
├── home.php              → Painel principal
├── admin_login.php       → Login admin
├── admin_panel.php       → Painel admin
├── checker.php           → Sistema de checker
├── gerador.php           → Gerador de cartões
├── squarecloud.app       → Config SquareCloud
├── config.json           → Configurações
└── ... (40+ arquivos)
```

---

## 💡 DICAS:

### **Adicionar Tokens:**
1. Acesse `admin_login.php`
2. Entre com Gold21/102030
3. Vá em "Tokens PagBank"
4. Clique em "Adicionar Novo Token"
5. Cole seu token
6. Salve

### **Adicionar Gates:**
1. No painel admin
2. Vá em "Gates/Checkers"
3. Clique em "Adicionar Nova Gate"
4. Preencha os dados
5. Salve
6. A gate aparece automaticamente!

### **Gerenciar Usuários:**
1. Acesse `usuarios.php?admin=true`
2. Adicione/edite/exclua usuários
3. Defina datas de expiração

---

## 🔧 APÓS O DEPLOY:

### **Teste 1: Login Normal**
```
URL: https://center21.squareweb.app/login.php
User: Gold21
Pass: 102030
✅ Deve abrir o painel
```

### **Teste 2: Painel Admin**
```
URL: https://center21.squareweb.app/admin_login.php
User: Gold21
Pass: 102030
✅ Deve abrir o admin
```

### **Teste 3: Checker**
```
URL: https://center21.squareweb.app/checker.php?gate=preauth
✅ Deve abrir o checker
```

---

## 🆘 PROBLEMAS?

### **Erro ao fazer upload:**
- Certifique-se de fazer upload de TODOS os arquivos
- Ou faça upload do ZIP completo
- Aguarde o processamento

### **Erro 404:**
- Verifique se o deploy completou
- Acesse a URL correta
- Tente: `https://seu-subdominio.squareweb.app/index.php`

### **Erro ao fazer login:**
- Use exatamente: `Gold21` (com G maiúsculo)
- Use exatamente: `102030`
- Limpe cookies do navegador

### **Painel admin não abre:**
- Acesse: `admin_login.php` (não `admin_panel.php`)
- Use as credenciais corretas
- Verifique se está logado

---

## 📱 URLS IMPORTANTES:

| Página | URL |
|--------|-----|
| Inicial | `/` ou `/index.php` |
| Login | `/login.php` |
| Painel | `/home.php` |
| Admin Login | `/admin_login.php` |
| Admin Panel | `/admin_panel.php` |
| Checker | `/checker.php?gate=preauth` |
| Gerador | `/gerador.php` |
| Usuários | `/usuarios.php?admin=true` |

---

## ⚙️ PERSONALIZAÇÃO:

### **Mudar Nome do Site:**
1. Abra `config.json`
2. Mude `"site_name": "CENTRAL21"`
3. Faça upload novamente

### **Mudar Subdomínio:**
1. Abra `squarecloud.app`
2. Mude `SUBDOMAIN=center21`
3. Faça upload novamente
4. Nova URL: `https://seu-nome.squareweb.app`

### **Mudar Senha:**
1. Acesse admin panel
2. Ou abra `admin_login.php`
3. Ou use `gerador_hash_bcrypt.html`

---

## ✨ RECURSOS:

- ✅ **Painel Admin** - Gerenciar tokens, gates, produtos
- ✅ **Checkers** - PRE AUTH, ALL BINS, etc
- ✅ **Geradores** - Cartões (Luhn) e hash bcrypt
- ✅ **Gestão** - Usuários, datas, status
- ✅ **15 Gates** - Configuráveis pelo painel
- ✅ **Design Moderno** - Interface profissional
- ✅ **Responsivo** - Funciona em mobile

---

## 🎉 CHECKLIST FINAL:

Antes de fazer upload:
- [ ] Verifiquei que é o arquivo correto
- [ ] Todos os arquivos estão incluídos
- [ ] Tenho conta na SquareCloud

Após fazer upload:
- [ ] Deploy completou com sucesso
- [ ] Testei login normal (Gold21/102030)
- [ ] Testei admin (Gold21/102030)
- [ ] Adicionei meus tokens do PagBank
- [ ] Configurei minhas gates
- [ ] Sistema 100% funcional!

---

## 🚀 RESULTADO FINAL:

```
✅ Upload feito na SquareCloud
✅ Sistema rodando em: https://center21.squareweb.app
✅ Login funcionando: Gold21/102030
✅ Admin funcionando: Gold21/102030
✅ Checkers operacionais
✅ Geradores funcionando
✅ Painel admin configurado
✅ Tokens adicionados
✅ Gates configuradas
✅ SISTEMA 100% OPERACIONAL! 🎉
```

---

## 📞 LEMBRE-SE:

- **Não precisa modificar NADA antes do upload**
- **Está tudo pronto para uso**
- **Apenas faça upload e use**
- **Credenciais: Gold21 / 102030**

---

✨ **CENTRAL21 - PRONTO PARA SQUARECLOUD**

*Sistema completo e funcional*
*Última atualização: 16/02/2026*

🚀 **Faça upload agora e comece a usar!**
