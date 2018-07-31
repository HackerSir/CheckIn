require('./bootstrap');
require('./bootstrap-echo');

window.Echo.private('student.' + window.Laravel.student)
    .listen('CheckInSuccess', (e) => {
        console.log(e);
    });
