require('./bootstrap');
require('./bootstrap-echo');

window.Echo.private('student.' + window.Laravel.student)
    .listen('CheckInSuccess', (data) => {
        let createdAt = moment(data.created_at);
        if (moment().diff(createdAt, 'seconds') >= 60) {
            console.log('Skip "CheckInSuccess" broadcast:', data.club_name);
            return;
        }

        if (data.ask_for_feedback) {
            let redirectToFeedback = confirm("於「" + data.club_name + "」打卡成功\n是否願意留下回饋資料？");
            if (redirectToFeedback) {
                window.location.href = data.feedback_url;
            }
            return;
        }
        alert("於「" + data.club_name + "」打卡成功");
    });
