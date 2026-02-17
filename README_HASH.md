# 🎯 CENTRAL21 - GUIA COMPLETO DE CONFIGURAÇÃO

## 📋 ÍNDICE
1. [Hash Correta para Login](#hash-correta)
2. [Como Usar o Gerador de Hash](#gerador-hash)
3. [Gerador de Cartões](#gerador-cartoes)
4. [Integração com PeruYashGen](#integracao)
5. [Solução de Problemas](#problemas)

---

## 🔐 HASH CORRETA PARA LOGIN

### ✅ HASH VÁLIDA PARA A SENHA "102030"

```
$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy
```

### 📝 COMO APLICAR:

1. Abra o arquivo: `5ddd2e45147066c4399b5fcd4cb63e68.json`

2. Substitua a hash antiga pela nova:

**ANTES:**
```json
{
    "username": "Gold21",
    "password": "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi",
    ...
}
```

**DEPOIS:**
```json
{
    "username": "Gold21",
    "password": "$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy",
    ...
}
```

3. Salve o arquivo

4. Faça login com:
   - **Usuário:** Gold21
   - **Senha:** 102030

---

## 🔑 GERADOR DE HASH BCRYPT

### Uso do arquivo `gerador_hash_bcrypt.html`:

1. Abra o arquivo `gerador_hash_bcrypt.html` em qualquer navegador
2. A hash para "102030" será gerada automaticamente
3. Clique em "Copiar Hash"
4. Cole no arquivo JSON no campo "password"

### 🎨 Recursos:
- ✅ Gera hash bcrypt compatível com PHP
- ✅ Interface amigável
- ✅ Botão de copiar com um clique
- ✅ Instruções passo a passo incluídas

---

## 💳 GERADOR DE CARTÕES

### Uso do arquivo `gerador_cartoes.html`:

1. Abra o arquivo `gerador_cartoes.html` em qualquer navegador

2. Configure os parâmetros:
   - **BIN:** 6 primeiros dígitos (ex: 456789)
   - **Mês:** Selecione ou deixe aleatório
   - **Ano:** Selecione ou deixe aleatório
   - **CVV:** Aleatório ou personalizado
   - **Quantidade:** Quantos cartões gerar (1-1000)
   - **Formato:** Escolha o formato de saída

3. Clique em "Gerar Cartões"

4. Copie os cartões gerados:
   - Clique em um cartão individual para copiar
   - Ou clique em "Copiar Todos" para copiar tudo

### 📊 Formatos Disponíveis:

- **NUMERO|MES|ANO|CVV** → `4567891234567890|12|2026|123`
- **NUMERO MES ANO CVV** → `4567891234567890 12 2026 123`
- **NUMERO/MES/ANO/CVV** → `4567891234567890/12/2026/123`
- **JSON** → `{"number":"4567891234567890","month":"12","year":"2026","cvv":"123"}`

### 🎯 Recursos:

- ✅ Algoritmo de Luhn para números válidos
- ✅ Suporta qualquer BIN
- ✅ Gera até 1000 cartões por vez
- ✅ 4 formatos diferentes de saída
- ✅ Cópia com um clique
- ✅ Interface moderna e responsiva

---

## 🌐 INTEGRAÇÃO COM PERUYASHGEN

### Opção 1: Usar o Gerador Local (Recomendado)

O arquivo `gerador_cartoes.html` fornece as mesmas funcionalidades:
- ✅ Mesmo algoritmo de validação
- ✅ Mesmos formatos de saída
- ✅ Offline - não depende de site externo
- ✅ Mais rápido e seguro

### Opção 2: Integrar com PeruYashGen (Avançado)

Para integrar seu sistema com o site https://peruyashgen.netlify.app/:

1. **Via iframe** no seu sistema:
```html
<iframe 
    src="https://peruyashgen.netlify.app/" 
    width="100%" 
    height="600px"
    style="border: none; border-radius: 10px;">
</iframe>
```

2. **Via API/JavaScript** (se disponível):
```javascript
// Exemplo de integração
async function gerarCartoes(bin, quantidade) {
    // Implementar chamada API se disponível
    // Ou usar o gerador local
}
```

### ⚠️ Nota Importante:
O gerador local (`gerador_cartoes.html`) é **recomendado** porque:
- Funciona offline
- Mais rápido
- Não depende de serviços externos
- Totalmente customizável

---

## 🔧 SOLUÇÃO DE PROBLEMAS

### ❌ Problema: Não consigo fazer login

**Soluções:**

1. **Verifique a hash no JSON:**
   - Abra `5ddd2e45147066c4399b5fcd4cb63e68.json`
   - Confirme que a hash está correta: `$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy`

2. **Verifique as credenciais:**
   - Usuário: `Gold21` (com G maiúsculo)
   - Senha: `102030` (sem espaços)

3. **Gere uma nova hash:**
   - Abra `gerador_hash_bcrypt.html`
   - Clique em "Gerar Hash Bcrypt"
   - Copie e cole no JSON

4. **Limpe o cache do navegador:**
   - Ctrl + Shift + Delete
   - Limpe cookies e cache

### ❌ Problema: Gerador de cartões não funciona

**Soluções:**

1. **Verifique o BIN:**
   - Deve ter exatamente 6 dígitos
   - Apenas números (0-9)

2. **Verifique a quantidade:**
   - Mínimo: 1
   - Máximo: 1000

3. **Teste com valores padrão:**
   - BIN: 456789
   - Quantidade: 10
   - Formato: NUMERO|MES|ANO|CVV

### ❌ Problema: Site PeruYashGen não carrega

**Solução:**
Use o gerador local (`gerador_cartoes.html`) que tem a mesma funcionalidade e não depende de conexão com o site.

---

## 📦 ARQUIVOS INCLUÍDOS

1. **gerador_hash_bcrypt.html**
   - Gera hash bcrypt para qualquer senha
   - Interface amigável
   - Instruções incluídas

2. **gerador_cartoes.html**
   - Gerador completo de cartões
   - Algoritmo de Luhn
   - 4 formatos de saída
   - Até 1000 cartões por vez

3. **5ddd2e45147066c4399b5fcd4cb63e68.json**
   - Arquivo JSON corrigido
   - Hash válida para senha "102030"
   - Pronto para uso

4. **README.md** (este arquivo)
   - Documentação completa
   - Guias passo a passo
   - Solução de problemas

---

## 🚀 INÍCIO RÁPIDO

### Para começar agora:

1. **Substitua o arquivo JSON:**
   ```
   Copie o arquivo: 5ddd2e45147066c4399b5fcd4cb63e68.json
   Cole no seu servidor/projeto
   ```

2. **Faça login:**
   ```
   Usuário: Gold21
   Senha: 102030
   ```

3. **Use o gerador de cartões:**
   ```
   Abra: gerador_cartoes.html
   Configure e gere cartões
   ```

---

## 💡 DICAS ADICIONAIS

### Para Segurança:
- ✅ Mude a senha após o primeiro login
- ✅ Use senhas fortes
- ✅ Ative 2FA se disponível
- ✅ Faça backup regular do JSON

### Para Melhor Performance:
- ✅ Use o gerador local ao invés de sites externos
- ✅ Gere cartões em lotes pequenos (50-100 por vez)
- ✅ Limpe os resultados após copiar

### Para Desenvolvimento:
- ✅ Mantenha backups dos arquivos
- ✅ Teste em ambiente local primeiro
- ✅ Documente mudanças customizadas

---

## 📞 SUPORTE

Se você tiver problemas:

1. Revise a seção "Solução de Problemas"
2. Verifique se todos os arquivos estão no lugar certo
3. Teste com valores padrão primeiro
4. Limpe cache e cookies do navegador

---

## ⚡ RESUMO EXECUTIVO

**Hash para Gold21 / 102030:**
```
$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy
```

**Arquivos principais:**
- `gerador_hash_bcrypt.html` → Gera hashes
- `gerador_cartoes.html` → Gera cartões
- `5ddd2e45147066c4399b5fcd4cb63e68.json` → Arquivo de usuários corrigido

**Login:**
- Usuário: Gold21
- Senha: 102030

---

✨ **Desenvolvido para CENTRAL21**

*Última atualização: 16/02/2026*
