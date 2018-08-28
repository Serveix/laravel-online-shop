<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['product_type_id', 'name'];
    
    public function type() {
        return $this->belongsTo('App\ProductType', 'product_type_id');
    }
    
    public function subcategories() {
        return $this->hasMany('App\ProductSubcategory', 'product_category_id');
    }
}
