 <nav class="navbar-custom d-flex justify-content-between align-items-center">
     <!-- Esquerda -->
     <div class="navbar-title">
         <i class='bx {{ $navbarIcon ?? "bx-home-alt" }}'></i>
         <p>{{ $titulo ?? "Dashboard" }}</p>
     </div>

     <!-- Direita -->
     <div class="navbar-right ">
         <div class="notification-icon"  onclick="abrirModalNotificacoes()">
             <i class='bx  bx-bell'></i>
             <div class="notification-badge">4</div>
         </div>

         <div class="dropdown">
             <div class="d-flex align-items-center gap-2 dropdown-toggle" data-bs-toggle="dropdown" role="button"
                 aria-expanded="false">
                 <img src="{{asset('img/user/fotoPerfil/' . (auth()->user()->img_user ?? 'default-banner.jpg'))}}"  class="profile-img"
                     alt="Perfil">
                 <div class="profile-info">
                     <span>{{ auth()->user()->nome_user }}</span>
                     <p class="small mb-0"> {{'@'. auth()->user()->arroba_user }}</p>
                 </div>
             </div>

             <ul class="dropdown-menu dropdown-menu-end">
                 <li><a class="dropdown-item" href="{{ route('instituicao.conta')}}">Perfil</a></li>
                 <li><a class="dropdown-item" href="#" onclick="abrirModalTema()">Tema</a></li>
                 <li>
                     <hr class="dropdown-divider">
                 </li>
                 <li><a class="dropdown-item text-danger" href="{{ route('fazerLogoff')}}">Sair</a></li>
             </ul>
         </div>
     </div>
 </nav>
