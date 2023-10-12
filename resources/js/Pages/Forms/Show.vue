<template>
    <jetin-layout :title="__('Details of') + '-' + __('Form')">
        <template #navbar-button>
            <div
                class="flex flex-wrap items-center justify-between w-full px-4"
            >
                <inertia-link
                    :href="route('admin.forms.index')"
                    class="text-2xl font-black text-zinc-400"
                ><i class="fas fa-arrow-left"></i> {{__('Back')}} | {{__('Details of')}} {{__("Form")}}
                    #{{ model.id }}</inertia-link>
            </div>
        </template>
        <div v-if="model.can.view" class="flex flex-wrap px-4">
            <div
                class="z-10 flex-auto max-w-5xl p-4 mx-auto bg-white md:rounded-md md:shadow-md"
            >
                <show-forms-form :model="model"></show-forms-form>
            </div>
        </div>
        <div v-else class="px-4 text-lg font-bold text-center text-red-500 bg-white rounded-md shadow-md space-4">
        {{__("You don't have permission to view this resource.")}}
        </div>
    </jetin-layout>
</template>

<script>
    import JetinLayout from "@/Layouts/JetinLayout.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import ShowFormsForm from "./ShowForm.vue"
    import { defineComponent } from "vue";

    export default defineComponent({
        name: "ShowForm",
        components: {
            InertiaButton,
            JetinLayout,
            ShowFormsForm,
        },
        props: {
            model: Object
        },
        data() {
            return {};
        },
        mounted() {},
        methods: {}
    });
</script>

<style scoped></style>

