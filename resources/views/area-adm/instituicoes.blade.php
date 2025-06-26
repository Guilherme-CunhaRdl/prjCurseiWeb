<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todas as instituicoes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    @include('area-adm.componentes.links-base')

    <link rel="stylesheet" href="{{asset('css/instituicoesAdm.css')}}">
</head>
<body>
@include('area-adm.componentes.sidebar')

    <main>

        <div class="container-fluid container">
        <div class="tituloGeral">
                <p>Instituições</p>
            </div>

            <div class="SelecInputs">
    <form id="filtroForm" method="GET" action="{{ url()->current() }}">
        <div class="pesqInput">
            <input type="text" name="search" placeholder="Digite o nome da instituição" 
                   value="{{ request('search') }}">
            <i class="fa-solid fa-magnifying-glass" onclick="document.getElementById('filtroForm').submit()"></i>
        </div>

        <select class="form-select selectInst" name="status" onchange="this.form.submit()">
    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>
        Todas as instituições
    </option>
    <option value="verificada" {{ request('status') == 'verificada' ? 'selected' : '' }}>
        Instituições verificadas
    </option>
    <option value="nao_verificada" {{ request('status') == 'nao_verificada' ? 'selected' : '' }}>
        Instituições não verificadas
    </option>
</select>

        <select name="order" class="form-select selectInst" onchange="this.form.submit()">
            <option value="mais_seguidas" {{ request('order') == 'mais_seguidas' ? 'selected' : '' }}>
                Mais seguidas
            </option>
            <option value="menos_seguidas" {{ request('order') == 'menos_seguidas' ? 'selected' : '' }}>
                Menos seguidas
            </option>
            <option value="mais_recentes" {{ request('order') == 'mais_recentes' ? 'selected' : '' }}>
                Mais recentes
            </option>
            <option value="mais_antigas" {{ request('order') == 'mais_antigas' ? 'selected' : '' }}>
                Mais antigas
            </option>
        </select>
    </form>
</div>

                            <div class="listarCards">

                            @foreach ($todasInstituicoes as $instituicao) 
                            <a href="/curseiAdm/dashInstituicaoAdm/{{ $instituicao->id}}">
                <div class="card">
             
                    <div class="imgContainer">
                        <img src="{{ asset('img/user/fotoPerfil/' . ($instituicao->img_user ?? 'default-banner.jpg')) }}" alt="Logo Senac" />
                        </div>
                    <div class="nomeCard">
                    <p>{{ $instituicao->nome_user }}</p>
                    </div>
                    <div class="infoCard">
                        <div>
                            <span>{{ $instituicao->total_curtidas }}</span>
                            Curtidas
                        </div>
                        <div>
                            <span>{{ $instituicao->total_seguidores }}</span>
                        seguidores
                        </div>
                    </div>
                 
                </div>
            </a>
                @endforeach


           
                
                

               


                
                </div>

                <div class="d-flex justify-content-center mt-4">
                {{ $todasInstituicoes->appends(request()->query())->links() }}
            </div>

</div>
    </main>

   
    <script src="{{asset('js/listarInstiuicoesAdm.js')}}"></script>
</body>
</html>