@extends('layouts.default')

@section('title', 'Pago con banco')

@section('content')

<div class="page-section title-area skyblue">
  <h1>Pedido generado con &eacute;xito</h1>
</div>

<div class="page-section">
    <div class="container-fluid">
        @if (session('transaction-errors'))
        <div class="alert alert-danger">
            <ul>
                {{ session()->get('transaction-errors') }}
            </ul>
        </div>
        @endif
        <div class="row">

            <div class="col-md-8 col-md-offset-2 ">
                <p>Podra acceder a su historial de pedidos y la informaci&oacute;n de cada uno en
                la seccion <strong>Mis pedidos</strong> en su <a href="{{route('profile')}}">perfil</a>.</p>
                
                <p>Le agradecemos su compra y le recordamos que puede ponerse en contacto con nuestro soporte para cualquier duda en la seccion <a href="{{route('help')}}">Ayuda <i class="fa fa-question-circle" aria-hidden="true"></i></a>.</p>
                
                <p><i class="fa fa-info-circle" aria-hidden="true"></i> 
                Su mercancia se separa en cuanto se realiza el pago. Para evitar contratiempos, le recomendamos hacer el pago a la brevedad.
                </p>
                <h3>Pago en banco</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr class="info">
                            <td colspan="2"><h4>Transferencia bancaria o pago en ventanilla</h4></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-right" style="width: 40%;"> <strong>Banco</strong></td>
                            <td  style="width: 60%;">{{ $bankInfo['bank'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="width: 40%;"><strong>Titular</strong></td>
                            <td  style="width: 60%;">{{ $bankInfo['titular'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="width: 40%;"><strong>C.L.A.B.E.</strong></td>
                            <td  style="width: 60%;">{{ $bankInfo['clabe'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="width: 40%;"><strong>Referencia</strong></td>
                            <td  style="width: 60%;">{{ $order->id + 1000 }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="width: 40%;"><strong>Sucursal</strong></td>
                            <td  style="width: 60%;">{{ $bankInfo['sucursal'] }}</td>
                        </tr>
                        <tr>
                            <td class="text-right" style="width: 40%;"><strong>Cuenta</strong></td>
                            <td  style="width: 60%;">{{ $bankInfo['cuenta'] }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="not-printable">
                    <BR/>
                    <a href="javascript:window.print()" class="btn button button-blue"><i class="fa fa-print" aria-hidden="true"></i> Imprimir informaci&oacute;n</a>
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


{{-- Esto es lo que estaba antes, con el sistema de pago de banco de openpay...
    @php ($urlToPDF = 'https://sandbox-dashboard.openpay.mx/spei-pdf/'.$merchantId.'/'.$orderInfo->invoice->payment->transaction_info )
    <object class="spei-pdf" data="{{$urlToPDF}}" type="application/pdf">
        <embed src="{{$urlToPDF}}" type="application/pdf" />
    </object>
--}}
@endsection


