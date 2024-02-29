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
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Clientes
    </div>
    @can('clientes.view.operadoras')
        <li class="nav-item active">
            <a class="nav-link" href="/operadoras">
                <i class="fa fa-address-book" aria-hidden="true"></i>
                <span>Operadoras</span></a>
        </li>
    @endcan
    @can('clientes.view.comercializadoras')
        <li class="nav-item active">
            <a class="nav-link" href="/comercializadoras">
                <i class="fa fa-address-book" aria-hidden="true"></i>
                <span>Comercializadoras</span></a>
        </li>
    @endcan
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Parillas
    </div>
    @can('parrillas.view.telefonia')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTelefonia"
                aria-expanded="true" aria-controls="collapseTelefonia">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <span>Telefonía</span>
            </a>
            <div id="collapseTelefonia" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('parrillas.view.telefonia.view-fibra')
                        <a class="collapse-item" href="{{route('parrillaFibra.index')}}">Fibra</a>
                    @endcan
                    @can('parrillas.view.telefonia.view-movil')
                        <a class="collapse-item" href="{{route('parrillaMovil.index')}}">Móvil</a>
                    @endcan
                    @can('parrillas.view.telefonia.view-fibramovil')
                        <a class="collapse-item" {{-- href="{{route('/parillas')}}" --}}>Fibra y móvil</a>
                    @endcan
                    @can('parrillas.view.telefonia.view-fibramoviltv')
                        <a class="collapse-item" {{-- href="{{route('/parillas')}}" --}}>Fibra, móvil y tv</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan
    @can('parrillas.view.energia')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fa fa-bolt" aria-hidden="true"></i>
                <span>Energia</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('parrillas.view.energia.view-luz')
                        <a class="collapse-item" {{-- href="{{route('/parillas')}}" --}}>Luz</a>
                    @endcan
                    @can('parrillas.view.energia.view-gas')
                        <a class="collapse-item" {{-- href="{{route('/parillas')}}" --}}>Gas</a>
                    @endcan
                    @can('parrillas.view.energia.view-luzygas')
                        <a class="collapse-item" {{-- href="{{route('/parillas')}}" --}}>Luz y gas</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-5">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
