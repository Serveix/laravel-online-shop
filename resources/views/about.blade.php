@extends('layouts.default')
@section('title', 'Nosotros')
@section('content')

<div class="page-section title-area skyblue">
  <h1>Nosotros</h1>
</div>
<div id="title-area-video">
    <video playsinline autoplay muted loop data-video="0">
        <source src="{{asset('assets/img/about/smiling.mp4')}}" type="video/mp4">
        {{-- <source src="https://storage.googleapis.com/snapchat-web/geofilters/splash-video/63fc2a7e-a18c-4e2f-9ab8-b46980013bbc.webm" type="video/webm"> --}}
    </video>

    <!-- <iframe src="http://www.youtube.com/embed/Zl4_98eVGk4?controls=0&showinfo=0&rel=0&autoplay=1&fs=0&loop=1&playlist=Zl4_98eVGk4" frameborder="0"></iframe> -->
</div>

<div class="page-section">
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-md-12">
                <div class="about-balls">
                    <div class="col-md-3">
                        <img class="img-circle" src="{{asset('assets/img/about/icons/vision.png')}}" alt="Generic placeholder image" width="150" height="150">
                        <h3>Visi&oacute;n</h3>
                        <p>Ser una empresa mexicana l&iacute;der en el mercado.</p>
                        <hr/>
                    </div> 
                    <div class="col-md-3">
                        <img class="img-circle" src="{{asset('assets/img/about/icons/experiencia.png')}}" alt="Generic placeholder image" width="150" height="150">
                        <h3>Experiencia</h3>
                        <p>Con mas de 30 a&ntilde;os de experiencia en el area tecnolog&iacute;ca, te 
                        ofrecemos una amplia gama de productos, servicios y asesoria especializada.  </p>
                        <hr/>
                    </div> 
                    <div class="col-md-3">
                        <img class="img-circle" src="{{asset('assets/img/about/icons/satisfaccion.png')}}" alt="Generic placeholder image" width="150" height="150">
                        <h3>Satisfacci&oacute;n</h3>
                        <p>Desde una sola persona hasta una empresa, nos ajustamos a tu necesidad con sentido humano y dando importancia a que tengas
                        una buena experiencia de compra.</p>
                        <hr/>
                    </div> 
                    <div class="col-md-3">
                        <img class="img-circle" src="{{asset('assets/img/about/icons/seguridad.png')}}" alt="Generic placeholder image" width="150" height="150">
                        <h3>Seguridad</h3>
                        <p>Desde que te registras estas protegido por un sitio web personalizado y creado desde 0, con un certificado SSL
                        de 256 bits para que todos tus datos esten siempre encriptados.</p>
                        <hr/>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<div class="page-section"></div>



@endsection
