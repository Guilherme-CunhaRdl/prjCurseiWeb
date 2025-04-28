<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos Os Post da Instituicoes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    @include('area-adm.componentes.links-base')

    <link rel="stylesheet" href="{{asset('css/instituicoesAdm.css')}}">
</head>
<body>
@include('area-adm.componentes.sidebar')

    <main>

        <div class="container-fluid cont">
        <div class="tituloGeral">
                <p>Todos os Posts</p>
            </div>

            <div class="SelecInputs">
                <div class="pesqInput">
                    <input type="text" placeholder="Digite o nome do usuario">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>


                <select class="form-select selectInst">
                    <option value="all">
                        Todos os Posts
                    </option>
                    <option value="all">
                        Posts ativos
                    </option>
                    <option value="all">
                      Posts Desativados
                    </option>
                </select>


                 <select name="Organizar" class="form-select selectInst">
                    <option value="all">
                        Mais Vistos
                    </option>
                    <option value="all">
                        Mais Curtidos
                    </option>
                    <option value="all">
                        Mais recentes
                    </option>
                    <option value="all">
                        Mais antigos
                    </option>
                    </select>

                   





            </div>

                            <div class="listarCards">

                     
                
             @foreach($Curtei as $C)    
                <div class="cardsPost">
                    <div class="topoCard">
                        <img src="{{ asset('img/user/fotoPerfil/' . ($C->user->img_user ?? 'default-banner.jpg')) }}" alt="Logo" class="logoInstituicao">
                        <h3 class="nomeInstituicao">{{ $C->user->nome_user ?? 'Desconhecido' }}</h3>
                    </div>

       

                                    <div class="videoRells">
                    <img src="{{ asset('img/user/imgRells/imgRells.jpg') }}" alt="Imagem do post">
                </div>


                    <div class="infoCard">
                        <div>
                        <span>0</span>
                        Comentarios
                        </div>
                        <div>
                        <span>{{ $C->curtidas_count }}</span>
                        Curtidas
                        </div>
                    </div>   
                </div>
                @endforeach
                


           
                
                

               


                
                </div>


    </main>

   
</body>
</html>