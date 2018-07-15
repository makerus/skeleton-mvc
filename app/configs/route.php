<?php

use system\core\Route;

Route::middleware('DemoMiddleware');

Route::get('/', 'IndexController@index');
Route::get('/:s/:i', 'IndexController@index');