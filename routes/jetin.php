<?php
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SendNotificationController;

Route::get('language/{language}', function ($language) {
    Session()->put('locale', $language);

    return redirect()->back();
})->name('language');

Route::middleware(['auth:sanctum', 'verified'])->get('/admin', function () {
    return Inertia::render('AdminDashboard');
})->name('admin.dashboard');


Route::get('/send-notify-test', [SendNotificationController::class, 'index']);


/* Auto-generated admins admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class)->parameters(["admins" => "admin"]);
});


/* Auto-generated languages admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('languages', \App\Http\Controllers\Admin\LanguageController::class)->parameters(["languages" => "language"]);
});


/* Auto-generated permissions admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class)->parameters(["permissions" => "permission"]);
});


/* Auto-generated roles admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->parameters(["roles" => "role"]);
});


/* Auto-generated users admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->parameters(["users" => "user"]);
});


/* Auto-generated product-types admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('product-types', \App\Http\Controllers\Admin\ProductTypeController::class)->parameters(["product-types" => "productType"]);
});


/* Auto-generated forms admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('forms', \App\Http\Controllers\Admin\FormController::class)->parameters(["forms" => "form"]);
    Route::delete('forms.children.destroy', [\App\Http\Controllers\Admin\FormController::class,"destroyChild"])->name("forms.children.destroy");
});


