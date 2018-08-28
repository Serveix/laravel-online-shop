@extends('layouts.default')

@section('title', 'Checkout')

@section('content')

<div class="page-section title-area skyblue">
  <h1><i class="fa fa-shopping-cart" aria-hidden="true"></i> Checkout</h1>
</div>


<div class="page-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                
                @if(session('NotExistingProduct'))
                <div class="alert alert-warning">
                    Ocurrio un error inesperado. Al parecer uno de los productos en tu lista cambi&oacute; o no existe.
                </div>
                @endif
                
                @if(session('itemPriceChanged'))
                <div class="alert alert-warning">
                    {!! session()->get('itemPriceChanged') !!}
                </div>
                @endif
                
                @if(session('itemOutOfStock'))
                <div class="alert alert-warning">
                    {!! session()->get('itemOutOfStock') !!}
                    
                </div>
                @endif
                
                @if(session('stores-errors'))
                <div class="alert alert-warning">
                    {!! session()->get('stores-errors') !!}
                    
                </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <hr>
                @if(session('addressUpdated'))
                <div class="alert alert-success">
                  &iexcl;Direcci&oacute;n actualizada con &eacute;xito!
                </div>
                @endif
                <div id="shippingAddressDisplay">
                    <h3><strong><i class="fa fa-map-marker" aria-hidden="true"></i> Direcci&oacute;n de envio </strong></h3>
                    {{ $shippingAddress->street_address1 }}, 
                    {{ $shippingAddress->street_address2 or '' }} <br>
                    {{ $shippingAddress->city }} <br>
                    {{ $shippingAddress->state }}, {{  $shippingAddress->postal_code }} <br>
                    M&eacute;xico <br>
                    {{ $shippingAddress->indications or '' }}<br>
                    
                </div>
                
                
                
                <form method="post" action="{{ route('shipping-address') }}" id="shippingAddressForm">
                    
                    {{ csrf_field() }}
                    <label >Direccion 1 *:</label>
                    <input name="direccion1" class="form-control" value="{{ $shippingAddress->street_address1 or old('direccion1', '')  }}" placeholder="Ej. Calle de la Paz #100" type="text">
                    
                    <label >Direccion 2 :</label>
                    <input name="direccion2" class="form-control" value="{{ $shippingAddress->street_address2 or old('direccion2', '') }}" placeholder="Ej. Las Puentes 3er Sector" type="text">
                    
                    <label>Pa&iacute;s * :</label>
                    <input name="pais" class="form-control"  value="M&eacute;xico" type="text" disabled>
                    
                    <label>Estado * :</label>
                    <select name="estado" class="form-control" id="shipping-address-state">
                        <option value="Aguascalientes">Aguascalientes</option>
                        <option value="Baja California">Baja California</option>
                        <option value="Baja California Sur">Baja California Sur</option>
                        <option value="Campeche">Campeche</option>
                        <option value="Coahuila de Zaragoza">Coahuila de Zaragoza</option>
                        <option value="Colima">Colima</option>
                        <option value="Chiapas">Chiapas</option>
                        <option value="Chihuahua">Chihuahua</option>
                        <option value="Distrito Federal">Distrito Federal</option>
                        <option value="Durango">Durango</option>
                        <option value="Guanajuato">Guanajuato</option>
                        <option value="Guerrero">Guerrero</option>
                        <option value="Hidalgo">Hidalgo</option>
                        <option value="Jalisco">Jalisco</option>
                        <option value="México">México</option>
                        <option value="Michoacán de Ocampo">Michoacán de Ocampo</option>
                        <option value="Morelos">Morelos</option>
                        <option value="Nayarit">Nayarit</option>
                        <option value="Nuevo León">Nuevo León</option>
                        <option value="Oaxaca">Oaxaca</option>
                        <option value="Puebla">Puebla</option>
                        <option value="Querétaro">Querétaro</option>
                        <option value="Quintana Roo">Quintana Roo</option>
                        <option value="San Luis Potosí">San Luis Potosí</option>
                        <option value="Sinaloa">Sinaloa</option>
                        <option value="Sonora">Sonora</option>
                        <option value="Tabasco">Tabasco</option>
                        <option value="Tamaulipas">Tamaulipas</option>
                        <option value="Tlaxcala">Tlaxcala</option>
                        <option value="Veracruz de Ignacio de la Llave">Veracruz de Ignacio de la Llave</option>
                        <option value="Yucatán">Yucatán</option>
                        <option value="Zacatecas">Zacatecas</option>
                    </select>
                    
                    <label>Municipio * :</label>
                    <input name="municipio" class="form-control shipping-address-city"  placeholder="Ej. Monterrey, Apodaca, etc." value="{{ $shippingAddress->city or old('municipio', '') }}" type="text">
                    
                    <select name="municipio" class="form-control shipping-address-city">
                        <option value="Abasolo">Abasolo</option>
                        <option value="Agualeguas">Agualeguas</option>
                        <option value="Los Aldamas">Los Aldamas</option>
                        <option value="Allende">Allende</option>
                        <option value="Anahuac">Anahuac</option>
                        <option value="Apodaca">Apodaca</option>
                        <option value="Aramberri">Aramberri</option>
                        <option value="Bustamante">Bustamante</option>
                        <option value="Cadereyta Jimenez">Cadereyta Jimenez</option>
                        <option value="Carmen">Carmen</option>
                        <option value="Cerralvo">Cerralvo</option>
                        <option value="Cienega de Flores">Cienega de Flores</option>
                        <option value="China">China</option>
                        <option value="Dr. Arroyo">Dr. Arroyo</option>
                        <option value="Dr. Coss">Dr. Coss</option>
                        <option value="Dr. Gonzalez">Dr. Gonzalez</option>
                        <option value="Galeana">Galeana</option>
                        <option value="Garcia">Garcia</option>
                        <option value="San Pedro Garza Garcia">San Pedro Garza Garcia</option>
                        <option value="Gral. Bravo">Gral. Bravo</option>
                        <option value="Gral. Escobedo">Gral. Escobedo</option>
                        <option value="Gral. Teran">Gral. Teran</option>
                        <option value="Gral. Trevi">Gral. Trevi</option>
                        <option value="Gral. Zaragoza">Gral. Zaragoza</option>
                        <option value="Gral. Zuazua">Gral. Zuazua</option>
                        <option value="Guadalupe">Guadalupe</option>
                        <option value="Los Herreras">Los Herreras</option>
                        <option value="Higueras">Higueras</option>
                        <option value="Hualahuises">Hualahuises</option>
                        <option value="Iturbide">Iturbide</option>
                        <option value="Juarez">Juarez</option>
                        <option value="Lampazos de Naranjo">Lampazos de Naranjo</option>
                        <option value="Linares">Linares</option>
                        <option value="Marin">Marin</option>
                        <option value="Melchor Ocampo">Melchor Ocampo</option>
                        <option value="Mier y Noriega">Mier y Noriega</option>
                        <option value="Mina">Mina</option>
                        <option value="Montemorelos">Montemorelos</option>
                        <option value="Monterrey">Monterrey</option>
                        <option value="Paras">Paras</option>
                        <option value="Pesqueria">Pesqueria</option>
                        <option value="Los Ramones">Los Ramones</option>
                        <option value="Rayones">Rayones</option>
                        <option value="Sabinas Hidalgo">Sabinas Hidalgo</option>
                        <option value="Salinas Victoria">Salinas Victoria</option>
                        <option value="San Nicolas de los Garza">San Nicolas de los Garza</option>
                        <option value="Hidalgo">Hidalgo</option>
                        <option value="Santa Catarina">Santa Catarina</option>
                        <option value="Santiago">Santiago</option>
                        <option value="Vallecillo">Vallecillo</option>
                        <option value="Villaldama">Villaldama</option>
                    </select>
                    
                      
                    <label >Código Postal * :</label>
                    <input name="codigoPostal" class="form-control" value="{{ $shippingAddress->postal_code or old('codigoPostal', '') }}" placeholder="22330" type="text">
                    
                    <label >Indicaciones :</label>
                    <input name="indicaciones" class="form-control" value="{{ $shippingAddress->indications or old('indicaciones', '') }}" placeholder="Casa naranja de dos pisos" type="text">
                    
                    <button type="submit" id="sAddressBtn" class="btn button button-default">Guardar cambios</button>
                    
                </form>
                <a id="edit-shipping-address">Editar direcci&oacute;n</a>
                
                <hr>
                
                <h3><strong><i class="fa fa-usd" aria-hidden="true"></i> Direcci&oacute;n de facturaci&oacute;n </strong></h3>
                
                @php ($billingAddressExists = !empty($billingAddress))
                
                
                <form method="post" action="{{ route('billing-address') }}" id="billingAddressForm">
                    {{ csrf_field() }}
                    <label >Direccion 1 *:</label>
                    <input name="direccion1" class="form-control" value="{{ $billingAddress->street_address1 or old('direccion1', '')  }}" placeholder="Ej. Calle de la Paz #100" type="text">
                    
                    <label >Direccion 2 :</label>
                    <input name="direccion2" class="form-control" value="{{ $billingAddress->street_address2 or old('direccion2', '') }}" placeholder="Ej. Las Puentes 3er Sector" type="text">
                    
                    <label>Pa&iacute;s * :</label>
                    <input name="pais" class="form-control"  value="M&eacute;xico" type="text" disabled>
                    
                    <label>Estado * :</label>
                    <select name="estado" class="form-control" id="billing-address-state">
                        <option value="Aguascalientes">Aguascalientes</option>
                        <option value="Baja California">Baja California</option>
                        <option value="Baja California Sur">Baja California Sur</option>
                        <option value="Campeche">Campeche</option>
                        <option value="Coahuila de Zaragoza">Coahuila de Zaragoza</option>
                        <option value="Colima">Colima</option>
                        <option value="Chiapas">Chiapas</option>
                        <option value="Chihuahua">Chihuahua</option>
                        <option value="Distrito Federal">Distrito Federal</option>
                        <option value="Durango">Durango</option>
                        <option value="Guanajuato">Guanajuato</option>
                        <option value="Guerrero">Guerrero</option>
                        <option value="Hidalgo">Hidalgo</option>
                        <option value="Jalisco">Jalisco</option>
                        <option value="México">México</option>
                        <option value="Michoacán de Ocampo">Michoacán de Ocampo</option>
                        <option value="Morelos">Morelos</option>
                        <option value="Nayarit">Nayarit</option>
                        <option value="Nuevo León">Nuevo León</option>
                        <option value="Oaxaca">Oaxaca</option>
                        <option value="Puebla">Puebla</option>
                        <option value="Querétaro">Querétaro</option>
                        <option value="Quintana Roo">Quintana Roo</option>
                        <option value="San Luis Potosí">San Luis Potosí</option>
                        <option value="Sinaloa">Sinaloa</option>
                        <option value="Sonora">Sonora</option>
                        <option value="Tabasco">Tabasco</option>
                        <option value="Tamaulipas">Tamaulipas</option>
                        <option value="Tlaxcala">Tlaxcala</option>
                        <option value="Veracruz de Ignacio de la Llave">Veracruz de Ignacio de la Llave</option>
                        <option value="Yucatán">Yucatán</option>
                        <option value="Zacatecas">Zacatecas</option>
                    </select>
                   
                    <label>Municipio * :</label>
                    <input name="municipio" class="form-control billing-address-city"  placeholder="Ej. Monterrey, Apodaca, etc." value="{{ $billingAddress->city or old('municipio', '') }}" type="text">
                    
                    <select name="municipio" class="form-control billing-address-city">
                        <option value="Abasolo">Abasolo</option>
                        <option value="Agualeguas">Agualeguas</option>
                        <option value="Los Aldamas">Los Aldamas</option>
                        <option value="Allende">Allende</option>
                        <option value="Anahuac">Anahuac</option>
                        <option value="Apodaca">Apodaca</option>
                        <option value="Aramberri">Aramberri</option>
                        <option value="Bustamante">Bustamante</option>
                        <option value="Cadereyta Jimenez">Cadereyta Jimenez</option>
                        <option value="Carmen">Carmen</option>
                        <option value="Cerralvo">Cerralvo</option>
                        <option value="Cienega de Flores">Cienega de Flores</option>
                        <option value="China">China</option>
                        <option value="Dr. Arroyo">Dr. Arroyo</option>
                        <option value="Dr. Coss">Dr. Coss</option>
                        <option value="Dr. Gonzalez">Dr. Gonzalez</option>
                        <option value="Galeana">Galeana</option>
                        <option value="Garcia">Garcia</option>
                        <option value="San Pedro Garza Garcia">San Pedro Garza Garcia</option>
                        <option value="Gral. Bravo">Gral. Bravo</option>
                        <option value="Gral. Escobedo">Gral. Escobedo</option>
                        <option value="Gral. Teran">Gral. Teran</option>
                        <option value="Gral. Trevi">Gral. Trevi</option>
                        <option value="Gral. Zaragoza">Gral. Zaragoza</option>
                        <option value="Gral. Zuazua">Gral. Zuazua</option>
                        <option value="Guadalupe">Guadalupe</option>
                        <option value="Los Herreras">Los Herreras</option>
                        <option value="Higueras">Higueras</option>
                        <option value="Hualahuises">Hualahuises</option>
                        <option value="Iturbide">Iturbide</option>
                        <option value="Juarez">Juarez</option>
                        <option value="Lampazos de Naranjo">Lampazos de Naranjo</option>
                        <option value="Linares">Linares</option>
                        <option value="Marin">Marin</option>
                        <option value="Melchor Ocampo">Melchor Ocampo</option>
                        <option value="Mier y Noriega">Mier y Noriega</option>
                        <option value="Mina">Mina</option>
                        <option value="Montemorelos">Montemorelos</option>
                        <option value="Monterrey">Monterrey</option>
                        <option value="Paras">Paras</option>
                        <option value="Pesqueria">Pesqueria</option>
                        <option value="Los Ramones">Los Ramones</option>
                        <option value="Rayones">Rayones</option>
                        <option value="Sabinas Hidalgo">Sabinas Hidalgo</option>
                        <option value="Salinas Victoria">Salinas Victoria</option>
                        <option value="San Nicolas de los Garza">San Nicolas de los Garza</option>
                        <option value="Hidalgo">Hidalgo</option>
                        <option value="Santa Catarina">Santa Catarina</option>
                        <option value="Santiago">Santiago</option>
                        <option value="Vallecillo">Vallecillo</option>
                        <option value="Villaldama">Villaldama</option>
                    </select>
                    
                    
                    <label >Código Postal * :</label>
                    <input name="codigoPostal" class="form-control" value="{{ $billingAddress->postal_code or old('codigoPostal', '') }}" placeholder="22330" type="text">
                  
                    
                    <label >Indicaciones :</label>
                    <input name="indicaciones" class="form-control" value="{{ $billingAddress->indications or old('indicaciones', '') }}" placeholder="Casa naranja de dos pisos" type="text">
                    
                    <button type="submit" id="bAddressBtn" class="btn button button-default">Guardar cambios</button>
                     
                </form>
                    
                <form method="post" action="#" id="finalOrder">
                    @php($fromMty = $shippingAddress->fromMty() === true)
                    

                    {{csrf_field()}}
                    
                    @if($billingAddressExists)
                    <div id="billingAddressDisplay">
                        <div class="radio">
                            <label>
                                <input type="radio" name="billing-options" value="2" checked>
                                Usar la direccion de facturaci&oacute;n
                            </label>
                        </div>
                        
                        {{ $billingAddress->street_address1 }}, 
                        {{ $billingAddress->street_address2 or '' }} <br>
                        {{ $billingAddress->city }} <br>
                        {{ $billingAddress->state }}, {{  $billingAddress->postal_code }} <br>
                        {{ $billingAddress->indications or '' }}<br>
                        
                        <a id="edit-billing-address">Editar direcci&oacute;n de facturaci&oacute;n</a>
                    </div>
                    @else
                    <a id="edit-billing-address">Agregar una direcci&oacute;n de facturaci&oacute;n</a>
                    @endif
                    
                    
                    <div class="radio">
                        <label>
                            <input type="radio" name="billing-options" value="1" @if(!$billingAddressExists) checked @endif>
                            Usar la misma que la direcci&oacute;n de envio. 
                        </label>
                    </div>
                    
                    
                    <hr>
                    <h3><strong><i class="fa fa-truck" aria-hidden="true"></i> M&eacute;todo de envio </strong></h3>

                    @if( $fromMty )
                    <div class="radio">
                        <label>
                            <input type="radio" name="shippment-method" value="1" checked="checked">
                            Envio gratis al area metropolitana de Monterrey ($0)
                        </label>
                    </div>
                    @endif

                    {{-- Esto hara que se haga un loop para mostrar todos los metodos de pago, excepto el primero, pues
                         el primero es Envio gratis en Mty y ya lo mostre arriba ^^ --}}

                    @foreach($shippmentMethods as $key=>$sMethod)
                        @if($key > 0) 
                        <div class="radio">
                            <label>
                                <input type="radio" name="shippment-method" value="{{$sMethod->id}}" @if(!$fromMty && $key==1) checked="checked" @endif>
                                {{$sMethod->description}} (${{ $sMethod->price }})
                            </label>
                        </div>
                        @endif
                    @endforeach
                    
                    
                    
                    
                    <hr>
                    <h3><strong><i class="fa fa-credit-card" aria-hidden="true"></i> M&eacute;todo de pago </strong></h3>
                    
                    @foreach($paymentMethods as $key=>$method)
                    @if($method->active)
                    <div class="radio">
                        <label>
                            <input type="radio" name="payment-method" value="{{$method->id}}" @if($key==0) checked="checked" @endif>
                            {!! $method->description !!}
                        </label>
                    </div>
                    @endif
                    @endforeach


                    <hr/>
                    <label>Numero de tel&eacute;fono (requerido) :</label> 
                    <input type="text" name="telefono" value="{{old('telefono')}}" placeholder="10 d&iacute;gitos" maxlength="10" class="form-control">
                    <hr/>
                    <label>Detalles extra: </label>
                    <textarea name="detalles" placeholder="Opcional" style="resize: none;height:75px" class="form-control" maxlength="100">{{old('detalles')}}</textarea>

                   <hr/>
                    
                    <div class="g-recaptcha" data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>

                    <hr/>
                    
                    <input type="hidden" name="total-price" value="{{ $finalPrice + $finalPrice * $iva}}">
                    <input type="submit" class="btn button button-blue" id="confirmAndPayBtn" value="Confirmar pedido y pagar" >
                    <hr/>
                </form>     
            </div> <!-- /col-md-5 col-md-offset-1 -->
            <div class="col-md-5 checkout-summary">
                <h3><strong><i class="fa fa-list-ul" aria-hidden="true"></i> Resumen del pedido </strong></h3>
                <hr>
                
                @foreach($orderProducts as $product)
                    
                    <p class="product-name">
                        <em>{{ $product['quantity'] }} x {{ $product['name'] }}</em>
                        
                            $ {{ number_format($product['price'] * $product['quantity'] , 2, '.', ',') }}
                        
                    </p>
                    
                @endforeach
                <hr>
                <p class="product-name">
                    <em>Subtotal:</em>
                    
                        $ {{ number_format($finalPrice, 2, '.', ',') }}
                    
                </p>
                <p class="product-name">
                    <em>IVA (16%):</em>
                    
                        $ {{ number_format($finalPrice * $iva, 2, '.', ',') }}
                    
                </p>
                
                <hr>
                <p class="products-total">
                    Total: 
                    <span>
                        $ {{ number_format($finalPrice+($finalPrice*$iva), 2, '.', ',') }}
                    </span>
                </p>

                @php($shippmentPrice = ($fromMty) ? 0.00 : $shippmentMethods->get(1)->price )
                <p class="product-name" id="shippment-price">
                    <em>+ Envio:</em>
                    
                    <span>$ {{ $shippmentPrice }}</span>
                </p>
            </div> <!--/col-md-3 checkout-summary-->

            
            
            

        </div> <!--/ row -->
    </div> <!--/ container-fluid -->
</div> <!--/ page-section -->

<!-- for separation purposes between content and footer -->
<div class="page-section"></div>
@endsection


@section('script')
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>
(function(yourcode) {
    yourcode(window.jQuery, window, document);
} (function($, window, document) {
    $(function() {
        // The DOM is ready!
    });
    //rest of code 
    var confirmAndPayBtn = $('#confirmAndPayBtn');
    var shippingAddressState = $('#shipping-address-state');
    var billingAddressState = $('#billing-address-state');
    
    var selectShippingCity = $('select.shipping-address-city');
    var inputShippingCity = $('input.shipping-address-city');
    
    var selectBillingCity = $('select.billing-address-city');
    var inputBillingCity = $('input.billing-address-city');
    
    var shippmentMethod = $('input[type=radio][name=shippment-method]');
    
    shippingAddressState.val('{{ $shippingAddress->state or "" }}');
    billingAddressState.val('{{ $billingAddress->state or "" }}');
    
    selectShippingCity.val('{{ $shippingAddress->city or "" }}');
    selectBillingCity.val('{{ $billingAddress->city or "" }}');

    confirmAndPayBtn.prop('disabled', false);

    confirmAndPayBtn.click(function() {
        event.preventDefault();
        $(this).prop('disabled', true);
        $('#finalOrder').submit();
    });

    
    $('#sAddressBtn').click(function() {
        event.preventDefault();
        $(this).prop('disabled', true);
        $('#shippingAddressForm').submit();
    
    });

    $('#bAddressBtn').click(function() {
        event.preventDefault();
        $(this).prop('disabled', true);
        $('#billingAddressForm').submit();
    
    });
    
    if(shippingAddressState.val() == 'Nuevo León'){
        selectShippingCity.show();
        inputShippingCity.hide();
        inputShippingCity.prop('disabled', true);
    }
    else 
    {
        selectShippingCity.hide();
        selectShippingCity.prop('disabled', true);
        
        inputShippingCity.show();
    }
    
    
    if(billingAddressState.val() == 'Nuevo León'){
        selectBillingCity.show();
        
        inputBillingCity.hide();
        inputBillingCity.prop('disabled', true);
    }
    else 
    {
        selectBillingCity.hide();
        selectBillingCity.prop('disabled', true);
        
        inputBillingCity.show();
    }
    
    shippingAddressState.on('change', function() {
        if( $(this).val() == 'Nuevo León' ) {
            selectShippingCity.show();
            selectShippingCity.val( '' );
            selectShippingCity.prop('disabled', false);
            
            inputShippingCity.hide();
            inputShippingCity.prop('disabled', true);
        }
        else 
        {
            selectShippingCity.hide();
            selectShippingCity.prop('disabled', true);
            
            inputShippingCity.show();
            inputShippingCity.val( '' );
            inputShippingCity.prop('disabled', false);
            
        }
    });
    
    billingAddressState.on('change', function() {
        if( $(this).val() == 'Nuevo León' ) {
            selectBillingCity.show();
            selectBillingCity.val( '' );
            selectBillingCity.prop('disabled', false);
            
            inputBillingCity.hide();
            inputBillingCity.prop('disabled', true);
        }
        else 
        {
            selectBillingCity.hide();
            selectBillingCity.prop('disabled', true);
            
            inputBillingCity.show();
            inputBillingCity.val( '' );
            inputBillingCity.prop('disabled', false);
        } 
    });
    
    shippmentMethod.change(function() {
        
        if($(this).val() == '1') {
            $('#shippment-price span').html('$ 0.00');
            $('input[type=hidden][name=shippment-price]').val('0.00');
        }
        @foreach($shippmentMethods as $sMethod)
        else if($(this).val() == '{{$sMethod->id}}') {
            $('#shippment-price span').html('$ {{$sMethod->price}}');
        }
        @endforeach
    });
    
    $('#edit-shipping-address').click(function() {
        $('.alert.alert-success').hide();
        $('#shippingAddressDisplay').hide();
        $('#shippingAddressForm').show();
    });
    
    $('#edit-billing-address').click(function() {
        $('.alert.alert-success').hide();
        $('#shippingAddressDisplay').show();
        $('#shippingAddressForm').hide();
        
        $('#billingAddressForm').show();
        $('#billingAddressDisplay').hide();
    });
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 340) {
            $('.checkout-summary').addClass('fixed');
        } else {
            $('.checkout-summary').removeClass('fixed');
        }
    });
    
}));
</script>
@endsection