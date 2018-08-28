<?php
/*==============================================================================
 * VeixStore by Carlos Eli Lopez Tellez
 * -----------------------------------------------------------------------------
 * The store is separated in product types. Each product type has many categories,
 * and each category has many subcategories.
 * 
 * == SUBCATEGORIES ARE ALSO REFFERED AS FILTERS ==
 * ===========================================================================*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\ProductType;
use Illuminate\Support\Facades\Log;
use App\Product;





class StoreController extends Controller
{

    function indexProducts() {

        $rProducts  = Product::orderByRaw('RAND()')->take(3)->get();
        $rProducts2 = Product::orderByRaw('RAND()')->take(3)->get();
        $rProducts3 = Product::orderByRaw('RAND()')->take(3)->get();
        return view('index')
                ->with('rProducts', $rProducts)
                ->with('rProducts2', $rProducts2)
                ->with('rProducts3', $rProducts3);
    }
    
    
    function index(Request $request, ProductType $productType, $page = 1)
    {
        $productCategories = $productType->categories;
        $productSubcategories = $productType->subcategories;
        
        // Every filter in filterIds session will be marked as active. If all
        // store filters are in the session then every product will be returned.
        if ( ! $request->session()->exists('filterIds') ) // if the user hasnt used any filters, just got in the store
        {
            $request->session()->put('filterIds',  array());
        }

        return view('store')
        ->with('page', $page)
        ->with('productType', $productType)
        ->with('productCategories', $productCategories);
    }

    
    function showCatalog(Request $request) {
        $filterId    = $request->input('filterId');
        $page        = $request->input('page');
        $productType = ProductType::find( $request->input('productTypeId') );
        
        $products    = 0;

        // 0 is default, when user enters site, not when he clicks a filter
        if( $filterId != 0 )
        {
	        // checks if the filter received is already in the array session
	        if(in_array( $filterId, $request->session()->get('filterIds') ))
	        {
	             $filterAt = array_search( $filterId, $request->session()->get('filterIds') );
	             $request->session()->pull('filterIds.' . $filterAt);
	        }
	        else 
	        	$request->session()->push('filterIds', $filterId);
        }

        $filterIds = $request->session()->get('filterIds');
        
        $productTypeProducts = $productType->products;
        
        
        if( $productTypeProducts != null || $productTypeProducts->count() > 0 || !empty($productTypeProducts))
        {
            
            $products = $productType->products()->withFiltersAndInPage( $filterIds );
            
            $totalPages = ceil( ($products->count() / 10) ) ;
            
            if($products->count() > 0){
                return view('includes.catalog')->with('products',  $products->splice( (10 * $page - 10), 10) )
                                               ->with('totalPages', $totalPages)
                                               ->with('currentPage', $page)
                                               ->with('productTypeSlug', $productType->slug );
            }
            else
                return 'A&uacute;n no hay productos en el catalogo';
        }
        else
            return 'A&uacute;n no hay productos en el catalogo';
        

        
    }
    
    
}