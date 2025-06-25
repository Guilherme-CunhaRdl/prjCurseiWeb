
const listaEngajamentos = document.getElementById('listaEngajamentos')
const modal = document.getElementById('modalEngajamentoCont')
const loadingm = document.getElementById('contLoadingModal')
const titulo = document.getElementById('tituloModalEngajamento')
async function verEngajamentos(tipo,id) {
    loadingm.style.display ='block';
    modal.style.display ='flex'
    listaEngajamentos.classList.add('centro')
    try{
    url = `http://${host}/api/cursei/instituicao/engajamentos/${id}/${tipo}`
    const result = await axios.get(url)
    loadingm.style.display = 'none';
    listaEngajamentos.classList.remove('centro')
    await carregarEngajamentos(tipo,result.data)
    }catch(error){
        alert('Erro')
    }

}


function carregarEngajamentos (tipo,data){
    listaEngajamentos.innerHTML =``
    if(tipo ==1 || tipo ==4){
        titulo.innerHTML = "Comentarios"
        data.forEach(item => {
            const user =`
              <div class="comentario">
                <div class="imgUser">
                    <img src="http://${host}/img/user/fotoPerfil/${item.usuario.img_user}" alt="">
                </div>
                <div class="infoUser">
                    <p class="nome">
                   ${item.usuario.nome_user}<span>${formatarTempoInsercao(item.tempo_insercao   )}</span>
                    </p>
                    <div class="desc">
                       ${item.comentario}
                    </div>
                    <div class="curtidas">
                        <i class="bx bx-heart"></i>
                        ${item.total_curtidas}
                    </div>
                </div>
            </div>
            `
            listaEngajamentos.innerHTML += user
        })
    }else{
                titulo.innerHTML = "Curtidas"

 data.forEach(item => {
            const user =`
              <div class="curtida">
                <div class="imgUser">
                    <img src="http://${host}/img/user/fotoPerfil/${item.user.img_user}" alt="">
                </div>
                <div class="infoUser">
                    <p class="nome">
                   ${item.user.nome_user}<span>${formatarTempoInsercao(item.tempo_insercao)}</span>
                    </p>
                    <p class="arroba">
                        @${item.user.arroba_user}
                    </p>
                </div>
            </div>
            `
            listaEngajamentos.innerHTML += user
        })
    }
}
  dayjs.locale('pt-br');

  dayjs.extend(window.dayjs_plugin_relativeTime);

  const formatarTempoInsercao = (seconds) => {
    return dayjs().subtract(seconds, 'second').fromNow();
  };

  function fecharEngajamento(){
        modal.style.display ='none'
        listaEngajamentos.innerHTML =`
          <div id="contLoadingModal" style="display: block;">

                <div class="loader"></div>
            </div>
        `
        
        
    
  }