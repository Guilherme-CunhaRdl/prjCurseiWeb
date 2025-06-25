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
  const addLinkUpdateButton = document.getElementById('addLinkUpdateButton');


  buttonOpenModalLinkPost.addEventListener('click', function () {
    modalLinkPost.style.display = 'flex';
    inputUrlLinkPost.focus();
  });
  addLinkUpdateButton.addEventListener('click', function () {
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
        document.getElementById('linkUpdate').value = inputUrlLinkPost.value.trim();

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
  const novoPost = new FormData(postFormulario);
  if(document.getElementById('descricaoPost').value !=''){
    setLoading(true)
   
    try {
      const res = await axios.post(`http://${host}/api/cursei/posts/${idInst}`, novoPost);
      listaPosts.innerHTML = ''
      carregarPost()
      fecharModal()
      setLoading(false)
      postFormulario.reset()
    } catch (error) {
alert('erro de conexão')
    setLoading(false)
    }
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
    setLoading(false)
  }
}