<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'admin'],function(){
  Route::resource('products',ProductController::class);
});
