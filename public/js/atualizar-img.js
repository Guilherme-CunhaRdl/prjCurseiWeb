// esse é o js da pagina de personalização
document.getElementById('bannerImg').addEventListener("change", readImage, false);
document.getElementById('imgPerfil').addEventListener("change", readImagePerfil, false);
//chamando campo nome e o oq esta sendo exibido
const nomePreview = document.getElementById('nome-user-preview');
const nomeInput = document.getElementById('input-nome');

const bioPreview = document.getElementById('bio-user-preview')
const bioInput = document.getElementById('input-bio')

const contatoPreview = document.getElementById('arroba-user-preview')
const contatoInput = document.getElementById('input-contato')

//aqui eu to colocando as paradas dos inputs dentro do preview
nomePreview.innerText = nomeInput.value;
bioPreview.innerText = bioInput.value;
contatoPreview.innerText = contatoInput.value;
    //sempre que digitado faz o codigo abaixo
    nomeInput.addEventListener('input', function(){
        //pegando oq tem no input e jogando no preview
        nomePreview.innerText = nomeInput.value;
        if(nomeInput.value === ''){
            nomePreview.innerText = "Sem Nome"
        }
    })
    bioInput.addEventListener('input', function(){
        bioPreview.innerText = bioInput.value;
        if(bioInput.value === ''){
            bioPreview.innerText = "Sem Bio"
        }
    })
    contatoInput.addEventListener('input', function(){
        contatoPreview.innerText = contatoInput.value;
        if(contatoInput.value === ''){
            contatoPreview.innerText = "Sem Contato"
        }
    })


    //atualizando imagens
function readImage(){
    if(this.files && this.files[0]){
        var file = new FileReader();

        file.onload = function(e){
            document.querySelectorAll('.bannerPreview').forEach(function(img){
                img.src = e.target.result;
            })
        };

        file.readAsDataURL(this.files[0]);
    }
}

function readImagePerfil(){
    if(this.files && this.files[0]){
        var file = new FileReader();

        file.onload = function(e){
            document.querySelectorAll('.carregarImgPerfil').forEach(function(img){
                img.src = e.target.result;
            })
        };
        file.readAsDataURL(this.files[0])
    }
}
