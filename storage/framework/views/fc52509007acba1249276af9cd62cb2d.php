<?php
    $hasCheckbox = true;
    $hasSelect = false;
    $hasTextArea = false;
    $hasInput = false;
    $hasDate = false;
    $hasPassword = false;
    $hasMultiSelect = false;
?>
<template>
    <jetin-tabs :class="`border-none`" nav-classes="bg-secondary-300 rounded-t-lg border-b-4 border-primary">
        <template #nav>
            <jetin-tab-link @activate="activeTab=$event" :active-classes="tabActiveClasses" :tab-controller="activeTab"
                          tab="basic-info">{{__("Basic Info")}}
            </jetin-tab-link>
            <jetin-tab-link @activate="activeTab=$event" :active-classes="tabActiveClasses" :tab-controller="activeTab"
                          tab="assign-roles">{{__("Assign Roles")}}
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
            <jetin-tab name="assign-roles" :tab-controller="activeTab">
                <div class="my-2 border rounded-md p-3">
                    <h3 class="font-bold py-3 text-lg">{{__("Assign Roles")}}</h3>
                    <hr>
                    <div class="p-2 mt-2 border rounded">
                        <div style="cursor: pointer" v-for="(role, idx) of form.assigned_roles" :key="idx"
                             class=" sm:col-span-4 px-10 flex border-b border-gray-100 justify-between py-3 items-center my-2">
                            <jet-label :for="role.name" class="inline-block  font-black text-xl"
                                       :value="role.title"/>
                            <jet-checkbox @change="toggleRole(role)" class="p-2 inline-block" type="checkbox"
                                          :id="role.name" :name="role.name" :checked="role.checked" v-model="role.checked"
                                          :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.assigned_roles}"
                            ></jet-checkbox>
                        </div>
                    </div>
                </div>
            </jetin-tab>
        </template>
    </jetin-tabs>
</template>

<script>
    import JetLabel from "@/Jetstream/Label.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import JetInputError from "@/Jetstream/InputError.vue";
    import {useForm} from "@inertiajs/vue3";
    import JetinTab from "@/JetinComponents/JetinTab.vue";
    import JetinTabs from "@/JetinComponents/JetinTabs.vue";
    import JetinTabLink from "@/JetinComponents/JetinTabLink.vue";
    import DisplayMixin from "@/Mixins/DisplayMixin.js";

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
<?php if($hasMultiSelect): ?>
    import LesMultiSelect from '@/LesComponents/LesMultiSelect.vue';
<?php endif; ?>

    export default {
        name: "Edit<?php echo e($modelPlural); ?>Form",
        props: {
            model: Object,
            roles: Object,
        },
        components: {
            InertiaButton,
            JetLabel,
            JetInputError,
            <?php if($hasInput): ?>JetInput,
<?php endif; ?>
            <?php if($hasDate): ?>JetinDatepicker,
<?php endif; ?>
            <?php if($hasCheckbox): ?>JetCheckbox,
<?php endif; ?>
            <?php if($hasTextArea): ?>JetinTextarea,
<?php endif; ?>
            <?php if($hasSelect): ?>InfiniteSelect,
<?php endif; ?>
            <?php if($hasMultiSelect): ?>LesMultiSelect,
<?php endif; ?>

            JetinTabLink,
            JetinTabs,
            JetinTab,
        },
        mixins: [DisplayMixin],
        data() {
            return {
                form: useForm({
                    ...this.model,
                    assigned_roles: this.roles,
<?php if($hasPassword): ?>
                    password_confirmation: null,
<?php endif; ?>
                },{remember:false}),
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
            async updateModel() {
                this.form.put(this.route('admin.<?php echo e($modelRouteAndViewName); ?>.update',this.form.slug),
                    {
                        onSuccess: res => {
                            if (this.flash.success) {
                                this.<?php echo e('$'); ?>emit(this.__("success"),this.__(this.flash.success));
                            } else if (this.flash.error) {
                                this.<?php echo e('$'); ?>emit(this.__("success"),this.__(this.flash.error));
                            } else {
                                this.<?php echo e('$'); ?>emit(this.__("success"),this.__("Unknown server error."))
                            }
                        },
                        onError: res => {
                            this.<?php echo e('$'); ?>emit(this.__("success"),this.__("A server error occurred"));
                        }
                    },{remember: false, preserveState: true})
            },
            async toggleRole(role) {
                const vm = this;
                axios.post(this.route('api.users.assign-role',this.form.slug),{role: role}).then(res => {
                    this.<?php echo e('$'); ?>inertia.reload({preserveState: true});
                    this.displayNotification(this.__("success"),res.data.message)
                }).catch(err => {
                    this.displayNotification(this.__("success"),err.response?.data?.message || err.message || err)
                    vm.form.assigned_roles[role.name].checked = !role.checked;
                });
            }
        }
    }
</script>

<style scoped>

</style>
<?php /**PATH /var/www/online_form/vendor/lesliew/laravel-jetin-generator/src/../resources/views/templates/user/edit-form.blade.php ENDPATH**/ ?>