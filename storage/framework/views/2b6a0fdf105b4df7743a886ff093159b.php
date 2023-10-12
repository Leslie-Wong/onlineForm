
/* Auto-generated <?php echo e($modelRouteName); ?> admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('<?php echo e($modelRouteName); ?>', \App\Http\Controllers\Admin\<?php echo e($controllerClassName); ?>::class)->parameters(["<?php echo e($modelRouteName); ?>" => "<?php echo e($modelVariableName); ?>"]);
});
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/permission/routes.blade.php ENDPATH**/ ?>