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


const app = createApp(App)

app.use(router)
app.use(PrimeVue)
app.use(ToastService)

app.config.globalProperties.axios = axios
app.component('Toast', Toast);
app.component('FileUpload', FileUpload);

app.mount('#app')
