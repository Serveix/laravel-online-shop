<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductType;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function showResults(Request $request)
    {
        $searchQuery = $request->input('q');
        $category    = $request->input('category');
        
        if(empty($searchQuery) || empty($category)) 
            return redirect('/');
        
        if($category != 'all')
        {
            $productType = ProductType::where('slug', $category)->first();
            
            if($productType == null || $productType->count() == 0)
                return redirect('/');
                
            $searchCategoryName = $productType->name;
            
            $products = $productType->products()->where('name', 'LIKE', '%'.$searchQuery.'%')->get();
            
            
            
        }   
        else  {
            $productTypes = ProductType::all();
            $searchCategoryName = 'todas las categorias';
            
            $products = null;
            
            if($productTypes !== null || $productTypes->count() > 0) {
                
                foreach($productTypes as $type){
                    if($products == null)
                        $products = $type->products()->where('name', 'like', '%'.$searchQuery.'%')->get();
                    else
                        $products = $products->merge($type->products()->where('name', 'like', '%'.$searchQuery.'%')->get());
                }
            }
            
            
        }
        
        
        
        
        
        return view('searchResults')
                ->with('searchCategoryName', $searchCategoryName)
                ->with('products', $products)
                ->with('searchQuery', $searchQuery);
        
    }
}
