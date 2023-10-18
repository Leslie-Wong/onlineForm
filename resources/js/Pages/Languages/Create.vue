<template>
    <jetin-layout :title="__('New') + '-' + __('Language')">
        <template #navbar-button>
            <div class="flex flex-wrap items-center justify-between w-full px-4">
                <inertia-link :href="route('admin.languages.index')"
                              class="text-xl font-black text-zinc-400"><i
                        class="fas fa-arrow-left"></i> {{__('Back')}} | {{__('New')}} {{__("Language")}}
                </inertia-link>
            </div>
        </template>
        <div class="flex flex-wrap px-4">
            <div class="z-10 flex-auto max-w-2xl p-4 mx-auto bg-white md:rounded-md md:shadow-md">
                <create-languages-form @success="onSuccess" @error="onError"/>
            </div>
        </div>
    </jetin-layout>
</template>

<script>
    import JetinLayout from "@/Layouts/JetinLayout.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import CreateLanguagesForm from "./CreateForm.vue";
    import DisplayMixin from "@/Mixins/DisplayMixin.js";
    import { defineComponent } from "vue";

    export default defineComponent({
        name: "CreateLanguages",
        components: {
            InertiaButton,
            JetinLayout,
            CreateLanguagesForm,
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
                this.$inertia.visit(route('admin.languages.index'));
            },
            onError(msg) {
                this.displayNotification(this.__("error"),msg, "error");
            }
        }
    });
</script>

<style scoped>

</style>
