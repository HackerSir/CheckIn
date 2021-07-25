import Vue from 'vue';
import Vuex from 'vuex';
import VueHolder from 'vue-holderjs';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./bootstrap-echo-vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// VueMoment ($moment)
const moment = require('moment');
require('moment/locale/zh-tw');
Vue.use(require('vue-moment'), {
    moment
});
moment.locale('zh-tw');

// VueHolder
Vue.use(VueHolder);

// Vuex
Vue.use(Vuex);

// Component
Vue.component('club-card', require('./components/ClubCard.vue').default);
Vue.component('club-cards', require('./components/ClubCards.vue').default);
Vue.component('my-feedback-list', require('./components/MyFeedbackList.vue').default);
Vue.component('my-feedback', require('./components/MyFeedback.vue').default);
Vue.component('record-list', require('./components/RecordList').default);
Vue.component('favorite-club-button', require('./components/FavoriteClubButton.vue').default);

Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');

const app = new Vue({
    el: '#vue-app'
});
