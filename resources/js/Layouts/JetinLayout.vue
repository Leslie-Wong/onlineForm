<template>
    <div class="bg-gray-200">
        <Head :title="title" />
        <slot name="sidebar">
            <sidebar-component
                :menu="sidebarMenu"
                class="z-40"
                v-if="withSidebar && !fullScreenBody"
            ></sidebar-component>
        </slot>
        <div
            class="relative flex flex-col min-h-screen"
            :class="{ 'md:ml-64': withSidebar }"
        >
            <navbar-component class="gap-x-2" v-if="!fullScreenBody">
                <template v-slot:navbar-button>
                    <slot name="navbar-button"></slot>
                </template>
                <slot name="navbar-menu">
                    <jet-nav-link
                        :class="`text-secondary font-bold hover:text-secondary-400`"
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                    >
                        {{__("Frontend")}}
                    </jet-nav-link>
                </slot>
            </navbar-component>
            <!-- Header -->
            <div class="page-header">
                <jetin-notifications />

                <div
                    v-if="!fullScreenBody"
                    class="relative max-w-full pb-24 bg-primary"
                >

                </div>
                <div
                    class="flex flex-col justify-between flex-1 w-full px-1 mx-auto bg-gray-200  lg:px-10"
                    :class="{
                        '-mt-24': !fullScreenBody,
                        'pt-4 bg-gray-500': fullScreenBody,
                    }"
                >
                    <div class="relative flex-auto">
                        <slot />
                    </div>
                    <footer class="flex-initial py-4">
                        <div class="container px-1 mx-auto md:px-4">
                            <hr class="mb-4 border-gray-300 border-b-1" />
                            <div
                                class="flex flex-wrap items-center justify-center  md:justify-between"
                            >
                                <div class="w-full px-1 md:px-4">
                                    <div
                                        class="py-1 text-sm font-semibold text-gray-600 "
                                    >
                                        Copyright © {{ date }}
                                        <a
                                            href="https://colors.com.hk"
                                            class="py-1 text-sm font-semibold text-gray-600  hover:text-gray-800"
                                        >
                                            Colors Link LTD
                                        </a>
                                    </div>
                                </div>
                                <div class="w-full px-4 md:w-8/12">
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { Head } from '@inertiajs/vue3';
import NavbarComponent from "@/Layouts/Jetin/Navbar.vue";
import SidebarComponent from "@/Layouts/Jetin/Sidebar.vue";
import JetinNotifications from "@/JetinComponents/JetinNotifications.vue";
import JetNavLink from "@/Jetstream/NavLink.vue";
import InertiaButton from "@/JetinComponents/InertiaButton.vue";
import ApplicationMark from "@/Jetstream/ApplicationMark.vue";
import menu from "@/Layouts/Jetin/Menu.json";

import { defineComponent } from "vue";
export default defineComponent({
    name: "JetinLayout",
    components: {
        ApplicationMark,
        InertiaButton,
        JetinNotifications,
        NavbarComponent,
        SidebarComponent,
        JetNavLink,
        Head
    },
    props: {
        withSidebar: {
            default: true,
        },
        fullScreenBody: {
            default: false,
        },
        title: String,
    },
    data() {
        return {
            date: new Date().getFullYear(),
            minSidebar: false,
            sidebarMenu: menu,
        };
    },
    mounted() {
        this.minSidebar = !this.withSidebar;
        console.log("new page! Setting body overflow to auto");
        document.body.style.overflow = "auto";

        addEventListener("scroll", (event) => {
            if(window.innerWidth < 768 && document.documentElement.scrollTop > 70){
                const nav = document.querySelector('#app > div > div > nav');

                if(!nav.classList.contains('mobile-nav-fixed')){
                    nav.classList.add("mobile-nav-fixed");
                }
            }else if(window.innerWidth < 768 && document.documentElement.scrollTop < 70){
                const nav = document.querySelector('#app > div > div > nav');

                if(nav.classList.contains('mobile-nav-fixed')){
                    nav.classList.remove("mobile-nav-fixed");
                }
            }
        });
    },
    methods: {
        toggleSidebarMin() {
            this.minSidebar = !this.minSidebar;
            localStorage.setItem("minSidebar", this.minSidebar);
        },
    },
});
</script>
<style>
#app > div > div > nav > div.pr-4.mx-auto.sm\:pr-6.lg\:pr-8 > div > div.w-full.flex.items-center.sm\:ml-6 > div.w-full > h3 > span{
    display: block;
    max-width: 60vw;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.mobile-nav-fixed{
    position: fixed;
}

.page-header{
    display: flex;
    flex-direction: column;
    flex: 1;
}

@media only screen and (min-width: 768px) {
    .navbar{
        position: fixed;
        width: calc(100% - 16rem);
    }
    .navbar > div{
        background-image: linear-gradient( rgba(229, 231, 235, 1), rgba(229, 231, 235, 1),rgba(229, 231, 235, 1),rgba(229, 231, 235, 1),rgba(229, 231, 235, 1),rgba(229, 231, 235, 1),rgba(229, 231, 235, 1),rgba(229, 231, 235,0.6),rgba(229, 231, 235, 0.3),rgb(229, 231, 235, 0));
    }
    .page-header{
        margin-top: 70px;
    }
}


@media only screen and (max-width: 768px) {
    .navbar > div{
        background-image: linear-gradient( rgba(229, 231, 235, 1), rgba(229, 231, 235, 1),rgba(229, 231, 235, 1),rgba(229, 231, 235, 1),rgba(229, 231, 235, 1),rgba(229, 231, 235, 1),rgba(229, 231, 235, 1),rgba(229, 231, 235,0.6),rgba(229, 231, 235, 0.3),rgb(229, 231, 235, 0));
    }
    .page-header{
        margin-top: 70px;
    }
}

</style>
