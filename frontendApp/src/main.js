import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import CKEditor from '@ckeditor/ckeditor5-vue';
import SweetAlertPlugin from '../plugins/sweetalert';


const app = createApp(App)
app.use(router)
app.use(CKEditor);
app.use(SweetAlertPlugin);
app.mount('#app')