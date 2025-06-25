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
  listaPosts.innerHTML = '';
  posts.forEach(post => {
 
    const cardPost = `
              <div class="card-conteudo"
              
           >
              <div style="cursor:pointer"    onclick="verPost(${post.id_post},
              '${(post.descricao_post || '').replace(/'/g, "\\'")}','${(post.conteudo_post || '').replace(/'/g, "\\'")}',${post.evento_id})">
                       <div class="cont-desc-card">
                           ${post.descricao_post ? `<p>${post.descricao_post}</p>` : ''}
                       </div>
                        <div class="img">
    <img src="http://${host}/img/user/imgPosts/${post.conteudo_post ? post.conteudo_post : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ8lRbS7eKYzDq-Ftxc1p8G_TTw2unWBMEYUw&s'}" alt="">
                        </div>
                         </div>
                        <div class="infos-conteudo">
                            <div class="info">
                                <i class='bx bx-heart' onclick="verEngajamentos(2,${post.id_post})"></i>
                                <p>${post.curtidas}</p>
                            </div>
                            <div class="info" onclick="verEngajamentos(1,${post.id_post})">
                                <i class='bx  bx-message-circle'></i>
                                <p>${post.comentarios}</p>
                            </div>
                            <div class="info" style="cursor:auto">
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

