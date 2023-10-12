<template>
    <form class="w-full" <?php echo e('@'); ?>submit.prevent="storeModel">
        <div class=" sm:col-span-4">
            <jet-label class="required" for="title" value="Title" />
            <jet-input class="w-full" type="text" id="title" name="title" v-model="form.title"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.title}"
            ></jet-input>
            <jet-input-error :message="form.errors.title" class="mt-2" />
        </div>

        <div class="mt-2 text-right">
            <inertia-button type="submit" class="bg-success font-semibold disabled:opacity-25" :disabled="form.processing">{{__("Submit")}}</inertia-button>
        </div>
    </form>
</template>

<script>
    import JetInput from "@/Jetstream/Input.vue";
    import JetLabel from "@/Jetstream/Label.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import JetInputError from "@/Jetstream/InputError.vue"
    import {useForm} from "@inertiajs/vue3";
    export default {
        name: "Create<?php echo e($modelPlural); ?>Form",
        components: {
            InertiaButton,
            JetInputError,
            JetLabel,
            JetInput,

        },
        data() {
            return {
                form: useForm({
                    title: null,
                }, {remember: false}),
            }
        },
        mounted() {
        },
        computed: {
            flash() {
                return this.<?php echo e('$'); ?>page.props.flash || {}
            }
        },
        methods: {
            async storeModel() {
                this.form.post(this.route('admin.roles.store'),{
                    onSuccess: res => {
                        if (this.flash.success) {
                            this.<?php echo e('$'); ?>emit(this.__("success"),this.__(this.flash.success));
                        } else if (this.flash.error) {
                            this.<?php echo e('$'); ?>emit(this.__("success"),this.__(this.flash.error));
                        } else {
                            this.<?php echo e('$'); ?>emit(this.__("success"),this.__("Unknown server error."))
                        }
                    },
                    onError: res => {
                        this.<?php echo e('$'); ?>emit(this.__("success"),this.__("A server error occurred"));
                    }
                },{remember: false, preserveState: true})
            }
        }
    }
</script>

<style scoped>

</style>
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/role/create-form.blade.php ENDPATH**/ ?>