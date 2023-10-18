<template>
    <dl class="gap-4">
    <jetin-dd>
    <template #dt>{{__("Name")}}</template>
    {{ model.name }}
</jetin-dd>

    <jetin-dd>
    <template #dt>{{__("Status")}}</template>
    {{ model.status }}
</jetin-dd>

    <div class=" sm:col-span-4 children-table shadow-sm border-gray-100">
        <jet-label class="shadow-sm" for="form_attributes">
            <span class="border-gray-100">Form Attributes</span>
        </jet-label>
        <div id="form_attributes" v-for="(form_attributes, index) in model.form_attributes">
        <div :class="['children-row', (index!=0?'children-row-n':''),(index%2!=0?'children-row-even':'')]">
                    <jetin-dd>
    <template #dt>{{__("Name")}}</template>
    {{ form_attributes.name }}
</jetin-dd>

                    <jetin-dd>
    <template #dt>{{__("Phone")}}</template>
    {{ form_attributes.phone }}
</jetin-dd>

                    <jetin-dd>
    <template #dt>{{__("Email")}}</template>
    {{ form_attributes.email }}
</jetin-dd>

                    <jetin-dd>
    <template #dt>{{__("Product Sku")}}</template>
    {{ form_attributes.product_sku }}
</jetin-dd>

                    <jetin-dd>
    <template #dt>{{__("Product Name")}}</template>
    {{ form_attributes.product_name }}
</jetin-dd>

                    <jetin-dd>
    <template #dt>{{__("Product Type")}}</template>
</jetin-dd>

                    <jetin-dd>
    <template #dt>{{__("Brand")}}</template>
    {{ form_attributes.brand }}
</jetin-dd>

                    <jetin-dd>
    <template #dt>{{__("Ref Price")}}</template>
    {{ form_attributes.ref_price }}
</jetin-dd>

                    <jetin-dd>
    <template #dt>{{__("Place Of Origin")}}</template>
    {{ form_attributes.place_of_origin }}
</jetin-dd>

                    <jetin-dd>
    <template #dt>{{__("Product Image")}}</template>
    {{ form_attributes.product_image }}
</jetin-dd>

                </div>
        </div>
    </div>
</dl>
</template>
<style>
    .children-table{
        border-width: 1px;
        border-radius: 10px;
        padding: 15px 10px;
        margin-top: 25px;
        margin-bottom: 20px;
        position: relative;
    }

    .children-row{
        margin-bottom: 10px;
    }
    .children-row-n{
        margin-top: 20px;
        padding-top: 10px;
        border-top: 1px silver dashed;
    }

    .children-row-even {
        background-color: #b1ff8517;
        margin-left: -10px;
        margin-right: -10px;
        padding-left: 10px;
        padding-right: 10px;
    }
    .children-table > label > span > span{
        position: absolute;
        top: -17px;
        background-color: white;
        padding: 3px 10px;
        border-width: 1px;
        border-radius: 10px;
    }
</style>
<script>
    import JetLabel from "@/Jetstream/Label.vue";
    import JetinDd from "@/JetinComponents/JetinDd.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";

    import { defineComponent } from "vue";

    export default defineComponent({
        name: "ShowFormsForm",
        props: {
            model: Object,
        },
        components: {
            JetLabel,
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
        methods: {
            getLangName(props){
                return this.$page.props.languages.find(i => i.code === props).name
            },
            getLangFlag(props){
                return this.$page.props.languages.find(i => i.code === props).flag
            },
            openNewPage(html){
                const winHtml = `<!DOCTYPE html>
                    <html>
                        <head>
                            <title>Window with Blob</title>
                        </head>
                        <body>
                            `+html+`
                        </body>
                    </html>`;

                const winUrl = URL.createObjectURL(
                    new Blob([winHtml], { type: "text/html" })
                );

                const win = window.open(
                    winUrl,
                    "win",
                    `width=800,height=400,screenX=200,screenY=200`
                );
            }
        }
    });
</script>

<style scoped>

</style>
