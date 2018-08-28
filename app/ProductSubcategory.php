<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSubcategory extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['product_category_id', 'name'];
    
    public function category() {
        return $this->belongsTo('App\ProductCategory', 'product_category_id');
    }
    
    
    public function products() {
        return $this->belongsToMany('App\Product', 'product_subcategory');
    }
}
