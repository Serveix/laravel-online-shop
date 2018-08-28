@extends('layouts.default')

@section('title', 'Pago con banco')

@section('content')

<div class="page-section title-area skyblue">
  <h1>Pedido generado con &eacute;xito</h1>
</div>

<div class="page-section">
    <div class="container-fluid">
       
        <div class="row">

            <div class="col-md-8 col-md-offset-2 ">
                <ul>
                    <li>Podra acceder a su historial de pedidos y la informaci&oacute;n de cada uno en
                    la seccion <strong>Mis pedidos</strong> en su <a href="{{route('profile')}}">perfil</a>.</li>
                    
                    <li>Le agradecemos su compra y le recordamos que puede ponerse en contacto con nuestro soporte para cualquier duda en la seccion <a href="{{route('help')}}">Ayuda <i class="fa fa-question-circle" aria-hidden="true"></i></a>.</li>
                    
                    <li><i class="fa fa-info-circle" aria-hidden="true"></i> 
                    Su mercancia se separa en cuanto se realiza el pago. Para evitar contratiempos, le recomendamos hacer el pago a la brevedad.
                    </li>
                    <li><i class="fa fa-info-circle" aria-hidden="true"></i> 
                    Le recordamos que este pago puede tardar un m&iacute;nimo de <strong>tres d&iacute;as</strong> en acreditarse.
                    </li>
                </ul>
                <h3>Pago en tiendas</h3>
                @php ($urlToPDF = $storeSettings->find('openpay_dashboard_path')->value . '/paynet-pdf/' .
                                    $storeSettings->find('merchant_id')->value . '/' . 
                                    $reference )
                <object class="spei-pdf" data="{{$urlToPDF}}" type="application/pdf">
                    <embed src="{{$urlToPDF}}" type="application/pdf" />
                </object>

                <div class="not-printable">
                    <a href="{{ route('order', ['order' => $order->id]) }}" class="btn button button-default">Continuar al pedido <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                </div>



            </div>
        </div>
    </div>
</div> <!--/ page-section -->

<div class="not-printable">
    <!-- for separation purposes between content and footer -->
    <div class="page-section"></div>
    <div class="page-section"></div>
</div>


@endsection


