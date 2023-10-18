/*
|--------------------------------------------------------------------------
| Main entry point
|--------------------------------------------------------------------------
| Files in the "resources/scripts" directory are considered entrypoints
| by default.
|
| -> https://vitejs.dev
| -> https://github.com/innocenzi/laravel-vite
*/

// Import modules...
import "@/bootstrap";
import "@/laravel-echo-setup";
import 'dynamic-import-polyfill';
import "../css/app.css"
import "/node_modules/flag-icons/css/flag-icons.min.css";
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { InertiaProgress } from '@inertiajs/progress';
import Notifications from '@kyvg/vue3-notification'
import VueNumerals from "vue-numerals"
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime"
import advancedFormat from "dayjs/plugin/advancedFormat"
import translation from "../lang/translation"
import 'flatpickr/dist/flatpickr.css';
import { emitter } from "@/JetinComponents/eventHub.js";
import { Link } from "@inertiajs/vue3";

import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
    theme: {
        defaultTheme: 'light',
        themes: {
          light: {
            dark: false,
            colors: {
              primary: "rgb(229 231 235 / var(--tw-bg-opacity))",
              secondary: "#E53935"
            }
          },
        },
      },
    components,
    directives,
})



import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

dayjs.extend(relativeTime);
dayjs.extend(advancedFormat)

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const pages = import.meta.glob('/resources/js/Pages/**/*.vue');
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`/resources/js/Pages/${name}.vue`, import.meta.glob('/resources/js/Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(vuetify)
            .mixin({ methods: { route, dayjs } })
            .mixin(translation)
            .use(Notifications)
            .use(VueNumerals)
            .component('datepicker', () => import('vue-flatpickr-component'))
            .component("inertia-link", Link)
            .provide("$refreshDt", function (tableId) {
                emitter.emit('refresh-dt', { tableId: tableId });
            })
            .provide("$dayjs", dayjs)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#F59E0B' });
