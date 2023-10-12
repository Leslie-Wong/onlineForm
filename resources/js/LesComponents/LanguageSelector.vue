<template>
    <jet-dropdown align="right" class="w-12"  :open="true">
        <template #trigger>
            <button
                class="flex text-sm transition duration-150 ease-in-out border-2 border-transparent rounded-full  focus:outline-none focus:border-gray-300"
            >
                <div class="lang-row">
                    <span v-bind:class="[{'fi': true}, selectable_locale.flag ? 'fi-' + selectable_locale.flag : '']"></span>
                </div>
            </button>
        </template>

        <template #content>
            <loop v-for="lang in langs" v-bind:key="lang" >
                <jet-dropdown-link v-if="lang != selectable_locale"
                :href="route('language',lang.code)"
                >
                    <span v-bind:class="[{'fi': true}, lang.flag ? 'fi-' + lang.flag : '']"></span><span>{{ lang.name}}</span>
                </jet-dropdown-link>
            </loop>
        </template>
    </jet-dropdown>
</template>
<style scoped>
span.fi {
    border-radius: 5px;
}
.lang-row {
    background: white;
    padding: 2px;
    border-radius: 5px;
    box-shadow: #80808099 0px 0px 3px 0px;
}
</style>
<script>
import Loop from '@/LesComponents/Loop.vue'
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";

export default {
data() {
    return {langs:this.$page.props.languages}
},
components: {
    Loop,
    JetDropdown,
    JetDropdownLink
},
computed: {
    selectable_locale() {
        return this.$page.props.locale
    }
},
}
</script>
