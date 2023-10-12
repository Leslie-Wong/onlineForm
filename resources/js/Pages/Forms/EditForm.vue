<template>
    <form @submit.prevent="updateModel">
        <div class=" sm:col-span-4">
            <jet-label for="name" value="Name" />
            <jet-input class="w-full" type="text" id="name" name="name" v-model="form.name"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.name}"
            ></jet-input>
            <jet-input-error :message="form.errors.name" class="mt-2" />
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

            <div class=" sm:col-span-4 children-table shadow-sm border-gray-100">
                <jet-label class="shadow-sm" for="form_attributes">
                    <span class="border-gray-100">Form Attributes</span>
                </jet-label>
                <div id="form_attributes" v-for="(form_attributes, index) in form.form_attributes" :key="index">
                    <div :class="['children-row', (index!=0?'children-row-n':''),(index%2!=0?'children-row-even':'')]">

        <div class=" sm:col-span-4">
            <jet-input class="w-full" type="hidden" id="id" name="id" v-model="form_attributes.slug"
            ></jet-input>
        </div>

        <div class=" sm:col-span-4">
            <jet-label for="name" value="Name" />
            <jet-input class="w-full" type="text" id="name" name="name" v-model="form_attributes.name"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors['form_attributes.'+index+'.name']}"
            ></jet-input>
            <jet-input-error :message="form.errors['form_attributes.'+index+'.name']" class="mt-2" />
        </div>

        <div class=" sm:col-span-4">
            <jet-label for="phone" value="Phone" />
            <jet-input class="w-full" type="text" id="phone" name="phone" v-model="form_attributes.phone"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors['form_attributes.'+index+'.phone']}"
            ></jet-input>
            <jet-input-error :message="form.errors['form_attributes.'+index+'.phone']" class="mt-2" />
        </div>

        <div class=" sm:col-span-4">
            <jet-label for="email" value="Email" />
            <jet-input class="w-full" type="text" id="email" name="email" v-model="form_attributes.email"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors['form_attributes.'+index+'.email']}"
            ></jet-input>
            <jet-input-error :message="form.errors['form_attributes.'+index+'.email']" class="mt-2" />
        </div>

        <div class=" sm:col-span-4">
            <jet-label for="product_sku" value="Product Sku" />
            <jet-input class="w-full" type="text" id="product_sku" name="product_sku" v-model="form_attributes.product_sku"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors['form_attributes.'+index+'.product_sku']}"
            ></jet-input>
            <jet-input-error :message="form.errors['form_attributes.'+index+'.product_sku']" class="mt-2" />
        </div>

        <div class=" sm:col-span-4">
            <jet-label for="product_name" value="Product Name" />
            <jet-input class="w-full" type="text" id="product_name" name="product_name" v-model="form_attributes.product_name"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors['form_attributes.'+index+'.product_name']}"
            ></jet-input>
            <jet-input-error :message="form.errors['form_attributes.'+index+'.product_name']" class="mt-2" />
        </div>

        <div class=" sm:col-span-4">
            <jet-label for="product_type" value="Product Type" />
            <infinite-select :per-page="15"
                             :api-url="route('api.product-types.index')"
                             v-model="form_attributes.product_type"
                             item-title="name"
                             :class="{'': form.errors.product_type}"
                             
                             
                             variant="solo"
            ></infinite-select>
            <jet-input-error :message="form.errors['form_attributes.'+index+'.product_type']" class="mt-2" />
        </div>

        <div class=" sm:col-span-4">
            <jet-label for="brand" value="Brand" />
            <jet-input class="w-full" type="text" id="brand" name="brand" v-model="form_attributes.brand"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors['form_attributes.'+index+'.brand']}"
            ></jet-input>
            <jet-input-error :message="form.errors['form_attributes.'+index+'.brand']" class="mt-2" />
        </div>

        <div class=" sm:col-span-4">
            <jet-label for="ref_price" value="Ref Price" />
            <jet-input class="w-full" type="text" id="ref_price" name="ref_price" v-model="form_attributes.ref_price"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors['form_attributes.'+index+'.ref_price']}"
            ></jet-input>
            <jet-input-error :message="form.errors['form_attributes.'+index+'.ref_price']" class="mt-2" />
        </div>

        <div class=" sm:col-span-4">
            <jet-label for="place_of_origin" value="Place Of Origin" />
            <jet-input class="w-full" type="text" id="place_of_origin" name="place_of_origin" v-model="form_attributes.place_of_origin"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors['form_attributes.'+index+'.place_of_origin']}"
            ></jet-input>
            <jet-input-error :message="form.errors['form_attributes.'+index+'.place_of_origin']" class="mt-2" />
        </div>

        <div class=" sm:col-span-4">
        <jet-label for="product_image" value="Product Image" />
        <input :ref="'form_attributes'+index" class="hidden" type="file" id="product_image" name="product_image" @input="this.form.form_attributes[index].product_image = $event.target.files[0]"
        >
        <img class="cursor-pointer " @click="selectImage('form_attributes', index)" :src="rendImag(form_attributes.product_image)" />
        <jet-input-error :message="form.errors['form_attributes.'+index+'.product_image']" class="mt-2" />
    </div>

                        <div id="delete-child">
                            <div  class="del-btn shadow-md rounded-md bg-gray-200 font-semibold form-button-bg-1 cursor-pointer disabled:opacity-25" @click="confirmDeletion(Object.assign({'index':index, 'modelName':'form_attributes'}, form_attributes))">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="delete-icon" version="1.1" viewBox="0 0 482.428 482.429" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M381.163,57.799h-75.094C302.323,25.316,274.686,0,241.214,0c-33.471,0-61.104,25.315-64.85,57.799h-75.098    c-30.39,0-55.111,24.728-55.111,55.117v2.828c0,23.223,14.46,43.1,34.83,51.199v260.369c0,30.39,24.724,55.117,55.112,55.117    h210.236c30.389,0,55.111-24.729,55.111-55.117V166.944c20.369-8.1,34.83-27.977,34.83-51.199v-2.828    C436.274,82.527,411.551,57.799,381.163,57.799z M241.214,26.139c19.037,0,34.927,13.645,38.443,31.66h-76.879    C206.293,39.783,222.184,26.139,241.214,26.139z M375.305,427.312c0,15.978-13,28.979-28.973,28.979H136.096    c-15.973,0-28.973-13.002-28.973-28.979V170.861h268.182V427.312z M410.135,115.744c0,15.978-13,28.979-28.973,28.979H101.266    c-15.973,0-28.973-13.001-28.973-28.979v-2.828c0-15.978,13-28.979,28.973-28.979h279.897c15.973,0,28.973,13.001,28.973,28.979    V115.744z"/>
                                            <path d="M171.144,422.863c7.218,0,13.069-5.853,13.069-13.068V262.641c0-7.216-5.852-13.07-13.069-13.07    c-7.217,0-13.069,5.854-13.069,13.07v147.154C158.074,417.012,163.926,422.863,171.144,422.863z"/>
                                            <path d="M241.214,422.863c7.218,0,13.07-5.853,13.07-13.068V262.641c0-7.216-5.854-13.07-13.07-13.07    c-7.217,0-13.069,5.854-13.069,13.07v147.154C228.145,417.012,233.996,422.863,241.214,422.863z"/>
                                            <path d="M311.284,422.863c7.217,0,13.068-5.853,13.068-13.068V262.641c0-7.216-5.852-13.07-13.068-13.07    c-7.219,0-13.07,5.854-13.07,13.07v147.154C298.213,417.012,304.067,422.863,311.284,422.863z"/>
                                        </g>
                                    </g>
                                </svg>
                                {{__("Delete")}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <div class="mt-2 text-right">
            <inertia-button type="submit" class="font-semibold text-white bg-primary bg-gray-400" :disabled="form.processing">{{__("Submit")}}</inertia-button>
        </div>
    </form>
    <jet-confirmation-modal title="Confirm Deletion" :show="confirmDelete">
        <template v-slot:content>
            <div>{{__('Are you sure you want to delete this record?')}}</div>
        </template>
        <template v-slot:footer>
            <div class="flex justify-end gap-x-2">
                <inertia-button as="button" type="button" @click.native.stop="cancelDelete" class="bg-orange-500 text-white">{{__('Cancel')}}</inertia-button>
                <inertia-button as="button" type="button" @click.native.prevent="deleteModel" class="bg-blue-500 text-white">{{__('Yes, Delete')}}</inertia-button>
            </div>
        </template>
    </jet-confirmation-modal>
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
.children-row {
    position: relative;
}

.children-row #delete-child {
  /*
  position: absolute;
  right: 4px;
  */
  margin-top: 20px;
  margin-right: 10px;
  display: flex;
  justify-content: flex-end;
}


.children-row-even  #delete-child {
    right: 10px;
}

svg.delete-icon {
  fill: #fcc;
  width: 15px;
  height: 15px;
}

.del-btn {
    display: flex;
    background: firebrick;
    padding: 6px 12px;
    border-radius: 5px;
    color: #fee;
    /* font-size: 10px; */
    cursor: pointer;
    align-items: center;
    margin-top: 10px;
    margin-right: 10px;
}

.del-btn svg{
    margin-right: 5px;
}

.v-select .v-field__field .v-field__input input[type='text'] {
    padding-top: unset;
}
</style>
<script>
    import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
    import DisplayMixin from "@/Mixins/DisplayMixin.js";
    import JetLabel from "@/Jetstream/Label.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import JetInputError from "@/Jetstream/InputError.vue";
    import {useForm} from "@inertiajs/vue3";
    import JetInput from "@/Jetstream/Input.vue";
    import InfiniteSelect from '@/JetinComponents/InfiniteSelect.vue';
    import JetinSelect from '@/JetinComponents/JetinSelect.vue';
    import { defineComponent, ref } from "vue";

    export default defineComponent({
        name: "EditFormForm",
        props: {
            model: Object,
        },
        components: {
            JetConfirmationModal,
            InertiaButton,
            JetLabel,
            JetInputError,
            JetInput,
            InfiniteSelect,
            JetinSelect,

        },
        data() {
            return {
                confirmDelete: false,
                currentModel: null,
                withDisabled: false,
                showModal: false,
                form: useForm({
                    ...this.model,
                                 
                    "_method": "PUT",
                },{remember:false}),
            }
        },
        mixins: [
            DisplayMixin,
        ],
        mounted() {
        },
        computed: {
            flash() {
                return this.$page.props.flash || {}
            }
        },
        methods: {
            rendImag(file){
                let url;
                let img_url = '';
                if(typeof file == 'string'){
                    url = file;
                }else if(file){
                    url = file.name;
                }
                if(!url){
                    return "/assets/images/upload_02.gif";
                }else{
                    let ext = url.substring(url.lastIndexOf('.')+1);

                    if(ext){
                        switch (ext) {
                            case 'jpg':
                        case 'png':
                        case 'jpeg':
                        case 'bmp':
                        case 'svg':
                        case 'gif':
                            if(typeof file == 'string')
                                img_url = file;
                            else
                                img_url = URL.createObjectURL(file);
                            break;
                        case 'html':
                        img_url = '/assets/file_format/html.svg';
                            break;
                        case 'mov':
                        img_url = '/assets/file_format/mov.svg';
                            break;
                        case 'mp3':
                        img_url = '/assets/file_format/mp3.svg';
                            break;
                        case 'mp4':
                        img_url = '/assets/file_format/mp4.svg';
                            break;
                        case 'mpeg':
                        img_url = '/assets/file_format/mpeg.svg';
                            break;
                        case 'pdf':
                        img_url = '/assets/file_format/pdf.svg';
                            break;
                        case 'ppt':
                        img_url = '/assets/file_format/ppt.svg';
                            break;
                        case 'rar':
                        img_url = '/assets/file_format/rar.svg';
                            break;
                        case 'txt':
                        img_url = '/assets/file_format/txt.svg';
                            break;
                        case 'xml':
                        img_url = '/assets/file_format/xml.svg';
                            break;
                        case 'xsl':
                        case 'xsls':
                        img_url = '/assets/file_format/xsl.svg';
                            break;
                        case 'zip':
                        img_url = '/assets/file_format/zip.svg';
                            break;
                        case 'csv':
                        img_url = '/assets/file_format/csv.svg';
                            break;
                        case 'doc':
                        img_url = '/assets/file_format/doc.svg';
                            break;
                        case 'docx':
                        img_url = '/assets/file_format/docx.svg';
                            break;
                        default:
                        img_url = '/assets/file_format/file.svg';
                            break;
                        }
                    }
                    return img_url;
                }
            },
            selectImage(name, index){
                if(typeof this.$refs[name + index][0] != 'undefined')
                    this.$refs[name + index][0].dispatchEvent(new MouseEvent('click'));
                else
                    this.$refs[name + index].dispatchEvent(new MouseEvent('click'));
            },
            confirmDeletion(model) {
                this.currentModel = model;
                this.confirmDelete = true;
            },
            cancelDelete() {
                this.currentModel = false;
                this.confirmDelete = false;
            },
            async deleteModel() {
                const vm = this;
                this.confirmDelete = false;
                if (this.currentModel && this.currentModel.id) {
                    this.$inertia.delete(route('admin.forms.children.destroy', vm.currentModel),{
                        onFinish: res => {
                            if(vm.$page.props.flash && Object.keys(vm.$page.props.flash)[0] == "success"){
                                vm.displayNotification("success",vm.__("Item deleted."));
                            }else{
                                vm.displayNotification("error",vm.__("There was an error while deleting the item."));
                            }
                            if(vm.currentModel.index > -1){
                                vm.form[vm.currentModel.modelName].splice(vm.currentModel.index, 1);
                            }

                        },
                        onError: err => {
                            console.log(err);
                            vm.displayNotification("error",vm.__("There was an error while deleting the item."));
                        }
                    });
                }else if(this.currentModel.index > -1){
                    this.form[this.currentModel.modelName].splice(this.currentModel.index, 1);
                }
            },
            async updateModel() {
                 
                this.form.post(this.route('admin.forms.update',this.form.slug),  
                    {
                         
                        forceFormData: true,
                         
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
                            if(typeof(this.$page.props.errors) == 'string')
                                this.$emit("error",this.$page.props.errors);
                            else if(typeof(this.$page.props.errors) != 'object')
                                this.$emit("error",this.__("A server error occurred"));
                        }
                    },{remember: false, preserveState: true})
            }
        }
    });
</script>

<style scoped>

</style>
