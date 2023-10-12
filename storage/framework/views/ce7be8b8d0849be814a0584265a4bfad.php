<?php
    $hasCheckbox = false;
    $hasSelect = false;
    $hasTextArea = false;
    $hasInput = false;
    $hasDate = false;
    $hasPassword = false;
?>
<template>
    <dl class="gap-4">
<?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <jetin-dd>
            <template #dt><?php echo '{{__("' . $column['label'] . '")}}'; ?>:</template>
            <?php echo e('{{'); ?> model.<?php echo e($column['name']); ?> }}
        </jetin-dd>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if(isset($relations['belongsTo']) && count($relations["belongsTo"])): ?>
<?php $__currentLoopData = $relations["belongsTo"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <jetin-dd>
            <template #dt><?php echo '{{__("' . $parent['related_model_title'] . '")}}'; ?>:</template>
            <?php echo e('{{'); ?> model.<?php echo e($parent['relationship_variable']); ?> ? model.<?php echo e($parent['relationship_variable']); ?>.<?php echo e($parent["label_column"]); ?> : '-' }}
        </jetin-dd>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</dl>
</template>

<script>
    import JetinDd from "@/JetinComponents/JetinDd.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";

    export default {
        name: "Show<?php echo e($modelPlural); ?>Form",
        props: {
            model: Object,
        },
        components: {
            InertiaButton,
            JetinDd,
        },
        data() {
            return {}
        },
        mounted() {},
        computed: {
            flash() {
                return this.$page.props.flash || {}
            }
        },
        methods: {}
    }
</script>

<style scoped>

</style>
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/permission/show-form.blade.php ENDPATH**/ ?>