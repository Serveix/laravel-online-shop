@extends('layouts.housekeeping')

@section('title', '| Housekeeping')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1>PASO 2: SUBCATEGORIAS</h1>
            <h3><strong>Tipo de producto:</strong> {{ ucfirst( session('productTypeName') ) }}</h3>
            <h3><strong>Categoria de producto:</strong> {{ ucfirst( session('productCategoryName') ) }}</h3>
            
            <a href="{{route('hkload-categories')}}"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Atr&aacute;s</a><br/>
            <a href="{{ route('hkload-unset-sessions') }}"><i class="fa fa-step-backward" aria-hidden="true"></i> Salir y regresar al inicio</a>
            
            <hr/>
        <!-- ADD NEW SUBCATEGORY -->
            
            @if(session('productSubcategoryAdded'))
                <div class="alert alert-success">
                    Subcategoria de producto agregada con &eacute;xito.
                </div>
            @endif
            
            
            <form action="#" method="post">
                {{ csrf_field() }}
                    
                <label for="productSubcategoryName"><i class="fa fa-plus" aria-hidden="true"></i> Nombre de la subcategoria a agregar: </label>
                <input type="text" id="productSubcategoryName" class="form-control" name="productSubcategoryName" placeholder="Ej."/>
                <input type="submit" class="btn button button-default" id="addProductSubcategory" value="Agregar">
            </form>
            
            <br>
            <br>
            
        </div>
    <div>
</div>
@endsection
@section('script')
<script>
// document ready setup the best way http://gregfranko.com/jquery-best-practices/#/8
(function(yourcode) {
    yourcode(window.jQuery, window, document);
}(function($, window, document) {
    $(function() {
        // dom ready
    });
    // rest of the code here
    
    // enable/disable button
    $('#addProductSubcategory').prop('disabled',true);
    $('#productSubcategoryName').keyup(function(){
        $('#addProductSubcategory').prop('disabled', this.value == "" ? true : false);     
    });
     
}));
</script>
@endsection



