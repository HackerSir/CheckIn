/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('club-card', require('./components/ClubCard.vue'));
Vue.component('club-cards', require('./components/ClubCards.vue'));
Vue.component('my-feedback-list', require('./components/MyFeedbackList.vue'));
Vue.component('my-feedback', require('./components/MyFeedback.vue'));
Vue.component('favorite-club-button', require('./components/FavoriteClubButton.vue'));

Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');

const app = new Vue({
    el: '#vue-app'
});
