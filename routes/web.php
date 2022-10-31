<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\UserController;
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

Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::prefix('/shopping-list')->middleware(['auth'])->group( function () {
    Route::post('/store', [ShoppingListController::class, 'store'])->name("shopping-list.store");

    Route::prefix('/{shopping_list_id}')->group( function () {
        Route::put('', [ShoppingListController::class, 'update'])->name('shopping-list.update');
        Route::delete('', [ShoppingListController::class, 'destroy'])->name('shopping-list.destroy');

        Route::prefix('/items')->group ( function () {
            Route::post('/store', [ItemController::class, 'store'])->name('item.store');
            Route::put('/{item_id}', [ItemController::class, 'update'])->name('item.update');
            Route::delete('/{item_id}', [ItemController::class, 'destroy'])->name('item.destroy');
        });
    });
});

require __DIR__.'/auth.php';
