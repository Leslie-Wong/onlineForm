<?php
    $hasCheckbox = false;
    $hasSelect = false;
    $hasTextArea = false;
    $hasInput = false;
    $hasDate = false;
    $hasPassword = false;
    $hasFile = false;
    $hasMultiSelect = false;
    $hasSelectMultiple = [];
    $hasEditor = false;
    $hasJetinSelect  = false;
?>
<template>
    <form <?php echo e('@submit'); ?>.prevent="updateModel">
        <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $json = null; ?>
<?php if($col['comment']): ?>
<?php

try {
    $json = json_decode($col['comment']);
} catch (\Throwable $th) {
    $json = null;
};

?>
<?php endif; ?>
<?php if( $json ): ?>
    <?php if( strtolower($json->type) == "select"): ?>
        <?php $hasSelect = true; $multiple1 = ""; $multiple2 = "return-object"; ?>
        <?php if(strtolower($json->multiple)): ?>
            <?php $hasSelectMultiple[] = "if(typeof this.form.{$col['name']} == \"object\") this.form.{$col['name']} = JSON.stringify(this.form.{$col['name']});";
            $multiple1 = "multiple";
            $multiple2 = ''; ?>
        <?php endif; ?> <?php echo PHP_EOL; ?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
            <infinite-select :per-page="15"
                             :api-url="route('api.<?php echo e($json->route_name); ?>.index')"
                             v-model="form.<?php echo e($col['name']); ?>"
                             item-title="<?php echo e($json->label_column); ?>"
                             :class="{'': form.errors.<?php echo e($col['name']); ?>}"
                             <?php echo $multiple1; ?>

                             <?php echo $multiple2; ?>

                             variant="solo"
            ></infinite-select>
            <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
        </div>
    <?php elseif( strtolower($json->type) == "html" ): ?>
        <?php $hasEditor = true; ?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
                <jetin-editor class="w-full"
                                id="<?php echo e($col['name']); ?>"
                                name="<?php echo e($col['name']); ?>"
                                v-model="form.<?php echo e($col['name']); ?>"
                                :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':form.errors.<?php echo e($col['name']); ?>}"
                ></jetin-editor>
            <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
        </div>
    <?php endif; ?>
<?php elseif($col['type'] === 'enum' ): ?>
<?php $hasJetinSelect  = true; ?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
            <jetin-select
                v-model="form.<?php echo e($col['name']); ?>"
                :items="[<?php echo $col['options']; ?>]"
                item-title="label"
                item-value="value"
                :class="{'': form.errors.<?php echo e($col['name']); ?>}"
                variant="solo"
            ></jetin-select>
            <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
        </div>
<?php elseif($col['type'] === 'date' ): ?><?php $hasDate = true; echo "\r";?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
            <jetin-datepicker
                class="w-full"
                id="<?php echo e($col['name']); ?>"
                name="<?php echo e($col['name']); ?>"
                v-model="form.<?php echo e($col['name']); ?>"
                data-date-format="Y-m-d"
                :data-alt-input="true"
                data-alt-format="l M J, Y"
                :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.<?php echo e($col['name']); ?>}"
            ></jetin-datepicker>
            <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
        </div>
<?php elseif($col['type'] === 'time'): ?><?php $hasDate = true;echo "\r"; ?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
            <jetin-datepicker class="w-full"
                            data-date-format="H:i"
                            :data-alt-input="true"
                            data-alt-format="h:i K"
                            data-default-hour="9"
                            :data-enable-time="true"
                            :data-no-calendar="true"
                            name="<?php echo e($col['name']); ?>"
                            v-model="form.<?php echo e($col['name']); ?>"
                            id="<?php echo e($col['name']); ?>"
                            :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.<?php echo e($col['name']); ?>}"
            ></jetin-datepicker>
        <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
    </div>
<?php elseif($col['type'] === 'datetime'): ?><?php $hasDate = true;echo "\r"; ?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
            <jetin-datepicker class="w-full"
                            data-date-format="Y-m-d H:i:s"
                            :data-alt-input="true"
                            data-alt-format="l M J, Y at h:i K"
                            data-default-hour="9"
                            :data-enable-time="true"
                            name="<?php echo e($col['name']); ?>"
                            v-model="form.<?php echo e($col['name']); ?>"
                            id="<?php echo e($col['name']); ?>"
                            :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.<?php echo e($col['name']); ?>}"
            ></jetin-datepicker>
            <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
        </div>
<?php elseif($col['type'] === 'boolean'): ?><?php $hasCheckbox = true; echo "\r"; ?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
            <jet-checkbox class="p-2" type="checkbox" id="<?php echo e($col['name']); ?>" name="<?php echo e($col['name']); ?>" :checked="form.<?php echo e($col['name']); ?>" v-model="form.<?php echo e($col['name']); ?>"
                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.<?php echo e($col['name']); ?>}"
            ></jet-checkbox>
            <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
        </div>
<?php elseif(strpos(strtolower($col['name']), "file") !== false || strpos(strtolower($col['name']), "image") !== false): ?> <?php $hasFile = true; ?>
    <div class=" sm:col-span-4">
        <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
        <input :ref="<?php echo '\''.$col['name'].'0\''; ?>" class="hidden" type="file" id="<?php echo e($col['name']); ?>" name="<?php echo e($col['name']); ?>" @input="<?php echo e('this.form.'.$col['name']); ?> = $event.target.files[0]"
        >
        <img class="cursor-pointer " @click="selectImage(<?php echo '\''.$col['name'].'\''; ?>, 0)" :src="rendImag(<?php echo 'form.'.$col['name']; ?>)" />
        <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
    </div>
<?php elseif($col['type'] === 'text'): ?><?php $hasTextArea = true; echo "\r"; ?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
            <jetin-textarea class="w-full" id="<?php echo e($col['name']); ?>" name="<?php echo e($col['name']); ?>" v-model="form.<?php echo e($col['name']); ?>"
                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.<?php echo e($col['name']); ?>}"
            ></jetin-textarea>
            <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
        </div>
<?php elseif($col['type'] === 'double'|| $col['type'] ==='integer'): ?><?php $hasInput = true; echo "\r";?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
            <jet-input class="w-full" type="number" id="<?php echo e($col['name']); ?>" name="<?php echo e($col['name']); ?>" v-model="form.<?php echo e($col['name']); ?>"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.<?php echo e($col['name']); ?>}"
            ></jet-input>
            <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
        </div>
<?php elseif($col['name'] === 'password'): ?> <?php $hasInput = true; $hasPassword = true; echo "\r";?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
            <jet-input class="w-full" type="password" id="<?php echo e($col['name']); ?>" name="<?php echo e($col['name']); ?>" v-model="form.<?php echo e($col['name']); ?>"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.<?php echo e($col['name']); ?>}"
            ></jet-input>
            <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
        </div>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($col['name']); ?>_confirmation" value="Repeat <?php echo e($col['label']); ?>" />
            <jet-input class="w-full" type="password" id="<?php echo e($col['name']); ?>_confirmation" name="<?php echo e($col['name']); ?>_confirmation" v-model="form.<?php echo e($col['name']); ?>_confirmation"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.<?php echo e($col['name']); ?>_confirmation}"
            ></jet-input>
        </div>
<?php elseif($col['name'] === 'lang'): ?>
<?php $hasMultiSelect = true; ?>
    <div class=" sm:col-span-4">
        <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
        <les-multi-select
            id="<?php echo e('form.'.$col['name']); ?>"
            name="<?php echo e('form.'.$col['name']); ?>"
            label="<?php echo e('form.'.$col['name']); ?>"
            v-model="<?php echo e('form.'.$col['name']); ?>"
            :placeholder="__('Please select a language')"
            :options="this.$page.props.languages.map(lang => lang.code)"
            :getLangName="getLangName"
            :getLangFlag="getLangFlag"
            :custom-label="getLangLable"
            trackBy=""
        />
        <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
    </div>
<?php else: ?> <?php $hasInput = true; echo "\r"; ?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($col['name']); ?>" value="<?php echo e($col['label']); ?>" />
            <jet-input class="w-full" type="text" id="<?php echo e($col['name']); ?>" name="<?php echo e($col['name']); ?>" v-model="form.<?php echo e($col['name']); ?>"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.<?php echo e($col['name']); ?>}"
            ></jet-input>
            <jet-input-error :message="form.errors.<?php echo e($col['name']); ?>" class="mt-2" />
        </div>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if(count($relations)): ?>
    <?php if(isset($relations['belongsTo']) && count($relations['belongsTo'])): ?>
        <?php $__currentLoopData = $relations['belongsTo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $belongsTo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php $hasSelect = true; echo "\r"; ?>
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
</template>

<script>
    import JetLabel from "@/Jetstream/Label.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import JetInputError from "@/Jetstream/InputError.vue";
    import {useForm} from "@inertiajs/vue3";
    <?php if($hasCheckbox): ?>import JetCheckbox from "@/Jetstream/Checkbox.vue";
<?php endif; ?>
<?php if($hasDate): ?>import JetinDatepicker from "@/JetinComponents/JetinDatepicker.vue";
<?php endif; ?>
    <?php if($hasInput): ?>import JetInput from "@/Jetstream/Input.vue";
<?php endif; ?>
    <?php if($hasTextArea): ?>import JetinTextarea from "@/JetinComponents/JetinTextarea.vue";
<?php endif; ?>
    <?php if($hasSelect): ?>import InfiniteSelect from '@/JetinComponents/InfiniteSelect.vue';
<?php endif; ?>
    <?php if($hasEditor): ?>import JetinEditor from '@/JetinComponents/JetinEditor.vue';
<?php endif; ?>
<?php if($hasJetinSelect): ?>
    import JetinSelect from '@/JetinComponents/JetinSelect.vue';
<?php endif; ?>
<?php if($hasMultiSelect): ?>
    import LesMultiSelect from '@/LesComponents/LesMultiSelect.vue';
<?php endif; ?>
    import DisplayMixin from "@/Mixins/DisplayMixin.js";
    import { defineComponent, ref } from "vue";

    export default defineComponent({
        name: "Edit<?php echo e($modelBaseName); ?>Form",
        props: {
            model: Object,
        },
        components: {
            InertiaButton,
            JetLabel,
            JetInputError,
            <?php if($hasInput): ?>JetInput,<?php endif; ?>
            <?php if($hasDate): ?>JetinDatepicker,<?php endif; ?>
            <?php if($hasCheckbox): ?>JetCheckbox,<?php endif; ?>
            <?php if($hasTextArea): ?>JetinTextarea,<?php endif; ?>
            <?php if($hasSelect): ?>InfiniteSelect,<?php endif; ?>
            <?php if($hasMultiSelect): ?>LesMultiSelect,<?php endif; ?>
            <?php if($hasEditor): ?>JetinEditor,<?php echo e("\r"); ?><?php endif; ?>
            <?php if($hasJetinSelect): ?>JetinSelect,<?php echo e("\r"); ?><?php endif; ?>
        },
        mixins: [DisplayMixin],
        data() {
            return {
                form: useForm({
                    ...this.model,
<?php if($hasPassword): ?>
                    "password_confirmation": null,
<?php endif; ?>

<?php if($hasFile): ?>
                    "_method": "PUT",
<?php endif; ?>
                },{remember:false}),
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
<?php if($hasFile): ?>
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
<?php endif; ?>
<?php if($hasMultiSelect): ?>
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
            selectImage(name, index){
                if(typeof this.$refs[name + index][0] != 'undefined')
                    this.$refs[name + index][0].dispatchEvent(new MouseEvent('click'));
                else
                    this.$refs[name + index].dispatchEvent(new MouseEvent('click'));
            },
            async updateModel() {
<?php $__currentLoopData = $hasSelectMultiple; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $multiple): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $multiple; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if($hasFile): ?>
                this.form.post(this.route('admin.<?php echo e($modelRouteAndViewName); ?>.update',this.form.slug),
<?php else: ?>
                this.form.put(this.route('admin.<?php echo e($modelRouteAndViewName); ?>.update',this.form.slug),
<?php endif; ?>
                    {
                        <?php if($hasFile): ?> <?php echo PHP_EOL ?>
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
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/edit-form.blade.php ENDPATH**/ ?>