<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="icon" href="{{ asset( 'img/Icone_Logo_Cursei_Preta.png') }}" type="image/x-icon" />

</head>

<body>
    <div class="container-fluid">
        <div class="row vh-100 overflow-hidden  ">
            <div class="col-6  d-flex align-items-center justify-content-center bg-white ">
                <div class="position-fixed d-flex  align-items-center justify-content-center  top-0  start-0 p-4 gap-3">
                    <img src="{{ url('img/img-instituicao/img-login/logoCursei.png') }}" class="imagemLogo" alt="">
                    <p class="textoCursei"> Cursei </p>
                </div>
                <div class="d-flex align-items-center justify-content-center  h-50 w-75 bg-white flex-grow-1">
                            <form  action="{{route('fazerLogin')}}" method="post">
                                @csrf
                            <div class="conteudoPagina bg-white mh-100 mw-100 ">
                            <p class="text-black-50 mb-1">Instituição</p>
                            <h1 class="fw-semibold mb-2">Faça login ao Cursei!</h1>
                                @if ($errors->any())
                                    <div class="text-center text-danger mb-2">
                                        {{ $errors->first() }}
                                    </div>
                                @endif
                            <div class="mb-3 position-relative">
                                <input type="email" class="form-control estilizacaoInput pe-5" name="email" placeholder="E-mail">
                            <img src="{{ url('img/img-instituicao/img-login/iconEmail.png') }}" class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted "  >
                            </div>
                            <div class="mb-3 position-relative">
                                <input type="password" class="form-control estilizacaoInput pe-5" name="senha" id="inputSenha" placeholder="Senha">
                                <img src="{{ url('img/img-instituicao/img-login/iconSenha.png') }}" class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted" id="verSenha" style="cursor: pointer;" >
                              </div>

                             <button type="submit" class="btn botaoLogin w-100 text-white fw-bold">LOGIN</button>
                            </div>
                            </form>
                </div>
            </div>
            <div class="col-6 bg-black p-0 mh-100 mw-100">
                <img src="{{ url('img/img-instituicao/img-login/imgLogin.png') }}" alt="" class="h-100 w-100 ">
            </div>
        </div>
    </div>
</body>
<script src="{{url('js/verSenha.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>

</html>