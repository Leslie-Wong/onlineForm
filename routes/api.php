<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware'=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
                    Route::post('me/notifications/single/read/{id}', [\App\Http\Controllers\API\MeNotificationsController::class,'read'])->name('me.notifications.single.read');
                    Route::get('me/notifications/unread/fetch', [\App\Http\Controllers\API\MeNotificationsController::class,'unreadFetch'])->name('me.notifications.unread.fetch');
                });

/* Auto-generated admins api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::post('/users/{user}/assign-role', [\App\Http\Controllers\API\UserController::class,'assignRole'])->name('users.assign-role');
    Route::get('/admins/dt', [\App\Http\Controllers\API\AdminController::class,'dt'])->name('admins.dt');
    Route::apiResource('/admins', \App\Http\Controllers\API\AdminController::class)->parameters(["admins" => "admin"]);
});


/* Auto-generated languages api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/languages/dt', [\App\Http\Controllers\API\LanguageController::class,'dt'])->name('languages.dt');
    Route::apiResource('/languages', \App\Http\Controllers\API\LanguageController::class)->parameters(["languages" => "language"]);
});


/* Auto-generated permissions api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/permissions/dt', [\App\Http\Controllers\API\PermissionController::class,'dt'])->name('permissions.dt');
    Route::apiResource('/permissions', \App\Http\Controllers\API\PermissionController::class)->parameters(["permissions" => "permission"]);
});


/* Auto-generated roles api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::post('/roles/{role}/assign-permission', [\App\Http\Controllers\API\RoleController::class,'assignPermission'])->name('roles.assign-permission');
    Route::get('/roles/dt', [\App\Http\Controllers\API\RoleController::class,'dt'])->name('roles.dt');
    Route::apiResource('/roles', \App\Http\Controllers\API\RoleController::class)->parameters(["roles" => "role"]);
});


/* Auto-generated users api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::post('/users/{user}/assign-role', [\App\Http\Controllers\API\UserController::class,'assignRole'])->name('users.assign-role');
    Route::get('/users/dt', [\App\Http\Controllers\API\UserController::class,'dt'])->name('users.dt');
    Route::apiResource('/users', \App\Http\Controllers\API\UserController::class)->parameters(["users" => "user"]);
});


/* Auto-generated product-types api routes */
Route::group(['as' => 'api.'], function () {
    Route::get('/product-types/dt', [\App\Http\Controllers\API\ProductTypeController::class,'dt'])->name('product-types.dt');
    Route::apiResource('/product-types', \App\Http\Controllers\API\ProductTypeController::class)->parameters(["product-types" => "productType"]);
});




/* Auto-generated forms api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/forms/dt', [\App\Http\Controllers\API\FormController::class,'dt'])->name('forms.dt');
    Route::apiResource('/forms', \App\Http\Controllers\API\FormController::class)->parameters(["forms" => "form"]);
    Route::post('/forms/data/upload', [\App\Http\Controllers\API\FormController::class,'dataUpload'])->name('forms.data.upload');
});
