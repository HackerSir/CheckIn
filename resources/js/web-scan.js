import Vue from 'vue';
import QrcodeStream from 'vue-qrcode-reader'
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.use(QrcodeStream);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('web-scan', require('./components/WebScan.vue').default);

const app = new Vue({
    el: '#vue-app'
});
