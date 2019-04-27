<?php

use Illuminate\Support\Facades\Route;

Route::get('/list', 'CurrencyController@list');

Route::get('/newest-rate/{code}', 'CurrencyController@newestRate');

Route::get('/average-rate/{code}', 'CurrencyController@averageRate');
