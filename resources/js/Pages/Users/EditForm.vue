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
                <form @submit.prevent="updateModel">
                                     <div class=" sm:col-span-4">
                        <jet-label for="name" value="Name" />
                        <jet-input class="w-full" type="text" id="name" name="name" v-model="form.name"
                                   :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.name}"
                        ></jet-input>
                        <jet-input-error :message="form.errors.name" class="mt-2" />
                    </div>
                                 <div class=" sm:col-span-4">
                        <jet-label for="email" value="Email" />
                        <jet-input class="w-full" type="text" id="email" name="email" v-model="form.email"
                                   :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.email}"
                        ></jet-input>
                        <jet-input-error :message="form.errors.email" class="mt-2" />
                    </div>
                                 <div class=" sm:col-span-4">
                        <jet-label for="email_verified_at" value="Email Verified At" />
                        <jet-input class="w-full" type="text" id="email_verified_at" name="email_verified_at" v-model="form.email_verified_at"
                                   :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.email_verified_at}"
                        ></jet-input>
                        <jet-input-error :message="form.errors.email_verified_at" class="mt-2" />
                    </div>
                                 <div class=" sm:col-span-4">
                        <jet-label for="password" value="Password" />
                        <jet-input class="w-full" type="password" id="password" name="password" v-model="form.password"
                                   :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.password}"
                        ></jet-input>
                        <jet-input-error :message="form.errors.password" class="mt-2" />
                    </div>
                    <div class=" sm:col-span-4">
                        <jet-label for="password_confirmation" value="Repeat Password" />
                        <jet-input class="w-full" type="password" id="password_confirmation" name="password_confirmation" v-model="form.password_confirmation"
                                   :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.password_confirmation}"
                        ></jet-input>
                    </div>
                                <div class=" sm:col-span-4">
                        <jet-label for="two_factor_secret" value="Two Factor Secret" />
                        <jetin-textarea class="w-full" id="two_factor_secret" name="two_factor_secret" v-model="form.two_factor_secret"
                                      :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.two_factor_secret}"
                        ></jetin-textarea>
                        <jet-input-error :message="form.errors.two_factor_secret" class="mt-2" />
                    </div>
                                <div class=" sm:col-span-4">
                        <jet-label for="two_factor_recovery_codes" value="Two Factor Recovery Codes" />
                        <jetin-textarea class="w-full" id="two_factor_recovery_codes" name="two_factor_recovery_codes" v-model="form.two_factor_recovery_codes"
                                      :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.two_factor_recovery_codes}"
                        ></jetin-textarea>
                        <jet-input-error :message="form.errors.two_factor_recovery_codes" class="mt-2" />
                    </div>
                                 <div class=" sm:col-span-4">
                        <jet-label for="two_factor_confirmed_at" value="Two Factor Confirmed At" />
                        <jet-input class="w-full" type="text" id="two_factor_confirmed_at" name="two_factor_confirmed_at" v-model="form.two_factor_confirmed_at"
                                   :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.two_factor_confirmed_at}"
                        ></jet-input>
                        <jet-input-error :message="form.errors.two_factor_confirmed_at" class="mt-2" />
                    </div>
                                 <div class=" sm:col-span-4">
                        <jet-label for="current_team_id" value="Current Team Id" />
                        <jet-input class="w-full" type="text" id="current_team_id" name="current_team_id" v-model="form.current_team_id"
                                   :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.current_team_id}"
                        ></jet-input>
                        <jet-input-error :message="form.errors.current_team_id" class="mt-2" />
                    </div>
                                 <div class=" sm:col-span-4">
                        <jet-label for="profile_photo_path" value="Profile Photo Path" />
                        <jet-input class="w-full" type="text" id="profile_photo_path" name="profile_photo_path" v-model="form.profile_photo_path"
                                   :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.profile_photo_path}"
                        ></jet-input>
                        <jet-input-error :message="form.errors.profile_photo_path" class="mt-2" />
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

    import JetCheckbox from "@/Jetstream/Checkbox.vue";
    import JetInput from "@/Jetstream/Input.vue";
    import JetinTextarea from "@/JetinComponents/JetinTextarea.vue";
        import LesMultiSelect from '@/LesComponents/LesMultiSelect.vue';

    export default {
        name: "EditUsersForm",
        props: {
            model: Object,
            roles: Object,
        },
        components: {
            InertiaButton,
            JetLabel,
            JetInputError,
            JetInput,
                        JetCheckbox,
            JetinTextarea,
                        LesMultiSelect,

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
                    password_confirmation: null,
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
            async updateModel() {
                this.form.put(this.route('admin.users.update',this.form.slug),
                    {
                        onSuccess: res => {
                            if (this.flash.success) {
                                this.$emit(this.__("success"),this.__(this.flash.success));
                            } else if (this.flash.error) {
                                this.$emit(this.__("success"),this.__(this.flash.error));
                            } else {
                                this.$emit(this.__("success"),this.__("Unknown server error."))
                            }
                        },
                        onError: res => {
                            this.$emit(this.__("success"),this.__("A server error occurred"));
                        }
                    },{remember: false, preserveState: true})
            },
            async toggleRole(role) {
                const vm = this;
                axios.post(this.route('api.users.assign-role',this.form.slug),{role: role}).then(res => {
                    this.$inertia.reload({preserveState: true});
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
