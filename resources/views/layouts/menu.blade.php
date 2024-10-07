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
                <i class="fa fa-users" aria-hidden="true"></i>
                <span>Roles</span></a>
        </li>
    @endcan
    @can('permisos.view')
        <li class="nav-item active">
            <a class="nav-link" href="/permisos">
                <i class="fa fa-key" aria-hidden="true"></i>
                <span>Permisos</span></a>
        </li>
    @endcan
    @can('usuarios.view')
        <li class="nav-item active">
            <a class="nav-link" href="/usuarios">
                <i class="fa fa-user" aria-hidden="true"></i>
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
                    <i class="fa fa-phone-square" aria-hidden="true"></i>
                    <span>Operadoras</span></a>
            </li>
        @endcan
        @can('comercializadoras.view')
            <li class="nav-item active">
                <a class="nav-link" href="/comercializadoras">
                    <i class="fa fa-bolt" aria-hidden="true"></i>
                    <span>Comercializadoras</span></a>
            </li>
        @endcan
        @can('comercios.view')
            <li class="nav-item active">
                <a class="nav-link" href="/comercios">
                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                    <span>Comercios</span></a>
            </li>
        @endcan
        @can('proveedores.view')
            <li class="nav-item active">
                <a class="nav-link" href="/proveedores">
                    <i class="fa fa-bullseye" aria-hidden="true"></i>
                    <span>Proveedores</span></a>
            </li>
        @endcan
        @can('proveedores.view')
            <li class="nav-item active">
                <a class="nav-link" href="/bancos">
                    <i class="fa fa-university" aria-hidden="true"></i>
                    <span>Bancos</span></a>
            </li>
        @endcan
        @can('paises.view')
            <li class="nav-item active">
                <a class="nav-link" href="/paises">
                    <i class="fa fa-globe" aria-hidden="true"></i>
                    <span>Paises</span></a>
            </li>
        @endcan
    @endcan
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Parillas
    </div>
    @can('cupones.view')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCupones"
                aria-expanded="true" aria-controls="collapseCupones">
                <i class="fa fa-binoculars" aria-hidden="true"></i>
                <span>Cupones</span>
            </a>
            <div id="collapseCupones" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('cupones.index') }}">Cupones</a>
                    <a class="collapse-item" href="{{ route('tipoCupones.index') }}">Tipo de cupones</a>
                    <a class="collapse-item" href="{{ route('categorias.index') }}">Categorias</a>
                    <a class="collapse-item" href="{{ route('traduccionCategorias.index') }}">Traducciones</a>
                </div>

            </div>
        </li>
    @endcan
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
    @can('streaming.view')
        <li class="nav-item active">
            <a class="nav-link" href="/streaming">
                <i class="fas fa-tv"></i>
                <span>Streaming</span></a>
        </li>
    @endcan

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBanca"
            aria-expanded="true" aria-controls="collapseBanca">
            <i class="fa fa-university" aria-hidden="true"></i>
            <span>Finanzas</span>
        </a>
        <div id="collapseBanca" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- @can('zonabancos.view') --}}
                {{-- @endcan
                    @can('prestamos.view') --}}
                <a class="collapse-item" href="{{ route('prestamos.index') }}">Tarifas Colombia</a>
                <a class="collapse-item" href="{{ route('prestamos.index') }}">Tarifas España</a>
                {{-- @endcan --}}
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAlarma"
            aria-expanded="true" aria-controls="collapseAlarma">
            <i class="fa fa-bullseye" aria-hidden="true"></i>
            <span>Seguros</span>
        </a>
        <div id="collapseAlarma" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- @can('zonabancos.view') --}}
                <a class="collapse-item" href="{{ route('alarmas.index') }}">Alarmas</a>
                <a class="collapse-item" href="{{ route('segurossalud.index') }}">Seguros de salud</a>
                {{-- <a class="collapse-item" href="{{ route('unificadoras.index') }}">Unificadoras</a>
                <a class="collapse-item" href="{{ route('microcreditos.index') }}">Microcreditos</a> --}}
                {{-- @endcan  --}}
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Página Web
    </div>
    @can('paginawebmenu.view')
        <li class="nav-item active">
            <a class="nav-link" href="/paginawebmenu">
                <i class="fa fa-bars" aria-hidden="true"></i>
                <span>Menú</span></a>
        </li>
    @endcan
    @can('paginawebfooter.view')
        <li class="nav-item active">
            <a class="nav-link" href="/paginaweb">
                <i class="fa-solid fa-layer-group"></i>
                <span>Footer</span></a>
        </li>
    @endcan
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Formularios
    </div>
    @can('formulariocontactenos.view')
        <li class="nav-item active">
            <a class="nav-link" href="/formulariocontactenos">
                <i class="fa fa-comments" aria-hidden="true"></i>
                <span>Contáctenos</span></a>
        </li>
    @endcan
    @can('formularionews.view')
        <li class="nav-item active">
            <a class="nav-link" href="/formularionews">
                <i class="fa fa-podcast" aria-hidden="true"></i>
                <span>NewsLetter</span></a>
        </li>
    @endcan
    @can('formularioleads.view')
        <li class="nav-item active">
            <a class="nav-link" href="/formularioleads">
                <i class="fa fa-child" aria-hidden="true"></i>
                <span>Leads</span></a>
        </li>
    @endcan
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Blog
    </div>
    @can('blog.view')
        <li class="nav-item active">
            <a class="nav-link" href="/blog">
                <i class="fa fa-inbox" aria-hidden="true"></i>
                <span>Blog</span></a>
        </li>
    @endcan
    <li class="text-center"><small>Version 1.0.2</small></li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline mt-5">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
