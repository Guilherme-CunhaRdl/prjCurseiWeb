<div class="container-fluid container-modal-post modal-oculto" id="containerModalCriarPost" onclick="fecharModalCriarPost(event)">
    <div class="box-modal-post" id="boxModalCriarPost">
        <div class="col-12 header-modal-informacoes align-items-center d-flex flex-row">
                  
            <div class="boxUsuario col-6 d-flex flex-row">
                <div class="col-3 ">
                <div class="boxImgUsuario">
                    <img class="img-fluid"  src="{{ url('img/user/fotoPerfil/'. $instituicao->img_user)  }}" alt="">
                </div>
                </div>
                <div class="col-9 ps-2">
                <div class=" d-flex  h-100 align-items-center">
                    <span>
                    {{$instituicao->nome_user}}
                    </span>
                    
                </div>
                </div>
            </div>

        <div class="col-6 d-flex justify-content-end pe-2">
        <button onclick="fecharModalCriarPost(event)" id="botaoFecharModalCriacao">
            <i class="bi bi-x" style="pointer-events: none;"></i>
        </button>
        </div>  
          </div>

        <div class="conteudo-modal-post" style="overflow-y: scroll;">
            <form action="{{ route('biblioteca.criarPost') }}" class="w-100" method="post" enctype="multipart/form-data">
                @csrf
            <div class="divInput mt-3">
                <textarea name="descricaoPost" class="inserirInfoPost" rows="3" placeholder="Sobre o que você quer falar?" type="text"></textarea>
            </div> 
            <div class="w-100" >
                <img src="" style="border-radius: 10px;" class="w-100 img-fluid imgPost"  alt="">
            </div>
            
            <div class="iconesPost position-relative">
                    <i class="bi bi-card-image"></i> 
                    <label for="imgPost" class="position-absolute top-0 start-0 w-100 h-100" style="cursor: pointer;"></label>
                    <input type="file" name="imgPost" accept="image/*" id="imgPost" class="d-none">
                </div>
        </div>
            <hr>

        <div class="footer-modal-post">
            <button type="submit" class="botaoPublicarPost" >Publicar</button>
        </div>
        </form>
    </div>
</div>