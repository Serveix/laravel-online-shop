<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    public $timestamps = false;
    
    protected $fillable = ['name', 'slug'];
    
    public function categories() {
        return $this->hasMany('App\ProductCategory', 'product_type_id');
    }
    
    public function subcategories() {
        return $this->hasManyThrough('App\ProductSubcategory', 'App\ProductCategory');
    }
    
    public function products() {
        return $this->hasMany('App\Product', 'product_type_id');
    }
    
    /// Route model binding customization
    /// https://laravel.com/docs/5.4/routing#route-model-binding
    public function getRouteKeyName() {
        return 'slug';
    }
}
