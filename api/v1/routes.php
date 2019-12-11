<?php

use Dingo\Api\Routing\Router;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['prefix' => 'api/v1', 'namespace' => 'Api\v1\Controllers'], function ($api) {

    /*****************************************************************************
     * ADMIN ENDPOINTS
     *****************************************************************************/

$api->group(['prefix' => 'admin', 'namespace' => 'Admin','middleware'=>'admin'], function ($api) {

        // $api->get('/login', 'AdminController@login');
        // $api->put('/update-profile', 'AdminController@updateProfile');
        // $api->put('/change-password', 'AdminController@changePassword');

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

         /************
         * Purchase Coupon
         ***********/
        $api->group(['prefix' => 'coupons'], function ($api) {
            $api->get('/', 'CouponsController@index');
            $api->get('/{coupons_id}', 'CouponsController@show');
            $api->delete('/{coupons_id}', 'CouponsController@destroy');
            $api->put('/update/{coupons_id}', 'CouponsController@update');
            $api->post('/', 'CouponsController@store');
        });

        /***********
         * USERS
         ***********/
        $api->group(['prefix' => 'users'], function ($api) {
            $api->get('/', 'UsersController@index');
            $api->get('/{user_id}', 'UsersController@show');
            $api->get('/{user_id}/suspend', 'UsersController@show');
            $api->get('/{user_id}/orders', 'UsersController@orders');
            $api->get('/{user_id}/cart', 'UsersController@cartItems');
            $api->get('/{user_id}/wishlist', 'UsersController@wishList');
            $api->put('/{user_id}/update', 'UsersController@update');
            $api->post('/', 'UsersController@store');
        });
        $api->get('/country/{country_id}/users','UsersController@getUsersByCountry');
        $api->get('/state/{state_id}/users','UsersController@getUsersByState');
        $api->get('/city/{city_id}/users','UsersController@getUsersByCity');
    });

    $api->group(['namespace' => 'User'], function ($api) {

        /*********************************************************************************
         * USERS ENDPOINTS
         *********************************************************************************/

        $api->post('/register', 'AuthController@register');
        $api->post('/login', 'AuthController@login');
        $api->group(['prefix' => 'user','middleware'=>'auth.api'], function ($api) {
            $api->get('/profile', 'UsersController@profile');
            $api->put('/profile/update', 'UsersController@updateProfile');
            $api->post('/profile/update-photo','UsersController@uploadPhoto');
            $api->put('/change-password', 'UsersController@profile');
            $api->get('/cart-items', 'CartsController@index');
            $api->post('/cart-items/add', 'CartsController@store');
            $api->delete('/cart-items/remove/{id}', 'CartsController@removeFromCart');
            $api->get('/wish-list', 'WishListsController@index');
            $api->post('/wish-list', 'WishListsController@store');
            $api->post('/orders', 'OrdersController@createOrder');
            $api->get('/orders', 'OrdersController@getUserOrders');
            $api->post('/review','ProductsController@productReview');
        });

        /**********************************************************************************
         *GENERAL ENDPOINTS
         ***********************************************************************************/

        /********************
         * CATEGORY ENDPOINTS
         ********************/

        $api->get('/categories', 'CategoriesController@getAll');
        $api->get('/categories/{category_id}', 'CategoriesController@show');

        /************************
         * PRODUCTS ENDPOINT
         ************************/
        $api->group(['prefix' => 'products'], function ($api) {
            $api->get('/', 'ProductsController@index');
            $api->get('/discounted','ProductsController@getDiscountedProducts');
            $api->get('/{product_id}', 'ProductsController@show');
            $api->get('/category/{category_id}','CategoriesController@index');
        });

        /*************************************
         * LOCATION ENDPOINT
         *************************************/

         $api->group(['prefix' => 'location'], function ($api) {
            $api->get('/countries','LocationController@getCountries');
            $api->get('/countries/{country_id}/states','LocationController@getStates');
            $api->get('/states/{state_id}/cities','LocationController@getCities');
         });


        /****************
         * SEARCH ENDPOINT
         */

        $api->get('/search', 'SearchController@search');
    });
});
