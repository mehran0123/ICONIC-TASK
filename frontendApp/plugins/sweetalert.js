// plugins/sweetalert.js
import { createApp } from 'vue';
import Swal from 'sweetalert2';

const plugin = {
    install(app) {
        app.config.globalProperties.$swal = Swal; // Make $swal globally accessible
    }
};

export default plugin;