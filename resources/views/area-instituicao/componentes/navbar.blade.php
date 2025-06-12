 <nav class="navbar-custom d-flex justify-content-between align-items-center">
            <!-- Esquerda -->
     <div class="navbar-title">
    <i class='bx {{ $navbarIcon ?? "bx-home-alt" }}'></i>
    <p>{{ $titulo ?? "Dashboard" }}</p>
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
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLlEbcdOHQQz51aAgsC6hIzwpRqTZxVxQCdC-DvkU-jG2_GQ3VbNDNz-1H3aL3USxZRF4&usqp=CAU" class="profile-img"
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