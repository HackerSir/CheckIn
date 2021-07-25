import Vue from 'vue';
import VueEcho from 'vue-echo';

window.io = require('socket.io-client');

Vue.use(VueEcho, {
    broadcaster: 'socket.io',
    host: process.env.MIX_ECHO_HOST
});
