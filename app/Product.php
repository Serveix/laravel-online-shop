<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductSubcategory;
use Illuminate\Support\Facades\Log;
use App\StoreSetting;
use Illuminate\Support\Collection;

class Product extends Model
{
    //protected $table = 'products';
    public $timestamps = false;
    protected $fillable = ['product_type_id', 'name', 'price', 'img_name', 'description', 'details', 'in_stock', 'guarantee'];
    
    public function type() {
        return $this->belongsTo('App\ProductType', 'product_type_id');
    }
    
    public function subcategories() {
        return $this->belongsToMany('App\ProductSubcategory', 'product_subcategory');
    }
    
    public function inOrders() {
        return $this->belongsToMany('App\Order', 'order_product');
    }
    
    public function manufacturerImgName() {
        $manufacturer;
        foreach($this->subcategories as $subcategory){
            if($subcategory->category->name == 'fabricante') {
                $manufacturer = $subcategory->name;
                break;
            }
        }
        
        //Make alphanumeric (removes all other characters)
        $manufacturerImgName = preg_replace("/[^a-z0-9_\s-]/", "", $manufacturer);
        //Clean up multiple dashes or whitespaces
        $manufacturerImgName = preg_replace("/[\s-]+/", " ", $manufacturerImgName);
        //Convert whitespaces and underscore to dash
        $manufacturerImgName = preg_replace("/[\s_]/", "-", $manufacturerImgName);
        
        return $manufacturerImgName;
    }
    
    public function scopeCartItemDetailsOnly( $query, $cartItemId ) {
        $returnableItem = $query->where('id', '=', $cartItemId)
                                ->select('id', 'name', 'price', 'img_name', 'in_stock')->first();
                                
        if(!empty($returnableItem))
            $returnableItem->price = $returnableItem->finalPrice();
        
        return $returnableItem;
    }
    
    public function finalPrice() {
        $iva = StoreSetting::find('iva_value')->value;
        $revenue = StoreSetting::find('item_revenue')->value;
        $usdmxn = StoreSetting::find('exchange_rate')->value;
        $finalPrice = ($this->price + ($this->price * ($revenue/100)) ) * $usdmxn; // USD price + USD revenue to MXN
        $finalPrice = $finalPrice + $finalPrice * ($iva/100); // Price + IVA
        // return number_format((round($finalPrice, -1) - 1), 2, '.', ',');
        return (round($finalPrice, -1) - 1);

        
    }
    
    public function finalPriceNoIva() {
        $iva = StoreSetting::find('iva_value')->value;
        $revenue = StoreSetting::find('item_revenue')->value;
        $usdmxn = StoreSetting::find('exchange_rate')->value;
        $finalPrice = ($this->price + ($this->price * ($revenue/100)) ) * $usdmxn; // USD price + USD revenue to MXN
        $finalPrice = $finalPrice + $finalPrice * ($iva/100); // Price + IVA
        $finalPrice = round($finalPrice, -1) - 1;
        
        /* 
        Regla de tres:
           precio mas iva - 116%
           precio sin iva - 100% */
        
        return round($finalPrice * 100 / 116);
    }
    

    /// !!! DONT SEND NULL PARAMETERS TO THIS FUNCTION, do the handling before...
    public function scopeWithFiltersAndInPage( $query, $filterIds )
    {
        $allProducts = $query->get();
        
        if(empty($filterIds) || $query->count() == 0)
            return $allProducts;
        
        
        $currentType = $query->first()->type; //current productType 
        $validSubcategories; // valid = exists and belongs to current product type
        
        
        /// get only those filters that exist and belong to current productType
        foreach($filterIds as $filterId) 
        {
            // filter = subcategory
            // check subcategory if exists
            $subcategory = ProductSubcategory::find([$filterId]);
            
            if($subcategory != null && $subcategory->first()->category->type->id == $currentType->id)
            {
                
                if( empty($validSubcategories) )
                    $validSubcategories = $subcategory;
                else
                    $validSubcategories = $validSubcategories->merge($subcategory);
                    
            }
        }
        
        
        if(empty($validSubcategories))
            return $allProducts;
        
        /// Get the items according to the filters
        $mainProductsPool;
        $finalProductsPool = null;
        $firstSubcategory;
        $differentCategory = false;
        foreach($validSubcategories as $subcategory)
        {
            if( empty($mainProductsPool) ) {
                $mainProductsPool = $subcategory->products;
                $firstSubcategory = $subcategory;
            }
            else {
                $firstCategory  = $firstSubcategory->category;
                $category       = $subcategory->category;
                
                if($category->id == $firstCategory->id)
                    $mainProductsPool = $mainProductsPool->merge($subcategory->products);   
                else
                {
                    $differentCategory = true;
                    
                    if(empty($finalProductsPool))
                    {
                        $finalProducts = collect([]);
                        foreach($mainProductsPool as $product)
                        {
                            foreach($product->subcategories as $toFinalSubcategory) 
                            {
                                if($toFinalSubcategory->id == $subcategory->id) 
                                {
                                    if(empty($finalProducts))
                                        $finalProducts = collect([$product]);
                                    else 
                                        $finalProducts = $finalProducts->merge(collect([$product]));
                                }
                                
                            }
                            
                        }
                        
                        $finalProductsPool = $finalProducts;
                    }
                    else
                    {
                        foreach($finalProductsPool as $key=>$finalProduct) 
                        {
                            $pullProduct = true;
                            
                            foreach($finalProduct->subcategories as $finalSubcategory)
                            {
                                if($finalSubcategory->id == $subcategory->id) 
                                    $pullProduct = false;
                                
                            }
                            
                            if($pullProduct) 
                                $finalProductsPool->pull($key);
                            
                        }
                    
                        
                    }
                    
                }
                
            }
        }
        
        if($differentCategory)
            return $finalProductsPool;
        else
            return $mainProductsPool ;
        
    }
    
}
