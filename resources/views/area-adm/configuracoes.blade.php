<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    @include('area-adm.componentes.links-base')

    <link rel="stylesheet" href="{{asset('css/ConfigAdm.css')}}">

</head>

<body>
    @include('area-adm.componentes.sidebar')


    <main>

        <div class="container-fluid cont">
            <div class="tituloPag">
                <p>Configurações</p>
            </div>
            <div class="container-fluid configuracoes">
                <div class="card card-tema">
                    <div class="modoEscuroTitulo">
                        <p class="titulo">Modo escuro</p>
                        <p class="desc">alterar o tema entre escuro e claro</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" id="btntema">
                        <div class="toggle-switch-background">
                            <div class="toggle-switch-handle"></div>
                        </div>
                    </label>

                </div>
                <div class="card">
                    <div>
                        <p class="titulo">Editar conta</p>
                        <p class="desc">alterar as informação da sua conta de administrador</p>
                    </div>

                    @foreach ($adm as $adma )


                    <form action="alterarAdm/{{1}}" method="get" class="editarConta">
                        @csrf
                        <label for="">Nome</label>
                        <div class="contInput">
                            <input type="text" name="nome" id="a" value="{{$adma->nome_admin }}">
                        </div>
                        <label for="">Email</label>
                        <div class="contInput">
                            <input type="email" name="email" value="{{$adma->email_admin }}">
                        </div>
                        <label for="">Senha</label>
                        <div class="contInput">
                            <input type="password" name="password" id="senha">
                            <i class="fa-regular fa-eye-slash" id="olho"></i>
                        </div>
                        <div class="w-100 d-flex justify-content-center justify-content-lg-end mt-5 mt-lg-0"> <button type="submit">Salvar</button></div>
                    </form>
                    @endforeach
                </div>
            </div>
        </div>
    </main>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <script>
        btntema.addEventListener('change', () => {

        if (localStorage.getItem('tema') == 'claro') {

            document.querySelector('.logo-sidebar img').src = "{{ asset('img/Icone_Cursei_Branco.png') }}";
        } else {
            document.querySelector('.logo-sidebar img').src = "{{asset('img/Icone_Logo_Cursei_Preta.png')}}";

        }
    })
    </script>
    <script src="{{asset('js/configAdm.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>