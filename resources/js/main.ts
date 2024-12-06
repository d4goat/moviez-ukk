import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from "./router";
import ElementPlus from "element-plus";
import 'element-plus/theme-chalk/dark/css-vars.css'
import './styles/dark/css-vars.css'
import 'element-plus/dist/index.css'
import App from './App.vue';
import i18n from "@/core/plugins/i18n";
import Inputmask from "inputmask";
import PrimeVue from 'primevue/config'
import { definePreset } from '@primevue/themes';
import Aura from '@primevue/themes/aura';

//imports for app initialization
import ApiService from './core/services/ApiService';
import { initApexCharts } from "@/core/plugins/apexcharts";
import { initInlineSvg } from "@/core/plugins/inline-svg";
import { initVeeValidate } from "@/core/plugins/vee-validate";
import $ from "jquery";

import  vueDebounce  from "vue-debounce";
import { VueQueryPlugin, QueryClient } from "@tanstack/vue-query";
import Vue3Toastify, { type ToastContainerOptions } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import '@fortawesome/fontawesome-free/css/all.css'
import 'aos/dist/aos.css'

import FileUpload from '@/components/FIleUpload.vue';
import Select2 from '@/components/Select2.vue';
import Paginate from '@/components/Paginate.vue';
import DatePicker from '@/components/DatePicker.vue';

// import "@/core/plugins/prismjs";
const app = createApp(App);

const customPreset = definePreset(Aura, {
    semantic: {
        primary: {
            50: '{sky.50}',
            100: '{sky.100}',
            200: '{sky.200}',
            300: '{sky.300}',
            400: '{sky.400}',
            500: '{sky.500}',
            600: '{sky.600}',
            700: '{sky.700}',
            800: '{sky.800}',
            900: '{sky.900}',
            950: '{sky.950}'
        }
    },
    components: {
        inputtext: {
            background: "#232323"
        }
    }
})

app.use(createPinia());
app.use(router);
app.use(ElementPlus);
app.use(PrimeVue, {
    theme: {
        preset: customPreset
    }
})

app.component("file-upload", FileUpload);
app.component("select2", Select2);
app.component("paginate", Paginate);
app.component("date-picker", DatePicker);

app.use(vueDebounce, {
    lock: true,
});
app.directive("mask", (el, binding) => {
    Inputmask(binding.value).mask(el);
});

const queryClient = new QueryClient({
    defaultOptions: {
        queries: {
            refetchOnWindowFocus: false,
            refetchOnMount: false,
            retry: false,
            staleTime: 0,
            networkMode: "always",
            onError: (err: any) => {
                if (err.response) {
                    if (err.response.status === 401) {
                        window.location.href = "/auth/sign-in";
                    }
                }
            },
        },
        mutations: {
            networkMode: "always",
            onError: (err: any) => {
                if (err.response) {
                    if (err.response.status === 401) {
                        window.location.href = "/auth/sign-in";
                    }
                }
            },
        },
    },
});

app.use(VueQueryPlugin, {
    queryClient,
});

app.use(Vue3Toastify, {
    newestOnTop: true,
    pauseOnFocusLoss: false,
    pauseOnHover: false,
} as ToastContainerOptions);


import { Form as VForm, Field, ErrorMessage } from "vee-validate";
app.component("VForm", VForm);
app.component("Field", Field);
app.component("ErrorMessage", ErrorMessage);

ApiService.init(app);
initApexCharts(app);
initInlineSvg(app);
initVeeValidate();

app.use(i18n);

app.mount("#app");

let cssRule =
    "display:block;width:200px;border-radius: 3px 0 0 3px;padding:3px 15px;background:#108bc3;color:#FFF;font-size: 30px;font-family:Arial, Helvetica, sans-seriffont-weight: bold;";
let cssRule2 =
    "display:block;border-radius: 0 3px 3px 0;padding:3px 15px;background:#fff;color:#666;font-size: 30px;font-family:Arial, Helvetica, sans-serif;";
console.log(
    "%cMatix Cineplex" + "%cMovie Ticket Booking",
    cssRule,
    cssRule2
);