<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i>
        </div>
        <div class="sidebar-brand-text mx-3">cmsVuskoo</div>
    </a>
    <div class="sidebar-heading">
        Admin
    </div>
    @can('dashboard.view')
        <li class="nav-item active">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endcan
    @can('roles.view')
        <li class="nav-item active">
            <a class="nav-link" href="/roles">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Roles</span></a>
        </li>
    @endcan
    @can('permisos.view')
        <li class="nav-item active">
            <a class="nav-link" href="/permisos">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Permisos</span></a>
        </li>
    @endcan
    @can('usuarios.view')
        <li class="nav-item active">
            <a class="nav-link" href="/usuarios">
                <i class="fa fa-address-book" aria-hidden="true"></i>
                <span>Usuarios</span></a>
        </li>
    @endcan
    <!-- Divider -->
    @can('clientes.view')
        <hr class="sidebar-divider d-none d-md-block">
        <div class="sidebar-heading">
            Clientes
        </div>
        @can('operadoras.view')
            <li class="nav-item active">
                <a class="nav-link" href="/operadoras">
                    <i class="fa fa-address-book" aria-hidden="true"></i>
                    <span>Operadoras</span></a>
            </li>
        @endcan
        @can('comercializadoras.view')
            <li class="nav-item active">
                <a class="nav-link" href="/comercializadoras">
                    <i class="fa fa-address-book" aria-hidden="true"></i>
                    <span>Comercializadoras</span></a>
            </li>
        @endcan
        @can('comercios.view')
            <li class="nav-item active">
                <a class="nav-link" href="/comercios">
                    <i class="fa fa-address-book" aria-hidden="true"></i>
                    <span>Comercios</span></a>
            </li>
        @endcan
    @endcan
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Parillas
    </div>
    @can('telefonia.view')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTelefonia"
                aria-expanded="true" aria-controls="collapseTelefonia">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>Telefonía</span>
            </a>
            <div id="collapseTelefonia" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('fibra.view')
                        <a class="collapse-item" href="{{ route('parrillafibra.index') }}">Fibra</a>
                    @endcan
                    @can('movil.view')
                        <a class="collapse-item" href="{{ route('parrillamovil.index') }}">Móvil</a>
                    @endcan
                    @can('fibramovil.view')
                        <a class="collapse-item" href="{{ route('parrillafibramovil.index') }}">Fibra y móvil</a>
                    @endcan
                    @can('fibramoviltv.view')
                        <a class="collapse-item" href="{{ route('parrillafibramoviltv.index') }}">Fibra, móvil y tv</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan
    @can('energia.view')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEnergia"
                aria-expanded="true" aria-controls="collapseEnergia">
                <i class="fa fa-bolt" aria-hidden="true"></i>
                <span>Energia</span>
            </a>
            <div id="collapseEnergia" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('luz.view')
                        <a class="collapse-item" href="{{ route('parrillaluz.index') }}">Luz</a>
                    @endcan
                    @can('gas.view')
                        <a class="collapse-item" href="{{ route('parrillagas.index') }}">Gas</a>
                    @endcan
                    @can('luzygas.view')
                        <a class="collapse-item" href="{{ route('parrillaluzgas.index') }}">Luz y gas</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan
    @can('cupones.view')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCupones"
                aria-expanded="true" aria-controls="collapseCupones">
                <i class="fa fa-ticket" aria-hidden="true"></i>
                <span>Cupones</span>
            </a>
            <div id="collapseCupones" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('cupones.index') }}">Cupones</a>
                </div>
            </div>
        </li>
    @endcan
    @can('streaming.view')
        <li class="nav-item active">
            <a class="nav-link" href="/streaming">
                <i class="fas fa-tv"></i>
                <span>Streaming</span></a>
        </li>
    @endcan
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-5">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
