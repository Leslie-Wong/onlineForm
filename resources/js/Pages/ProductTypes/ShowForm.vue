<template>
    <dl class="gap-4">
        <jetin-dd>
            <template #dt>Name:</template>
            {{ model.name }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>Lang:</template>
            {{ model.lang }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>Status:</template>
            {{ model.status }}
        </jetin-dd>
    </dl>
</template>

<script>
    import JetinDd from "@/JetinComponents/JetinDd.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";

    import { defineComponent } from "vue";

    export default defineComponent({
        name: "ShowProductTypesForm",
        props: {
            model: Object,
        },
        components: {
            InertiaButton,
            JetinDd,
        },
        data() {
            return {}
        },
        mounted() {},
        computed: {
            flash() {
                return this.$page.props.flash || {}
            }
        },
        methods: {}
    });
</script>

<style scoped>

</style>
