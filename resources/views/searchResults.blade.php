@extends('layouts.default')

@section('title', '| Resultados de busqueda')

@section('content')


<div class="page-section">
    
    <div class="container-fluid">
        <div class="row">
            
            <!-- CATALOG SHOWING COLUMN -->
            <div class="col-md-10 col-md-offset-1 no-padding">
                <h2 class="header-box header-box-red">
                    Busqueda en {{ $searchCategoryName }}
                </h2>
                
                <div class="container-fluid">
                    <div class="row productCatalog">
                        <h4><strong>Resultados({{ $products->count() }}) de </strong>"{{ $searchQuery }}" </h4>
                        <!-- Section updated from AJAX -->
                        @foreach($products as $product)
                        <div class="col-md-12"> 
                            <div class="container-fluid product-container">
                                
                                <div class="row">
                                    <div class="col-md-2 text-center">
                                        <a href="{{route('product-page', ['product' => $product->id]) }}">
                                            <img class="product-img " src="{{ asset('/assets/img/product_img/' . $product->img_name) }}" alt="img"/>
                                        </a>    
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <img class="manufacturer-logo" src="{{ asset('/assets/img/manufacturer_img/' . $product->manufacturerImgName().'.png' ) }}">
                                        <p class="product-sku">
                                            SKU: {{ $product->id + 1000 }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 >
                                            <a href="{{ route('product-page', ['product' => $product->id]) }}">
                                                <strong>{{ $product->name }}</strong>
                                            </a>
                                        </h4>
                                        
                                        <p class="product-description">{!! $product->description !!}</p>
                                        
                                    </div>
                                    
                                    <div class="col-md-3 text-center">
                                        
                                        <p class="product-price ">
                                            $ {{ $product->finalPrice() }} MXN<br/><small>IVA incluido</small>
                                        </p>
                                       
                                        
                                        <button class="btn button button-default add-to-cart" value="{{ $product->id }}">
                                            Agregar! <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        </button>
                                        <img class="cart-add-loading-{{ $product->id }} hidden" src="{{asset('assets/img/loading.gif')}}" />
                                        
                                        <div class="alert alert-danger hidden item-error-{{ $product->id }} "> </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- / CATALOG SHOWING COLUMN -->
            
        </div> <!-- /row -->
    </div><!-- / container fluid -->
</div> <!-- / page-section -->

<!-- for separation purposes between content and footer -->
<div class="page-section"></div>
@endsection

