<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
 //   return view('welcome');
//});

//Route::get('blade', function () {
  //  return view('viewEngine');
//});

//////////////client////////////
Route::get('/', [
    'uses' => 'HomepageController@home',
    'as' => 'ui.index'
]);

Route::get('/blog', function () {
    return view('ui.blog');
})->name('ui.blog');
Route::get('/team', function () {
    return view('ui.team');
})->name('ui.team');
Route::get('/testimonial', function () {
    return view('ui.testimonial');
})->name('ui.testimonial');
Route::get('/schedule', function () {
    return view('ui.schedule');
})->name('ui.schedule');

Route::group(['prefix' => 'home'], function () {

    Route::get('products', [
        'uses' => 'HomepageController@index',
        'as' => 'ui.home'
    ]);
// home

    Route::get('category/{id_cate}',[
        'uses' => 'HomepageController@getproductsfromcate',
        'as' => 'ui.showproducts'
    ]);
//    Route::get('category',[
//        'uses' => 'HomepageController@listcate',
//        'as' => 'ui.category'
//    ]);
    //details

    Route::get('details/{id_p?}',[
        'uses' => 'HomepageController@showdetails',
        'as' => 'ui.details'
    ]);
    Route::get('show/{id_p}',[
        'uses' => 'HomepageController@show',
        'as' => 'ui.show'
    ]);

     Route::get('create',[
       'uses' => 'HomepageController@create',
        'as' => 'ui.create'
    ]);

    Route::post('create',[
        'uses' => 'HomepageController@storecustomer',
        'as' => 'ui.store'
    ]);

    Route::get('update/{id_p}',[
        'uses' => 'HomepageController@edit',
        'as' => 'ui.edit'
    ]);

    Route::post('update/{id_p}',[
        'uses' => 'HomepageController@update',
        'as' => 'ui.update'
    ]);

    Route::get('search/',[
        'uses' => 'HomepageController@search',
        'as' => 'ui.search'
    ]);
    Route::get('thanks',function(){
        return view('ui.thankyou');
    })->name('ui.thank');


});
////////////////Login Admin ////////////////////////////////////
///
Route::group(['prefix' => 'auth'], function (){
    Route::get('login',[
        'uses' => 'ManualAuthController@ask',
        'as' => 'auth.ask'
    ]);

    Route::post('login',[
        'uses' => 'ManualAuthController@signin',
        'as' => 'auth.signin'
    ]);

    Route::get('logout',[
        'uses' => 'ManualAuthController@signout',
        'as' => 'auth.signout'
    ]);
});

Route::group(['prefix' => 'blog'], function () {
    Route::get('', [
        'uses' => 'BlogController@index',
        'as' => 'blog.index'
    ]);

    Route::get('show/{id}', [
        'uses' => 'BlogController@show',
        'as' => 'blog.show'
    ]);

    Route::get('create', [
        'uses' => 'BlogController@create',
        'as' => 'blog.create'
    ]);

    Route::post('create', [
        'uses' => 'BlogController@store',
        'as' => 'blog.store'
    ]);

    Route::get('update/{id}', [
        'uses' => 'BlogController@edit',
        'as' => 'blog.edit'
    ]);

    Route::post('update/{id}', [
        'uses' => 'BlogController@update',
        'as' => 'blog.update'
    ]);

    Route::get('delete/{id}', [
        'uses' => 'BlogController@confirm',
        'as' => 'blog.confirm'
    ]);

    Route::post('delete/{id}', [
        'uses' => 'BlogController@destroy',
        'as' => 'blog.destroy'
    ]);

    // Route cho bình luận
    Route::post('{id}/comment', [
        'uses' => 'BlogController@storeComment',
        'as' => 'blog.comment.store'
    ]);

    Route::post('{id}/comment/{commentId}/destroy', [
        'uses' => 'BlogController@destroyComment',
        'as' => 'blog.comment.destroy'
    ]);
});

///////////handicraftRepos/////////////////////////

Route::group(
    ['prefix' => 'product', 'middleware' => ['manual.auth']],
    function () {

    Route::get('', [
        'uses' => 'ProductController@index',
        'as' => 'product.index'
    ]);

    Route::get('show/{id_p}',[
        'uses' => 'ProductController@show',
        'as' => 'product.show'
    ]);

    Route::get('create',[
        'uses' => 'ProductController@create',
        'as' => 'product.create'
    ]);

    Route::post('create',[
        'uses' => 'ProductController@store',
        'as' => 'product.store'
    ]);

    Route::get('update/{id_p}',[
        'uses' => 'ProductController@edit',
        'as' => 'product.edit'
    ]);

    Route::post('update/{id_p}',[
        'uses' => 'ProductController@update',
        'as' => 'product.update'
    ]);

    Route::get('delete/{id_p}', [
        'uses' => 'ProductController@confirm',
        'as' => 'product.confirm'
    ]);

    Route::post('delete/{id_p}',[
        'uses' => 'ProductController@destroy',
        'as' => 'product.destroy'
    ]);


});

/////////////admin///////////////////

Route::group(['prefix' => 'admin', 'middleware' => ['manual.auth']], function () {
    Route::get('', [
        'uses' => 'AdminController@index',
        'as' => 'admin.index'
    ]);

    Route::get('show/{id_a}',[
        'uses' => 'AdminController@show',
        'as' => 'admin.show'
    ]);

    Route::get('update/{id_a}',[
        'uses' => 'AdminController@edit',
        'as' => 'admin.edit'
    ]);

    Route::post('update/{id_a}',[
        'uses' => 'AdminController@update',
        'as' => 'admin.update'
    ]);



});
///////////////Category////////////////////


Route::group(['prefix' => 'category', 'middleware' => ['manual.auth']], function () {

    Route::get('', [
        'uses' => 'CategoryController@index',
        'as' => 'category.index'
    ]);

    Route::get('show/{id_cate}',[
        'uses' => 'CategoryController@show',
        'as' => 'category.show'
    ]);

    Route::get('create',[
        'uses' => 'CategoryController@create',
        'as' => 'category.create'
    ]);

    Route::post('create',[
        'uses' => 'CategoryController@store',
        'as' => 'category.store'
    ]);

    Route::get('update/{id_cate}',[
        'uses' => 'CategoryController@edit',
        'as' => 'category.edit'
    ]);

    Route::post('update/{id_cate}',[
        'uses' => 'CategoryController@update',
        'as' => 'category.update'
    ]);

    Route::get('delete/{id_cate}', [
        'uses' => 'CategoryController@confirm',
        'as' => 'category.confirm'
    ]);

    Route::post('delete/{id_cate}',[
        'uses' => 'CategoryController@destroy',
        'as' => 'category.destroy'
    ]);
});

////////////////////////Customer////////////////////////////////////
Route::group(['prefix' => 'customer', 'middleware' => ['manual.auth']], function () {
    Route::get('', [
        'uses' => 'CustomerController@index',
        'as' => 'customer.index'
    ]);

    Route::get('show/{id_c}',[
        'uses' => 'CustomerController@show',
        'as' => 'customer.show'
    ]);

    Route::get('update/{id_c}',[
        'uses' => 'CustomerController@edit',
        'as' => 'customer.edit'
    ]);

    Route::post('update/{id_c}',[
        'uses' => 'CustomerController@update',
        'as' => 'customer.update'
    ]);

    Route::get('delete/{id_c}', [
        'uses' => 'CustomerController@confirm',
        'as' => 'customer.confirm'
    ]);

    Route::post('delete/{id_c}',[
        'uses' => 'CustomerController@destroy',
        'as' => 'customer.destroy'
    ]);
});


/////////////////////////////////////////////////

