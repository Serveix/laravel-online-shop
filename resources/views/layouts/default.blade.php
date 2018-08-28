<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <meta name="description" content="Tienda en linea de hardware, electronica y servicios de software"/>
        <meta name="keywords" content="tienda en linea, hardware, electronica, servicios, segura, sencilla"/>
        
        <!--<meta property="og:url" content="http://" />-->
        <!--<meta property="og:type" content="Tienda en linea" />-->
        <meta property="og:title" content="KarloServices" />
        <meta property="og:description" content="Tienda en linea de hardware, electronica y servicios" />
        <!--<meta property="og:image" content=" " />-->
        
        <!--FAVICON-->
        <link rel="shortcut icon" href="{{ asset('assets/favicon/') }}favicon.ico" type="image/x-icon">
        <link rel="icon" href="{{ asset('assets/favicon/') }}favicon.ico" type="image/x-icon">
        
        <!--FAVICON ICON MOBILE -->
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/favicon/') }}apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favicon/') }}apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/favicon/') }}apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/') }}apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/favicon/') }}apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/favicon/') }}apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/favicon/') }}apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favicon/') }}apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/') }}apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('assets/favicon/') }}android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/') }}favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/') }}favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/') }}favicon-16x16.png">
        
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        
        <title>KarloServices - @yield('title')</title>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
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
        <div class="not-printable">
            @include('includes.header')
        </div>

        @yield('content')

        <div class="not-printable">
            @include('includes.footer')
        
            @include('includes.cart')
        </div>
        
        <script>
        (function(yourcode) {
            yourcode(window.jQuery, window, document);
        }(function($, window, document) {
            $(function() { 
                //dom ready
            });
            
            var searchBarButton = $('.search-bar-button');
            var searchBarInput = $('.search-bar-input');
            
            searchBarButton.prop('disabled', true);
            
            searchBarInput.keyup(function() {
                searchBarButton.prop('disabled', this.value == '' ? true : false);
            });
            
        }));
        </script>
        
        @yield('script')
        
        <script src="{{asset('js/store.js')}}"></script>
    </body>
</html>



