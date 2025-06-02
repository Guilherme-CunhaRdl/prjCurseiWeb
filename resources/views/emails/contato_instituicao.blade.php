<!DOCTYPE html>
<html>
<head>
    <title>Contato da Instituição</title>
</head>
<body>
    <div style="justify-content: center; align-items: center; display: flex; flex-direction: column; text-align: center;">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(255, 255, 255);
            color: #333;
        }
        img {
            width: 400px;
            height: auto;
            margin-bottom: 30   px;
            margin-top: 30px;
        }
        h2 {
            color: #2c3e50;
        }
        p {
            font-size: 20px;
            line-height: 1.5;
        }
    </style>
    <img src="{{asset('img/curseiNomeLogo.png')}}" alt="">
    <h2>Olá, {{ $instituicao->user->nome_user }}</h2>
    <p>{{ $mensagem }}</p>
    </div>
</body>
</html>
