<?php
    $hasCheckbox = false;
    $hasSelect = false;
    $hasTextArea = false;
    $hasInput = false;
?>
<template>
    <jetin-layout :title="__('New') + '-' + <?php echo '__(\'' . $modelTitle. '\')'; ?>">
        <template <?php echo e('#'); ?>navbar-button>
            <div class="flex flex-wrap items-center justify-between w-full px-4">
                <inertia-link :href="route('admin.<?php echo e($modelRouteAndViewName); ?>.index')"
                              class="text-xl font-black text-zinc-400"><i
                        class="fas fa-arrow-left"></i> {{__('Back')}} | {{__('New')}} <?php echo '@{{__("' . $modelTitle. '")}}'; ?>

                </inertia-link>
            </div>
        </template>
        <div class="flex flex-wrap px-4">
            <div class="z-10 flex-auto max-w-2xl p-4 mx-auto bg-white md:rounded-md md:shadow-md">
                <create-<?php echo e($modelRouteAndViewName); ?>-form <?php echo e('@'); ?>success="onSuccess" <?php echo e('@'); ?>error="onError"/>
            </div>
        </div>
    </jetin-layout>
</template>

<script>
    import JetinLayout from "@/Layouts/JetinLayout.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import Create<?php echo e($modelPlural); ?>Form from "./CreateForm.vue";
    import DisplayMixin from "@/Mixins/DisplayMixin.js";
    export default {
        name: "Create<?php echo e($modelPlural); ?>",
        components: {
            InertiaButton,
            JetinLayout,
            Create<?php echo e($modelPlural); ?>Form,
        },
        data() {
            return {}
        },
        mixins: [DisplayMixin],
        mounted() {},
        computed: {
            flash() {
                return this.$page.props.flash || {}
            }
        },
        methods: {
            onSuccess(msg) {
                localStorage.setItem('notifyMessage', `{"status":"success", "msg":"${msg}"}`);
                this.$inertia.visit(route('admin.<?php echo e($modelRouteAndViewName); ?>.index'));
            },
            onError(msg) {
                this.displayNotification(this.__("error"),msg, "error");
            }
        }
    }
</script>

<style scoped>

</style>
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/permission/create.blade.php ENDPATH**/ ?>