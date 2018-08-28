@extends('layouts.default')

@section('title', 'Terminos y condiciones')

@section('content')
<div class="page-section title-area skyblue">
  <h1>T&eacute;rminos y condiciones</h1>
</div>

<div class="page-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('documents.terms')
            </div>
        </div><!--/row-->
    </div><!--container-fluid-->
</div><!--page-section-->

<div class="page-section"></div>
@endsection