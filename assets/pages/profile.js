import './../components/profile/scss/index.scss';

import Vue from 'vue';
import Router from 'vue-router'
import App from './../components/profile/App';
import {routes} from './../components/profile/routes/routes';

Vue.config.productionTip = false;

Vue.use(Router);

const router = new Router({
  mode: 'history',
  routes: routes
})

if (document.getElementById('profile-app') !== null) {
  new Vue({
    router,
    render: h => h(App),
  }).$mount('#profile-app');
}
