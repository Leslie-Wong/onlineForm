<template>
    <div class="flex flex-wrap px-4">
        <div class="flex-auto max-w-2xl text-center p-4 mx-auto bg-white md:rounded-md md:shadow-md">
            Thank You. Your information has been saved.
        </div>
    </div>
</template>

<script>
    // import JetinLayout from "@/Layouts/JetinLayout.vue";
    import DisplayMixin from "@/Mixins/DisplayMixin.js";
    import { defineComponent } from "vue";

    export default defineComponent({
        name: "PubFinish",
        components: {
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
    });
</script>


<style scoped>
.flex.flex-wrap.px-4 {
    margin-top: 40vh;
}
</style>
