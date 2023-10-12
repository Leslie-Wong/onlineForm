<?php
    $initData = [
        "hasCheckbox" => false,
        "hasSelect" => false,
        "hasMultiSelect" => false,
        "hasTextArea" => false,
        "hasInput" => false,
        "hasDate" => false,
        "hasPassword" => false,
        "hasFile" => false,
        "hasSelectMultiple" => [],
        "hasEditor" => false,
    ];
    $children = [];
    $hasEnableMulti = false;
?>
<template>
    <form <?php echo e('@submit'); ?>.prevent="updateModel">
<?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $children[$key] = ""; ?>
<?php if(!isset($col['type']) && gettype($col) === "object"): ?>
<?php $children[$key] = "";?>
            <div class=" sm:col-span-4 children-table shadow-sm border-gray-100">
                <jet-label class="shadow-sm" for="<?php echo e($key); ?>">
                    <span class="border-gray-100"><?php echo e(str_replace("_"," ",Str::title($key))); ?></span>
                </jet-label>
                <div id="<?php echo e($key); ?>" v-for="(<?php echo e($key); ?>, index) in form.<?php echo e($key); ?>" :key="index">
                    <div :class="['children-row', (index!=0?'children-row-n':''),(index%2!=0?'children-row-even':'')]">

<?php $hasLang = false; ?>
<?php $__currentLoopData = $col; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childKey => $childColumns): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $model->renderViewColumn($childColumns, $key, $type); ?>

<?php if($childKey === 'lang'): ?>
<?php $hasLang = true; ?>
<?php endif; ?>
<?php if($model->initData->hasCheckbox): ?>
<?php $children[$key] .= $childKey.':false,'; ?>
<?php else: ?>
<?php $children[$key] .= $childKey.':null,'; ?>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div id="delete-child">
                            <div  class="del-btn shadow-md rounded-md bg-gray-200 font-semibold form-button-bg-1 cursor-pointer disabled:opacity-25" @click="confirmDeletion(Object.assign({'index':index, 'modelName':'<?php echo e($key); ?>'}, <?php echo e($key); ?>))">
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
<?php if(isset($childrenOptions[$key]) && in_array('multi', $childrenOptions[$key])): ?>
<?php $hasEnableMulti = true; ?>
                                <div class="mt-2 text-right">
                                    <input type="button" @click="addNewLang('<?php echo e($key); ?>')" class="add-new-lang p-2 shadow-md rounded-md bg-gray-200 font-semibold form-button-bg-1 cursor-pointer disabled:opacity-25" :value="__('New')"/>
                                </div>
<?php elseif($hasLang): ?>
                                <div class="mt-2 text-right">
                                    <input type="button" @click="addNewLang('<?php echo e($key); ?>')" class="add-new-lang p-2 shadow-md rounded-md bg-gray-200 font-semibold form-button-bg-1 cursor-pointer disabled:opacity-25" :value="__('Add New Language')"/>
                                </div>
<?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
<?php $children[$key] = "{".$children[$key]."}"; ?>
<?php else: ?>
        <?php echo $model->renderViewColumn($col, "", $type); ?>

<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if(count($relations)): ?>
<?php if(isset($relations['belongsTo']) && count($relations['belongsTo'])): ?>
<?php $__currentLoopData = $relations['belongsTo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $belongsTo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $model->initData->hasSelect = true; ?>
<?php Lesliew\LaravelJetinGenerator\Generators\ColumnTransition::addTransitionText($belongsTo['related_model_title']) ?>
                <div class=" sm:col-span-4">
                    <jet-label for="<?php echo e($belongsTo['relationship_variable']); ?>" :value="__('<?php echo e($belongsTo['related_model_title']); ?>')" />
                    <infinite-select :per-page="15"
                             :api-url="route('api.<?php echo e($belongsTo['related_route_name']); ?>.index')"
                             v-model="form.<?php echo e($belongsTo['relationship_variable']); ?>"
                             item-title="<?php echo e($belongsTo["label_column"]); ?>"
                             :class="{'': form.errors.<?php echo e($belongsTo['relationship_variable']); ?>}"
                             return-object
                             variant="solo"
                    ></infinite-select>
                    <jet-input-error :message="form.errors.<?php echo e($belongsTo['relationship_variable']); ?>" class="mt-2" />
                </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php endif; ?>

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
<?php if($model->initData->hasCheckbox): ?>
    import JetCheckbox from "@/Jetstream/Checkbox.vue";
<?php endif; ?>
<?php if($model->initData->hasDate): ?>
    import JetinDatepicker from "@/JetinComponents/JetinDatepicker.vue";
<?php endif; ?>
<?php if($model->initData->hasInput): ?>
    import JetInput from "@/Jetstream/Input.vue";
<?php endif; ?>
<?php if($model->initData->hasTextArea): ?>
    import JetinTextarea from "@/JetinComponents/JetinTextarea.vue";
<?php endif; ?>
<?php if($model->initData->hasSelect): ?>
    import InfiniteSelect from '@/JetinComponents/InfiniteSelect.vue';
<?php endif; ?>
<?php if($model->initData->hasEditor): ?>
    import JetinEditor from '@/JetinComponents/JetinEditor.vue';
<?php endif; ?>
<?php if($model->initData->hasJetinSelect): ?>
    import JetinSelect from '@/JetinComponents/JetinSelect.vue';
<?php endif; ?>
<?php if($model->initData->hasMultiSelect): ?>
    import LesMultiSelect from '@/LesComponents/LesMultiSelect.vue';
<?php endif; ?>
    import { defineComponent, ref } from "vue";

    export default defineComponent({
        name: "Edit<?php echo e($modelBaseName); ?>Form",
        props: {
            model: Object,
        },
        components: {
            JetConfirmationModal,
            InertiaButton,
            JetLabel,
            JetInputError,
<?php if($model->initData->hasInput): ?>
            JetInput,
<?php endif; ?>
<?php if($model->initData->hasDate): ?>
            JetinDatepicker,
<?php endif; ?>
<?php if($model->initData->hasCheckbox): ?>
            JetCheckbox,
<?php endif; ?>
<?php if($model->initData->hasTextArea): ?>
            JetinTextarea,
<?php endif; ?>
<?php if($model->initData->hasSelect): ?>
            InfiniteSelect,
<?php endif; ?>
<?php if($model->initData->hasEditor): ?>
            JetinEditor,
<?php endif; ?>
<?php if($model->initData->hasJetinSelect): ?>
            JetinSelect,
<?php endif; ?>
<?php if($model->initData->hasMultiSelect): ?>
            LesMultiSelect,
<?php endif; ?>

        },
        data() {
            return {
                confirmDelete: false,
                currentModel: null,
                withDisabled: false,
                showModal: false,
                form: useForm({
                    ...this.model,
                <?php if($model->initData->hasPassword): ?> <?php echo PHP_EOL ?>
                    "password_confirmation": null,<?php endif; ?>
                <?php if(isset($model->initData->hasFile) && $model->initData->hasFile): ?> <?php echo PHP_EOL ?>
                    "_method": "PUT",<?php endif; ?>

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
<?php if($model->initData->hasFile): ?>
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
<?php endif; ?>
<?php if($hasLang || $hasEnableMulti): ?>
            addNewLang(val){
                if(!this.form[val][this.form[val].length]){
                    this.form[val][this.form[val].length] = {};
                }
                Object.keys(this.form[val][0]).forEach(key => {
                    this.form[val][this.form[val].length][key] = null;
                });
            },
<?php endif; ?>
<?php if($model->initData->hasMultiSelect): ?>
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
<?php endif; ?>
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
                    this.$inertia.delete(route('admin.<?php echo e($modelRouteAndViewName); ?>.children.destroy', vm.currentModel),{
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
<?php $__currentLoopData = $model->initData->hasSelectMultiple; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($key == "root"): ?>
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                if(typeof this.form.<?php echo e($field); ?> == "object") this.form.<?php echo e($field); ?> = JSON.stringify(this.form.<?php echo e($field); ?>);
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
<?php $dataFields = []; ?>
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $dataFields[] = 'if(typeof this.form.'.$key.'[index].'.$field.' == "object"){  this.form.'.$key.'[index].'.$field.' = JSON.stringify(this.form.'.$key.'[index].'.$field.'); }'; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                this.form.<?php echo e($key); ?>.forEach((val,index) => {
<?php $__currentLoopData = $dataFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dataField): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $dataField; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                });
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($model->initData->hasFile) && $model->initData->hasFile): ?> <?php echo PHP_EOL ?>
                this.form.post(this.route('admin.<?php echo e($modelRouteAndViewName); ?>.update',this.form.slug), <?php else: ?> <?php echo PHP_EOL ?>
                this.form.put(this.route('admin.<?php echo e($modelRouteAndViewName); ?>.update',this.form.slug), <?php endif; ?> <?php echo PHP_EOL ?>
                    {
                        <?php if(isset($model->initData->hasFile) && $model->initData->hasFile): ?> <?php echo PHP_EOL ?>
                        forceFormData: true,
                        <?php endif; ?> <?php echo PHP_EOL ?>
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
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/withChildren/edit-form.blade.php ENDPATH**/ ?>