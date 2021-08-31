<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\HomeBannerController;

use App\Http\Controllers\Front\FrontController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[FrontController::class,'index']);
Route::get('product/{id}',[FrontController::class,'product']);
Route::get('category/{id}',[FrontController::class,'category']);
Route::post('add_to_cart',[FrontController::class,'add_to_cart']);
Route::get('/cart',[FrontController::class,'cart']);

Route::get('/admin',[AdminController::class,'index']);
Route::post('admin/auth',[AdminController::class,'auth'])->name('admin.auth');

Route::group(['middleware'=>'admin_auth'],function(){
    Route::prefix('/admin')->group(function () {
    Route::get('dashboard',[AdminController::class,'dashboard']);
    // Route::get('/admin/updatepass',[AdminController::class,'updatepassword'])->name('admin.updatepassword');
    Route::get('category',[CategoryController::class,'index']);
    Route::get('category/manage_category',[CategoryController::class,'manage_category'])->name('manage_category');
    Route::post('category/manage_category_insert',[CategoryController::class,'manage_category_insert'])->name('category.insert');
    Route::get('logout',[AdminController::class,'logout'])->name('admin.logout');
    Route::get('category/delete/{id}',[CategoryController::class,'delete'])->name('admin.delete');
    Route::get('category/{id}/edit',[CategoryController::class,'manage_category'])->name('admin.edit');
    Route::get('category/status/{status}/{id}',[CategoryController::class,'status']);

    
    Route::get('coupon',[CouponController::class,'index']);
    Route::get('coupon/manage_coupon',[CouponController::class,'manage_coupon'])->name('manage_coupon');
    Route::post('coupon/manage_coupon_insert',[CouponController::class,'manage_coupon_insert'])->name('coupon.insert');    
    Route::get('coupon/delete/{id}',[CouponController::class,'delete'])->name('admin.delete.coupon');
    Route::get('coupon/{id}/edit',[CouponController::class,'manage_coupon'])->name('admin.edit.coupon');
    Route::get('coupon/status/{status}/{id}',[CouponController::class,'status']);   

    Route::get('size',[SizeController::class,'index']);
    Route::get('size/manage_size',[SizeController::class,'manage_size'])->name('manage_size');
    Route::post('size/manage_size_insert',[SizeController::class,'manage_size_insert'])->name('size.insert');    
    Route::get('size/delete/{id}',[SizeController::class,'delete'])->name('admin.delete.size');
    Route::get('size/status/{status}/{id}',[SizeController::class,'status']);
    Route::get('size/{id}/edit',[SizeController::class,'manage_size'])->name('admin.edit.size');

    Route::get('color',[ColorController::class,'index']);
    Route::get('color/manage_color',[ColorController::class,'manage_color'])->name('manage_color');
    Route::post('color/manage_color_insert',[ColorController::class,'manage_color_insert'])->name('color.insert');    
    Route::get('color/delete/{id}',[ColorController::class,'delete'])->name('admin.delete.color');
    Route::get('color/status/{status}/{id}',[ColorController::class,'status']);
    Route::get('color/{id}/edit',[ColorController::class,'manage_color'])->name('admin.edit.color');


    Route::get('product',[ProductController::class,'index']);
    Route::get('product/manage_product',[ProductController::class,'manage_product'])->name('manage_product');
    Route::post('product/manage_product_insert',[ProductController::class,'manage_product_insert'])->name('product.insert');    
    Route::get('product/delete/{id}',[ProductController::class,'delete'])->name('admin.delete.product');
    Route::get('product/status/{status}/{id}',[ProductController::class,'status']);
    Route::get('product/{id}/edit',[ProductController::class,'manage_product'])->name('admin.edit.product');
    Route::get('product/delete_attr/{pid}/{id}',[ProductController::class,'delete_attrr']);
    Route::get('product/image_delete/{piid}/{id}',[ProductController::class,'image_delete']);

    Route::get('brand',[BrandController::class,'index']);
    Route::get('brand/manage_brand',[BrandController::class,'manage_brand'])->name('manage_brand');
    Route::post('brand/manage_brand_insert',[BrandController::class,'manage_brand_insert'])->name('brand.insert');    
    Route::get('brand/delete/{id}',[BrandController::class,'delete'])->name('admin.delete.brand');
    Route::get('brand/status/{status}/{id}',[BrandController::class,'status']);
    Route::get('brand/{id}/edit',[BrandController::class,'manage_brand']);

    Route::get('tax',[TaxController::class,'index']);
    Route::get('tax/manage_tax',[TaxController::class,'manage_tax'])->name('manage_tax');
    Route::post('tax/manage_tax_insert',[TaxController::class,'manage_tax_insert'])->name('tax.insert');    
    Route::get('tax/delete/{id}',[TaxController::class,'delete'])->name('admin.delete.tax');
    Route::get('tax/status/{status}/{id}',[TaxController::class,'status']);
    Route::get('tax/{id}/edit',[TaxController::class,'manage_tax'])->name('admin.edit.tax');


    Route::get('customers',[CustomerController::class,'index']);
    Route::get('customers/delete/{id}',[CustomerController::class,'delete'])->name('admin.delete.customers');
    Route::get('customers/show/{id}',[CustomerController::class,'show'])->name('show_customers');
    Route::get('customers/status/{status}/{id}',[CustomerController::class,'status']);

    Route::get('home_banner',[HomeBannerController::class,'index']);
    Route::get('home_banner/manage_home_banner',[HomeBannerController::class,'manage_home_banner'])->name('manage_home_banner');
    Route::post('home_banner/manage_home_banner_insert',[HomeBannerController::class,'manage_home_banner_insert'])->name('home_banner.insert');    
    Route::get('home_banner/delete/{id}',[HomeBannerController::class,'delete'])->name('admin.delete.home_banner');
    Route::get('home_banner/status/{status}/{id}',[HomeBannerController::class,'status']);
    Route::get('home_banner/{id}/edit',[HomeBannerController::class,'manage_home_banner']);


    
});

});
    



