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
    vermelho: '#E63946',
    azul: '#448FFF',
    verde: '#2ECC71',
    amarelo: '#F1C40F',
    laranja: '#FF8418',
    roxo: '#9B59B6',
    rosa: '#E91E63'
};

trocarCorInst('azul')
const root = document.documentElement;


function trocarCorInst(cor) {
    localStorage.setItem('instCor', cores[cor]);
}

if (localStorage.getItem('instCor')) {
    root.style.setProperty('--inst', localStorage.getItem('instCor'));

} else {
    localStorage.setItem('instCor', '#000');
}

if (!localStorage.getItem('temaInst')) {
    
    root.style.setProperty('--fundo', '#F6F6F6');
    root.style.setProperty('--branco', '#ffffff');
    root.style.setProperty('--preto', '#2c2c2c');
    root.style.setProperty('--texto', '#616161');
    root.style.setProperty('--sidebar', '#1B242E');
    root.style.setProperty('--cinzaClaro', '#F6F6F6');
} 
    else {
        root.style.setProperty('--fundo', '#121212');
        root.style.setProperty('--branco', '#1e1e1e');
        root.style.setProperty('--preto', '#f5f5f5');
        root.style.setProperty('--texto', '#d1d1d1');
        root.style.setProperty('--sidebar', '#1e1e1e');
        root.style.setProperty('--cinzaClaro', '#1a1a1a');
    }


function alterarTema() {
    if (localStorage.getItem('temaInst') == 'claro') {
        localStorage.setItem('temaInst', 'escuro')
        root.style.setProperty('--fundo', '#121212');
        root.style.setProperty('--branco', '#1e1e1e');
        root.style.setProperty('--preto', '#f5f5f5');
        root.style.setProperty('--texto', '#d1d1d1');
        root.style.setProperty('--sidebar', '#1e1e1e');
        root.style.setProperty('--cinzaClaro', '#1a1a1a');
    } else {
        localStorage.setItem('temaInst', 'escuro')
        root.style.setProperty('--fundo', '#F6F6F6');
        root.style.setProperty('--branco', '#ffffff');
        root.style.setProperty('--preto', '#2c2c2c');
        root.style.setProperty('--texto', '#616161');
        root.style.setProperty('--sidebar', '#1B242E');
        root.style.setProperty('--cinzaClaro', '#F6F6F6');
    }
}
alterarTema()
