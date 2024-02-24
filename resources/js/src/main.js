import { createApp } from 'vue'
import App from './App.vue'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import 'bootstrap-icons/font/bootstrap-icons.css'
import axiosInstance from '@axios'
import CookiesPlugin from '@cookies'
import '@/libs/toastification'
import router from './router'



let app = createApp(App)
app.config.globalProperties.$http = axiosInstance;
app.use(CookiesPlugin)
app.use(router)
app.mount("#app")
