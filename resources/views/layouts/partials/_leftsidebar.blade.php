<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="user-pro"> 
                    <a class="has-arrow waves-effect waves-dark d-flex no-block" href="javascript:void(0)" aria-expanded="false">
                        <img src="{{asset('images/users/1.jpg')}}" alt="user-img" class="img-circle">
                        <span class="hide-menu text-truncate ">{{ Auth::user()->name }}</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <router-link :to="{name: 'spa'}"><i class="ti-user"></i> Perfil</router-link>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form-menu').submit();">
                                <i class="fa fa-power-off"></i> {{ __('Logout') }}
                            </a>
                            <!-- text-->
                            <form id="logout-form-menu" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                {{-- <div class="dropdown-divider"></div> --}}
                {{-- <li>
                    <router-link class="waves-effect waves-dark" :to="{ name: 'spa.dashboard'}" aria-expanded="false">
                        <i class="icon-speedometer"></i>
                        <span class="hide-menu">Dashboard </span>
                    </router-link>
                </li> --}}
                {{-- @if (in_array(Auth::user()->idrol, Rule::ADMINISTRATORS_ACCESS) && Auth::user()->idcuenta == Rule::SYSTEM_COMPANY_ACCOUNT) --}}
                @if (Auth::user()->idrol == Rule::SYSTEM_ADMIN_ROLE && Auth::user()->idcuenta == Rule::SYSTEM_COMPANY_ACCOUNT)
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="ti-panel"></i>
                        <span class="hide-menu">Sistema</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.rol'}">Rol</router-link></li>
                        <li><router-link :to="{name: 'spa.cuenta'}">Cuentas</router-link></li>
                        <li><router-link :to="{name: 'spa.tipoAtencion'}">Tipo de atención</router-link></li>
                        <li><router-link :to="{name: 'spa.administrarcliente'}">Administrar Cliente</router-link></li>  
                        <li><router-link :to="{name: 'spa.logerror'}">Log Error</router-link></li>  
                    </ul>
                </li>
                @endif
                @if (in_array(Auth::user()->idrol, Rule::ADMINISTRATORS_ACCESS))
                <li> 
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-user-lock"></i>
                        <span class="hide-menu">Administrador</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.user'}">Usuario</router-link></li>                          
                        <li><router-link :to="{name: 'spa.campania'}">Campañas</router-link></li>
                    </ul>
                </li>
                @endif
                <li> 
                    <router-link class="waves-effect waves-dark" :to="{name: 'spa.import'}" aria-expanded="false">
                        <i class="ti-server"></i>
                        <span class="hide-menu">Importar Registros</span>
                    </router-link>
                </li>
                {{-- <li> 
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-mail-bulk"></i>
                        <span class="hide-menu">Actividades MKT</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="javascript:void(0)">Eventos</a></li>
                        <li><a href="javascript:void(0)">Plantilla SMS</a></li>
                        <li><a href="javascript:void(0)">Plantilla Correo</a></li>
                        <li><a href="javascript:void(0)">Informe - Otros Canales</a></li>
                    </ul>
                </li>
                <li> 
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="ti-bookmark-alt"></i>
                        <span class="hide-menu">Mant. Generales</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="javascript:void(0)">Periodo</a></li>
                        <li><a href="javascript:void(0)">canal de venta</a></li>
                        <li><a href="javascript:void(0)">Producto</a></li>
                    </ul>
                </li> --}}
                <li> 
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-user-edit"></i>
                        <span class="hide-menu">Registros</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><router-link :to="{name: 'spa.cliente'}">Registros</router-link></li>
                        <li><router-link :to="{name: 'spa.atencion'}">Gestionar</router-link></li>
                        
                    </ul>
                </li>

                {{-- <li> 
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
                        <i class="fas fa-clipboard-check"></i>
                        <span class="hide-menu">Prospección</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="javascript:void(0)">Informe - eventos</a></li>
                    </ul>
                </li> --}}
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>