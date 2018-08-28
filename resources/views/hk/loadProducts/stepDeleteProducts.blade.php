@extends('layouts.housekeeping')

@section('title', '| Housekeeping')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- SELECT NEW PRODUCT TYPE -->
        <div class="col-md-6 col-md-offset-3">
            <h1>ELIMINAR PRODUCTOS</h1>
            <h3><strong>Tipo de producto:</strong> {{ ucfirst( session('productTypeName') ) }}</h3>
            <a href="{{route('hkload-step-pick')}}"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Atr&aacute;s</a><br/>
            <a href="{{ route('hkload-unset-sessions') }}"><i class="fa fa-step-backward" aria-hidden="true"></i> Salir y regresar al inicio</a>
            
           <hr/>
           @if( session('productDeleted') )
                <div class="alert alert-success">
                    Producto eliminado con &eacute;xito.
                </div>
            @endif
            
            @if( session('productDeletedFailed') )
                <div class="alert alert-danger">
                    Ocurrio un error al eliminar el producto.
                </div>
            @endif
            <form action="{{route('hkload-delete-products')}}" method="post">
                {{ csrf_field() }}
                
                @if($products->count() > 0 )
                <label for="product">Selecciona el producto que deseas eliminar</label><br/>
                <select id="product" name="productId" class="form-control" >
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ ucfirst( $product->name ) }}</option>
                    @endforeach
                </select>
                
                <input type="submit" class="btn button button-default" value="Eliminar">
                @else
                    No hay productos. <a href="{{route('hkload-products')}}">Agregar</a>
                @endif
                <hr/>
            </form>
        </div>
        
    <div>
</div>
@endsection

@section('script')
<script>
// jquery document.ready() set up the best way http://gregfranko.com/jquery-best-practices/#/8
(function(yourcode) {
    yourcode(window.jQuery, window, document);
}(function($, window, document) {
    $(function() {
        //dom ready
    });  
    // rest of the code here
    
    
    // show and hide product type adding menu
    $("#newProductType").hide();
    $("#toggleNewProductType").click(function() {
        $("#newProductType").toggle();
    });
    
    // enable/disable button
    $('#addProductType').prop('disabled',true);
    $('#productTypeName').keyup(function(){
        $('#addProductType').prop('disabled', this.value == "" ? true : false);     
    });
        
    
}));
 
</script>
@endsection



