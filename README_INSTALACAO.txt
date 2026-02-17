╔═══════════════════════════════════════════════════════════════╗
║                    CENTRAL21 - INSTALAÇÃO                     ║
║              Pronto para Deploy na Squarecloud                ║
╚═══════════════════════════════════════════════════════════════╝

📋 INSTRUÇÕES DE INSTALAÇÃO NA SQUARECLOUD
═══════════════════════════════════════════════════════════════

🔧 REQUISITOS:
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
✅ Conta na Squarecloud
✅ Plano com suporte a PHP (versão 7.4 ou superior)
✅ Acesso FTP ou Gerenciador de Arquivos


🚀 PASSO A PASSO:
═══════════════════════════════════════════════════════════════

1️⃣ UPLOAD DOS ARQUIVOS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   • Acesse o painel da Squarecloud
   • Vá até o Gerenciador de Arquivos ou conecte via FTP
   • Faça upload de TODOS os arquivos deste ZIP para a pasta:
     public_html/ (ou www/ ou htdocs/ - depende do servidor)
   
   ⚠️ IMPORTANTE: Manter a estrutura de arquivos!


2️⃣ CONFIGURAR PERMISSÕES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   Via FTP ou painel, configure as permissões:
   
   Arquivos PHP: 644 ou 755
   Arquivos JSON: 666 (precisa escrever)
   Arquivo cookie.txt: 666 (precisa escrever)
   Pasta principal: 755


3️⃣ CONFIGURAÇÕES DO SERVIDOR
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   No painel da Squarecloud, verifique:
   
   ✅ Versão PHP: 7.4 ou superior
   ✅ mod_rewrite: ATIVADO (para .htaccess funcionar)
   ✅ Timezone: America/Sao_Paulo
   ✅ allow_url_fopen: Ativado
   ✅ cURL: Ativado


4️⃣ PRIMEIRO ACESSO
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   • Acesse: http://seudominio.com/
   • Faça login com o usuário fixo:
   
   ✅ CREDENCIAIS PERMANENTES:
   Username: Gold21
   Password: 102030
   Expiração: 2099 (nunca expira)


📁 ESTRUTURA DE ARQUIVOS:
═══════════════════════════════════════════════════════════════

public_html/
├── .htaccess                           (Reescrita de URLs)
├── 5ddd2e45147066c4399b5fcd4cb63e68.json   (Banco de dados)
├── admin_login.php                     (Login Admin)
├── admin_logout.php                    (Logout Admin)
├── banir_usuario.php                   (Banir usuário)
├── checker.php                         (Sistema Checker)
├── cookie.txt                          (Cookies de sessão)
├── corrigir.php                        (Validação de cartões)
├── editar_usuario.php                  (Editar usuário)
├── excluir_usuario.php                 (Excluir usuário)
├── home.php                            (Dashboard)
├── index.php                           (Página inicial)
├── live.mp3                            (Áudio notificação)
├── login.php                           (Login usuário)
├── loginApi.php                        (API de login)
├── pagseguro.php                       (Integração PagSeguro)
├── paypal.php                          (Integração PayPal)
├── registro.php                        (Registro de usuário)
├── registroApi.php                     (API de registro)
├── salvar_edicao.php                   (Salvar edições)
├── usuarios.php                        (Gerenciar usuários)
└── validation.php                      (Validação de sessão)


⚙️ CONFIGURAÇÕES IMPORTANTES:
═══════════════════════════════════════════════════════════════

🔐 SEGURANÇA:
   • Usuário Gold21 é permanente (não expira)
   • Você pode adicionar mais usuários pelo painel admin
   • Configure HTTPS/SSL no painel
   • Faça backup regular do arquivo JSON

📊 BANCO DE DADOS:
   • Sistema usa JSON (5ddd2e45147066c4399b5fcd4cb63e68.json)
   • Permissão 666 é obrigatória
   • Backup recomendado diariamente

🌐 URLs LIMPAS:
   • .htaccess remove extensão .php
   • Acesse: /login ao invés de /login.php
   • Acesse: /home ao invés de /home.php


🔧 SOLUÇÃO DE PROBLEMAS:
═══════════════════════════════════════════════════════════════

❌ Erro 500:
   → Verifique permissões dos arquivos
   → Verifique se mod_rewrite está ativo
   → Veja os logs de erro do servidor

❌ Não consegue fazer login:
   → Verifique permissão do arquivo JSON (666)
   → Verifique se as sessões PHP estão ativas
   → Limpe cookies do navegador

❌ URLs não funcionam:
   → Ative mod_rewrite no painel
   → Verifique se .htaccess está presente
   → Confirme que está na pasta correta

❌ Não salva dados:
   → Permissão do JSON deve ser 666
   → Permissão do cookie.txt deve ser 666
   → Verifique se o diretório tem permissão de escrita


📞 SUPORTE:
═══════════════════════════════════════════════════════════════

Para dúvidas sobre configuração do servidor:
👉 Suporte técnico da Squarecloud

Para personalização do sistema:
👉 Consulte os arquivos PHP (código comentado)


✅ CHECKLIST FINAL:
═══════════════════════════════════════════════════════════════

□ Arquivos enviados para public_html/
□ Permissões configuradas corretamente
□ PHP 7.4+ ativado
□ mod_rewrite ativado
□ Timezone configurado
□ Primeiro acesso realizado (Gold21 / 102030)
□ Backup do JSON criado
□ HTTPS configurado (recomendado)


🎉 PRONTO! SEU SISTEMA ESTÁ FUNCIONANDO!
═══════════════════════════════════════════════════════════════

Acesse: http://seudominio.com/

Desenvolvido por: CENTRAL21
Versão: 2.1
Data: 2026
