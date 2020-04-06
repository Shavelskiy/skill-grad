import Vue from 'vue';
import App from './App';
import './index.scss';

Vue.config.productionTip = false;

if (document.getElementById('app') !== null) {
  new Vue({
    render: h => h(App),
  }).$mount('#app');
}
