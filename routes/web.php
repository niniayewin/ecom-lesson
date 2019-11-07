<?php

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

Route::get('/', [
   'uses'=>'ForntendController@getWelcome' ,
     'as'=> '/'
]
);
Route::get('/post-image/{file_name}',[
    'uses'=>'ForntendController@getImage',
    'as'=>'images'
]);
Route::get('/posts/{post_id}/category',[
    'uses'=>'ForntendController@getPostByCategory',
    'as'=>'post.by.category'
]);
Route::get('/search/post',[
    'uses'=>'ForntendController@getSearchPost',
    'as'=>'post.search'
]);
Route::get('/add/to/cart/{id}',[
    'uses'=>'ForntendController@addToCart',
    'as'=>'add.to.cart'
]);
Route::get('/shopping/card',[
    'uses'=>'ForntendController@getshoppingCard',
    'as'=>'shopping.cart'
]);
/*Auth::routes(['register'=>false]);*/
Auth::routes();

Route::group(['prefix'=>'user','middleware'=>'auth'],function () {
    Route::post('/checkout', [
        'uses' => 'ForntendController@postCheckout',
        'as' => 'checkout'
    ]);
    Route::get('/dashboard', [
        'uses' => 'HomeController@index',
        'as' => 'dashboard'
    ]);
    Route::post('/update/posts/',[
        'uses'=>'UserController@postUpdatePosts',
        'as'=>'update.user']);
    });
Route::group(['prefix'=>'admin','middleware'=>'role:Admin'],function (){
    Route::get('/deliver/{id}', [
        'uses'=>'OrderController@getDeliver',
        'as' => 'deliver'
    ]);
    Route::get('/users',[
        'uses'=>'UserController@getUsers',
        'as'=>'users'
    ]);
    Route::post('/assign/user/role',[
        'uses'=>'UserController@postAssignUserRole',
        'as'=>'assign.user.role'
    ]);
});

Route::group(['prefix'=>'post','middleware'=>'role:Admin'],function () {

    Route::get('/orders/filter/by/month', [
        'uses'=>'OrderController@getOrders',
        'as' => 'filter_by_month'
    ]);
    Route::get('/orders/filter/by/date', [
        'uses'=>'OrderController@getOrders',
        'as' => 'filter_by_date'
    ]);
    Route::get('/orders', [
        'uses'=>'OrderController@getOrders',
        'as' => 'orders'
    ]);
    Route::get('/categories', [
        'uses'=>'PostController@getCategory',
        'as' => 'post.categories'
    ]);
    Route::post('/categories',[
        'uses'=>'postController@NewCategories',
        'as'=>'new.post']);

    Route::get('/delete/categories/id/{id}',[
        'uses'=>'PostController@DeleteCategories',
        'as'=>'delete.category']);

    Route::post('/update/category',[
        'uses'=>'PostController@getUpdateCategory',
        'as'=>'update.category']);
    Route::get('/all',[
        'uses'=>'PostController@getPost',
        'as'=>'posts']);
    Route::get('/add/post',[
        'uses'=>'PostController@getNewPost',
        'as'=>'post.new']);
    Route::post('/add/post',[
        'uses'=>'PostController@postNewPost',
        'as'=>'add.post']);
    Route::get('/post-image/{file_name}',[
        'uses'=>'PostController@getImage',
        'as'=>'post.image']);
    Route::get('/drop/post/{id}',[
        'uses'=>'PostController@getDropPost',
        'as'=>'post.drop']);
    Route::get('/post/drop/{id}',[
        'uses'=>'UserController@getDropPosts',
        'as'=>'post.drops']);
    Route::get('/post/id/{id}/edit',[
        'uses'=>'PostController@getEditPost',
        'as'=>'edit.post']);
    Route::post('/update/post',[
        'uses'=>'PostController@postUpdatePost',
        'as'=>'update.post']);

    Route::get('/search/post',[
        'uses'=>'PostController@getSearchPost',
        'as'=>'search.post']);

});

