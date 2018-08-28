@extends('layouts.housekeeping')

@section('title', '| Housekeeping')

@section('content')

<div class="container-fluid">
    <div class="row medium-text">
        <div class="col-md-4 col-md-offset-4">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            @if(session('savedChanges') === true)
                <div class="alert alert-success">
                    Cambios guardados
                </div>
            @endif
            
            <div class="form-group">
                <label for="usdMxnExchangeRate">Tipo de cambio segun Google API (USD a MXN):</label>
                <div class="input-group">
                        <div class="input-group-addon">$</div>
                        <input class="form-control" type="number" id="usdMxnExchangeRate" value="{{ $usdMxnExchangeRate or 'ERROR al recibir datos del api' }}" disabled/>
                </div>
            </div>
            <form method="post" action="#">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="ownUsdMxnExchangeRate">Tipo de cambio propio fijado (USD a MXN):</label>
                    <div class="input-group">
                        <div class="input-group-addon">$</div>
                        <input class="form-control" step=".01" name="ownExchangeRate" type="number" id="ownExchangeRate" value="{{ $ownExchangeRate->value or 0 }}"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="revenue">Ganancia por producto:</label>
                    <div class="input-group">
                        <!--<div class="input-group-addon">%</div>-->
                        <input class="form-control" type="number" step=".01" id="revenue" name="revenue" value="{{ $itemRevenue->value or 0 }}"/>
                        <div class="input-group-addon">%</div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="ivaValue">Valor del IVA:</label>
                    <div class="input-group">
                        <!--<div class="input-group-addon">%</div>-->
                        <input class="form-control" type="number" step=".01" id="ivaValue" name="ivaValue" value="{{ $ivaValue->value or 0 }}"/>
                        <div class="input-group-addon">%</div>
                    </div>
                </div>
                <button type="submit" id="savebtn" class="btn button button-default">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
(function(yourcode) {
    yourcode(window.jQuery, window, document);
}(function($, window, document) {
    $(function() { 
        // dom ready
    });   
    // rest of the code here
    
    $('#savebtn').prop('disabled',true);
 
 
    $('#ownExchangeRate').keyup(function() {
        $('#savebtn').prop('disabled', this.value == "" ? true : false);     
    });
    
    $('#revenue').keyup(function() {
        $('#savebtn').prop('disabled', this.value == "" ? true : false);     
    });
    
     
    $('#ivaValue').keyup(function() {
        $('#savebtn').prop('disabled', this.value == "" ? true : false);     
    });
    
    
    
}));
</script>
@endsection