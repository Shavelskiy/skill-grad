import Vue from 'vue';
import App from './App';

Vue.config.productionTip = false;

if (document.getElementById('app') !== null) {
  new Vue({
    render: h => h(App),
  }).$mount('#app');
}
