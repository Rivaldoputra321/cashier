<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardStaffController;
use App\Http\Controllers\DashboardMemberController;
use App\Http\Controllers\DashboardHistoryController;
use App\Http\Controllers\DashboardLaporanController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\DashboardCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {


    Route::get('loginowner', [AuthController::class, 'indexowner']);
    Route::post('loginowner',[AuthController::class, 'loginowner'])->name('loginowner');

    Route::get('loginstaff', [AuthController::class, 'indexstaff']);
    Route::post('loginstaff',[AuthController::class, 'loginstaff'])->name('loginstaff');

    Route::get('login', [AuthController::class, 'indexadmin']);
    Route::post('login',[AuthController::class, 'login'])->name('login');


    Route::get('register', [AuthController::class, 'indexreg']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('/', [BeginController::class, 'index'])->name('begin');#
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {

        
        Route::get('dashboard', [DashboardController::class, 'index']);
                
        // Route::get('category', [CategoryController::class, 'index'])->name('dashboard_category');
        // Route::get('categories_add', [CategoryController::class, 'add']);
        // Route::post('categories_add', [CategoryController::class, 'store']);
        // Route::get('categories_edit/{slug}', [CategoryController::class, 'edit']);
        // Route::put('categories_edit/{slug}', [CategoryController::class, 'update']);
        Route::resource('/dashboard_category', DashboardCategoryController::class);



        // Route::get('dashboard_staff', [DashboardStaffController::class, 'indexstaff'])->name('dashboard_staff_index');
        // Route::get('dashboard_staff_add', [DashboardStaffController::class, 'storestaffindex']);
        // Route::post('dashboard_staff_add', [DashboardStaffController::class, 'storestaff']);
        // Route::get('dashboard_staff_edit', [DashboardStaffController::class, 'edit']);
        // Route::put('dashboard_staff_edit', [DashboardStaffController::class, 'updatestaff']);
        Route::resource('/dashboard_staff', DashboardStaffController::class);
        Route::resource('/dashboard_member', DashboardMemberController::class);
        Route::resource('/dashboard_product', DashboardProductController::class);
        Route::resource('/dashboard_admin', DashboardAdminController::class);
        Route::get('/dashboard_inactive', [DashboardAdminController::class, 'inactive'])->name('dashboard_inactive');
        Route::post('/dashboard_inactive/{id}/activate', [DashboardAdminController::class, 'activate'])->name('dashboard_inactive.activate');
        // routes/web.php
Route::get('/transaksi', [TransactionController::class, 'index']);
Route::post('/transaksi', [TransactionController::class, 'processTransaction'])->name('transaksi');


Route::post('/add-to-cart/{id}', [TransactionController::class, 'addToCart'])->name('add-to-cart');
Route::post('/minus/{id}', [TransactionController::class, 'minus'])->name('minus');
Route::post('/plus/{id}', [TransactionController::class, 'plus'])->name('plus');
Route::post('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
Route::delete('/delete/{id}', [TransactionController::class, 'delete'])->name('delete');

Route::get('/nota/{id}', [TransactionController::class, 'showNota'])->name('nota.show');

Route::get('/history', [DashboardHistoryController::class, 'history'])->name('history');
Route::get('/laporan', [DashboardLaporanController::class, 'index'])->name('laporan');






});




Route::get('logout', [AuthController::class, 'logout']);