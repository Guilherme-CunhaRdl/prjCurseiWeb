const lista = document.getElementById('listaCurteis')
setLoading(true)
carregarCurteis()

async function carregarCurteis() {
    try{
        const result = await axios.get(`http://${host}/api/curtei/IntituicaoWeb/${idInst}`)
        const data = result.data.videos
        await mostrarCurteis(data)
        setLoading(false)

    }
    catch(error){
            alert('erro ao conectar ao servidor');
    
}
}

function mostrarCurteis(curteis){
    lista.innerHTML = ''
    curteis.forEach(curtei => {
        const card = `
             <div class="card-conteudo" >
                  <div style="cursor:pointer" onclick= "verCurtei('${(curtei.legenda || '').replace(/'/g, "\\'")}',
             '${(curtei.video_url || '').replace(/'/g, "\\'")}','${(curtei.thumb_url || '').replace(/'/g, "\\'")}', ${curtei.id})">
                         <div class="img">
                             <img src="${curtei.thumb_url}" alt=""/>
                         </div>
                         </div>
                         <div class="infos-conteudo">
                             <div class="info" onclick="verEngajamentos(3,${curtei.id})">
                                 <i class='bx bx-heart'></i>
                                 <p>${curtei.curtidas_count} </p>
                             </div>
                             <div class="info" onclick="verEngajamentos(4,${curtei.id})">
                                 <i class='bx  bx-message-circle'></i>
                                 <p>${curtei.comentarios_count}</p>
                             </div>
                    
                         </div>

                     </div >
        `
        lista.innerHTML += card;
    })
}

const pesquisarCurtei = document.getElementById('pesquisarCurtei');

let debounceTimeout = null;

pesquisarCurtei.addEventListener('input', () => {
  clearTimeout(debounceTimeout); // Limpa o timer anterior

  debounceTimeout = setTimeout(() => {
    pesquisar();
  }, 500); // Espera 500ms após parar de digitar
});

async function pesquisar() {
  const termo = pesquisarCurtei.value.trim(); // Remove espaços
  lista.innerHTML = '';

  if (termo.length > 1) {
    try {
      const res = await axios.get(`http://${host}/api/curtei/IntituicaoWeb/${idInst}/${termo}`);
      setTimeout(() => {
        lista.innerHTML = '';
        const data = res.data.videos;
        mostrarCurteis(data)
      }, 500);
    } catch (err) {
      alert('erro ao conectar ao servidor');
    }
  } else {
    // Se o campo estiver vazio ou com 1 caractere
    setTimeout(() => {
      
      carregarCurteis(); // Chama carregarPost() direto aqui
    }, 200); // Pode até reduzir o delay se quiser
  }
}





