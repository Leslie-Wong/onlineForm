<template>
    <v-card>
        <v-tabs
        v-model="tab"
        bg-color="primary"
        >
        <v-tab value="one">{{__('Input Form')}}</v-tab>
        <v-tab value="two">{{__('Batch Upload')}}</v-tab>
        </v-tabs>

        <v-card-text>
        <v-window v-model="tab">
                <v-window-item value="one">
                    <form ref="inputForm" class="w-full" @submit.prevent="storeModel">
                    <div class="sm:col-span-4 children-table shadow-sm border-gray-100">
                        <div
                        id="form_attributes"
                        v-for="(form_attributes, index) in form.form_attributes"
                        :key="index"
                        >
                        <div
                            :class="[
                            'children-row',
                            index != 0 ? 'children-row-n' : '',
                            index % 2 != 0 ? 'children-row-even' : '',
                            ]"
                        >
                            <div
                            v-if="index != 0"
                            id="delete-child"
                            @click="
                                confirmDeletion(
                                Object.assign(
                                    { index: index, modelName: 'form_attributes' },
                                    form_attributes
                                )
                                )
                            "
                            >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                class="delete-icon"
                                version="1.1"
                                viewBox="0 0 482.428 482.429"
                                xml:space="preserve"
                            >
                                <g>
                                <g>
                                    <path
                                    d="M381.163,57.799h-75.094C302.323,25.316,274.686,0,241.214,0c-33.471,0-61.104,25.315-64.85,57.799h-75.098    c-30.39,0-55.111,24.728-55.111,55.117v2.828c0,23.223,14.46,43.1,34.83,51.199v260.369c0,30.39,24.724,55.117,55.112,55.117    h210.236c30.389,0,55.111-24.729,55.111-55.117V166.944c20.369-8.1,34.83-27.977,34.83-51.199v-2.828    C436.274,82.527,411.551,57.799,381.163,57.799z M241.214,26.139c19.037,0,34.927,13.645,38.443,31.66h-76.879    C206.293,39.783,222.184,26.139,241.214,26.139z M375.305,427.312c0,15.978-13,28.979-28.973,28.979H136.096    c-15.973,0-28.973-13.002-28.973-28.979V170.861h268.182V427.312z M410.135,115.744c0,15.978-13,28.979-28.973,28.979H101.266    c-15.973,0-28.973-13.001-28.973-28.979v-2.828c0-15.978,13-28.979,28.973-28.979h279.897c15.973,0,28.973,13.001,28.973,28.979    V115.744z"
                                    />
                                    <path
                                    d="M171.144,422.863c7.218,0,13.069-5.853,13.069-13.068V262.641c0-7.216-5.852-13.07-13.069-13.07    c-7.217,0-13.069,5.854-13.069,13.07v147.154C158.074,417.012,163.926,422.863,171.144,422.863z"
                                    />
                                    <path
                                    d="M241.214,422.863c7.218,0,13.07-5.853,13.07-13.068V262.641c0-7.216-5.854-13.07-13.07-13.07    c-7.217,0-13.069,5.854-13.069,13.07v147.154C228.145,417.012,233.996,422.863,241.214,422.863z"
                                    />
                                    <path
                                    d="M311.284,422.863c7.217,0,13.068-5.853,13.068-13.068V262.641c0-7.216-5.852-13.07-13.068-13.07    c-7.219,0-13.07,5.854-13.07,13.07v147.154C298.213,417.012,304.067,422.863,311.284,422.863z"
                                    />
                                </g>
                                </g>
                            </svg>
                            </div>

                            <div class="sm:col-span-4">
                            <jet-label for="product_sku" value="Product Sku" />
                            <jet-input
                                class="w-full"
                                type="text"
                                id="product_sku"
                                name="product_sku"
                                v-model="form_attributes.product_sku"
                                :class="{
                                'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':
                                    form.errors['form_attributes.' + index + '.product_sku'],
                                }"
                            ></jet-input>
                            <jet-input-error
                                :message="form.errors['form_attributes.' + index + '.product_sku']"
                                class="mt-2"
                            />
                            </div>

                            <div class="sm:col-span-4">
                            <jet-label for="product_name" value="Product Name" />
                            <jet-input
                                class="w-full"
                                type="text"
                                id="product_name"
                                name="product_name"
                                v-model="form_attributes.product_name"
                                :class="{
                                'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':
                                    form.errors['form_attributes.' + index + '.product_name'],
                                }"
                            ></jet-input>
                            <jet-input-error
                                :message="form.errors['form_attributes.' + index + '.product_name']"
                                class="mt-2"
                            />
                            </div>

                            <div class="sm:col-span-4">
                            <jet-label for="product_type" value="Product Type" />
                            <infinite-select
                                :per-page="15"
                                :api-url="route('api.product-types.index')"
                                v-model="form_attributes.product_type"
                                item-title="name"
                                :class="{ '': form.errors.product_type }"
                                variant="solo"
                            ></infinite-select>
                            <jet-input-error
                                :message="form.errors['form_attributes.' + index + '.product_type']"
                                class="mt-2"
                            />
                            </div>

                            <div class="sm:col-span-4">
                            <jet-label for="brand" value="Brand" />
                            <jet-input
                                class="w-full"
                                type="text"
                                id="brand"
                                name="brand"
                                v-model="form_attributes.brand"
                                :class="{
                                'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':
                                    form.errors['form_attributes.' + index + '.brand'],
                                }"
                            ></jet-input>
                            <jet-input-error
                                :message="form.errors['form_attributes.' + index + '.brand']"
                                class="mt-2"
                            />
                            </div>

                            <div class="sm:col-span-4">
                            <jet-label for="ref_price" value="Ref Price" />
                            <jet-input
                                class="w-full"
                                type="text"
                                id="ref_price"
                                name="ref_price"
                                v-model="form_attributes.ref_price"
                                :class="{
                                'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':
                                    form.errors['form_attributes.' + index + '.ref_price'],
                                }"
                            ></jet-input>
                            <jet-input-error
                                :message="form.errors['form_attributes.' + index + '.ref_price']"
                                class="mt-2"
                            />
                            </div>

                            <div class="sm:col-span-4">
                            <jet-label for="place_of_origin" value="Place Of Origin" />
                            <jet-input
                                class="w-full"
                                type="text"
                                id="place_of_origin"
                                name="place_of_origin"
                                v-model="form_attributes.place_of_origin"
                                :class="{
                                'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':
                                    form.errors['form_attributes.' + index + '.place_of_origin'],
                                }"
                            ></jet-input>
                            <jet-input-error
                                :message="form.errors['form_attributes.' + index + '.place_of_origin']"
                                class="mt-2"
                            />
                            </div>

                            <div class="sm:col-span-4">
                            <jet-label for="product_image" value="Product Image" />
                            <input
                                :ref="'form_attributes' + index"
                                class="hidden"
                                type="file"
                                id="product_image"
                                name="product_image"
                                accept="image/*" 
                                @input="
                                this.form.form_attributes[index].product_image = $event.target.files[0]
                                "
                            />
                            <img
                                class="cursor-pointer"
                                @click="selectImage('form_attributes', index)"
                                :src="rendImag(form_attributes.product_image)"
                            />
                            <jet-input-error
                                :message="form.errors['form_attributes.' + index + '.product_image']"
                                class="mt-2"
                            />
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="mt-2 text-right text-white">
                        <inertia-button
                        type="submit"
                        class="font-semibold bg-success disabled:opacity-25 bg-gray-400"
                        :disabled="form.processing"
                        >{{ __("Submit") }}</inertia-button
                        >
                    </div>
                    </form>
                </v-window-item>

                <v-window-item value="two">

                    <v-file-input v-model="fileUpload" accept=".xlsx,.xls" @change="handleFilesUpload" clearable :label="__('File input')" variant="solo"></v-file-input>
                    <v-expansion-panels>
                        <v-expansion-panel
                          :title="this.__('Tips')"
                          :text="this.__('The image only support a downloadable url.')"
                        >
                        </v-expansion-panel>
                      </v-expansion-panels>
                      <p style=" height: 30px; "></p>
                      <a style=" color: blue; float: right;" target="_blank" :href="this._url('/assets/files/forms-product-example.xlsx')" >{{__('Download Example File')}}</a>

                      <v-overlay
                            :model-value="overlay"
                            class="align-center justify-center"
                            persistent="true"
                            >
                            <v-progress-circular
                                color="primary"
                                indeterminate
                                size="64"
                            ></v-progress-circular>
                        </v-overlay>
                </v-window-item>

            </v-window>
        </v-card-text>
    </v-card>
    <jet-dialog-modal :title="__('Preview Upload File')" :show="previewFile">
        <template v-slot:content>
            <div class="overflow-y-scroll">
                <table>
                    <thead>
                        <th v-for="(row, idx) in files[0]" :key="idx">{{idx}}</th>
                    </thead>
                    <tbody>
                        <tr v-for="(rows, i) in files" :key="i">
                            <td v-for="(row, j) in rows" :key="j">{{ row }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
        <template v-slot:footer>
            <div class="flex justify-end gap-x-2">
              <inertia-button
                as="button"
                type="button"
                @click.native.stop="this.previewFile = false"
                class="bg-yellow-200 text-neutral"
                >{{ __("Cancel") }}</inertia-button
              >
              <inertia-button
                as="button"
                type="button"
                @click.native.prevent="uploadFile"
                class="bg-orange-500 text-neutral"
                >{{ __("Submit") }}</inertia-button
              >
            </div>
          </template>
    </jet-dialog-modal>

    <jet-confirmation-modal title="Confirm Deletion" :show="confirmDelete">
      <template v-slot:content>
        <div>{{ __("Are you sure you want to delete this record?") }}</div>
      </template>
      <template v-slot:footer>
        <div class="flex justify-end gap-x-2">
          <inertia-button
            as="button"
            type="button"
            @click.native.stop="cancelDelete"
            class="bg-orange-500 text-white"
            >{{ __("Cancel") }}</inertia-button
          >
          <inertia-button
            as="button"
            type="button"
            @click.native.prevent="deleteModel"
            class="bg-blue-500 text-white"
            >{{ __("Yes, Delete") }}</inertia-button
          >
        </div>
      </template>
    </jet-confirmation-modal>
  </template>
  <style>
  .children-table {
    border-width: 1px;
    border-radius: 10px;
    padding: 15px 10px;
    margin-top: 25px;
    margin-bottom: 20px;
    position: relative;
  }

  .children-row {
    margin-bottom: 10px;
  }
  .children-row-n {
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
  .children-table > label > span > span {
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
    margin-top: 10px;
    margin-right: 10px;
    display: flex;
    justify-content: flex-end;
  }

  .children-row-even #delete-child {
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

  .del-btn svg {
    margin-right: 5px;
  }

  .v-select .v-field__field .v-field__input input[type="text"] {
    padding-top: unset;
  }
  th, td {
    border-width: 0.5px;
    border-color: #d7e0e0;
    padding: 5px;
  }

  </style>
  <script>
  import JetInput from "@/Jetstream/Input.vue";
  import InfiniteSelect from "@/JetinComponents/InfiniteSelect.vue";
  import JetinSelect from "@/JetinComponents/JetinSelect.vue";
  import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
  import JetDialogModal from "@/Jetstream/DialogModal.vue";
  import JetLabel from "@/Jetstream/Label.vue";
  import InertiaButton from "@/JetinComponents/InertiaButton.vue";
  import JetInputError from "@/Jetstream/InputError.vue";
  import { useForm } from "@inertiajs/vue3";
  import { defineComponent, ref } from "vue";
  import * as XLSX from 'xlsx'

  export default defineComponent({
    name: "CreateFormsForm",
    components: {
      InertiaButton,
      JetInputError,
      JetLabel,
      JetConfirmationModal,
      JetInput,
      InfiniteSelect,
      JetinSelect,
      JetDialogModal
    },
    data() {
      let formData = useForm(
        {
          name: null,
          status: "Enable",
          form_attributes: [
            {
              name: null,
              phone: null,
              email: null,
              product_sku: null,
              product_name: null,
              product_type: null,
              brand: null,
              ref_price: null,
              place_of_origin: null,
              product_image: null,
            },
          ],
        },
        { remember: false }
      );
      formData.errors.form_attributes = {};
      return {
        previewFile: false,
        tab: null,
        overlay: false,
        files: [],
        fileUpload:null,
        confirmDelete: false,
        currentModel: null,
        withDisabled: false,
        showModal: false,
        form: formData,
      };
    },
    mounted() {},
    computed: {
      flash() {
        return this.$page.props.flash || {};
      },
    },
    methods: {
        onChange(event) {
            this.file = event.target.files ? event.target.files[0] : null;
        },
        uploadFile(){
            const vm = this;
            this.previewFile = false;
            this.overlay = true;
            axios.post(this.route("api.forms.data.upload"), {
                "form_attributes": this.files
            })
            .then(function (response) {
                console.log(response);

                vm.overlay = false;
                vm.$refs.inputForm.reset();
                vm.fileUpload=null;
                vm.$emit("success", vm.__(response.data.message));
            })
            .catch(function (error) {
                console.log(error);
                vm.overlay = false;
                vm.fileUpload=null;
                vm.$emit("error", vm.__(error));
            });
        },
        rendImag(file) {
            let url;
            let img_url = "";
            if (typeof file == "string") {
            url = file;
            } else if (file) {
            url = file.name;
            }
            if (!url) {
            return "/assets/images/upload_02.gif";
            } else {
            let ext = url.substring(url.lastIndexOf(".") + 1);

            if (ext) {
                switch (ext) {
                case "jpg":
                case "png":
                case "jpeg":
                case "bmp":
                case "svg":
                case "gif":
                    if (typeof file == "string") img_url = file;
                    else img_url = URL.createObjectURL(file);
                    break;
                case "html":
                    img_url = "/assets/file_format/html.svg";
                    break;
                case "mov":
                    img_url = "/assets/file_format/mov.svg";
                    break;
                case "mp3":
                    img_url = "/assets/file_format/mp3.svg";
                    break;
                case "mp4":
                    img_url = "/assets/file_format/mp4.svg";
                    break;
                case "mpeg":
                    img_url = "/assets/file_format/mpeg.svg";
                    break;
                case "pdf":
                    img_url = "/assets/file_format/pdf.svg";
                    break;
                case "ppt":
                    img_url = "/assets/file_format/ppt.svg";
                    break;
                case "rar":
                    img_url = "/assets/file_format/rar.svg";
                    break;
                case "txt":
                    img_url = "/assets/file_format/txt.svg";
                    break;
                case "xml":
                    img_url = "/assets/file_format/xml.svg";
                    break;
                case "xsl":
                case "xsls":
                    img_url = "/assets/file_format/xsl.svg";
                    break;
                case "zip":
                    img_url = "/assets/file_format/zip.svg";
                    break;
                case "csv":
                    img_url = "/assets/file_format/csv.svg";
                    break;
                case "doc":
                    img_url = "/assets/file_format/doc.svg";
                    break;
                case "docx":
                    img_url = "/assets/file_format/docx.svg";
                    break;
                default:
                    img_url = "/assets/file_format/file.svg";
                    break;
                }
            }
            return img_url;
            }
        },
        selectImage(name, index) {
            if (typeof this.$refs[name + index][0] != "undefined")
            this.$refs[name + index][0].dispatchEvent(new MouseEvent("click"));
            else this.$refs[name + index].dispatchEvent(new MouseEvent("click"));
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
            if (this.currentModel.index > -1) {
            this.form[this.currentModel.modelName].splice(this.currentModel.index, 1);
            }
        },
        async storeModel() {
            this.form.post(
            this.route("forms.store"),
            {
                forceFormData: true,
                onSuccess: (res) => {
                    this.overlay = false;
                    if (this.flash.success) {
                        this.fileUpload=null;
                        this.$refs.inputForm.reset();
                        this.$emit("success", this.__(this.flash.success));
                    } else if (this.flash.error) {
                        this.$emit("error", this.__(this.flash.error));
                    } else {
                        this.$emit("error", this.__("Unknown server error."));
                    }
                },
                onError: (res) => {
                    this.overlay = false;
                    if (typeof this.$page.props.errors == "string")
                        this.$emit("error", this.$page.props.errors);
                    else if (typeof this.$page.props.errors != "object")
                        this.$emit("error", this.__("A server error occurred"));
                },
            },
            { remember: false, preserveState: true }
            );
        },
        addFiles() {
            this.$refs.files.click();
        },

        async handleFilesUpload(e) {
            
            this.overlay = true;
            let uploadedFiles = e.target.files[0];

            const result = await this.readXLSX(uploadedFiles)
            console.log(result)
            this.files = result;
            this.previewFile = true;
            
            this.overlay = false;
            return false
        },
        removeFile(key) {
            this.files.splice(key, 1);
        },
        async readXLSX(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader()

                reader.readAsBinaryString(file)
                reader.onload = evt => {
                const data = evt.target.result
                const wb = XLSX.read(data, { type: 'binary', sheetStubs:true })
                const ws = wb.Sheets[wb.SheetNames[0]]
                const jsonData = XLSX.utils.sheet_to_json(ws,{defval:""})
                resolve(jsonData)
                }
            })
        }
    },
    // watch: {
    //     overlay (val) {
    //         val && setTimeout(() => {
    //         this.overlay = false;
    //         }, 3000)
    //     },
    // },
  });
  </script>

  <style scoped></style>
