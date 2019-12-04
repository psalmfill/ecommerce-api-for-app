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

Route::get('/', function () {
    return view('welcome');
});

Route::get('mail', function () {
    $invoice = App\Order::find('17b8f6e8-883d-4b4e-91a0-4adcc09105b5');

    return (new App\Notifications\OrderCompleted($invoice))
                ->toMail($invoice->user);
});