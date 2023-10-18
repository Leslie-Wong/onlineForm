<template>
    <dl class="gap-4">
        <jetin-dd>
            <template #dt>{{__("Name")}}:</template>
            {{ model.name }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Guard Name")}}:</template>
            {{ model.guard_name }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Title")}}:</template>
            {{ model.title }}
        </jetin-dd>
    </dl>
</template>

<script>
    import JetinDd from "@/JetinComponents/JetinDd.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";

    export default {
        name: "ShowRolesForm",
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
    }
</script>

<style scoped>

</style>
