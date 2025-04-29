import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";


createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
    return pages[`./Pages/${name}.vue`];
  },


  setup({ el, App, props, plugin }) {
    const vueApp = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(Toast, {
        position: 'top-right',
        timeout: 3000,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        hideProgressBar: false,
        closeButton: "button",
        icon: true,
        rtl: false
      })
      vueApp.config.errorHandler = (err) => {  //This way, even if small mistakes happen, you see errors in the browser console, instead of blank page!
        console.error('Vue Error:', err);
      };
      vueApp.mount(el);
  },
});

// ✅ ADD THIS
import { InertiaProgress } from '@inertiajs/progress'

InertiaProgress.init({
  delay: 250,
  color: '#4F46E5',
  includeCSS: true,
  showSpinner: true,
});
