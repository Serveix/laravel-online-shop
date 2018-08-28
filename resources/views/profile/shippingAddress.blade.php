@extends('layouts.default')

@section('title', ': Direccion de envio ')

@section('content')

<div class="page-section title-area skyblue">
  <h1>Direcci&oacute;n de Envio</h1>
</div>

<div class="page-section gray-bg">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 white-bg">
                <a href="/">Inicio</a> >
                <a href="{{route('profile')}}">Perfil</a> >
                Direcci&oacute;n de Envio
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 white-bg"> 
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                @if(session('addressUpdated'))
                <div class="alert alert-success">
                  &iexcl;Direcci&oacute;n actualizada con &eacute;xito!
                </div>
                @endif
                
                @if(session('comingFromCheckout'))
                <div class="alert alert-warning">
                  <strong>Atenci&oacute;n:</strong> Antes de pasar al <i>checkout</i> debes agregar una direccion de envio
                </div>
                @endif
                
                
                <form method="post">
                    {{ csrf_field() }}
                    <label >Direccion 1 *:</label>
                    <input name="direccion1" class="form-control" value="{{ $s_address->street_address1 or old('direccion1', '')  }}" placeholder="Ej. Calle de la Paz #100" type="text">
                    
                    <label >Direccion 2 :</label>
                    <input name="direccion2" class="form-control" value="{{ $s_address->street_address2 or old('direccion2', '') }}" placeholder="Ej. Las Puentes 3er Sector" type="text">
                    
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
                        <input name="municipio" class="form-control shipping-address-city"  placeholder="Ej. Monterrey, Apodaca, etc." value="{{ $s_address->city or old('municipio', '') }}" type="text">
                        
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
                    <input name="codigoPostal" class="form-control" value="{{ $s_address->postal_code or old('codigoPostal', '') }}" placeholder="22330" type="text">
                  
                    
                    <label >Indicaciones :</label>
                    <input name="indicaciones" class="form-control" value="{{ $s_address->indications or old('indicaciones', '') }}" placeholder="Casa naranja de dos pisos" type="text">
                    
                    <button type="submit" class="btn button button-default">Guardar cambios</button>
                    
                </form>    
                
                <br/><br/>
              
            </div>
          
        </div> 
    </div>   
</div>
</div>
<div class="page-section"></div>


@endsection

@section('script')
<script>
(function(yourcode) {
    yourcode(window.jQuery, window, document);
} (function($, window, document) {
    $(function() {
        // The DOM is ready!
    });
    //rest of code 
    var shippingAddressState = $('#shipping-address-state');
    var selectShippingCity = $('select.shipping-address-city');
    var inputShippingCity = $('input.shipping-address-city');
    
    shippingAddressState.val('{{ $s_address->state or "" }}');
    selectShippingCity.val('{{ $s_address->city or ""}}');

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
}));
</script>
@endsection