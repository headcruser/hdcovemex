<!-- Navigation -->
<h6 class="navbar-heading text-muted">
    Menu
</h6>
<ul class="navbar-nav">

    <li class="nav-item">
        <a class="nav-link">
            <i class="ni ni-circle-08 text-blue"></i> <span class="nav-link-text">Perfil</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
            <i class="ni ni-key-25"></i> Cerrar sesión
        </a>
        <form action="{{ route('logout') }}" method="POST" style="display: none;" id="formLogout">
            @csrf
        </form>
    </li>

</ul>
