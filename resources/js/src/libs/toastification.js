import { createApp } from 'vue';
import Toast from 'vue-toastification'

import 'vue-toastification/dist/index.css'

createApp().use(Toast, {
  hideProgressBar: true,
  closeOnClick: false,
  closeButton: false,
  icon: false,
  timeout: 3000,
  transition: 'Vue-Toastification__fade',
})
