<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        {{-- Home --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/home') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">{{ _('Inicio') }}</span>
            </a>
        </li>
        {{-- End Home --}}

        @if (auth()->user()->isAdmin())
            {{-- Elementos Administrativos --}}
            <li class="nav-item nav-category">{{ _('Elementos Administrativos') }}</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-users" aria-expanded="false"
                    aria-controls="ui-users">
                    <i class="menu-icon mdi mdi mdi-account-multiple"></i>
                    <span class="menu-title">{{ _('Usuarios') }}</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-users">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link"
                                href="{{ route('usuarios.index') }}">{{ _('Todos los Usuarios') }}</a></li>
                        {{-- <li class="nav-item"> <a class="nav-link"
                                href="{{ route('usuarios.create') }}">{{ _('Añadir Usuario') }}</a></li> --}}
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-rol" aria-expanded="false"
                    aria-controls="ui-rol">
                    <i class="menu-icon mdi mdi-key-variant"></i>
                    <span class="menu-title">{{ _('Roles de Usuario') }}</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-rol">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link"
                                href="{{ route('roles.index') }}">{{ _('Roles de Usuario') }}</a></li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="{{ route('auditory.index') }}" class="nav-link">
                    <i class="menu-icon mdi mdi-history"></i>
                    <span class="menu-title">{{ 'Historial de Cambios' }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('budgets.index') }}" class="nav-link">
                    <i class="menu-icon mdi mdi-cash-multiple"></i>
                    <span class="menu-title">{{ _('Presupuesto Meltec') }}</span>
                </a>
            </li>

            {{-- Fin Elementos Administrativos --}}
        @endif

        {{-- Elementos de informes SAP --}}
        @if (auth()->user()->kpiViewAuthorization())
            <li class="nav-item nav-category">{{ _('Informes SAP') }}</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#ui-informes" aria-expanded="false"
                    aria-controls="ui-informes">
                    <i class="menu-icon mdi mdi mdi-file-document"></i>
                    <span class="menu-title">{{ _('Informes') }}</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-informes">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link"
                                href="{{ url('/home/reports') }}">{{ _('Informe de reportes SAP') }}</a></li>
                    </ul>
                </div>
            </li>
        @endif
        {{-- Fin Elementos de informes SAP --}}
        {{-- Administrador de sitio --}}

        <li class="nav-item nav-category">{{ _('Administrador del Sitio') }}</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-blog" aria-expanded="false"
                aria-controls="form-elements">
                <i class="menu-icon mdi mdi-card-text-outline"></i>
                <span class="menu-title">{{ _('Blogs y Noticias') }}</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-blog">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('blogs.index') }}">{{ _('Todos los Blogs y Noticias') }}</a></li>
                    <li class="nav-item"><a class="nav-link"
                            href="{{ route('categorias.index') }}">{{ _('Categorias') }}</a></li>
                </ul>
            </div>
        </li>

        @if (auth()->user()->can('ver-pagina'))
            {{-- Paginas --}}
            <li class="nav-item">
                <a href="#ui-pages" class="nav-link" data-bs-toggle="collapse" aria-expanded="false"
                    aria-controls="form-elements">
                    <i class="menu-icon mdi mdi-menu"></i>
                    <span class="menu-title">{{ _('Paginas') }}</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-pages">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a href="{{ route('menus.index') }}"
                                class="nav-link">{{ _('Administrador de Paginas') }}</a></li>
                        <li class="nav-item"><a href="{{ route('menus.create') }}"
                                class="nav-link">{{ _('Nueva Pagina') }}</a></li>
                        <li class="nav-item"><a href="{{ route('casosdeexito.index') }}"
                                class="nav-link">{{ _('Casos de Exito') }}</a></li>
                        <li class="nav-item"><a href="{{ route('ventajas.index') }}" class="nav-link">
                                {{ _('Ventajas') }} </a></li>
                    </ul>
                </div>
            </li>
            {{-- Fin Paginas --}}

            {{-- Productos --}}
            <li class="nav-item">
                <a href="#ui-products" class="nav-link" data-bs-toggle="collapse" aria-expanded="false"
                    aria-controls="form-elements">
                    <i class="menu-icon mdi mdi-cart"></i>
                    <span class="menu-title">{{ _('Productos') }}</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-products">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a href="{{ route('products.index') }}"
                                class="nav-link">{{ _('Todos los productos') }}</a></li>
                    </ul>
                </div>
            </li>
            {{-- Fin Productos --}}
        @endif

        <li class="nav-item">
            <a class="nav-link" href="{{ route('gallery.index') }}">
                <i class="menu-icon mdi mdi-folder-image"></i>
                <span class="menu-title">{{ _('Galeria de Imagenes') }}</span>
            </a>
        </li>
        {{-- Fin Administrador de sitio --}}

        <li class="nav-item nav-category">{{ _('Sitio web Principal') }}</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/') }}">
                <i class="menu-icon mdi mdi-home"></i>
                <span class="menu-title">{{ _('Visitar el sitio Web') }}</span>
            </a>
        </li>
    </ul>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}">
            <i class="dropdown-item-icon mdi mdi-power"></i>
            <span class="menu-title">{{ _('Cerrar Sesion') }}</span>
        </a>
    </li>
</nav>
