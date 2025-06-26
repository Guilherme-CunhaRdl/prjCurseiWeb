document.addEventListener('DOMContentLoaded', function() {
    // Submeter o formulário quando o usuário pressionar Enter no campo de busca
    document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('filtroForm').submit();
        }
    });
    
    // Manter os parâmetros de filtro na paginação
    document.querySelectorAll('.page-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = new URL(this.href);
            const formData = new FormData(document.getElementById('filtroForm'));
            
            formData.forEach((value, key) => {
                if (value !== 'all' && value !== '') {
                    url.searchParams.set(key, value);
                }
            });
            
            window.location.href = url.toString();
        });
    });
});