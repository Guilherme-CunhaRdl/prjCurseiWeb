<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    @include('area-adm.componentes.links-base')

    <link rel="stylesheet" href="{{asset('css/usuariosAdm.css')}}">
</head>

<body>
    @include('area-adm.componentes.sidebar')

    <main>
        <div class="container-fluid cont">
            <div class="tituloPag">
                <p>Usuarios</p>
            </div>
            <div class="inputs">
                <div class="contInput">
                    <input type="text" id="pesquisa" placeholder="Pesquise pelo nome do usuario">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>

                <select name="filtrar" class="form-select" id="filtrar">
                    <option value="all">
                        Todos usuarios
                    </option>
                    <option value="on">
                        Usuarios ativos
                    </option>
                    <option value="off">
                        Desativados
                    </option>
                </select>

                <select name="Organizar" class="form-select" id="organizar">
                    <option value="recent">
                        Mais recentes
                    </option>
                    <option value="old">
                        Mais antigos
                    </option>
                    <option value="mais">
                        Mais seguidos
                    </option>
                    <option value="menos">
                        Menos seguidos
                    </option>
                </select>

            </div>
            <div class="lista-cards" id="cardsPadrao">
                @foreach ($usuarios as $usuario )

                @if ( $usuario -> status_user ==0)
                <div class="card" style="opacity: 0.2;">
                    @else
                    <div class="card">
                        @endif
                        <div class="avatar">
                            @if ($usuario->img_user =="")
                            <img src="https://img.freepik.com/psd-gratuitas/ilustracao-3d-de-uma-pessoa-com-oculos-de-sol_23-2149436188.jpg?semt=ais_country_boost&w=740" alt="">
                            @else
                            <img src="{{ asset('img/user/fotoPerfil/' . ($usuario->img_user ?? 'default-banner.jpg')) }}" alt="">
                            @endif
                        </div>
                        <div class="info">
                            <p>{{$usuario ->nome_user}}</p>
                            <p id="email">{{ $usuario-> email_user }}</p>
                        </div>
                        <div class="status">
                            @if ( $usuario -> status_user ==1)
                            <p>Ativado</p>
                            @else
                            <p>Desativado</p>

                            @endif
                        </div>
                        <div class="acoes">
                            <a href="/curseiAdm/dashUsuarioAdm/{{$usuario -> id}}"><i class='bx bx-info-circle'></i></a>
                            <a href="/curseiAdm/desativarUsuarios/{{$usuario->id}}"><i class='bx bx-user-x'></i></a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="lista-cards" id="cardsPesquisa"></div>
            </div>

    </main>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let timeout = null; // variável global de controle

        $('#pesquisa').on('keyup', function() {
            if (pesquisa.value.length > 0) {
            pesquisar()
        }else{
            document.getElementById('cardsPadrao').style.display = "flex";
                    document.getElementById('cardsPesquisa').innerHTML = '';
        }
        });

        
        document.getElementById('filtrar').addEventListener('change', function() {
            pesquisar()

        })
        document.getElementById('organizar').addEventListener('change', function() {
            pesquisar()
            
        })

        function pesquisar() {
            clearTimeout(timeout);
            const pesquisa = document.getElementById('pesquisa');
            const filtro = document.getElementById('filtrar');
            const organizar = document.getElementById('organizar');
            
            document.getElementById('cardsPesquisa').innerHTML = '';
            timeout = setTimeout(() => {
                
                    

                    $.ajax({
                        url: '/curseiAdm/buscarUsuarios',
                        type: 'GET',
                        data: {
                            pesquisa: pesquisa.value,
                            filtro: filtro.value,
                            organizar: organizar.value
                        },
                        success: function(data) {
                            data.forEach(usuario => {
                                document.getElementById('cardsPadrao').style.display = "none";
                                const card = `
                        <div class="card" style="opacity: ${usuario.status_user == 0 ? '0.2' : '1'};">
                            <div class="avatar">
            <img src="{{ asset('img/user/fotoPerfil') }}/${usuario.img_user ?? 'default-banner.jpg'}" alt="">
                            </div>
                            <div class="info">
                                <p>${usuario.nome_user}</p>
                                <p id="email">${usuario.email_user}</p>
                            </div>
                            <div class="status">
                                <p>${usuario.status_user == 1 ? 'Ativado' : 'Desativado'}</p>
                            </div>
                            <div class="acoes">
                                 <a href="/curseiAdm/dashUsuarioAdm/${usuario.id}"><i class='bx bx-info-circle'></i></a>
                            <a href="/curseiAdm/desativarUsuarios/${usuario.id}"><i class='bx bx-user-x'></i></a>
                            </div>
                        </div>
                    `;
                                document.getElementById('cardsPesquisa').innerHTML += card;
                            });
                        }
                    });
                
            }, 500);
            

        }
    </script>




    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>