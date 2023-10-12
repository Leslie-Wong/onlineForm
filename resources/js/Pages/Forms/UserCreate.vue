<template>
    <Head :title="title" />
    <jetin-notifications />
    <div class="pr-4 mx-auto sm:pr-6 lg:pr-8">
        <div class="flex w-full justify-between h-16">
            <div class="w-full flex items-center sm:ml-6">
                <div class="w-full"></div>
                <language-selector />
                <div class="relative ml-3">
                    <jet-dropdown align="right" class="w-12" :width="48">
                        <template #trigger>
                            <button
                                v-if="
                                    $page.props.jetstream
                                        .managesProfilePhotos
                                "
                                class="flex text-sm transition duration-150 ease-in-out border-2 border-transparent rounded-full  focus:outline-none focus:border-gray-300"
                            >
                                <img
                                    class="object-cover w-10 h-10 rounded-full "
                                    :src="
                                        $page.props.auth.user.profile_photo_url
                                    "
                                    :alt="$page.props.auth.user.name"
                                />
                            </button>

                            <span v-else class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md  hover:text-gray-700 focus:outline-none"
                                >
                                    {{ $page.props.auth.user.name }}

                                    <svg
                                        class="ml-2 -mr-0.5 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>

                            <!-- Account Management -->
                            <div
                                class="block px-4 py-2 text-xs text-gray-400 "
                            >
                                {{ $page.props.auth.user.name }}
                            </div>

                            <jet-dropdown-link
                                :href="route('profile.show')"
                            >
                                {{__("Profile")}}
                            </jet-dropdown-link>

                            <jet-dropdown-link
                                :href="route('api-tokens.index')"
                                v-if="$page.props.jetstream.hasApiFeatures"
                            >
                            {{__("API Tokens")}}
                            </jet-dropdown-link>

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <responsive-nav-link
                                @click.native.prevent="logout"
                                target="_blank"
                                v-if="$page.props.auth.user.is_cas"
                                :href="route('cas.logout')"
                                >{{__("Logout")}}</responsive-nav-link
                            >
                            <form v-else @submit.prevent="logout">
                                <jet-dropdown-link as="button">
                                    {{__("Logout")}}
                                </jet-dropdown-link>
                            </form>
                        </template>
                    </jet-dropdown>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap px-4">
        <div class="flex-auto max-w-2xl p-4 mx-auto bg-white md:rounded-md md:shadow-md">
            <create-forms-form @success="onSuccess" @error="onError"/>
        </div>
    </div>
</template>

<script>
// import JetinLayout from "@/Layouts/JetinLayout.vue";
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";
import CreateFormsForm from "./UserCreateForm.vue";

import JetinNotifications from "@/JetinComponents/JetinNotifications.vue";
import DisplayMixin from "@/Mixins/DisplayMixin.js";
import LanguageSelector from "@/LesComponents/LanguageSelector.vue";
import { defineComponent } from "vue";

export default defineComponent({
    name: "PubCreateForms",
    components: {
        JetDropdown,
        JetDropdownLink,
        CreateFormsForm,
        LanguageSelector,
        JetinNotifications
    },
    data() {
        return {}
    },
    mixins: [DisplayMixin],
    mounted() {},
    computed: {
        flash() {
            return this.$page.props.flash || {}
        }
    },
    methods: {
        onSuccess(msg) {
            localStorage.setItem('notifyMessage', `{"status":"success", "msg":"${msg}"}`);
            // this.$inertia.visit(route('forms.finish'));
            this.displayNotification(this.__("success"),msg, "success");
        },
        onError(msg) {
            this.displayNotification(this.__("error"),msg, "error");
        },
        logout() {
            this.$inertia.post(route("logout"));
        },
    }
});
</script>

<style scoped>

</style>
