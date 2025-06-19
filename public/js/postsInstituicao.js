//   axios.get('https://minhaapi.com/posts')
//     .then(res => console.log(res.data))
//     .catch(err => console.error(err));
setLoading(true)
carregarPost();

async function carregarPost() {
  try {
    const res = await axios.get(`http://${host}/api/posts/2/0/100/0/${idInst}`);
    const posts = res.data.data;
    mostrarPosts(posts)
    setLoading(false)
  } catch (err) {
    alert('erro ao conectar ao servidor');
  }
}
const listaPosts = document.getElementById('listaPosts')
async function mostrarPosts(posts) {
  console.log(posts)
  posts.forEach(post => {
    const cardPost = `
              <div class="card-conteudo">
                       <div class="cont-desc-card">
                         <p>${post.descricao_post}</p>
                       </div>
                        <div class="img">
                            <img src="http://${host}/img/user/imgPosts/${post.conteudo_post}" alt="">
                        </div>
                        <div class="infos-conteudo">
                            <div class="info">
                                <i class='bx bx-heart'></i>
                                <p>${post.curtidas}</p>
                            </div>
                            <div class="info">
                                <i class='bx  bx-message-circle'></i>
                                <p>${post.comentarios}</p>
                            </div>
                            <div class="info">
                                <i class='bx bx-repeat-alt'></i>
                                <p>${post.total_reposts}</p>
                            </div>

                        </div>

                    </div>
        `
    listaPosts.innerHTML += cardPost;
  });



}
const pesquisarPosts = document.getElementById('pesquisarPosts');

let debounceTimeout = null;

pesquisarPosts.addEventListener('input', () => {
  clearTimeout(debounceTimeout); // Limpa o timer anterior

  debounceTimeout = setTimeout(() => {
    pesquisar();
  }, 500); // Espera 500ms após parar de digitar
});

async function pesquisar() {
  const termo = pesquisarPosts.value.trim(); // Remove espaços
  listaPosts.innerHTML = '';

  if (termo.length > 1) {
    try {
      const res = await axios.get(`http://${host}/api/posts/10/${idInst}/100/0/${termo}`);
      setTimeout(() => {
        listaPosts.innerHTML = '';
        const posts = res.data.data;
        mostrarPosts(posts);
      }, 500);
    } catch (err) {
      alert('erro ao conectar ao servidor');
    }
  } else {
    // Se o campo estiver vazio ou com 1 caractere
    setTimeout(() => {
      listaPosts.innerHTML = '';
      carregarPost(); // Chama carregarPost() direto aqui
    }, 200); // Pode até reduzir o delay se quiser
  }
}

document.getElementById('imgPostinput').addEventListener('change', readImagePost, false);

function readImagePost() {
  if (this.files && this.files[0]) {
    var file = new FileReader();

    file.onload = function (e) {
      document.getElementById('imgPost').src = e.target.result;
      document.getElementById('imgPost').style.height = "300px"
      document.getElementById('novoPostModal').classList.add('comImg')
      document.getElementById('buttonOpenModalLinkPost').style.display ="flex"
    };
    file.readAsDataURL(this.files[0])
  }
}

document.getElementById('inputcapa').addEventListener('change', readImageEvento, false);

function readImageEvento() {
  if (this.files && this.files[0]) {
    var file = new FileReader();

    file.onload = function (e) {
      document.getElementById('previewCapa').src = e.target.result;
      document.getElementById('previewCapa').style.display = 'block'

    };
    file.readAsDataURL(this.files[0])
  }
}

const tbEvento = document.getElementById('tabEvento')
const tbPost = document.getElementById('tabPost')

var tab = 'postForm'
tbEvento.addEventListener('click', mudarTab)
tbPost.addEventListener('click', mudarTab)

function mudarTab() {
  if (tab == 'postForm') {
    tab = 'evento'
    tbEvento.classList.add('tab-ativo')
    tbPost.classList.remove('tab-ativo')
    document.getElementById('postForm').style.display = 'none'
    document.getElementById('evento').style.display = 'block'

  } else {

    tab = 'postForm'
    tbEvento.classList.remove('tab-ativo')
    tbPost.classList.add('tab-ativo')
    document.getElementById('postForm').style.display = 'block'
    document.getElementById('evento').style.display = 'none'
  }
}

function abrirModal() {
  const modal = document.getElementById('novoPostmodalCont');
  modal.classList.add('ativo');
}

document.addEventListener('DOMContentLoaded', function () {
  const modalCont = document.getElementById('novoPostmodalCont');
  const modal = document.querySelector('.novoPostModal');

  modalCont.addEventListener('click', function (e) {
    if (!modal.contains(e.target)) {
      fecharModal();
    }
  });
});
document.addEventListener('DOMContentLoaded', function () {
  const modalLinkPost = document.getElementById('modalLinkPost');
  const buttonOpenModalLinkPost = document.getElementById('buttonOpenModalLinkPost');
  const buttonAddLinkPost = document.getElementById('buttonAddLinkPost');
  const inputUrlLinkPost = document.getElementById('inputUrlLinkPost');



  buttonOpenModalLinkPost.addEventListener('click', function () {
    modalLinkPost.style.display = 'flex';
    inputUrlLinkPost.focus();
  });


  modalLinkPost.addEventListener('click', function (e) {
    if (e.target === modalLinkPost) {
      modalLinkPost.style.display = 'none';
    }
  });

  buttonAddLinkPost.addEventListener('click', function () {
    document.getElementById('linkInput').value = inputUrlLinkPost.value.trim();
    modalLinkPost.style.display = 'none';
  });


  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modalLinkPost.style.display === 'flex') {
      modalLinkPost.style.display = 'none';
    }
  });
});



document.addEventListener('DOMContentLoaded', function () {
  const modalDataPost = document.getElementById('modalDataPost');
  const buttonOpenModalDataPost = document.getElementById('buttonOpenModalDataPost');
  const buttonAddDataPost = document.getElementById('buttonAddDataPost');
  const inputdataPost = document.getElementById('inputdataPost');
  const inputHoraPost = document.getElementById('inputHoraPost');


  buttonOpenModalDataPost.addEventListener('click', function () {
    modalDataPost.style.display = 'flex';
    inputHoraPost.focus();
  });


  modalDataPost.addEventListener('click', function (e) {
    if (e.target === modalDataPost) {
      modalDataPost.style.display = 'none';
    }
  });

  buttonAddDataPost.addEventListener('click', function () {
    document.getElementById('horaInput').value = inputHoraPost.value.trim();
      document.getElementById('dataInput').value = inputdataPost.value.trim();
      modalDataPost.style.display = 'none';

  });


  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modalDataPost.style.display === 'flex') {
      modalDataPost.style.display = 'none';
    }
  });
});










const postFormulario = document.getElementById('postForm')

function fecharModal() {
  const modal = document.getElementById('novoPostmodalCont');
  modal.classList.remove('ativo');
  document.getElementById('imgPost').src = ''
  document.getElementById('imgPost').style.height = "0px"
  document.getElementById('novoPostModal').classList.remove('comImg')
    document.getElementById('previewCapa').src = '';
          document.getElementById('previewCapa').style.display = 'none'

  postFormulario.reset()
}

async function postarPost() {
  setLoading(true)
  const novoPost = new FormData(postFormulario);

  try {
    const res = await axios.post(`http://${host}/api/cursei/posts/${idInst}`, novoPost);
    listaPosts.innerHTML = ''
    carregarPost()
    fecharModal()
    setLoading(false)
    postFormulario.reset()
  } catch (error) {

  }
}

const eventoFormulario = document.getElementById('evento')

async function postarEvento() {
  setLoading(true)
    const novoEvento = new FormData(eventoFormulario);
 try {
    const result = await axios.post(`http://${host}/api/cursei/evento/${idInst}`, novoEvento);
    listaPosts.innerHTML = ''
    carregarPost()
    fecharModal()
    setLoading(false)
    postFormulario.reset()
    eventoFormulario.reset()
  } catch (error) {
    alert('erro de conexão')
  }
}