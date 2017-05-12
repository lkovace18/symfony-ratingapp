import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRange from 'vue-for-range'
var VueCookie = require('vue-cookie');

Vue.use(VueAxios, axios)
Vue.use(VueRange);
Vue.use(VueCookie);

Vue.component('rating', require('./rating.vue'));

new Vue({
  el: '#rating-app',
})