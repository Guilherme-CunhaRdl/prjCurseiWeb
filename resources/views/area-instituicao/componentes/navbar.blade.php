 <nav class="navbar-custom d-flex justify-content-between align-items-center">
            <!-- Esquerda -->
     <div class="navbar-title">
    <i class='bx {{ $navbarIcon ?? "bx-home-alt" }}'></i>
    <p>{{ $navbarTitle ?? "Dashboard" }}</p>
</div>

            <!-- Direita -->
            <div class="navbar-right ">
                <div class="notification-icon">
                    <i class='bx  bx-bell'></i>
                    <div class="notification-badge">4</div>
                </div>

                <div class="dropdown">
                    <div class="d-flex align-items-center gap-2 dropdown-toggle" data-bs-toggle="dropdown" role="button"
                        aria-expanded="false">
                        <img src="../../../public/img/user/fotoPerfil/1746553339_681a49fbdd278.jpg" class="profile-img"
                            alt="Perfil">
                        <div class="profile-info">
                            <span>Etec de Itaquera</span>
                            <p class="small mb-0">@etecitaquera</p>
                        </div>
                    </div>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('instituicao.conta')}}">Perfil</a></li>
                        <li><a class="dropdown-item" href="#">Configurações</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="#">Sair</a></li>
                    </ul>
                </div>
            </div>
        </nav>