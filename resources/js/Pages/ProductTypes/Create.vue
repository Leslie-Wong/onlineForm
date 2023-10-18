<template>
    <jetin-layout :title="__('New') + '-' + __('Product Type')">
        <template #navbar-button>
            <div class="flex flex-wrap items-center justify-between w-full px-4">
                <inertia-link :href="route('admin.product-types.index')"
                              class="text-xl font-black text-zinc-400"><i
                        class="fas fa-arrow-left"></i> {{__('Back')}} | {{__('New')}} {{__("Product Type")}}
                </inertia-link>
            </div>
        </template>
        <div class="flex flex-wrap px-4">
            <div class="flex-auto max-w-2xl p-4 mx-auto bg-white md:rounded-md md:shadow-md">
                <create-product-types-form @success="onSuccess" @error="onError"/>
            </div>
        </div>
    </jetin-layout>
</template>

<script>
    import JetinLayout from "@/Layouts/JetinLayout.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import CreateProductTypesForm from "./CreateForm.vue";
    import DisplayMixin from "@/Mixins/DisplayMixin.js";
    import { defineComponent } from "vue";

    export default defineComponent({
        name: "CreateProductTypes",
        components: {
            InertiaButton,
            JetinLayout,
            CreateProductTypesForm,
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
                this.$inertia.visit(route('admin.product-types.index'));
            },
            onError(msg) {
                this.displayNotification(this.__("error"),msg, "error");
            }
        }
    });
</script>

<style scoped>

</style>
