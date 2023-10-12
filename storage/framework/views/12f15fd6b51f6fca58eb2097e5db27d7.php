<?php
    $initData = [
        "hasCheckbox" => false,
        "hasSelect" => false,
        "hasTextArea" => false,
        "hasInput" => false,
        "hasDate" => false,
        "hasPassword" => false
    ];
?>
<template>
    <dl class="gap-4">
<?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if(!isset($col['type']) && gettype($col) === "object"): ?>
    <div class=" sm:col-span-4 children-table shadow-sm border-gray-100">
        <jet-label class="shadow-sm" for="<?php echo e($key); ?>">
            <span class="border-gray-100"><?php echo e(str_replace("_"," ",Str::title($key))); ?></span>
        </jet-label>
        <div id="<?php echo e($key); ?>" v-for="(<?php echo e($key); ?>, index) in model.<?php echo e($key); ?>">
        <div :class="['children-row', (index!=0?'children-row-n':''),(index%2!=0?'children-row-even':'')]">
        <?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childColumns): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $model->renderViewColumn($childColumns, $key, $type); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        </div>
    </div>
<?php else: ?>
    <?php echo $model->renderViewColumn($col, "", $type); ?>

<?php endif; ?>
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
<style>
    .children-table{
        border-width: 1px;
        border-radius: 10px;
        padding: 15px 10px;
        margin-top: 25px;
        margin-bottom: 20px;
        position: relative;
    }

    .children-row{
        margin-bottom: 10px;
    }
    .children-row-n{
        margin-top: 20px;
        padding-top: 10px;
        border-top: 1px silver dashed;
    }

    .children-row-even {
        background-color: #b1ff8517;
        margin-left: -10px;
        margin-right: -10px;
        padding-left: 10px;
        padding-right: 10px;
    }
    .children-table > label > span > span{
        position: absolute;
        top: -17px;
        background-color: white;
        padding: 3px 10px;
        border-width: 1px;
        border-radius: 10px;
    }
</style>
<script>
    import JetLabel from "@/Jetstream/Label.vue";
    import JetinDd from "@/JetinComponents/JetinDd.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";

    import { defineComponent } from "vue";

    export default defineComponent({
        name: "Show<?php echo e($modelPlural); ?>Form",
        props: {
            model: Object,
        },
        components: {
            JetLabel,
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
        methods: {
            getLangName(props){
                return this.$page.props.languages.find(i => i.code === props).name
            },
            getLangFlag(props){
                return this.$page.props.languages.find(i => i.code === props).flag
            },
            openNewPage(html){
                const winHtml = `<!DOCTYPE html>
                    <html>
                        <head>
                            <title>Window with Blob</title>
                        </head>
                        <body>
                            `+html+`
                        </body>
                    </html>`;

                const winUrl = URL.createObjectURL(
                    new Blob([winHtml], { type: "text/html" })
                );

                const win = window.open(
                    winUrl,
                    "win",
                    `width=800,height=400,screenX=200,screenY=200`
                );
            }
        }
    });
</script>

<style scoped>

</style>
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/withChildren/show-form.blade.php ENDPATH**/ ?>