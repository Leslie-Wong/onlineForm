<template>
    <jetin-layout :title="__('New') + '-' + __('Admin')">
        <template #navbar-button>
            <div class="flex flex-wrap items-center justify-between w-full px-4">
                <inertia-link :href="route('admin.admins.index')"
                              class="text-xl font-black text-zinc-400"><i
                        class="fas fa-arrow-left"></i> {{__('Back')}} | {{__('New')}} Admin
                </inertia-link>
            </div>
        </template>
        <div class="flex flex-wrap px-4">
            <div class="z-10 flex-auto max-w-2xl p-4 mx-auto bg-white md:rounded-md md:shadow-md">
                <create-admins-form @success="onSuccess" @error="onError"/>
            </div>
        </div>
    </jetin-layout>
</template>

<script>
    import JetinLayout from "@/Layouts/JetinLayout.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import CreateAdminsForm from "./CreateForm.vue";
    import DisplayMixin from "@/Mixins/DisplayMixin.js";
    export default {
        name: "CreateAdmins",
        components: {
            InertiaButton,
            JetinLayout,
            CreateAdminsForm,
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
                this.$inertia.visit(route('admin.admins.index'));
            },
            onError(msg) {
                this.displayNotification(this.__("error"),msg, "error");
            }
        }
    }
</script>

<style scoped>

</style>
