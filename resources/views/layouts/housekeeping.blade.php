<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!--FAVICON-->
        <link rel="shortcut icon" href="/img/Favicon/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/img/Favicon/favicon.ico" type="image/x-icon">
        
        <title>Housekeeping: @yield('title')</title>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        
        <script src="//cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
        
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        
        <link rel="stylesheet" href="{{ asset('css/hk.css') }}">  
        

        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    </head>
    <body>
        
        <!-- !!! HEADER !!! -->
        <nav class='sidebar sidebar-menu-collapsed'> <a href='#' id='justify-icon'>
        <span class='glyphicon glyphicon-align-justify'></span>
          </a>
    
            <ul class='level1'>
                <li @if( Request::is('housekeeping')) class='active' @endif >
                    <a class='expandable' href="{{ route('hkindex') }}" title='Dashboard'>
                        <span class='glyphicon glyphicon-home collapsed-element'></span>
                        <span class='expanded-element'>Dashboard</span>
                    </a>
                    
                </li>
                
                <li @if( Request::is('housekeeping/store')) class='active' @endif > 
                    <a class='expandable' href="{{ route('hkstore') }}" title='Configuracion de la Tienda'>
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        <span class='expanded-element'>Tienda</span>
                    </a>
                </li>
                
                <li @if( Request::is('housekeeping/products/load')) class='active' @endif > 
                    <a class='expandable' href="{{ route('hkload-step1') }}" title='Cargar productos'>
                        <i class="fa fa-book" aria-hidden="true"></i>
                        <span class='expanded-element'>Productos</span>
                    </a>
                </li>

                <li @if( Request::is('housekeeping/orders')) class='active' @endif > 
                    <a class='expandable' href="{{ route('hkorders') }}" title='Cargar productos'>
                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                        <span class='expanded-element'>Ordenes</span>
                    </a>
                </li>
                
                
                
            </ul> <a href='/' id='logout-icon' title='Regresar al sitio'>
            <span class='glyphicon glyphicon-off'></span>
            
          </a>
    
        </nav>
        
        
        
        <div class="hk-content">
            <h1>KarloServices HOUSEKEEPING</h1>
            <h2>Ordenes</h2>
            <hr/>
            @yield('content')
        </div>

        <script src="/js/hk.js"></script>
        <script>
            (function () {
                $(function () {
                    var SideBAR;
                    SideBAR = (function () {
                        function SideBAR() {}
            
                        SideBAR.prototype.expandMyMenu = function () {
                            return $("nav.sidebar").removeClass("sidebar-menu-collapsed").addClass("sidebar-menu-expanded");
                        };
            
                        SideBAR.prototype.collapseMyMenu = function () {
                            return $("nav.sidebar").removeClass("sidebar-menu-expanded").addClass("sidebar-menu-collapsed");
                        };
            
                        SideBAR.prototype.showMenuTexts = function () {
                            return $("nav.sidebar ul a span.expanded-element").show();
                        };
            
                        SideBAR.prototype.hideMenuTexts = function () {
                            return $("nav.sidebar ul a span.expanded-element").hide();
                        };
            
                        SideBAR.prototype.showActiveSubMenu = function () {
                            $("li.active ul.level2").show();
                            return $("li.active a.expandable").css({
                                width: "100%"
                            });
                        };
            
                        SideBAR.prototype.hideActiveSubMenu = function () {
                            return $("li.active ul.level2").hide();
                        };
            
                        SideBAR.prototype.adjustPaddingOnExpand = function () {
                            $("ul.level1 li a.expandable").css({
                                padding: "1px 4px 4px 0px"
                            });
                            return $("ul.level1 li.active a.expandable").css({
                                padding: "1px 4px 4px 4px"
                            });
                        };
            
                        SideBAR.prototype.resetOriginalPaddingOnCollapse = function () {
                            $("ul.nbs-level1 li a.expandable").css({
                                padding: "4px 4px 4px 0px"
                            });
                            return $("ul.level1 li.active a.expandable").css({
                                padding: "4px"
                            });
                        };
            
                        SideBAR.prototype.ignite = function () {
                            return (function (instance) {
                                return $("#justify-icon").click(function (e) {
                                    if ($(this).parent("nav.sidebar").hasClass("sidebar-menu-collapsed")) {
                                        instance.adjustPaddingOnExpand();
                                        instance.expandMyMenu();
                                        instance.showMenuTexts();
                                        instance.showActiveSubMenu();
                                        $(this).css({
                                            color: "#000"
                                        });
                                    } else if ($(this).parent("nav.sidebar").hasClass("sidebar-menu-expanded")) {
                                        instance.resetOriginalPaddingOnCollapse();
                                        instance.collapseMyMenu();
                                        instance.hideMenuTexts();
                                        instance.hideActiveSubMenu();
                                        $(this).css({
                                            color: "#FFF"
                                        });
                                    }
                                    return false;
                                });
                            })(this);
                        };
            
                        return SideBAR;
            
                    })();
                    return (new SideBAR).ignite();
                });
            
            }).call(this);
        </script>

        @yield('script')
    </body>
</html>



