@extends('layouts.housekeeping')

@section('title', '| Housekeeping')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- SELECT NEW PRODUCT TYPE -->
        <div class="col-md-6 col-md-offset-3">
            <h1>TIPOS DE PRODUCTOS</h1>
            @if(session('productTypeSelected') === false)
                <div class="alert alert-danger">
                    Por favor, selecciona un tipo de producto antes de ir al siguiente paso.
                </div>
            @endif
            <form action="{{route('hkload-step1-session')}}" method="post">
                {{ csrf_field() }}
                
                <label for="product_type">Selecciona el tipo de producto que deseas modificar.</label><br/>
                <select id="product_type" name="productTypeId" class="form-control" >
                    @foreach($productTypes as $productType)
                        <option value="{{ $productType->id }}">{{ ucfirst( $productType->name ) }}</option>
                    @endforeach
                </select>
                
                <input type="submit" class="btn button button-default" value="Seleccionar">
                
                <hr/>
            </form>
        </div>
        
        <!-- ADD NEW PRODUCT TYPE -->
        <div class="col-md-6 col-md-offset-3">
            
            @if(session('productTypeAdded'))
                <div class="alert alert-success">
                    Tipo de producto agregado con exito.
                </div>
            @endif
            
            <a id="toggleNewProductType">
                <i class="fa fa-plus" aria-hidden="true"></i> Nuevo tipo de producto
            </a>
            
            <div id="newProductType">
                <form action="#" method="post">
                    {{ csrf_field() }}
                    
                    <label for="productTypeName">Nombre del tipo de producto: </label>
                    <input type="text" id="productTypeName" class="form-control" name="productTypeName" placeholder="Ej. Memoria RAM"/>
                    
                    <label for="productTypeNameSlug">Slug del nombre: </label>
                    <input type="text" id="productTypeNameSlug" class="form-control" name="productTypeNameSlug" placeholder="Ej. memoria-ram"/>

                    <input type="submit" class="btn button button-default" id="addProductType" value="Agregar">
                </form>
            </div>
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



