@extends('layouts.housekeeping')

@section('title', '| Housekeeping')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- SELECT NEW PRODUCT TYPE -->
        <div class="col-md-6 col-md-offset-3">
            <h1>PASO 1: CATEGORIAS</h1>
            <h3><strong>Tipo de producto:</strong> {{ ucfirst( session('productTypeName') ) }}</h3>
            @if(session('productCategorySelected') === false)
                <div class="alert alert-danger">
                    Por favor, selecciona una categoria antes de avanzar al siguiente paso.
                </div>
            @endif
            
            <a href="{{ route('hkload-step-pick') }}"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Atr&aacute;s</a><br/>
            <a href="{{ route('hkload-unset-sessions') }}"><i class="fa fa-step-backward" aria-hidden="true"></i> Salir y regresar al inicio</a>
            
            <hr/>
            <form action="{{ route('hkload-categories-session') }}" method="post">
                {{ csrf_field() }}
                
                <label for="product_category">Elije una categoria y presiona <i>Seleccionar</i> para ver sus subcategorias.</label><br/>
                <select id="product_category" name="productCategoryId" class="form-control" >
                    @if($productCategories != null)
                    @foreach($productCategories as $productCategory)
                        <option value="{{ $productCategory->id }}">{{ ucfirst( $productCategory->name ) }}</option>
                    @endforeach
                    @endif
                </select>
                
                <input type="submit" class="btn button button-default" value="Seleccionar"><br>
                
                
                <hr/>
            </form>
        </div>
        
        <!-- ADD NEW PRODUCT TYPE -->
        <div class="col-md-6 col-md-offset-3">
            
            @if(session('productCategoryAdded'))
                <div class="alert alert-success">
                    Categoria de producto agregada con &eacute;xito.
                </div>
            @endif
            
            <a id="toggleNewProductCategory">
                <i class="fa fa-plus" aria-hidden="true"></i> Nueva categoria de producto
            </a>
            
            <div id="newProductCategory">
                <form action="#" method="post">
                    {{ csrf_field() }}
                    
                    <label for="productTypeName">Nombre de la categoria: </label>
                    <input type="text" id="productCategoryName" class="form-control" name="productCategoryName" placeholder="Ej. Marca"/>
                    <input type="submit" class="btn button button-default" id="addProductCategory" value="Agregar">
                </form>
            </div> <br>
            <br>
            
            
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
        // dom ready
    });   
    // rest of the code here
    
    // show and hide product type adding menu
    $("#newProductCategory").hide();
    $("#toggleNewProductCategory").click(function() {
        $("#newProductCategory").toggle();
    });
    
    // enable/disable button
    $('#addProductCategory').prop('disabled',true);
    $('#productCategoryName').keyup(function() {
        $('#addProductCategory').prop('disabled', this.value == "" ? true : false);     
    });
   
}));
</script>
@endsection



