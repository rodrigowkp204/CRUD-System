import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import VMaks from 'v-mask'; // Importa v-mask
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

const app = createApp(App);
app.use(router);
app.directive('mask', VMaks.VueMaskDirective);
app.mount('#app');
app.use(VueToast);