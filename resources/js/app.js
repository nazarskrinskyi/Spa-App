import { createApp } from 'vue';
import App from './App.vue';
import axios from 'axios';
import router from './router';
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import './bootstrap';
import "primevue/resources/themes/lara-light-blue/theme.css";
import Toast from 'primevue/toast';
import FileUpload from 'primevue/fileupload';
import Paginate from "vuejs-paginate-next";
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const app = createApp(App)

app.use(router)
app.use(PrimeVue)
app.use(ToastService)
app.use(Paginate)
app.component('QuillEditor', QuillEditor)
app.config.globalProperties.axios = axios
app.component('Toast', Toast);
app.component('FileUpload', FileUpload);

app.mount('#app')
