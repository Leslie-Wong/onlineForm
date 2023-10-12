<template>
    <dl class="gap-4">
        <jetin-dd>
            <template #dt>{{__("Code")}}:</template>
            {{ model.code }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Name")}}:</template>
            {{ model.name }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Flag")}}:</template>
            {{ model.flag }}
        </jetin-dd>
    </dl>
</template>

<script>
    import JetinDd from "@/JetinComponents/JetinDd.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";

    import { defineComponent } from "vue";

    export default defineComponent({
        name: "ShowLanguagesForm",
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
