import { createApp } from 'vue'
import './style.css'
import { router } from './router'
import App from './App.vue'
import PrimeVue from 'primevue/config';

import ToastService from 'primevue/toastservice';


const app = createApp(App);
app.use(PrimeVue);
app.use(router);
app.use(ToastService);
app.mount('#app');
