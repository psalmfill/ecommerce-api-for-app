<?php

use Dingo\Api\Routing\Router;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['prefix' => 'api/v1', 'namespace' => 'Api\v1\Controllers'], function ($api) {

    /*****************************************************************************
     * ADMIN ENDPOINTS
     *****************************************************************************/

    $api->group(['prefix' => 'admin', 'namespace' => 'Admin','middleware'=>'admin'], function ($api) {

        $api->get('/login', 'AdminController@login');
        $api->put('/update-profile', 'AdminController@updateProfile');
        $api->put('/change-password', 'AdminController@changePassword');

        /***********
         * PRODUCTS
         ***********/
        $api->group(['prefix' => 'product'], function ($api) {
            $api->get('/', 'ProductsController@index');
            $api->get('/{product_id}', 'ProductsController@show');
            $api->delete('/{product_id}', 'ProductsController@destroy');
            $api->put('/update/{product_id}', 'ProductsController@update');
            $api->post('/', 'ProductsController@store');
        });

        /************
         * CATEGORY
         ************/
        $api->group(['prefix' => 'category'], function ($api) {
            $api->get('/', 'CategoriesController@index');
            $api->get('/{category_id}', 'CategoriesController@show');
            $api->get('/{category_id}/sub-category', 'CategoriesController@subCategory');
            $api->delete('/{category_id}', 'CategoriesController@destroy');
            $api->put('/update/{category_id}', 'CategoriesController@update');
            $api->post('/', 'CategoriesController@store');
        });

        /************
         * ROLE
         ***********/
        $api->group(['prefix' => 'role'], function ($api) {
            $api->get('/', 'RolesController@index');
            $api->get('/{role_id}', 'RolesController@show');
            $api->delete('/{role_id}', 'RolesController@destroy');
            $api->put('/update/{role_id}', 'RolesController@update');
            $api->post('/', 'RolesController@store');
        });

        /***********
         * USERS
         ***********/
        $api->group(['prefix' => 'users'], function ($api) {
            $api->get('/', 'UsersController@index');
            $api->get('/{user_id}', 'UsersController@show');
            $api->get('/suspend/{user_id}', 'UsersController@show');
            $api->get('/orders/{user_id}', 'UsersController@orders');
            $api->get('cart/{user_id}', 'UsersController@cartItems');
            $api->get('wishlist/{user_id}', 'UsersController@wishList');
            $api->put('/update/{user_id}', 'UsersController@update');
            $api->post('/', 'UsersController@store');
        });
    });

    $api->group(['namespace' => 'User'], function ($api) {

        /*********************************************************************************
         * USERS ENDPOINTS
         *********************************************************************************/

        $api->post('/register', 'AuthController@register');
        $api->post('/login', 'AuthController@login');
        $api->group(['prefix' => 'user'], function ($api) {
            $api->get('/profile/{user_id}', 'UsersController@profile');
            $api->put('/profile/update', 'UsersController@updateProfile');
            $api->put('/change-password', 'UsersController@profile');
            $api->get('/cart-items/{user_id}', 'CartsController@index');
            $api->post('/cart-items/add', 'CartsController@store');
            $api->delete('/cart-items/remove/{id}', 'CartsController@removeFromCart');
            $api->get('/wish-list/{user_id}', 'WishListsController@index');
            $api->post('/wish-list', 'WishListsController@store');
            $api->post('/orders', 'OrdersController@createOrder');
            $api->get('/orders/{user_id}', 'OrdersController@getUserOrders');
            $api->post('/review','ProductsController@productReview');
        });

        /**********************************************************************************
         *GENERAL ENDPOINTS
         ***********************************************************************************/

        /********************
         * CATEGORY ENDPOINTS
         ********************/

        $api->get('/categories', 'CategoriesController@index');
        $api->get('/category/{category_id}', 'CategoriesController@show');
        $api->get('/category/sub-category/{category_id}', 'CategoriesController@subCategory');

        /************************
         * PRODUCTS ENDPOINT
         ************************/
        $api->group(['prefix' => 'products'], function ($api) {
            $api->get('/', 'ProductsController@index');
            $api->get('/{product_id}', 'ProductsController@show');
            $api->get('/category/{category_id}','CategoriesController@index');
        });


        /****************
         * SEARCH ENDPOINT
         */

        $api->get('/search', 'SearchController@search');
    });
});
