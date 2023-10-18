<template>
    <form class="w-full" @submit.prevent="storeModel">

        <div class=" sm:col-span-4">
            <jet-label for="name" value="Name" />
            <jet-input class="w-full" type="text" id="name" name="name" v-model="form.name"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.name}"
            ></jet-input>
            <jet-input-error :message="form.errors.name" class="mt-2" />
        </div>
            <div class=" sm:col-span-4">
        <jet-label for="lang" value="Lang" />
        <les-multi-select
            id="form.lang"
            name="form.lang"
            label="form.lang"
            v-model="form.lang"
            :placeholder="__('Please select a language')"
            :options="this.$page.props.languages.map(lang => lang.code)"
            :getLangName="getLangName"
            :getLangFlag="getLangFlag"
            :custom-label="getLangLable"
            trackBy=""
        />
        <jet-input-error :message="form.errors.lang" class="mt-2" />
    </div>
                <div class=" sm:col-span-4">
            <jet-label for="status" value="Status" />
            <jetin-select
                v-model="form.status"
                :items="['Enable','Disable']"
                item-title="label"
                item-value="value"
                :class="{'': form.errors.status}"
                variant="solo"
            ></jetin-select>
            <jet-input-error :message="form.errors.status" class="mt-2" />
        </div>
                
        <div class="mt-2 text-right">
            <inertia-button type="submit" class="font-semibold bg-success disabled:opacity-25" :disabled="form.processing">{{__("Submit")}}</inertia-button>
        </div>
    </form>
</template>

<script>
    import JetInput from "@/Jetstream/Input.vue";
    import JetinSelect from '@/JetinComponents/JetinSelect.vue';
    import LesMultiSelect from '@/LesComponents/LesMultiSelect.vue';
    import JetLabel from "@/Jetstream/Label.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import JetInputError from "@/Jetstream/InputError.vue"
    import {useForm} from "@inertiajs/vue3";
    import { defineComponent, ref } from "vue";

    export default defineComponent({
        name: "CreateProductTypesForm",
        components: {
            InertiaButton,
            JetInputError,
            JetLabel,
                         JetInput,                                                LesMultiSelect,                        JetinSelect,        },
        data() {
            return {
                form: useForm({
                    name:  null ,
                    lang:  null ,
                    status:  "Enable",
                                                            
                }, {remember: false}),
            }
        },
        mounted() {
        },
        computed: {
            flash() {
                return this.$page.props.flash || {}
            }
        },
        methods: {
            getLangLable(val, id){
               if(this.$page.props.languages.find(x => x.code == val))
                    return this.$page.props.languages.find(x => x.code == val).name + " " + this.$page.props.languages.find(x => x.code == val).code;
                return val;
            },
            getLangName(props){
                if(this.$page.props.languages.find(i => i.code === props))
                    return this.$page.props.languages.find(i => i.code === props).name
                return props
            },
            getLangFlag(props){
                if(this.$page.props.languages.find(i => i.code === props))
                    return this.$page.props.languages.find(i => i.code === props).flag
                return props
            },
            selectImage(name, index){
                if(typeof this.$refs[name + index][0] != 'undefined')
                    this.$refs[name + index][0].dispatchEvent(new MouseEvent('click'));
                else
                    this.$refs[name + index].dispatchEvent(new MouseEvent('click'));
            },
            async storeModel() {
                this.form.post(this.route('admin.product-types.store'),{
                    onSuccess: res => {
                        if (this.flash.success) {
                            this.$emit("success",this.__(this.flash.success));
                        } else if (this.flash.error) {
                            this.$emit("error",this.__(this.flash.error));
                        } else {
                            this.$emit("error",this.__("Unknown server error."));
                        }
                    },
                    onError: res => {
                        this.$emit("error",this.__("A server error occurred"));
                    }
                },{remember: false, preserveState: true})
            }
        }
    });
</script>

<style scoped>

.v-select .v-field__field .v-field__input input[type='text'] {
    padding-top: unset;
}
</style>
