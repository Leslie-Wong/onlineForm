<template>
    <VueMultiselect
        :model-value="modelValue"
        @update:modelValue="onUpdate"
        :openDirection="openDirection"
        :label="label"
        :track-by="trackBy"
        :options="options"
        :multiple="multiple"
		:searchable="searchable"
        :placeholder="placeholder"
        :option-height="optionHeight"
        :max-height="maxHeight"
        :allow-empty="allowEmpty"
        :custom-label="customLabel"
        @select="select"
    >
        <template v-slot:singleLabel="props">
            <span class="option__desc">
                <span class="fi" :class="'fi-' + (getLangFlag?getLangFlag(props.option):(props.option.name?props.option.name:props.option))"></span><span>{{ (getLangName?getLangName(props.option):(props.option.name?props.option.name:props.option).toUpperCase())}}</span>
            </span>
        </template>
        <template v-slot:option="props">
            <div class="option__desc">
                <span class="fi" :class="'fi-' + (getLangFlag?getLangFlag(props.option):(props.option.name?props.option.name:props.option))"></span><span>{{ (getLangName?getLangName(props.option):(props.option.name?props.option.name:props.option).toUpperCase())}}</span>
            </div>
        </template>
        <template #noResult>
            {{__("Oops! No elements found. Consider changing the search query.")}}
        </template>
    </VueMultiselect>
</template>

<script>
import VueMultiselect from 'vue-multiselect'
import { defineComponent } from "vue";
export default defineComponent({
    name: "LesMultiSelect",
    emits: ["update:modelValue"],
    components: {
        VueMultiselect
    },
    props: {
        multiple: {
            default: false,
        },
        searchable: {
            default: true,
        },
        modelValue: {
            default: null,
        },
        options: {
            default: () => [],
        },
        label: {
            type: String,
        },
        openDirection:{
            default: "bottom",
        },
        placeholder: {
            default: "Search or Select",
        },
        trackBy: {
            default: "",
        },
        label: {
            default: "",
        },
        optionHeight: {
            default: 50
        },
        maxHeight: {
            default: 160
        },
        allowEmpty: {
            default: false
        },
        getLangName:{
            type: Function,
            default: null
        },
        getLangFlag:{
            type: Function,
            default: null
        },
        select:{
            type: Function,
            default: null
        },
        customLabel: {
            required: false,
            type: Function
        }
    },
    model: {
        prop: "value",
        event: "input",
    },
    methods: {
        onSelect(value) {
            console.log(value);
            this.$emit("select:modelValue", value);
        },
        onUpdate(value) {
            console.log(value);
            this.$emit("update:modelValue", value);
        },
    },
});
</script>

<style>

.multiselect__content-wrapper::-webkit-scrollbar {
    width: 0.6em;
    height: 0.6em;
}

.multiselect__content-wrapper::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 0px rgba(255, 255, 255, 0);
    border-radius: 5px;
}

.multiselect__content-wrapper::-webkit-scrollbar-thumb {
  background-color: #e9e9e9;
  outline: 0px solid slategrey;
  border-radius: 5px;
}
.multiselect__single {
    white-space: nowrap;
    overflow: hidden;
  }
.multiselect{
    position: relative;
}
.multiselect__content-wrapper{
    overflow-y: scroll;
    position: absolute;
    left: 0px;
    top: 42px;
    right: 0px;
    width: 100%;
    z-index: 99999999;
    background-color: white;
}
.multiselect__single{
    margin: 5px;
}
.option__desc{
    margin-left: 10px;
}
.multiselect__input{
    /*
    width:100% !important;
    position: unset !important;
    */
    border-width: 0px;

}
.multiselect__placeholder{
    margin-left: 10px;
}
.multiselect__tags{
    min-width: 100%;
    min-height: 40px;
    vertical-align: middle;
    --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
    --tw-bg-opacity: 1;
    background-color: rgb(249 250 251 / var(--tw-bg-opacity));
    --tw-border-opacity: 1;
    border-color: rgb(243 244 246 / var(--tw-border-opacity));
    border-radius: 0.375rem;
    display: flex;
    align-items: center;
}
</style>
