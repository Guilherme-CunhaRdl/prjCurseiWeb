  <div class="sidebar">
      <div class="topoSidebar">
          <div class="logo">
              <img src="{{ asset('img/Icone_Cursei_Branco.png') }}" alt="">
          </div>
          <p>Instituição</p>
      </div>
      <div class="links">
          <a href="/curseiInstituicao/dashboard" class="link">
              <p>Dashboard</p>
              <i class='bx bx-home-alt'></i>
          </a>
          <a href="/curseiInstituicao/posts" class="link ">
              <p>Posts</p>
              <i class='bx  bx-image'></i>
          </a>
          <a href="/curseiInstituicao/curteis" class="link ">
              <p>Curteis</p>
              <i class='bx bxs-videos'></i>
          </a>
          <a href="/curseiInstituicao/seguidores
            " class="link ">
              <p>Seguidores</p>
              <i class='bx bx-user'></i>
          </a>
      </div>
  </div>
  <script>
      const links = document.querySelectorAll('.link');
      links.forEach(link => {
          if (window.location.pathname == new URL(link.href).pathname) {
              link.classList.add('link_focus');
          }
      });
  </script>

  <div id="contLoading">
      <!-- 
    <div class="flex-col gap-4 w-full flex items-center justify-center">
  <div class="spinner-bg"></div>
</div> -->
      <div class="loader"></div>
  </div>
  <div class="ContmodalTema" id="ContmodalTema">
      <div class="modalTema" id="modalTema">
    <i class="bx bx-x" onclick="fecharModalTema()" style="cursor: pointer;margin: 0px;width: 100%;text-align: end;padding-right: 20px;font-size: 30px;"></i>
          <p class="titulotema">
              Personalize sua cursei
          </p>

          <div style="padding-inline: 5%;">
              <p>Tema:</p>
              <div class="buttonsTemas">
                  <button onclick="alterarTema('claro')" id="sun">
                      <i class='bx  bx-sun'></i>
                  </button>
                  <button id="moon" onclick="alterarTema('escuro')">
                      <i class='bx  bx-moon'></i>
                  </button>
              </div>
          </div>
          <div class="cores">
              <p>Cor Principal:</p>
              <div class="listaCores" id="listaCores">

                  <button onclick="trocarCorInst(this,'vermelho')" style="background-color:#e90013;">
                      
                  </button>

                  <button onclick="trocarCorInst(this,'azul')" style="background-color: #448FFF;">
                      
                  </button>

                  <button onclick="trocarCorInst(this,'verde')" style="background-color: #2ECC71;">
                      
                  </button>

                  <button onclick="trocarCorInst(this,'amarelo')" style="background-color: #F1C40F;">
                      
                  </button>

                  <button onclick="trocarCorInst(this,'laranja')" style="background-color: #FF8418;">
                      
                  </button>

                  <button onclick="trocarCorInst(this,'roxo')" style="background-color: #6b00cf;">
                      
                  </button>

                  <button onclick="trocarCorInst(this,'rosa')" style="background-color: #E91E63;">
                      
                  </button>

                  <button onclick="trocarCorInst(this,'preto')" style="background-color: #2F2F2F;">
                      
                  </button>

                  <button onclick="trocarCorInst(this,'verdeAqua')" style="background-color: #05A4B6;">
                      
                  </button>

                  <button onclick="trocarCorInst(this,'azulEscuro')" style="background-color: #10009D;">
                      
                  </button>


              </div>
          </div>
      </div>
  </div>
  <script>
    if (localStorage.getItem('temaInst') == 'claro') {
        document.getElementById('sun').classList.add('buttontemaAtivo')
    }else{
        document.getElementById('moon').classList.add('buttontemaAtivo')
    }
     document.getElementById('sun').addEventListener('click', () => {
        document.getElementById('sun').classList.add('buttontemaAtivo')
        document.getElementById('moon').classList.remove('buttontemaAtivo')
     })
        document.getElementById('moon').addEventListener('click', () => {
        document.getElementById('sun').classList.remove('buttontemaAtivo')
        document.getElementById('moon').classList.add('buttontemaAtivo')
     })
  </script>