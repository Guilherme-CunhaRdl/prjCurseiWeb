<link rel="stylesheet" href="{{ asset('css/sidebarInst.css') }}">
<link rel="stylesheet" href="{{ asset('css/modalNotificacao.css') }}">
<link rel="stylesheet" href="{{ asset('css/padraoInst.css') }}">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
   <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
<link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>

<script>
    
    window.host ='localhost:8000'
    window.idInstituicao = {{ auth()->user()->id }}
    function setLoading(state) {
  document.getElementById('contLoading').style.display = state ? 'flex' : 'none';
}
</script>
 <script src="{{ asset('js/modalNotificacao.js') }}"></script>
        <script src="{{ asset('js/alterar-tema.js') }}"></script>
