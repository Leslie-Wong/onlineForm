<template>
    <dl class="gap-4">
        <jetin-dd>
            <template #dt>{{__("Name")}}:</template>
            {{ model.name }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Email")}}:</template>
            {{ model.email }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Email Verified At")}}:</template>
            {{ model.email_verified_at }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Password")}}:</template>
            {{ model.password }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Lang")}}:</template>
            {{ model.lang }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Two Factor Secret")}}:</template>
            {{ model.two_factor_secret }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Two Factor Recovery Codes")}}:</template>
            {{ model.two_factor_recovery_codes }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Two Factor Confirmed At")}}:</template>
            {{ model.two_factor_confirmed_at }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Current Team Id")}}:</template>
            {{ model.current_team_id }}
        </jetin-dd>
        <jetin-dd>
            <template #dt>{{__("Profile Photo Path")}}:</template>
            {{ model.profile_photo_path }}
        </jetin-dd>
    </dl>
</template>

<script>
    import JetinDd from "@/JetinComponents/JetinDd.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";

    export default {
        name: "ShowAdminsForm",
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
