<?php
error_reporting(0);
require_once "validation.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MULTI BIN CC GENERATOR - CENTRAL21</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            width: 100%;
            margin: 20px auto;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
            text-decoration: none;
        }

        .generator-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }

        h1 {
            text-align: center;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 35px;
            color: #ffffff;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            color: #4CAF50;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
        }

        input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus {
            border-color: #4CAF50;
            background: rgba(76, 175, 80, 0.1);
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .date-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .hint {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
            margin-top: 5px;
            font-weight: 400;
        }

        .btn-generate,
        .btn-copy {
            width: 100%;
            padding: 16px;
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: #ffffff;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
            transition: all 0.3s ease;
            margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
        }

        .btn-generate:hover,
        .btn-copy:hover {
            background: linear-gradient(45deg, #45a049, #3d8b40);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.5);
        }

        .btn-generate:active,
        .btn-copy:active {
            transform: translateY(0);
        }

        .output-area {
            width: 100%;
            min-height: 300px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            font-size: 0.9rem;
            font-family: 'Courier New', monospace;
            border-radius: 12px;
            resize: vertical;
            margin-bottom: 15px;
            outline: none;
        }

        .output-area::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .credits {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
        }

        .credits .dev-name {
            color: #4CAF50;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.4rem;
            }

            .generator-card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="home.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>

        <div class="generator-card">
            <h1>Multi BIN CC Generator</h1>

            <form id="generatorForm">
            <div class="form-group">
                <label>Bins</label>
                <input type="text" id="bins" placeholder="Enter Your Bins XXXXXX;XXXXXX;XXXXXX" required>
                <div class="hint">* Seperate your bins with ;</div>
            </div>

            <div class="form-group">
                <label>Date</label>
                <div class="date-row">
                    <select id="month">
                        <option value="Random">Random</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select id="year">
                        <option value="Random">Random</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                        <option value="2032">2032</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>CVV</label>
                <input type="text" id="cvv" placeholder="XXX" maxlength="3" value="XXX">
            </div>

            <div class="form-group">
                <label>Quantity</label>
                <input type="number" id="quantity" value="10" min="1" max="100">
            </div>

            <button type="submit" class="btn-generate">
                <i class="fas fa-magic"></i> Generate
            </button>
        </form>

        <textarea id="output" class="output-area" placeholder="XXXXXXXXXXXXXXXX | XX | XX | XXX" readonly></textarea>

        <button class="btn-copy" onclick="copyCards()">
            <i class="fas fa-copy"></i> Copy Cards
        </button>

        <div class="credits">
            <p>Desenvolvido por <span class="dev-name">CENTRAL21</span></p>
            <p>Sistema de Checkers e Geradores</p>
        </div>
        </div>
    </div>

    <script>
        // Algoritmo de Luhn para validar números de cartão
        function luhnCheck(num) {
            let arr = (num + '')
                .split('')
                .reverse()
                .map(x => parseInt(x));
            let lastDigit = arr.splice(0, 1)[0];
            let sum = arr.reduce((acc, val, i) => (i % 2 !== 0 ? acc + val : acc + ((val * 2) % 9) || 9), 0);
            sum += lastDigit;
            return sum % 10 === 0;
        }

        // Gerar dígito de verificação usando Luhn
        function generateCheckDigit(partialCard) {
            for (let i = 0; i <= 9; i++) {
                if (luhnCheck(partialCard + i)) {
                    return i;
                }
            }
            return 0;
        }

        // Gerar número de cartão completo
        function generateCardNumber(bin) {
            // Limpar o BIN de caracteres não numéricos exceto X
            let cleanBin = bin.replace(/[^0-9Xx]/g, '');
            
            // Determinar se é AMEX (começa com 34 ou 37)
            let isAmex = cleanBin.startsWith('34') || cleanBin.startsWith('37');
            let targetLength = isAmex ? 15 : 16;
            
            let card = '';
            
            // Processar cada caractere do BIN
            for (let i = 0; i < cleanBin.length; i++) {
                let char = cleanBin[i];
                if (char.toUpperCase() === 'X') {
                    // Substituir X por número aleatório
                    card += Math.floor(Math.random() * 10);
                } else {
                    card += char;
                }
            }
            
            // Preencher com dígitos aleatórios até targetLength - 1
            while (card.length < targetLength - 1) {
                card += Math.floor(Math.random() * 10);
            }
            
            // Adicionar dígito de verificação
            card += generateCheckDigit(card);
            
            return card;
        }

        // Gerar cartões
        document.getElementById('generatorForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const binsInput = document.getElementById('bins').value.trim();
            const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;
            const cvvInput = document.getElementById('cvv').value.trim();
            const quantity = parseInt(document.getElementById('quantity').value);

            if (!binsInput) {
                alert('Please enter at least one BIN!');
                return;
            }

            // Separar BINs por ; ou ,
            const bins = binsInput.split(/[;,]/).map(b => b.trim()).filter(b => b.replace(/[Xx]/g, '').length >= 6);

            if (bins.length === 0) {
                alert('Please enter valid BINs (minimum 6 digits)!');
                return;
            }

            let cards = [];

            for (let i = 0; i < quantity; i++) {
                // Selecionar BIN aleatório
                const randomBin = bins[Math.floor(Math.random() * bins.length)];
                
                // Gerar número do cartão
                const cardNumber = generateCardNumber(randomBin);

                // Gerar mês
                let cardMonth = month;
                if (month === 'Random') {
                    cardMonth = String(Math.floor(Math.random() * 12) + 1).padStart(2, '0');
                }

                // Gerar ano
                let cardYear = year;
                if (year === 'Random') {
                    const years = ['2025', '2026', '2027', '2028', '2029', '2030', '2031', '2032'];
                    cardYear = years[Math.floor(Math.random() * years.length)];
                }

                // Gerar CVV
                let cardCVV = cvvInput;
                if (cvvInput === 'XXX' || cvvInput === '') {
                    cardCVV = String(Math.floor(Math.random() * 1000)).padStart(3, '0');
                }

                // Formato: XXXXXXXXXXXXXXXX | XX | XX | XXX
                cards.push(`${cardNumber} | ${cardMonth} | ${cardYear.slice(-2)} | ${cardCVV}`);
            }

            document.getElementById('output').value = cards.join('\n');
        });

        // Copiar cartões
        function copyCards() {
            const output = document.getElementById('output');
            if (output.value.trim() === '') {
                alert('Generate cards first!');
                return;
            }
            output.select();
            document.execCommand('copy');
            
            // Feedback visual
            const btn = event.target;
            const originalText = btn.textContent;
            btn.textContent = 'COPIED!';
            btn.style.background = '#2dd60f';
            
            setTimeout(() => {
                btn.textContent = originalText;
                btn.style.background = '#39ff14';
            }, 1500);
        }

        // Limitar CVV a 3 dígitos
        document.getElementById('cvv').addEventListener('input', function(e) {
            if (this.value.length > 3) {
                this.value = this.value.slice(0, 3);
            }
        });
    </script>
</body>
</html>
