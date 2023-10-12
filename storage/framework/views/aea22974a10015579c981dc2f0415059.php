<?php $json = null; ?>
<?php if($column['comment']): ?>
<?php

try {
    $json = json_decode($column['comment']);
} catch (\Throwable $th) {
    $json = null;
};

?>
<?php endif; ?>
<?php if( $json): ?>
<?php if( strtolower($json->type) == "select" ): ?>
<?php $initData->hasSelect = true; $multiple1 = ""; $multiple2 = ""; ?>
<?php if(strtolower($json->multiple)): ?>
    <?php
    $initData->hasSelectMultiple[$key?$key:"root"][] = $column['name'];
    $multiple1 = "multiple";
    $multiple2 = 'return-object'; ?>
<?php endif; ?> <?php echo PHP_EOL; ?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
            <infinite-select :per-page="15"
                             :api-url="route('api.<?php echo e(str_replace("_","-",$json->route_name)); ?>.index')"
                             v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
                             item-title="<?php echo e($json->label_column); ?>"
                             :class="{'': form.errors.<?php echo e($column['name']); ?>}"
                             <?php echo $multiple1; ?>

                             <?php echo $multiple2; ?>

                             variant="solo"
            ></infinite-select>
            <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
        </div>
<?php elseif( strtolower($json->type) == "html" ): ?>
<?php $initData->hasEditor = true; ?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
                <jetin-editor class="w-full"
                                id="<?php echo e($column['name']); ?>"
                                name="<?php echo e($column['name']); ?>"
                                v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
                                :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>}"
                ></jetin-editor>
            <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
        </div>
<?php endif; ?>
<?php elseif($column['type'] === 'enum' ): ?>
<?php $initData->hasJetinSelect  = true; ?>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
            <jetin-select
                v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
                :items="[<?php echo $column['options']; ?>]"
                item-title="label"
                item-value="value"
                :class="{'': form.errors.<?php echo e($column['name']); ?>}"
                variant="solo"
            ></jetin-select>
            <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
        </div>
<?php elseif($column['type'] === 'date' ): ?><?php $initData->hasDate  = true; echo "\r";?>
    <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
            <jetin-datepicker
                class="w-full"
                id="<?php echo e($column['name']); ?>"
                name="<?php echo e($column['name']); ?>"
                v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
                data-date-format="Y-m-d"
                :data-alt-input="true"
                data-alt-format="Y-m-d"
                :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>}"
            ></jetin-datepicker>
            <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
        </div>
<?php elseif($column['type'] === 'time'): ?><?php $initData->hasDate  = true;echo "\r"; ?>
    <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
            <jetin-datepicker class="w-full"
                            data-date-format="H:i"
                            :data-alt-input="true"
                            data-alt-format="h:i K"
                            data-default-hour="9"
                            :data-enable-time="true"
                            :data-no-calendar="true"
                            name="<?php echo e($column['name']); ?>"
                            v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
                            id="<?php echo e($column['name']); ?>"
                            :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>}"
            ></jetin-datepicker>
        <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
    </div>
<?php elseif($column['type'] === 'datetime' || $column['type'] === 'timestamp'): ?><?php $initData->hasDate  = true;echo "\r"; ?>
    <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
            <jetin-datepicker class="w-full"
                            data-date-format="Y-m-d H:i:s"
                            :data-alt-input="true"
                            data-alt-format="Y-m-d h:i K"
                            data-default-hour="9"
                            :data-enable-time="true"
                            name="<?php echo e($column['name']); ?>"
                            v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
                            id="<?php echo e($column['name']); ?>"
                            :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>}"
            ></jetin-datepicker>
            <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
        </div>
<?php elseif($column['type'] === 'boolean'): ?><?php $initData->hasCheckbox  = true; echo "\r"; ?>
    <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
            <jet-checkbox class="p-2" type="checkbox" id="<?php echo e($column['name']); ?>" name="<?php echo e($column['name']); ?>" :checked="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>" v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>}"
            ></jet-checkbox>
            <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
        </div>
<?php elseif(strpos(strtolower($column['name']), "file") !== false || strpos(strtolower($column['name']), "image") !== false): ?>
<?php $initData->hasFile = true; ?>
    <div class=" sm:col-span-4">
        <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
        <input :ref="<?php echo $key!=''?'\''.$key.'\'+index':'\''.$column['name'].'0\''; ?>" class="hidden" type="file" id="<?php echo e($column['name']); ?>" name="<?php echo e($column['name']); ?>" @input="<?php echo e($key!=''?'this.form.'.$key.'[index].'.$column['name']:'this.form.'.$column['name']); ?> = $event.target.files[0]"
        >
        <img class="cursor-pointer " @click="selectImage(<?php echo $key!=''?'\''.$key.'\'':'\''.$column['name'].'\''; ?>, <?php echo $key!=''?'index':0; ?>)" :src="rendImag(<?php echo $key!=''?$key.'.'.$column['name']:'form.'.$column['name']; ?>)" />
        <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
    </div>
<?php elseif($column['type'] === 'text'  || ($column['type'] === 'varchar' && intval($column['options']) > 255 )): ?><?php $initData->hasTextArea  = true; echo "\r"; ?>
    <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
            <jetin-textarea class="w-full" id="<?php echo e($column['name']); ?>" name="<?php echo e($column['name']); ?>" v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>}"
            ></jetin-textarea>
            <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
        </div>
<?php elseif($column['type'] === 'double'|| $column['type'] ==='integer'): ?><?php $initData->hasInput  = true; echo "\r";?>
    <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
            <jet-input class="w-full" type="number" id="<?php echo e($column['name']); ?>" name="<?php echo e($column['name']); ?>" v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>}"
            ></jet-input>
            <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
        </div>
<?php elseif($column['name'] === 'password'): ?> <?php $initData->hasInput = true; $hasPassword  = true; echo "\r";?>
    <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
            <jet-input class="w-full" type="password" id="<?php echo e($column['name']); ?>" name="<?php echo e($column['name']); ?>" v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>}"
            ></jet-input>
            <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
        </div>
        <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>_confirmation" value="Repeat <?php echo e($column['label']); ?>" />
            <jet-input class="w-full" type="password" id="<?php echo e($column['name']); ?>_confirmation" name="<?php echo e($column['name']); ?>_confirmation" v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>_confirmation"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>_confirmation}"
            ></jet-input>
        </div>
<?php elseif($column['name'] === 'lang'): ?>
<?php $initData->hasMultiSelect = true; ?>
    <div class=" sm:col-span-4">
        <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
        <les-multi-select
            id="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
            name="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
            label="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
            v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
            :placeholder="__('Please select a language')"
            :options="this.$page.props.languages.map(lang => lang.code)"
            :getLangName="getLangName"
            :getLangFlag="getLangFlag"
            :custom-label="getLangLable"
            trackBy=""
        />
        <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
    </div>
<?php else: ?>
<?php $initData->hasInput  = true; ?>
<?php if($column['name'] === 'id'): ?>
    <div class=" sm:col-span-4">
            <jet-input class="w-full" type="hidden" id="<?php echo e($column['name']); ?>" name="<?php echo e($column['name']); ?>" v-model="<?php echo e($key!=''?$key.".slug":'form.slug'); ?>"
            ></jet-input>
        </div>
<?php else: ?>
    <div class=" sm:col-span-4">
            <jet-label for="<?php echo e($column['name']); ?>" value="<?php echo e($column['label']); ?>" />
            <jet-input class="w-full" type="text" id="<?php echo e($column['name']); ?>" name="<?php echo e($column['name']); ?>" v-model="<?php echo e($key!=''?$key.".".$column['name']:'form.'.$column['name']); ?>"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>}"
            ></jet-input>
            <jet-input-error :message="form.errors<?php echo $key!=''?'[\''.$key.'.\'+index+\'.'.$column['name'].'\']':'.'.$column['name']; ?>" class="mt-2" />
        </div>
<?php endif; ?>
<?php endif; ?>
<?php if(isset($relations) && count($relations)): ?>
<?php if(isset($relations['belongsTo']) && count($relations['belongsTo'])): ?>
<?php $__currentLoopData = $relations['belongsTo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $belongsTo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $initData->hasSelect = true; ?>
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
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/withChildren/edit-form-column.blade.php ENDPATH**/ ?>