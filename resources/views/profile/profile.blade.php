@extends('layouts.default')

@section('title', ': Perfil ')

@section('content')

<div class="page-section title-area skyblue">
  <h1>Perfil</h1>
</div>

<div class="page-section ">
  <div class="container-fluid ">
      <div class="row">
         
        <!--Columna UNO-->
        <div class="col-md-4 col-md-offset-2"> 
          <h3>Información de la Cuenta</h3>
          
          <form class="form-horizontal" role="form">
            <label for="name" >Nombre *:</label>
            <input id="name" class="form-control" value="{{ $user_info->name }}" placeholder="John Doe" type="text">
            
            <label for="email" >Email *:</label>
            <input id="email" class="form-control" value="{{ $user_info->email }}" placeholder="john.doe@example.com" type="text">
            
            <button type="submit" class="btn button button-default">Guardar cambios</button>
          </form>    
          <br/><br/>
          
        </div>
          
        <div class=" col-md-4"> 
            <h3>Direcciones</h3>
            <ul align=left>
              <li><a href="{{route('shipping-address')}}">Ver o editar direccion de envio</a></li>
              <li><a href="{{route('billing-address')}}">Ver o editar direccion de facturacion</a></li>
            </ul>
            <hr/>
            <!--Historial de pedidos-->
            <h3 align=left>Mis pedidos</h3>
            <hr>
            <!--Historial de pedidos LINK-->
            <ul align=left>
              <li><a href="{{ route('active-orders') }}">Ver pedidos activos</a></li>
              <li><a href="{{ route('completed-orders') }}">Ver historial de pedidos completados</a></li>
            </ul>
            
          </div>
          
        </div>
  </div>
      
</div>
<div class="page-section"></div>


@endsection