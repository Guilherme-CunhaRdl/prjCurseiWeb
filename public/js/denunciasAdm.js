const modal = document.querySelector(".modal-denuncia")
const contmodal = document.querySelector(".container-modal-denuncia")
function abrirModalDenuncia(autor,tipo,denunciado,data,desc) {
    contmodal.style.display = "flex"
    document.getElementById('autor').textContent = autor;
    document.getElementById('tipo').textContent = tipo;
    document.getElementById('denunciado').textContent = denunciado;
    document.getElementById('data').textContent = data;
    document.getElementById('descmod').textContent = desc;


}


function fecharModalDenuncia() {
   
        contmodal.style.animation = "removerModalCont 500ms ease-in-out"
        modal.style.animation = "tiraModal 500ms ease-in-out"
        setTimeout(() => {
            contmodal.style.display = "none"
            contmodal.style.animation = "aparecerModalCont 300ms ease-in-out"
            modal.style.animation = "aparecerModal 800ms ease-in-out"

        }, 450);
    
}
 function fecharforaDenuncia(event){

    if (event.target === contmodal) {
                 fecharModalDenuncia()
        
          }
     }


     $(document).ready(function() {
     
        $('#pesquisa').on('keyup', function() {
            let searchTerm = $(this).val().toLowerCase();
            
            if (searchTerm === '') {
                $('#cardsPesquisa').hide();
                $('#cardsPadrao').show();
                return;
            }
    
            $('#cardsPadrao').hide();
            $('#cardsPesquisa').empty().show();
    
            $('.card').each(function() {
                let cardText = $(this).text().toLowerCase();
                if (cardText.includes(searchTerm)) {
                    $('#cardsPesquisa').append($(this).clone());
                }
            });
        });
    
       
        $('.form-select').on('change', function() {
            let order = $(this).val();
            let $container = $('#cardsPadrao');
            let $cards = $container.find('.card').get();
    
            $cards.sort(function(a, b) {
                let dateA = new Date($(a).find('#data').text() || $(a).find('p').last().text());
                let dateB = new Date($(b).find('#data').text() || $(b).find('p').last().text());
                
                return order === 'Mais recentes' ? dateB - dateA : dateA - dateB;
            });
    
            $container.empty().append($cards);
        });
    });