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
                <form @submit.prevent="updateModel">
                                     <div class=" sm:col-span-4">
            <jet-label for="name" value="Name" />
            <jet-input class="w-full" type="text" id="name" name="name" v-model="form.name"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.name}"
            ></jet-input>
            <jet-input-error :message="form.errors.name" class="mt-2" />
        </div>
                                     <div class=" sm:col-span-4">
            <jet-label for="guard_name" value="Guard Name" />
            <jet-input class="w-full" type="text" id="guard_name" name="guard_name" v-model="form.guard_name"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.guard_name}"
            ></jet-input>
            <jet-input-error :message="form.errors.guard_name" class="mt-2" />
        </div>
                                     <div class=" sm:col-span-4">
            <jet-label for="title" value="Title" />
            <jet-input class="w-full" type="text" id="title" name="title" v-model="form.title"
                       :class="{'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100': form.errors.title}"
            ></jet-input>
            <jet-input-error :message="form.errors.title" class="mt-2" />
        </div>
                                                
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
    name: "EditRolesForm",
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
