@extends('layouts.default')

@section('title', '| Hardware')

@section('content')


<div class="page-section">
    
    <div class="container-fluid">
        <div class="row">
            <!-- FILTERS COLUMN --> 
            <div class="col-xs-4 col-md-3 no-padding">
                <h3 class="header-box"><span>Filtros</span> <i class="fa fa-filter" aria-hidden="true"></i></h3>
                
                @foreach($productCategories as $productCategory)
                <h4 class="toggle-category " id="category-{{$productCategory->id}}">
                    {{ ucfirst( $productCategory->name ) }} <em>[ACTIVO]</em>
                    <i class="fa fa-caret-right" aria-hidden="true"></i>
                </h4>
                
                <ul class="list-unstyled subcategories-panel category-{{$productCategory->id}}" >
                
                    @foreach($productCategory->subcategories as $subcategory)
                    @php ( $active =  in_array($subcategory->id, session()->get('filterIds')) )
                    <li>
                        <button class="filter-button {{ $active ? 'button-green' : 'button-red' }} btn" value="{{ $subcategory->id }}">
                            {{ ucfirst( $subcategory->name ) }} <i class="fa {{ $active ? 'fa-times-circle' : 'fa-plus-circle' }} text-right" aria-hidden="true"></i>
                        </button>
                    </li>
                    @endforeach
                    
                </ul>
                @endforeach
                
            </div>
            <!-- / FILTERS COLUMN -->
            
            <!-- CATALOG SHOWING COLUMN -->
            <div class="col-xs-8 col-md-9 no-padding">
                <h3 class="header-box header-box-red">
                    {{ ucfirst( $productType->name ) }}
                    
                </h3>
                
                <div class="container-fluid">
                    <div class="row productCatalog">
                        Cargando catalogo...
                        <!-- Section updated from AJAX -->
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


@section('script')
<script>
(function(yourcode) {
    yourcode(window.jQuery, window, document);
}(function($, window, document) {
    $(function() {
        // The DOM is ready!
    });
    // rest of the code here
    
    function updateCatalog( filterId = 0 ) {
        $(".productCatalog").html('Actualizando catalogo... <br/> <img src="{{ asset("assets/img/loading.gif") }}" alt="Cargando" height="100"/>');
        return $.ajax({
            url: "/store/catalog",
            type: "post",
            data: { 
                filterId: filterId, 
                productTypeId: '{{ $productType->id }}', 
                page: '{{ $page }}',
            }
        });
    
    }
    
    updateCatalog().done(function(response) {
        $(".productCatalog").html( response );
    });
    
    
    $('.filter-button').click(function() {
        var filterId = $(this).val();
        
        updateCatalog( filterId ).done(function(response) {
            $(".productCatalog").html( response );
            console.log('Catalogo actualizado!');
        });

        // TOGGLE CATALOG FILTER BUTTONS COLOR BT RED & GREEN
        $(this).toggleClass('button-red');
        $(this).toggleClass('button-green');
        $(this).find('i').toggleClass('fa fa-times-circle text-right');
        $(this).find('i').toggleClass('fa fa-plus-circle text-right');
        
    });
    
    
    
    // hiding side panels
    var toggleCategories = $('h4.toggle-category');
    
    toggleCategories.click(function() {
        
        var categoriesElem = $( 'ul.' + $(this).attr('id') );
        var caret = $(this).find('i');
        
        caret.toggleClass('fa-caret-right');
        caret.toggleClass('fa-caret-down');
        
        categoriesElem.toggleClass('show-categories');
        
        categoriesElem.find('li').each(function(i){
            $(this).delay(25*i).queue(function() {
               $(this).toggleClass('show-subcategory').dequeue(); 
            });
        });
        
    });
    
    
}
));
</script>

@endsection