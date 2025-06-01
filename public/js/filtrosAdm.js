document.addEventListener('DOMContentLoaded', function() {
    const searchUserInput = document.getElementById('searchUser');
    const filterStatusSelect = document.getElementById('filterStatus');
    const sortPostsSelect = document.getElementById('sortPosts');
    const postsContainer = document.querySelector('.listarCards');
    

    let debounceTimer;
    const debounceDelay = 500;
    

    [searchUserInput, filterStatusSelect, sortPostsSelect].forEach(element => {
        element.addEventListener('change', applyFilters);
        element.addEventListener('input', function(e) {
            if (e.target === searchUserInput) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(applyFilters, debounceDelay);
            }
        });
    });
    
    async function applyFilters() {
        try {
            const response = await fetch('/curseiAdm/tdPostInst/filter', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    search: searchUserInput.value,
                    status: filterStatusSelect.value,
                    sort: sortPostsSelect.value
                })
            });
            
            if (!response.ok) throw new Error('Erro na requisição');
            
            const data = await response.json();
            updatePostsList(data.posts);
            
        } catch (error) {
            console.error('Erro ao filtrar posts:', error);
            postsContainer.innerHTML = `
                <div class="alert alert-danger">
                    Erro ao carregar posts. Tente novamente.
                </div>
            `;
        }
    }
    
    function updatePostsList(posts) {
        postsContainer.innerHTML = '';
        
        if (posts.length === 0) {
            postsContainer.innerHTML = `
                <div class="no-results">
                    Nenhum post encontrado com esses critérios.
                </div>
            `;
            return;
        }
        
        posts.forEach(post => {
            const postElement = createPostElement(post);
            postsContainer.appendChild(postElement);
        });
    }
    
    function createPostElement(post) {
        const postElement = document.createElement('div');
        postElement.className = 'cardsPost';
        
 
        const hasImage = post.conteudo_post && 
                        /\.(jpg|jpeg|png|gif)$/i.test(post.conteudo_post);
        
    
        const postDate = new Date(post.created_at);
        const formattedDate = postDate.toLocaleDateString('pt-BR');
        
        postElement.innerHTML = `
            <div class="conteudo-flex">
                <div class="topoCard">
                    <img src="${getUserImageUrl(post.usuario.img_user)}" 
                         alt="Foto do usuário" class="logoInstituicao">
                    <h3 class="nomeInstituicao">@${post.usuario.arroba_user || 'Desconhecido'}</h3>
                </div>

                <p class="descricaoInstituicao">
                    ${post.descricao_post || ''}
                </p>

                <div class="imagemPostagem">
                    ${hasImage ? 
                        `<img src="/img/user/imgPosts/${post.conteudo_post}" alt="Imagem do post">` : 
                        `<div class="no-image-placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span>Sem imagem</span>
                        </div>`
                    }
                </div>
            </div>

            <div class="infoCard">
                <div>
                    <span>${post.comentario_count || 0}</span>
                    Comentários
                </div>
                <div>
                    <span>${post.curtidas_count || 0}</span>
                    Curtidas
                </div>
            </div>
        `;
        
        return postElement;
    }
    
    function getUserImageUrl(imgPath) {
        return imgPath 
            ? `/img/user/fotoPerfil/${imgPath}`
            : '/img/user/fotoPerfil/default-banner.jpg';
    }
});

async function applyFilters() {
    try {
        console.log("Enviando requisição...");
        
        const response = await fetch('/tdPostInst/filter', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                search: searchUserInput.value,
                status: filterStatusSelect.value,
                sort: sortPostsSelect.value
            })
        });
        
        console.log("Resposta recebida:", response);
        
        const data = await response.json();
        
        if (!data.success) {
            throw new Error(data.message || 'Erro no servidor');
        }
        
        updatePostsList(data.posts);
        
    } catch (error) {
        console.error('Erro completo:', error);
        showError(error.message);
    }
}

function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'alert alert-danger';
    errorDiv.innerHTML = `
        <strong>Erro!</strong> ${message}
        <button onclick="this.parentElement.remove()" class="btn-close float-end"></button>
    `;
    
    postsContainer.prepend(errorDiv);
    

    setTimeout(() => {
        errorDiv.remove();
    }, 5000);
}