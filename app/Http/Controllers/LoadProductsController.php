<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Product;
use App\ProductType;
use App\ProductCategory;
use App\ProductSubcategory;

class LoadProductsController extends Controller
{
    /*** ****************************** ***
     *** STEP ONE                       ***
     *** ****************************** ***/
    /**
     * Step one of loading products
     * @return String view
     */
    function showLoadProductsPage() {
        $productTypes = ProductType::all();
        
        return view('hk.loadProducts.step1')->with('productTypes', $productTypes);
        
    }
    
    /**
     * POST Method used to create product type
     */
    function createProductType(Request $request) {
        
        $productTypeName =  strtolower($request->input('productTypeName'));
        $productTypeNameSlug = strtolower($request->input('productTypeNameSlug'));

        ProductType::create(['name' => $productTypeName,
                             'slug' => $productTypeNameSlug]);
        
        return back()->withInput()->with('productTypeAdded', true); // redirect user back to page
    }
    
    /// POST method: sets session that will allow use to go to next step
    function setProductTypeSession(Request $request) {
        $productType = ProductType::find( $request->input('productTypeId') );
        
        $request->session()->put('productTypeId', $productType->id);
        $request->session()->put('productTypeName', $productType->name);
        
        // step where user will decide wether to load products or categories/subcategories
        return redirect()->route('hkload-step-pick'); 
    }
    
    /*** ****************************** ***
     *** STEP PICK                      ***
     *** ****************************** ***/
     /// GET method: Loads view for picking whether to edit (add, see) products or categories/subcategories
    function showStepPick(Request $request) {
        if( ! ($request->session()->has('productTypeId') && $request->session()->has('productTypeName') ) )
            return redirect()->route('hkload-step1')->withInput()->with('productTypeSelected', false);
            
        return view('hk.loadProducts.stepPick');
    }
     
    /*** ****************************** ***
     *** STEP OF LOADING CATEGORIES     ***
     *** ****************************** ***/
     /// GET Method: Loads view for creating product category
    function showSelectProductCategory(Request $request) {
        // Case user didnt go through step 1, redirects to it
        if( ! ($request->session()->has('productTypeId') && $request->session()->has('productTypeName') ) )
            return redirect()->route('hkload-step1')->withInput()->with('productTypeSelected', false);
        
        $productCategories = ProductType::find( $request->session()->get('productTypeId') )->categories;
        return view('hk.loadProducts.stepCategories')->with('productCategories', $productCategories);
    }
    
    // POST method
    function createProductCategory(Request $request) {
            
        $productCategoryName     =  strtolower($request->input('productCategoryName'));
        
        ProductCategory::create(['product_type_id' => $request->session()->get('productTypeId'), 
                                 'name'            => $productCategoryName]);
        
        return back()->withInput()->with('productCategoryAdded', true); // redirect user back to page
    }
    
    /// POST method: sets session that will allow use to go to next step
    function setProductCategorySession(Request $request)
    {
        $productCategory = ProductCategory::find( $request->input('productCategoryId') );
        
        $request->session()->put('productCategoryId', $productCategory->id);
        $request->session()->put('productCategoryName', $productCategory->name);
        
        return redirect()->route('hkload-subcategories');
    }
    
    /*** ************************************* ***
     *** STEP OF LOADING PRODUCT SUBCATEGORIES ***
     *** ************************************* ***/
     /// GET Method: Loads view for creating product subcategory
     function showSelectProductSubcategory(Request $request)
     {
        // Case user didnt select a Product Type, redirects
        if( ! ($request->session()->has('productTypeId') && $request->session()->has('productTypeName') ) )
            return redirect()->route('hkload-step1')->withInput()->with('productTypeSelected', false);
        
        // Case user didnt select a Product Category, redirects
        if( ! ($request->session()->has('productCategoryId') && $request->session()->has('productCategoryName') ) )
            return redirect()->route('hkload-categories')->withInput()->with('productCategorySelected', false);
            
            
        $productSubcategories = ProductCategory::find($request->session()->get('productCategoryId'))->subcategories;
        return view('hk.loadProducts.stepSubcategories')->with('productSubcategories', $productSubcategories);
    }
    
    /// POST method
    function createProductSubcategory(Request $request) {
        
        $productSubcategoryName =  strtolower($request->input('productSubcategoryName'));
        
        ProductSubcategory::create(['product_category_id' => $request->session()->get('productCategoryId'), 
                                 'name'            => $productSubcategoryName]);
        
        return back()->withInput()->with('productSubcategoryAdded', true); // redirect user back to page
    }
    
    /// GET method: This function unsets every product type, category or
    /// subcategory sessions created any step before
    function unsetSessions(Request $request)
    {
        $request->session()->forget('productTypeId');
        $request->session()->forget('productTypeName');
        
        $request->session()->forget('productCategoryId');
        $request->session()->forget('productCategoryName');
        
        return redirect()->route('hkload-step1');
    }
    
    
    /*** ****************************** ***
     *** STEP OF LOADING NEW PRODUCTS   ***
     *** ****************************** ***/
     function showLoadProduct(Request $request)
     {
        // Case user didnt select a Product Type
        if( ! ($request->session()->has('productTypeId') && $request->session()->has('productTypeName') ) )
            return redirect()->route('hkload-step1')->withInput()->with('productTypeSelected', false);
        
        $productCategories = ProductType::find( $request->session()->get('productTypeId') )->categories;
        
        return view('hk.loadProducts.stepProducts')->with('productCategories', $productCategories); 
        
    }
    
    //get method: loads products in list for user to select which one to delete
    function showDeleteProduct(Request $request)
     {
        // Case user didnt select a Product Type
        if( ! ($request->session()->has('productTypeId') && $request->session()->has('productTypeName') ) )
            return redirect()->route('hkload-step1')->withInput()->with('productTypeSelected', false);
        
        $products = ProductType::find( $request->session()->get('productTypeId') )->products;
        
        return view('hk.loadProducts.stepDeleteProducts')->with('products', $products); 
        
    }
    
    // post method: deletes selected item
    function deleteProduct(Request $request){
        $product = Product::findOrFail( $request->input('productId') );
        
        if(Storage::disk('product_img_uploads')->exists( 'img/product_img/'.$product->img_name )) {
            Storage::disk('product_img_uploads')->delete( 'img/product_img/'.$product->img_name );
            Log::info('deleted: ' . $product->img_name);
        } else {
            Log::info('imagen ' .$product->img_name. ' no existe');
        }
        
        if( $product->delete() )
            return back()->withInput()->with('productDeleted', true);
        
        
        
        return back()->withInput()->with('productDeletedFailed', true);
    }
    
    /// POST method: Loads products. Adds relationships between product and categories/subcategories
    function loadProduct(Request $request)
    {
        if( ! $request->session()->has('productTypeId')  )
            return redirect()->route('hkload-step1')->withInput()->with('productTypeSelected', false);
            
        /// Catching every input first...
        $productName        = $request->input('productName');
        $productPrice       = $request->input('productPrice');
        $productDescription = $request->input('productDescription');
        $productDetails     = $request->input('productDetails');
        $productInStock     = $request->input('productInStock');
        $productGuarantee   = $request->input('productGuarantee');
        
        if( empty($productName) || empty($productPrice) || empty($productDescription) 
            || empty($productDetails) || empty($productInStock))
            return back()->withInput()->with('emptyInput', true);
            
        if( !is_numeric($productPrice) )
            return back()->withInput()->with('invalidPrice', true);
        
        //hidden input
        $numberOfCategories = $request->input('numberOfCategories');
        
        //Make alphanumeric (removes all other characters)
        $productImgName = preg_replace("/[^a-z0-9_\s-]/", "", strtolower($productName));
        //Clean up multiple dashes or whitespaces
        $productImgName = preg_replace("/[\s-]+/", " ", $productImgName);
        //Convert whitespaces and underscore to dash
        $productImgName = preg_replace("/[\s_]/", "-", $productImgName);
        
        
        
        if( $request->hasFile(['productImg']) )
        {
            $productImg = $request->file('productImg');
            
            if( $productImg->isValid() )
                $productImg->storeAs('img/product_img', $productImgName.'.jpg', 'product_img_uploads');
            else
                return back()->withInput()->with('invalidProductImg', true);
        }
        else
            return back()->withInput()->with('invalidProductImg', true);
        
        $product = new Product(['product_type_id' => $request->session()->get('productTypeId'), 
                                'name'          => $productName,
                                'price'         => $productPrice,
                                'img_name'      => $productImgName . '.jpg',
                                'description'   => $productDescription,
                                'details'       => $productDetails,
                                'in_stock'      => $productInStock,
                                'guarantee'     => $productGuarantee ]);
        $product->save();
        
        for ($i = 0; $i < $numberOfCategories; $i++)
        {
            $subcategoryId = $request->input( 'productSubcategoryId' . $i );
            
            if( $subcategoryId !== 'default') 
                $product->subcategories()->attach( $subcategoryId );
            
        }
        
        return back()->withInput()->with('productAdded', true); // redirect user back to page*/
        
    }
    
}
