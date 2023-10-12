<template>
    <form class="w-full" @submit.prevent="storeModel">
                            <div class=" sm:col-span-4">
                <jet-label for="code" value="Code" />
                <jet-input class="w-full" type="text" id="code" name="code" v-model="form.code"
                    :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.code}"
                ></jet-input>
                <jet-input-error :message="form.errors.code" class="mt-2" />
            </div>
                                    <div class=" sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input class="w-full" type="text" id="name" name="name" v-model="form.name"
                    :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.name}"
                ></jet-input>
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
                                <div class=" sm:col-span-4">
            <jet-label for="flag" value="Flag" />
            <les-multi-select
                id="flag"
                name="flag"
                v-model="form.flag"
                :placeholder="__('Please select a flag')"
                label="flag"
                :options="flags"
                @select="onSelcet"
            />
            <jet-input-error :message="form.errors.flag" class="mt-2" />
        </div>
                    
        <div class="mt-2 text-right">
            <inertia-button type="submit" class="font-semibold bg-success disabled:opacity-25" :disabled="form.processing">{{__("Submit")}}</inertia-button>
        </div>
    </form>
</template>
<script>
    import JetInput from "@/Jetstream/Input.vue";
    import JetLabel from "@/Jetstream/Label.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import JetInputError from "@/Jetstream/InputError.vue"
    import {useForm} from "@inertiajs/vue3";
    import { defineComponent } from "vue";
    import LesMultiSelect from '@/LesComponents/LesMultiSelect.vue';

    const flagfiles = _.cloneDeep(import.meta.glob('/node_modules/flag-icons/flags/4x3/*.svg'));
    var langArr = [];
    Object.keys(flagfiles).forEach(element => {
        let name = {"name":flagfiles[element].name.replaceAll("/node_modules/flag-icons/flags/4x3/","").replaceAll(".svg",""), "flag":flagfiles[element].name.replaceAll("/node_modules/flag-icons/flags/4x3/","").replaceAll(".svg","")};
        langArr.push(name);
    });

    export default defineComponent({
        name: "CreateLanguagesForm",
        components: {
            InertiaButton,
            JetInputError,
            JetLabel,
            LesMultiSelect,
                         JetInput,                                    
        },
        data() {
            return {
                flags:langArr,
                form: useForm({
                    code: null,
                    name: null,
                    flag: null,
                                                            
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
            onSelcet(option, id){
                this.form.flag = option.flag;
                return option.name
            },
            async storeModel() {
                this.form.post(this.route('admin.languages.store'),{
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

</style>
