@extends('layouts.default')

@section('title', 'Ubicación')

@section('content')
<div class="page-section title-area skyblue">
  <h1>Ubicaci&oacute;n</h1>
</div>
<div class="page-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-1"> 
                <h1><i class="fa fa-map-marker pastel-red-text" aria-hidden="true"></i> Oficinas Monterrey</h1>
                <hr>
                <h2>Direcci&oacute;n</h2>
                <p>
                    Av. Guerrero 2804A <br/>
                    Col. Regina <br/>
                    Monterrey, Nuevo Le&oacute;n <br>
                    C.P. 64290
                </p>
                <h2>Horarios</h2>
                <p>Lunes a viernes de 8:00 a.m. a 6:00 p.m.</p>

                <h2>Contacto</h2>
                <p>
                    <strong>Atencion telefonica: </strong> (81) 83317659<br/>
                    <strong>Soporte: </strong> <a href="mailto:soporte@karloservices.com">soporte@karloservices.com</a>
                </p>
            </div>
            
            <div class="col-md-6"> 
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3594.974630483184!2d-100.31172168498023!3d25.705263983662462!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3a6aecd9ec3952b8!2sKarlo+Services+S.A.+de+C.V.!5e0!3m2!1ses!2smx!4v1502029101011" style="width:100%;height:500px" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<div class="page-section"></div>

<hr></hr>



   

@endsection