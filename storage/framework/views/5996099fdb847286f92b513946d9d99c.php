/* Auto-generated <?php echo e($modelRouteName); ?> api routes */
Route::group(["middleware"=>['auth:sanctum', 'verified'],'as' => 'api.'], function () {
    Route::get('/<?php echo e($modelRouteName); ?>/dt', [\App\Http\Controllers\API\<?php echo e($controllerClassName); ?>::class,'dt'])->name('<?php echo e($modelRouteName); ?>.dt');
    Route::apiResource('/<?php echo e($modelRouteName); ?>', \App\Http\Controllers\API\<?php echo e($controllerClassName); ?>::class)->parameters(["<?php echo e($modelRouteName); ?>" => "<?php echo e($modelVariableName); ?>"]);
});
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/permission/api-routes.blade.php ENDPATH**/ ?>