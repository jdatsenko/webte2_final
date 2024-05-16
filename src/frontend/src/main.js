import { createApp } from "vue";
import "./style.css";
import { router } from "./router";
import App from "./App.vue";
import PrimeVue from "primevue/config";
import { i18n } from "./i18n";
import { createPinia } from "pinia";

import ToastService from "primevue/toastservice";
import ConfirmationService from "primevue/confirmationservice";
import DialogService from "primevue/dialogservice";

import Tooltip from "primevue/tooltip";

const app = createApp(App);
app.directive("tooltip", Tooltip);
app.use(createPinia());
app.use(PrimeVue);
app.use(router);
app.use(DialogService);
app.use(ConfirmationService);
app.use(i18n);
app.use(ToastService);
app.mount("#app");
