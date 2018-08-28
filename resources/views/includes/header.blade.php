<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Mostrar menu de navegacion de la pagina</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        
        
        <div id="logo-container">
          <!-- FIXME: - Change this jpeg logo to .SVG-->
          <a href="/"><img src="{{ asset('assets/svg/logo-karlo.svg') }}" /></a>
        </div>
        
        
      </div>
      
      <div class="col-md-7" >
        <form method="get" action="{{route('search')}}">
          <div class="search-bar-simulator">
            
            <select name="category" class="search-bar-select">
              <option value="all">Todas las categorias</option>
              @foreach(App\ProductType::all() as $productType)
              <option value="{{ $productType->slug }}">{{ ucfirst($productType->name) }}</option>
              @endforeach
            </select>
            
            
            <label for="search-text" class="sr-only">Producto a buscar</label>
            <input maxlength="100" id="search-text" type="text" name="q" class="search-bar-input text-field" placeholder="Buscar: " /> 
            
            
            
            <button type="submit" class="btn button button-default search-bar-button">
              <i class="fa fa-search" aria-hidden="true"></i>
            </button>
            
          </div>
          
        </form>
      </div>
      
      <div class="col-md-2 text-center">
          <div class="row">
            @if ( Auth::guest() )
            <div class="col-xs-6 col-md-12">
              <a class="btn button button-skyblue" href="{{ route('login') }}">Iniciar Sesión</a>
            </div>
        
            <div class="col-xs-6 col-md-12">
              <a class="btn button button-default" href="{{ route('register') }}">Registrarse </a>
            </div>
            @else
            <div class="col-md-12 text-center">
              Hola, <a href="/profile">{{ current(explode(' ', Auth::user()->name)) }} <i class="fa fa-user" aria-hidden="true"></i></a>
              (<a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">Salir</a>)
              
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
              </form>
            </div>
              @if (Auth::user()->rank == 0 ) 
              <!-- This get shown only if user is admin (rank is 0) -->
              <div class="col-md-12 text-center">
                <a href="/housekeeping">Housekeeping</a>
              </div>
              @endif
            @endif
            
          </div>

      </div>
      
    </div> <!--/.row-->
  </div><!--/.container-fluid-->
  
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ Request::is('/') ? 'active' : '' }}">
          <a href="/">
            <i class="fa fa-home" aria-hidden="true"></i>
            
            @if( Request::is('/'))
            <span class="sr-only">(current)</span>
            @endif
          </a>
        </li>
        <li class="{{ Request::is('about') ? 'active' : '' }}">
          <a href="/about">
            <i class="fa fa-users" aria-hidden="true"></i> <br/> NOSOTROS
            
            @if( Request::is('/about'))
            <span class="sr-only">(current)</span>
            @endif
          </a>
        </li>
        
        <li class="dropdown {{ Request::is('hardware') ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-microchip" aria-hidden="true"></i> <br/> HARDWARE <br/>
            <span class="caret"></span>
            
            @if( Request::is('/hardware'))
            <span class="sr-only">(current)</span>
            @endif
          </a>
          <ul class="dropdown-menu">
            <li><a href="/store/procesadores">PROCESADORES</a></li>
            <li><a href="/store/procesadores">TARJETAS MADRE</a></li>
            <li><a href="/store/memoria-ram">MEMORIA RAM</a></li> 
            <li><a href="/store/tarjetas-de-video">TARJETAS DE VIDEO</a></li>
            <li><a href="/store/fuentes-de-poder">FUENTES DE PODER</a></li>
            <li><a href="/store/discos-duro">DISCOS DURO</a></li>
            <li><a href="/store/discos-duro-solido">DISCOS DURO SOLIDO</a></li>
            <li><a href="/store/gabinetes">GABINETES</a></li>
            <li><a href="/store/enfriamiento">ENFRIAMIENTO</a></li>
            
            <!--<li role="separator" class="divider"></li>-->
          </ul>
        </li>
        
        
        <li class="dropdown {{ Request::is('copiado') ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-print" aria-hidden="true"></i> <br/>IMPRESIÓN<br/>
            <span class="caret"></span>
            
            @if( Request::is('/copiado'))
            <span class="sr-only">(current)</span>
            @endif
          </a>
          <ul class="dropdown-menu">
            <li><a href="/store/blanco-y-negro">IMPRESION</a></li>
            <li><a href="/store/multifuncionales">SCANNERS</a></li> 
            <li><a href="/store/suministros">CONSUMIBLES Y SUMINISTROS</a></li>
            <li><a href="/store/color">PUNTO DE VENTA</a></li> 
            <!--<li role="separator" class="divider"></li>-->
          </ul>
        </li>
          
          
          <li class="dropdown {{ Request::is('copiado') ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-window-maximize" aria-hidden="true"></i> <br/> SOFTWARE<br/>
            <span class="caret"></span>
            
            @if( Request::is('/copiado'))
            <span class="sr-only">(current)</span>
            @endif
          </a>
          <ul class="dropdown-menu">
            <li><a href="/store/color">PERSONALIZADO PARA TU EMPRESA</a></li> 
            <li role="separator" class="divider"></li>
            <li><a href="/store/blanco-y-negro">SISTEMAS OPERATIVOS</a></li>
            <li><a href="/store/multifuncionales">ANTIVIRUS</a></li> 
            <li><a href="/store/suministros">MICROSOFT OFFICE</a></li>
          </ul>
        </li> 

        <li class="dropdown {{ Request::is('copiado') ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-desktop" aria-hidden="true"></i> <br/> ELECTRONICA<br/>
            <span class="caret"></span>
            
            @if( Request::is('/copiado'))
            <span class="sr-only">(current)</span>
            @endif
          </a>
          <ul class="dropdown-menu">
            <li><a href="/store/color">LAPTOPS</a></li> 
            <li><a href="/store/color">DESKTOPS</a></li> 
            <li><a href="/store/color">TABLETS</a></li> 
            <li><a href="/store/blanco-y-negro">CAMARAS</a></li>
            <li><a href="/store/blanco-y-negro">MONITORES</a></li>
            <li><a href="/store/multifuncionales">TELEVISORES</a></li>
            <li><a href="/store/multifuncionales">ACCESORIOS PARA TV</a></li> 
            <li><a href="/store/color">DRONES</a></li> 
            <li><a href="/store/suministros">BOCINAS</a></li>
            <li><a href="/store/blanco-y-negro">PROYECTORES</a></li>
          </ul>
        </li> 


        <li class="dropdown {{ Request::is('copiado') ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-sitemap" aria-hidden="true"></i> <br/> REDES<br/>
            <span class="caret"></span>
            
            @if( Request::is('/copiado'))
            <span class="sr-only">(current)</span>
            @endif
          </a>
          <ul class="dropdown-menu">
            <li><a href="/store/blanco-y-negro">ACCESS POINT</a></li>
            <li><a href="/store/blanco-y-negro">ADAPTADORES</a></li>
            <li><a href="/store/blanco-y-negro">REPETIDORES</a></li>
            <li><a href="/store/blanco-y-negro">ROUTERS</a></li>
            <li><a href="/store/blanco-y-negro">SWITCH</a></li>
            <li><a href="/store/blanco-y-negro">TARJETAS RED</a></li>
            <li><a href="/store/blanco-y-negro">TARJETAS INALAMBRICAS</a></li>

          </ul>
        </li> 

        <li class="dropdown {{ Request::is('copiado') ? 'active' : '' }}">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-server" aria-hidden="true"></i> <br/> SERVIDORES
            <span class="caret"></span>
            
            @if( Request::is('/copiado'))
            <span class="sr-only">(current)</span>
            @endif
          </a>
          <ul class="dropdown-menu">
            <li><a href="/store/color">WORKSTATIONS</a></li> 
            <li><a href="/store/blanco-y-negro">SOFTWARE</a></li>
            <li><a href="/store/blanco-y-negro">RACK</a></li>
            <li><a href="/store/blanco-y-negro">TORRE</a></li>
          </ul>
        </li> 

          <li class="{{ Request::is('help') ? 'active' : '' }}">
            <a href="/help">
              <i class="fa fa-question-circle" aria-hidden="true"></i> <br/> AYUDA
              
              @if( Request::is('/contact'))
              <span class="sr-only">(current)</span>
              @endif
            </a>
            
          </li> 
          
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>