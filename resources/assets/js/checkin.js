require('./vue');

import Echo from "laravel-echo"

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: process.env.MIX_ECHO_HOST
});

window.Echo.private('student.' + window.Laravel.student)
    .listen('CheckInSuccess', (e) => {
        console.log(e);
    });
