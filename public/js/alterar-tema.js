// const temaLaranja = document.querySelector('.button-laranja')
// const temaAzul = document.querySelector('.button-azul')
// const temaVermelho = document.querySelector('.button-vermelho')
// const temaDark = document.querySelector('.button-dark')
// const temaRoxo = document.querySelector('.button-roxo')

// temaLaranja.addEventListener('click', () => {
//     document.body.className = '';

//     document.body.className = 'laranja'

//     localStorage.setItem('tema', 'laranja')
// })

// temaAzul.addEventListener('click', () => {
//     document.body.className = '';

//     document.body.className = 'azul'

//     localStorage.setItem('tema', 'azul')

// })

// temaVermelho.addEventListener('click', () => {
//     document.body.className = '';

//     document.body.className = 'vermelho'

//     localStorage.setItem('tema', 'vermelho')

// })

// temaDark.addEventListener('click', () => {
//     document.body.className = '';

//     document.body.className = 'dark'

//     localStorage.setItem('tema', 'dark')

// })

// temaRoxo.addEventListener('click', () => {
//     document.body.className = '';

//     document.body.className = 'roxo'

//     localStorage.setItem('tema', 'roxo')

// })
const cores = {
    vermelho: '#e90013',
    azul: '#448FFF',
    verde: '#2ECC71',
    amarelo: '#F1C40F',
    laranja: '#FF8418',
    roxo: '#9B59B6',
    rosa: '#E91E63',
    preto: '#2F2F2F',
    verdeAqua: '#05A4B6',
    azulEscuro: '#10009D',
};


const root = document.documentElement;


function trocarCorInst(botaoClicado,cor) {
    localStorage.setItem('instCor', cores[cor]);
    localStorage.setItem('instCorNome', cor);
    root.style.setProperty('--inst', localStorage.getItem('instCor'));
    document.querySelectorAll('#listaCores button').forEach(botao => {
        botao.innerHTML = '';
    });

    botaoClicado.innerHTML = "<i class='bx bx-check'></i>";

   
}

if (localStorage.getItem('instCor')) {
    root.style.setProperty('--inst', localStorage.getItem('instCor'));

} else {
    localStorage.setItem('instCor', '#000');
    localStorage.setItem('instCorNome', 'preto');

}
    localStorage.getItem('instCorNome');


if (localStorage.getItem('temaInst')) {
    if (localStorage.getItem('temaInst') == 'claro') {
        root.style.setProperty('--fundo', '#F6F6F6');
        root.style.setProperty('--branco', '#ffffff');
        root.style.setProperty('--preto', '#2c2c2c');
        root.style.setProperty('--texto', '#616161');
        root.style.setProperty('--sidebar', '#1B242E');
        root.style.setProperty('--cinzaClaro', '#F6F6F6');
        
    } else {
        root.style.setProperty('--fundo', '#121212');
        root.style.setProperty('--branco', '#1e1e1e');
        root.style.setProperty('--preto', '#f5f5f5');
        root.style.setProperty('--texto', '#d1d1d1');
        root.style.setProperty('--sidebar', '#1e1e1e');
        root.style.setProperty('--cinzaClaro', '#1a1a1a');
    }
}
else {
        localStorage.setItem('temaInst', 'claro')
        root.style.setProperty('--fundo', '#F6F6F6');
        root.style.setProperty('--branco', '#ffffff');
        root.style.setProperty('--preto', '#2c2c2c');
        root.style.setProperty('--texto', '#616161');
        root.style.setProperty('--sidebar', '#1B242E');
        root.style.setProperty('--cinzaClaro', '#F6F6F6');
}


function alterarTema(mudar) {
       document.querySelectorAll('*').forEach(function (element) {
            element.style.transition = '200ms';
        });
    if (mudar =='escuro') {
        localStorage.setItem('temaInst', 'escuro')
        root.style.setProperty('--fundo', '#121212');
        root.style.setProperty('--branco', '#1e1e1e');
        root.style.setProperty('--preto', '#f5f5f5');
        root.style.setProperty('--texto', '#d1d1d1');
        root.style.setProperty('--sidebar', '#1e1e1e');
        root.style.setProperty('--cinzaClaro', '#1a1a1a');
    } else {
        localStorage.setItem('temaInst', 'claro')
        root.style.setProperty('--fundo', '#F6F6F6');
        root.style.setProperty('--branco', '#ffffff');
        root.style.setProperty('--preto', '#2c2c2c');
        root.style.setProperty('--texto', '#616161');
        root.style.setProperty('--sidebar', '#1B242E');
        root.style.setProperty('--cinzaClaro', '#F6F6F6');
    }
}

function abrirModalTema() {
  const modal = document.getElementById('ContmodalTema');
  modal.classList.add('ativo');
}

document.addEventListener('DOMContentLoaded', function () {
  const modalCont = document.getElementById('ContmodalTema');
  const modal = document.querySelector('.modalTema');

  modalCont.addEventListener('click', function (e) {
    if (!modal.contains(e.target)) {
      fecharModalTema();
    }
  });
});
function fecharModalTema() {
  const modal = document.getElementById('ContmodalTema');
  modal.classList.remove('ativo');
}




