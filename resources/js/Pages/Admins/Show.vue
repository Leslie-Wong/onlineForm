<template>
    <jetin-layout :title="__('Details of') + '-' + __('Admin')">
        <template #navbar-button>
            <div
                class="flex flex-wrap items-center justify-between w-full px-4"
            >
                <inertia-link
                    :href="route('admin.admins.index')"
                    class="text-2xl font-black text-zinc-400"
                ><i class="fas fa-arrow-left"></i> Back | Details of Admin
                    #{{ model.id }}</inertia-link>
            </div>
        </template>
        <div v-if="model.can.view" class="flex flex-wrap px-4">
            <div
                class="z-10 flex-auto max-w-5xl p-4 mx-auto bg-white md:rounded-md md:shadow-md"
            >
                <show-admins-form :model="model"></show-admins-form>
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
    import ShowAdminsForm from "./ShowForm.vue"
    export default {
        name: "ShowAdmins",
        components: {
            InertiaButton,
            JetinLayout,
            ShowAdminsForm,
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

<style scoped></style>

