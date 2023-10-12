<?php
    $hasCheckbox = false;
    $hasSelect = false;
    $hasTextArea = false;
    $hasInput = false;
    $hasDate = false;
    $hasPassword = false;
?>
<template>
    <jetin-tabs :class="`border-none`" nav-classes="bg-secondary-300 rounded-t-lg border-b-4 border-primary">
        <template #nav>
            <jetin-tab-link @activate="setTab" :active-classes="tabActiveClasses" :tab-controller="activeTab"
                          tab="basic-info">{{__("Basic Info")}}
            </jetin-tab-link>
            <jetin-tab-link @activate="setTab" :active-classes="tabActiveClasses" :tab-controller="activeTab"
                          tab="assign-permissions">{{__("Assign Permissions")}}
            </jetin-tab-link>
        </template>
        <template #content>
            <jetin-tab name="basic-info" :tab-controller="activeTab">
                <form <?php echo e('@submit'); ?>.prevent="updateModel">
                <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($col['type'] === 'date' ): ?><?php $hasDate = true; echo "\r";?>
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
    <div class=" sm:col-span-4">
        <jet-label for="<?php echo e($belongsTo['relationship_variable']); ?>" :value="__('<?php echo e($belongsTo['related_model_title']); ?>')" />
        <infinite-select class="w-full" :per-page="15" :api-url="route('api.<?php echo e($belongsTo['related_route_name']); ?>.index')"
                         id="<?php echo e($belongsTo['relationship_variable']); ?>" name="<?php echo e($belongsTo['relationship_variable']); ?>"
                         v-model="form.<?php echo e($belongsTo['relationship_variable']); ?>" label="<?php echo e($belongsTo["label_column"]); ?>"
                         :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.<?php echo e($belongsTo['relationship_variable']); ?>}"
        ></infinite-select>
        <jet-input-error :message="form.errors.<?php echo e($belongsTo['relationship_variable']); ?>" class="mt-2" />
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
                <?php endif; ?>

                    <div class="mt-2 text-right">
                        <inertia-button type="submit" class="bg-primary font-semibold text-white bg-gray-400" :disabled="form.processing">{{__("Submit")}}</inertia-button>
                    </div>
                </form>
            </jetin-tab>
            <jetin-tab name="assign-permissions" :tab-controller="activeTab">
                <assign-perms :role="model" :permissions="permissions"></assign-perms>
            </jetin-tab>
        </template>
    </jetin-tabs>
</template>

<script>
import JetLabel from "@/Jetstream/Label.vue";
import InertiaButton from "@/JetinComponents/InertiaButton.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import {useForm} from "@inertiajs/vue3";
import JetInput from "@/Jetstream/Input.vue";
import JetinTabs from "@/JetinComponents/JetinTabs.vue";
import JetinTabLink from "@/JetinComponents/JetinTabLink.vue";
import JetinTab from "@/JetinComponents/JetinTab.vue";
import AssignPerms from "@/Pages/Roles/AssignPerms.vue";

export default {
    name: "Edit<?php echo e($modelPlural); ?>Form",
    props: {
        model: Object,
        permissions: Object,
    },
    components: {
        AssignPerms,
        JetinTab,
        JetinTabLink,
        JetinTabs,
        InertiaButton,
        JetLabel,
        JetInputError,
        JetInput,

    },
    data() {
        return {
            form: useForm({
                ...this.model,
            }, {remember: false}),
            activeTab: 'basic-info',
            tabActiveClasses: "bg-primary font-bold text-secondary rounded-t-lg hover:bg-primary-200 hover:text-amber-900 text-amber-400"
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
        async updateModel() {
            this.form.put(this.route('admin.roles.update', this.form.slug),
                {
                    onSuccess: res => {
                        if (this.flash.success) {
                            this.$emit("success",this.__(this.flash.success));
                        } else if (this.flash.error) {
                            this.$emit(__("error"),__(this.flash.error));
                        } else {
                            this.$emit(__("error"),__("Unknown server error."))
                        }
                    },
                    onError: res => {
                        this.$emit(__("error"),__("A server error occurred"));
                    }
                }, {remember: false, preserveState: true})
        },
        setTab(tab){
            this.activeTab = tab;
        }
    }
}
</script>

<style scoped>

</style>
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/role/edit-form.blade.php ENDPATH**/ ?>