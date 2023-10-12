<template>
    <Head :title="title" />
    <div class="pr-4 mx-auto sm:pr-6 lg:pr-8">
        <div class="flex w-full justify-between h-16">
            <div class="w-full flex items-center sm:ml-6">
                <div class="w-full"></div>
                <language-selector />
                <nav-link :href="route('login')" :active="route().current('login')">{{__('Login')}}</nav-link>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap px-4">
        <div class="flex-auto max-w-2xl p-4 mx-auto bg-white md:rounded-md md:shadow-md">
            <pub-create-forms-form @success="onSuccess" @error="onError"/>
        </div>
    </div>
</template>

<script>
    // import JetinLayout from "@/Layouts/JetinLayout.vue";
    import NavLink from '@/Components/NavLink.vue';
    import PubCreateFormsForm from "./PubCreateForm.vue";
    import DisplayMixin from "@/Mixins/DisplayMixin.js";
    import LanguageSelector from "@/LesComponents/LanguageSelector.vue";
    import { defineComponent } from "vue";

    export default defineComponent({
        name: "PubCreateForms",
        components: {
            NavLink,
            PubCreateFormsForm,
            LanguageSelector,
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
                this.$inertia.visit(route('forms.finish'));
            },
            onError(msg) {
                this.displayNotification(this.__("error"),msg, "error");
            }
        }
    });
</script>

<style scoped>

</style>
