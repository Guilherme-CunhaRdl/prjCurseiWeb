<div class="novoPostmodalCont" id="novoPostmodalCont">
  <div class="novoPostModal " id="novoPostModal">
    <div class="topo">
      <p>Novo Post</p>
      <i class="bx bx-x" onclick="fecharModal()"></i>
    </div>
    <div class="tab">
      <button type="button" class="tab-ativo" id="tabPost">Post</button>
      <button type="button" id="tabEvento">Evento</button>
    </div>
    <form id="postForm">
      <div class="usuario">
        <div class="contImg">
          <img src="https://i.redd.it/6bn647ynsg9e1.jpeg" alt="" />
        </div>
        <div class="infouser">
          <p class="nome">Itau intitui</p>
          <p class="arroba">@itau</p>
        </div>
      </div>
      <div class="conteudoCont">
        <textarea placeholder="Digite o que aconteceu hoje..." name="descricaoPost" id="descricaoPost"></textarea>
        <div class="conteudo-img" id="conteudo-img">
          <img src="" alt="" id="imgPost" />
        </div>
      </div>
      <i class='bx bx-calendar-alt' id="buttonOpenModalDataPost"></i>
      <div class="rodape">
        <div>
          <button type="button" class="add" id="buttonOpenModalLinkPost" style="display: none;">
            <i class='bx bx-link'></i>
            <p>Adicionar Link</p>
          </button>
          <button type="button" class="add">
            <i class='bx bx-image-plus'></i>
            <label for="imgPostinput" style="cursor: pointer;">Adicionar imagem</label>
            <input type="file" style="display: none;" name="img" id="imgPostinput">
          </button>
        </div>
        <div class="cpb">
          <button type="button" class="cancelar" onclick="fecharModal()">
            Cancelar
          </button>
          <button type="button" class="postar" onclick="postarPost()">
            postar
          </button>
        </div>
      </div>
      <input type="hidden" name="link" id="linkInput">
      <input type="hidden" name="data" id="dataInput">
      <input type="hidden" name="hora" id="horaInput">

    </form>
    <form id="evento" class="evento">
      <div class="topo-evento">
        <div class="capa_cont">
          <img src="" alt="" id="previewCapa">
          <label for="inputcapa">
            <i class='bx bx-image-plus'></i>
            <p>Adicione uma capa</p>
          </label>
          <input type="file" id="inputcapa" style="display: none;" name="img">
        </div>
        <div class="inputData">
          <div>
            <label for="">data inicio</label>
            <input type="date" placeholder="" name="inicio">
            <input type="time" placeholder="" class="horas" name="hinicio">
          </div>
          <div>
            <label for="">data término</label>
            <input type="date" placeholder="" name="fim">
            <input type="time" placeholder="" class="horas" name="hfim">
          </div>
        </div>
      </div>
      <div class="infosEvento">
        <label for="">Título </label>
        <div class="inputEventoCont">
          <img src="Icone_Logo_Cursei_Preta.png" alt="">
          <input type="text" placeholder="Escolha o título do seu evento " name="tituloEvento">
        </div>
        <label for="">Link</label>
        <div class="inputEventoCont">
          <i class='bx bx-link'></i>
          <input type="url" placeholder="Sua url aqui" name="link">
        </div>
        <label for="">data inicio</label>
        <textarea placeholder="Descreva seu evento" name="descEvento"></textarea>
      </div>
      <div class="rodape" style="justify-content: end;">
    
        <div class="cpb">
          <button type="button" class="cancelar" onclick="fecharModal()">
            Cancelar
          </button>
          <button type="button" class="postar" onclick="postarEvento()"> 
            postar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
 <div class="modalLinkPost" id="modalLinkPost">
        <div class="modalLinkPostContent">
            <h4 style="text-align: center;">Adicionar link no post</h4>
            <div class="modalLinkPostInputGroup">
                <label for="inputUrlLinkPost">URL</label>
                <input type="text" id="inputUrlLinkPost" placeholder="Cole ou digite a URL aqui">
            </div>
           
            <div style="width: 100%;display: flex;justify-content: center;">
                          <button id="buttonAddLinkPost">Adicionar</button>
            </div>
        </div>
    </div>

    <div class="modalLinkPost" id="modalDataPost">
        <div class="modalLinkPostContent">
            <h4 style="text-align: center;">Agendar Postagem</h4>
            <div class="modalLinkPostInputGroup">
                <label for="inputUrlLinkPost">Data e hora</label>
                <div style="display: flex;justify-content: space-evenly;">
                <input type="date" id="inputdataPost"  style="width:45%;">
                <input type="time" id="inputHoraPost"  style="width: 45%;">
                </div>
            </div>
           
            <div style="width: 100%;display: flex;justify-content: center;">
                          <button type="button" id="buttonAddDataPost">Agendar</button>
            </div>
        </div>
    </div>