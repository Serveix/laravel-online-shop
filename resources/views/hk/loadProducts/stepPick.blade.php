@extends('layouts.housekeeping')

@section('title', '| Housekeeping')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- SELECT NEW PRODUCT TYPE -->
        <div class="col-md-6 col-md-offset-3">
            <h1>&iquest;EDITAR PRODUCTOS O CATEGORIAS/SUBCATEGORIAS?</h1>
            <a href="{{ route('hkload-unset-sessions') }}"><i class="fa fa-step-backward" aria-hidden="true"></i> Regresar al inicio</a>
            <hr/>
            <a class="btn button button-default productsBtn">Productos</a> 
            <a  class="btn button button-default categoriesBtn">Categorias/subcategorias</a>
        
            
            <ul class="products-options">
                Productos:
                <li><a href="{{ route('hkload-products') }}">Agregar productos</a></li>
                <li><a href="{{ route('hkload-delete-products') }}">Eliminar productos</a></li>
            </ul>
            
            <ul class="categories-options">
                Categorias/subcategorias:
                <li><a href="{{ route('hkload-categories') }}">Agregar cat/subcat</a></li>
                <li><a href="#">[ NOT WORKING ] Eliminar cat/subcat</a></li>
            </ul>
            
        </div>
        
        
    <div>
</div>


@endsection

@section('script')

<script>
    // IIFE - Immediately Invoked Function Expression
(function(yourcode) {
    yourcode(window.jQuery, window, document);
}(function($, window, document) {
    $(function() {
        // The DOM is ready!
    });
    
    var productsOptions = $('.products-options');
    var categoriesOptions = $('.categories-options');
    
    productsOptions.hide();
    categoriesOptions.hide();
    
    $('.productsBtn').click(function() {
        productsOptions.show();
        categoriesOptions.hide();
    });
    
    $('.categoriesBtn').click(function() {
        productsOptions.hide();
        categoriesOptions.show();
    });
    
    
}));
</script>

@endsection



