import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from "./router";
import ElementPlus from "element-plus";
import App from './App.vue';
import i18n from "@/core/plugins/i18n";
import Inputmask from "inputmask";

//imports for app initialization
import { initApexCharts } from "@/core/plugins/apexcharts";
import { initInlineSvg } from "@/core/plugins/inline-svg";
import { initVeeValidate } from "@/core/plugins/vee-validate";
import $ from "jquery";

import  vueDebounce  from "vue-debounce";
import { VueQueryPlugin, QueryClient } from "@tanstack/vue-query";
import Vue3Toastify, { type ToastContainerOptions } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import '@fortawesome/fontawesome-free/css/all.css'

import FileUpload from '@/components/FIleUpload.vue';
import Select2 from '@/components/Select2.vue';
import Paginate from '@/components/Paginate.vue';
import DatePicker from '@/components/DatePicker.vue';

// import "@/core/plugins/prismjs";
const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(ElementPlus);

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

initApexCharts(app);
initInlineSvg(app);
initVeeValidate();

app.use(i18n);

app.mount("#app");