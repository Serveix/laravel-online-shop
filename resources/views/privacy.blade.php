@extends('layouts.default')

@section('title', 'Aviso de privacidad')

@section('content')
<div class="page-section title-area skyblue">
  <h1>Aviso de privacidad</h1>
</div>

<div class="page-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('documents.privacy')
            </div>
        </div><!--/row-->
    </div><!--container-fluid-->
</div><!--page-section-->

<div class="page-section"></div>
@endsection