<template>
    <!-- component -->
    <div class="flex flex-col grid-cols-12 p-2 mx-auto md:grid text-indigo-50">
        <slot></slot>
    </div>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
    name: "JetinTimeline",
});
</script>

<style scoped></style>
