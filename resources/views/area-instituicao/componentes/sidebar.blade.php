  <div class="sidebar">
        <div class="topoSidebar">
            <div class="logo">
                <img src="{{ asset('img/Icone_Cursei_Branco.png') }}" alt="">
            </div>
            <p>Instituição</p>
        </div>
        <div class="links">
            <a href="/curseiInstituicao/dashboard" class="link">
                <p>Dashboard</p>
                <i class='bx bx-home-alt'></i>
            </a>
            <a href="/curseiInstituicao/posts" class="link ">
                <p>Posts</p>
                <i class='bx  bx-image'></i>
            </a>
            <a href="/curseiInstituicao/curteis" class="link ">
                <p>Curteis</p>
                <i class='bx bxs-videos'></i>
            </a>
            <a href="/curseiInstituicao/seguidores
            " class="link ">
                <p>Seguidores</p>
                <i class='bx bx-user'></i>
            </a>
        </div>
    </div>
    <script>
        const links = document.querySelectorAll('.link');
links.forEach(link => {
    if (window.location.pathname == new URL(link.href).pathname) {
        link.classList.add('link_focus');
    }
});
    </script>