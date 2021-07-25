import Vue from 'vue';

require('./bootstrap');
require('./bootstrap-echo');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('broadcast-test', require('./components/BroadcastTest.vue').default);

const app = new Vue({
    el: '#vue-app'
});
