<template>
    <jetin-layout :title="__('Details of') + '-' + <?php echo '__(\'' . $modelTitle. '\')'; ?>">
        <template <?php echo e('#'); ?>navbar-button>
            <div
                class="flex flex-wrap items-center justify-between w-full px-4"
            >
                <inertia-link
                    :href="route('admin.<?php echo e($modelRouteAndViewName); ?>.index')"
                    class="text-2xl font-black text-zinc-400"
                ><i class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?> | <?php echo e(__('Details of')); ?> <?php echo e(__($modelTitle)); ?>

                    #{{ model.id }}</inertia-link>
            </div>
        </template>
        <div v-if="model.can.view" class="flex flex-wrap px-4">
            <div
                class="z-10 flex-auto max-w-5xl p-4 mx-auto bg-white md:rounded-md md:shadow-md"
            >
                <show-<?php echo e($modelRouteAndViewName); ?>-form :model="model"></show-<?php echo e($modelRouteAndViewName); ?>-form>
            </div>
        </div>
        <div v-else class="text-center space-4 px-4 bg-white rounded-md shadow-md text-red-500 font-bold text-lg">
            You don't have permission to view this resource.
        </div>
    </jetin-layout>
</template>

<script>
    import JetinLayout from "@/Layouts/JetinLayout.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import Show<?php echo e($modelPlural); ?>Form from "./ShowForm.vue"
    export default {
        name: "Show<?php echo e($modelPlural); ?>",
        components: {
            InertiaButton,
            JetinLayout,
            Show<?php echo e($modelPlural); ?>Form,
        },
        props: {
            model: Object
        },
        data() {
            return {};
        },
        mounted() {},
        methods: {}
    };
</script>

<style <?php echo e('scoped'); ?>></style>

<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/role/show.blade.php ENDPATH**/ ?>