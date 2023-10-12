<?php
    $hasCheckbox = false;
    $hasSelect = false;
    $hasTextArea = false;
    $hasInput = false;
    $hasPassword = false;
?>
<template>
    <jetin-layout :title="__('Edit') + '-' + <?php echo '__(\'' . $modelTitle. '\')'; ?>">
        <template <?php echo e('#'); ?>navbar-button>
            <div class="flex flex-wrap items-center justify-between w-full px-4">
                <inertia-link :href="route('admin.<?php echo e($modelRouteAndViewName); ?>.index')" class="text-xl font-black text-zinc-400"><i class="fas fa-arrow-left"></i> {{__('Back') }} | {{__('Edit') }}
                    <?php echo '{{__("' . $modelTitle. '")}}'; ?> #{{model.id}}</inertia-link>
            </div>
        </template>
        <div class="flex flex-wrap px-4">
            <div class="flex-auto max-w-2xl p-4 mx-auto bg-white md:rounded-md md:shadow-md">
                <edit-<?php echo e($modelRouteAndViewName); ?>-form :model="model" <?php echo e('@'); ?>success="onSuccess" <?php echo e('@'); ?>error="onError"/>
            </div>
        </div>
    </jetin-layout>
</template>

<script>
    import JetinLayout from "@/Layouts/JetinLayout.vue";
    import JetLabel from "@/Jetstream/Label.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import JetInputError from "@/Jetstream/InputError.vue";
    import JetButton from "@/Jetstream/Button.vue";
    import Edit<?php echo e($modelPlural); ?>Form from "./EditForm.vue";
    import DisplayMixin from "@/Mixins/DisplayMixin.js";
    import { defineComponent } from "vue";

    export default defineComponent({
        name: "Edit<?php echo e($modelPlural); ?>",
        props: {
            model: Object,
        },
        components: {
            InertiaButton,
            JetLabel,
            JetButton,
            JetInputError,
            JetinLayout,
            Edit<?php echo e($modelPlural); ?>Form,
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
        },methods: {
            onSuccess(msg) {
                localStorage.setItem('notifyMessage', `{"status":"success", "msg":"${msg}"}`);
                this.$inertia.visit(route('admin.<?php echo e($modelRouteAndViewName); ?>.index'));
            },
            onError(msg) {
                this.displayNotification(this.__("error"),msg, "error");
            }
        }
    });
</script>

<style scoped>

</style>
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/edit.blade.php ENDPATH**/ ?>