<template>
    <v-select
        :model-value="formatData(modelValue)"
        :items="formatItems(items)"
        @update:modelValue="onSelect"
        :item-title="title"
        :item-value="value"
        variant="solo"
    ></v-select>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
    name: "JetinSelect",
    emits: ["update:modelValue"],
    props: {
        multiple: {
            default: false,
        },
        modelValue: {
            default: null,
        },
        items: {
            default: () => [],
        },
        class: {
            default: "",
        },
        value: {
            default: "value",
        },
        title: {
            default: "label",
        },

    },
    model: {
        prop: "value",
        event: "input",
    },
    methods: {
        onSelect(value) {
            this.$emit("update:modelValue", value);
        },
        formatData(data){
            return this.__(data);
        },
        formatItems(items){
            let $items = [];
            items.forEach(element => {
                $items.push(
                    {"label":this.__(element),"value":element}
                )
            });
            return $items;
        }
    },
});
</script>

<style lang="scss">
</style>
