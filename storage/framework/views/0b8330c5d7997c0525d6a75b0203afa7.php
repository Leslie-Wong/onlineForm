
/* Auto-generated <?php echo e($modelRouteName); ?> admin routes */
Route::group(["prefix" => "admin","as" => "admin.","middleware"=>['auth:sanctum', 'verified']], function () {
    Route::resource('<?php echo e($modelRouteName); ?>', \App\Http\Controllers\Admin\<?php echo e($controllerClassName); ?>::class)->parameters(["<?php echo e($modelRouteName); ?>" => "<?php echo e($modelVariableName); ?>"]);
<?php if(isset($children) && count($children)): ?>
    Route::delete('<?php echo e($modelRouteName); ?>.children.destroy', [\App\Http\Controllers\Admin\<?php echo e($controllerClassName); ?>::class,"destroyChild"])->name("<?php echo e($modelRouteName); ?>.children.destroy");
<?php endif; ?>
<?php if(isset($rootOptions) && in_array('pdfview', $rootOptions)): ?>
    Route::get('/<?php echo e($modelRouteName); ?>/<?php echo e("{"); ?><?php echo e($modelVariableName); ?><?php echo e("}"); ?>/pdf/view', [\App\Http\Controllers\Admin\<?php echo e($controllerClassName); ?>::class,"pdfView"])->name("<?php echo e($modelRouteName); ?>.pdf.view");
<?php endif; ?>
});


<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/withChildren/routes.blade.php ENDPATH**/ ?>