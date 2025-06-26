const contModalNovoCurte = document.getElementById('contModalNovoCurte')
const pt1 = document.getElementById('pt1')
const pt2 = document.getElementById('pt2')
const pt3 = document.getElementById('pt3')

var pt = 1
function mudarParte(ptv) {
    pt = ptv
    if (ptv == 1) {
        pt1.style.display = 'flex'
        pt2.style.display = 'none'
        pt3.style.display = 'none'
        document.getElementById('btnVoltar').style.display = 'none'
        document.getElementById('btnsalvar').style.display = 'none'
        document.getElementById('continuarBtn').style.display = 'block'

    } else if (ptv == 2) {
        pt1.style.display = 'none'
        pt2.style.display = 'flex'
        pt3.style.display = 'none'
        document.getElementById('btnVoltar').style.display = 'block'
        document.getElementById('btnsalvar').style.display = 'none'
        document.getElementById('continuarBtn').style.display = 'block'

    } else if (ptv == 3) {
        pt1.style.display = 'none'
        pt2.style.display = 'none'
        pt3.style.display = 'flex'
        document.getElementById('btnVoltar').style.display = 'block'
        document.getElementById('btnsalvar').style.display = 'block'
        document.getElementById('continuarBtn').style.display = 'none'


    }
}
function abrirmodalNovoCurtei() {
    document.getElementById('videoAdd').style.display = 'none';
    mudarParte(1)
    contModalNovoCurte.style.display = 'flex'
    document.getElementById('previewThub').style.display = "none"

}
function fecharmodalNovoCurtei() {
    contModalNovoCurte.style.display = 'none'

}
const formNovoCurtei = document.getElementById('formNovoCurtei')

async function salvarCurtei() {

    const novoCurtei = new FormData(formNovoCurtei);

    try {
        const res = await axios.post(`http://${host}/api/curtei/upload`, novoCurtei);
        fecharmodalNovoCurtei()
        formNovoCurtei.reset()
    } catch (error) {
        alert('erro de conexão')
        setLoading(false)
    }


}



document.getElementById('inputVideoCurteiAdd').addEventListener('change', readImageVideoADD, false);

function readImageVideoADD() {
    if (this.files && this.files[0]) {
        var file = new FileReader();

        file.onload = function (e) {
            document.getElementById('videoAdd').src = e.target.result;
            document.getElementById('videoAdd').style.display = "block";

        };
        file.readAsDataURL(this.files[0])
    }
}
document.getElementById('inputImgCurteiAdd').addEventListener('change', readImage, false);

function readImage() {
    if (this.files && this.files[0]) {
        var file = new FileReader();

        file.onload = function (e) {
            document.getElementById('previewThub').src = e.target.result;
            document.getElementById('previewThub').style.display = "block"
        };
        file.readAsDataURL(this.files[0])
    }
}