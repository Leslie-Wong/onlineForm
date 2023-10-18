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
            <jet-input type="password" id="password" name="password" v-model="form.password"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.password}"
            ></jet-input>
            <jet-input-error :message="form.errors.password" class="mt-2" />
        </div>
        <div class=" sm:col-span-4">
            <jet-label for="password_confirmation" value="Repeat Password" />
            <jet-input type="password" id="password_confirmation" name="password_confirmation" v-model="form.password_confirmation"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.password_confirmation}"
            ></jet-input>
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
            <jet-label for="assigned_roles" :value="__('Assign Roles')" />
            <infinite-select :per-page="15"
                             :api-url="route('api.roles.index')"
                             v-model="form.assigned_roles"
                             item-title="name"
                             :class="{'': form.errors.assigned_roles}"
                             return-object
                             variant="solo"
                             multiple
            ></infinite-select>
            <jet-input-error :message="form.errors.assigned_roles" class="mt-2" />
        </div>

        <div class="mt-2 text-right">
            <inertia-button type="submit" class="font-semibold bg-success disabled:opacity-25" :disabled="form.processing">{{__("Submit")}}</inertia-button>
        </div>
    </form>
</template>

<script>
    import JetInput from "@/Jetstream/Input.vue";
    import JetinTextarea from "@/JetinComponents/JetinTextarea.vue";
    import InfiniteSelect from '@/JetinComponents/InfiniteSelect.vue';
    import LesMultiSelect from '@/LesComponents/LesMultiSelect.vue';
    import JetLabel from "@/Jetstream/Label.vue";
    import InertiaButton from "@/JetinComponents/InertiaButton.vue";
    import JetInputError from "@/Jetstream/InputError.vue"
    import {useForm} from "@inertiajs/vue3";
    export default {
        name: "CreateAdminsForm",
        components: {
            InertiaButton,
            JetInputError,
            JetLabel,
                         JetInput,                         JetinTextarea,             InfiniteSelect,            LesMultiSelect,        },
        data() {
            return {
                form: useForm({
                    name: null,
                    email: null,
                    email_verified_at: null,
                    password: null,
                    lang: null,
                    two_factor_secret: null,
                    two_factor_recovery_codes: null,
                    two_factor_confirmed_at: null,
                    current_team_id: null,
                    profile_photo_path: null,
                                        password_confirmation: null,
                    assigned_roles: null,
                    "assigned_roles": null,
                    
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
            async storeModel() {
                this.form.post(this.route('admin.admins.store'),{
                    onSuccess: res => {
                        if (this.flash.success) {
                            this.$emit("success",this.__(this.flash.success));
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
            }
        }
    }
</script>

<style scoped>

</style>
