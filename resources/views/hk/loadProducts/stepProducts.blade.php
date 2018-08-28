@extends('layouts.housekeeping')

@section('title', '| Housekeeping')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- SELECT NEW PRODUCT TYPE -->
        <div class="col-md-6 col-md-offset-3">
            <h1>CARGAR PRODUCTOS</h1>
            <h3><strong>Tipo de producto:</strong> {{ ucfirst( session('productTypeName') ) }}</h3>
            
            <a href="{{route('hkload-step-pick')}}"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Atr&aacute;s</a><br/>
            <a href="{{ route('hkload-unset-sessions') }}"><i class="fa fa-step-backward" aria-hidden="true"></i> Salir y regresar al inicio</a>
            
            <hr/>
        </div>
        
        <!-- ADD NEW PRODUCT TYPE -->
        <div class="col-md-6 col-md-offset-3">
            
            @if( session('productAdded') )
                <div class="alert alert-success">
                    Producto agregado con &eacute;xito.
                </div>
            @endif
            
            @if( session('invalidProductImg') )
                <div class="alert alert-danger">
                    Error al subir la imagen.
                </div>
            @endif
            
            @if( session('emptyInput') )
                <div class="alert alert-danger">
                    No olvides llenar todos los campos
                </div>
            @endif
            
            @if( session('invalidPrice') )
                <div class="alert alert-danger">
                    Precio invalido
                </div>
            @endif
            
            <form action="#" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="productName">Nombre del producto: </label>
                    <input type="text" id="productName" class="form-control" name="productName" placeholder="Ej: Intel Core i7 7700"/>
                </div>
                
                <div class="form-group">
                    <label for="productPrice">Precio ( USD ): </label>
                    <input type="text" id="productPrice" class="form-control" name="productPrice" placeholder="Ej: 55.00"/>
                </div>
                
                <div class="form-group">
                    <label for="productDescription">Descripci&oacute;n: </label>
                    <textarea class="form-control" id="productDescription" name="productDescription" placeholder="(150 caracteres max) Ej: Procesador que nos ofrece..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="productDetails">Detalles: </label>
                    <textarea class="form-control" id="productDetails" name="productDetails" placeholder="Ej. ~Tablas e imagenes con detalles del producto~"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="productInStock">Productos en stock: </label>
                    <input type="number" id="productInStock" class="form-control" name="productInStock" placeholder="Ej: 23"/>
                </div>
                
                <div class="form-group">
                    <label for="productGuarantee">Garantia del producto: </label>
                    <input type="text" id="productGuarantee" class="form-control" name="productGuarantee" placeholder="Ej: de por vida, directa con 36 MESES de vigencia, etc."/>
                </div>
                
                <div class="form-group">
                    <label for="productImg">Imagen del Producto</label>
                    <input type="file" name="productImg" id="productImg">
                    <p class="help-block">Preferentemente .jpg con las medidas correspondientes</p>
                </div>
                
                <div class="form-group">
                    <!-- productData is a bidimensional array. See more of how its composed in the controller -->
                    @for( $i = 0 ; $i < count($productCategories) ; $i++ )
                    <label for="product_subcategory">{{ ucfirst( $productCategories[$i]->name ) }}<br/>
                    <select id="product_subcategory" name="productSubcategoryId{{ $i }}" class="form-control" >
                        <option value="default">Ninguna</option>
                        @foreach($productCategories[$i]->subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ ucfirst( $subcategory->name ) }}</option>
                        @endforeach
                    </select>
                    @endfor
                </div>
                
                <input type="hidden" name="numberOfCategories" value="{{ count( $productCategories ) }}">
                
                <input type="submit" class="btn button button-default" id="addProduct" value="Agregar">
                <p class="text-warning">* OJO: Para activar el boton, hay que llenar los campos de arriba hacia abajo.</p>
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
    //rest of the code here
    
    
    
    CKEDITOR.replace( 'productDetails' );
     
}));
</script>
@endsection

