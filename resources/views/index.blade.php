@extends('layouts.default')

@section('title', 'Inicio')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="carousel-wrapper">
                <img id="img2" class="img-responsive center-block" src="{{asset('assets/img/promos/nuevos-ryzen.jpg')}}">
                <img id="img1" class="img-responsive center-block" src="{{asset('assets/img/promos/software-personalizado.jpg')}}">
            </div>
        </div>
    </div>
</div>

<div class="page-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <h2 class="text-center">Popular</h2>
                <ul class="list-unstyled">
                    @foreach($rProducts as $product)
                    <li>
                        <div class="container-fluid product-display">
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <a href="{{route('product-page', ['product' => $product->id]) }}">
                                        <img src="{{ asset('assets/img/product_img/'.$product->img_name) }}" height="120" class="img-circle center-block" alt="gray square">
                                    </a>
                                </div>
                                <div class="col-xs-6 col-md-6">
                                    <h4 class="name">
                                        <a href="{{route('product-page', ['product' => $product->id]) }}">
                                            <strong>{{$product->name}}</strong>
                                        </a>
                                    </h4>
                                </div>
                                <div class="col-xs-6 col-md-6">
                                    <p class="product-price"> ${{ number_format($product->finalPrice(), 2, '.', ',') }} </p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <hr/>
                    @endforeach
                </ul>
            </div>
            
            <div class="col-md-4">
                <h2 class="text-center">Lo mas vendido</h2>
                <ul class="list-unstyled">
                    @foreach($rProducts2 as $product)
                    <li>
                        <div class="container-fluid product-display">
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <a href="{{route('product-page', ['product' => $product->id]) }}">
                                        <img src="{{ asset('assets/img/product_img/'.$product->img_name) }}" height="120" class="img-circle center-block" alt="gray square"></div>
                                    </a>
                                <div class="col-xs-6 col-md-6">
                                    <h4 class="name">
                                        <a href="{{route('product-page', ['product' => $product->id]) }}">
                                            <strong>{{$product->name}}</strong>
                                        </a>
                                    </h4>
                                    
                                </div>
                                <div class="col-xs-6 col-md-6">
                                    <p class="product-price"> ${{ number_format($product->finalPrice(), 2, '.', ',') }} </p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <hr/>
                    @endforeach
                </ul>
            </div>
            
            <div class="col-md-4">
                <h2 class="text-center">Ofertas</h2>
                <ul class="list-unstyled">
                    @foreach($rProducts3 as $product)
                    <li>
                        <div class="container-fluid product-display">
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <img src="{{ asset('assets/img/product_img/'.$product->img_name) }}" height="120" class="img-circle center-block" alt="gray square">
                                </div>
                                <div class="col-xs-6 col-md-6">
                                    <h4 class="name">
                                        <a href="{{route('product-page', ['product' => $product->id]) }}">
                                            <strong>{{$product->name}}</strong>
                                        </a>
                                    </h4>
                                </div>
                                <div class="col-xs-6 col-md-6">
                                    <p class="product-price">
                                        <small><del>${{ number_format(($product->finalPrice() + $product->finalPrice() * 0.20), 2, '.', ',') }}</del></small>
                                        ${{ number_format($product->finalPrice(), 2, '.', ',') }}
                                    </p>
                                </div>
                                
                            </div>
                        </div>
                    </li>
                    <hr/>
                    @endforeach
                </ul>
            </div>
            
            
        </div><!--/row-->
    </div><!--container-fluid-->
</div><!--page-section-->

<div class="page-section"></div>
@endsection

@section('script')
<script type="text/javascript">
    (function(yourcode) {
        yourcode(window.jQuery, window, document);
    } (function($, window, document) {
        $(function() {
        // The DOM is ready!
        });
        // rest of the code 

        var currentImage = 1;
        var image1 = $('#img1');
        var image2 = $('#img2');

        image2.hide();
        changeImage();

        function changeImage() {
            setTimeout(changeImage, 5000);
            switch( currentImage )
            {
                case 1: 
                    image2.fadeOut(500);
                    image1.fadeIn(500);
                    currentImage++;
                    break;
                case 2:
                    image1.fadeOut(500);
                    image2.fadeIn(500);

                     currentImage--;
                     break;
            }

        }


    }));
</script>
@endsection