import 'bootstrap';
import Vue from 'vue';
import router from './routes.js';
import Stock from "highcharts/modules/stock";
import Highcharts from 'highcharts';
import HighchartsVue from 'highcharts-vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import store from './stores/store';

library.add(far, fab, fas);

Vue.component('font-awesome-icon', FontAwesomeIcon);
Stock(Highcharts);
Vue.use(HighchartsVue, {Highcharts});


const app = new Vue({
    router: router,
    store,
    el: "#app"
})
