$(document).ready(function() {
    // Filtro de pesquisa
    $('#pesquisa').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        $('.cardsPost').each(function() {
            const userName = $(this).find('.nomeInstituicao').text().toLowerCase();
            const caption = $(this).find('.legendaPost p').text().toLowerCase();
            
            if (userName.includes(searchTerm) || caption.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Filtro por status
    $('#filtroStatus').on('change', function() {
        const status = $(this).val();
        
        $('.cardsPost').each(function() {
            if (status === 'all') {
                $(this).show();
            } else {
                // Você precisará adicionar um atributo data-status aos cards
                const postStatus = $(this).attr('data-status');
                if ((status === 'active' && postStatus === 'active') || 
                    (status === 'inactive' && postStatus === 'inactive')) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            }
        });
    });

    // Filtro de ordenação
    $('#filtroOrdenacao').on('change', function() {
        const order = $(this).val();
        const $container = $('.listarCards');
        const $cards = $container.find('.cardsPost').get();

        $cards.sort(function(a, b) {
            switch(order) {
                case 'mais_curtidos':
                    const likesA = parseInt($(a).find('.interactionBtn span').first().text());
                    const likesB = parseInt($(b).find('.interactionBtn span').first().text());
                    return likesB - likesA;
                
                case 'mais_recentes':
                    return new Date($(b).attr('data-date')) - new Date($(a).attr('data-date'));
                
                case 'mais_antigos':
                    return new Date($(a).attr('data-date')) - new Date($(b).attr('data-date'));
                
                // Para mais_vistos, você precisaria ter essa informação no seu modelo
                case 'mais_vistos':
                default:
                    return 0; // Mantém a ordem original
            }
        });

        $container.empty().append($cards);
    });
});