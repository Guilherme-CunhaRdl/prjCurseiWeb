<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Código de Verificação</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 20px;
        }
        h2 {
            color: #333333;
        }
        p {
            color: #555555;
            font-size: 16px;
        }
        .code {
            font-size: 28px;
            font-weight: bold;
            color: #1e88e5;
            background-color: #f0f8ff;
            display: inline-block;
            padding: 12px 20px;
            border-radius: 6px;
            margin: 20px 0;
            letter-spacing: 3px;
        }
        .footer {
            font-size: 12px;
            color: #888888;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
        <img src="{{asset('img/curseiNomeLogo.png')}}" alt="">
        </div>

        <h2>Seu Código de Verificação</h2>
        <p>Use o código abaixo para concluir seu login:</p>

        <div class="code">
            {{ $code }}
        </div>

        <p>Este código expira em 15 minutos.</p>

        <div class="footer">
            Caso você não tenha solicitado este código, ignore este e-mail.
        </div>
    </div>
</body>
</html>
