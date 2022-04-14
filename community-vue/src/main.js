import Vue from 'vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import './common/css/flex.css'
import './common/css/layout.css'
import common from "./common/js/common";
import qs from 'qs';
import VueCookies from 'vue-cookies'
//ciikies
Vue.use(VueCookies)
//element-ui
Vue.use(ElementUI);
Vue.config.productionTip = false
Vue.prototype.$qs = qs;
Vue.prototype.common = common
new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
