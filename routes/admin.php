<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::group(['prefix'=>'admin','as'=>'admin.','middleware' => ['auth',IsAdminMiddleware::class]],function(){
  Route::resource('products',ProductController::class);
  Route::get('/dashboard', function () {
      return Inertia::render('Dashboard');
  })->middleware(['auth', 'verified'])->name('dashboard');
});
