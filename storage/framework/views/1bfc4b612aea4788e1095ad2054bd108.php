<?php $json = null; ?>
<?php if($column['comment']): ?>
<?php

try {
    $json = json_decode($column['comment']);
} catch (\Throwable $th) {
    $json = null;
};

?>
<?php endif; ?>
<jetin-dd>
    <template #dt><?php echo '{{__("' . $column['label'] . '")}}'; ?></template>
<?php if($json): ?>
<?php if( strtolower($json->type) == "html" ): ?>
        <span @click="openNewPage(<?php echo e('{{'); ?> <?php echo e($key!=''?$key.".".$column['name']:'model.'.$column['name']); ?> }})"> Open at new page </span>
        <?php endif; ?>
<?php elseif($column['name'] === 'lang'): ?>
    <span class="fi" :class="'fi-' + getLangFlag(<?php echo e($key!=''?$key.".".$column['name']:'model.'.$column['name']); ?>)"> </span> <span><?php echo e('{{'); ?> getLangName( <?php echo e($key!=''?$key.".".$column['name']:'model.'.$column['name']); ?>)  }}</span>
<?php else: ?>
    <?php echo e('{{'); ?> <?php echo e($key!=''?$key.".".$column['name']:'model.'.$column['name']); ?> }}
<?php endif; ?>
</jetin-dd>
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/withChildren/show-form-column.blade.php ENDPATH**/ ?>