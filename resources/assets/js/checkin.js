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
            confirmMessage = `於「${data.club_name}」打卡成功\n是否願意留下回饋資料？`;
            confirmCallback = function () {
                window.location.href = data.feedback_url;
            };
            $confirmModal.modal('show');

            return;
        }

        // alert("於「" + data.club_name + "」打卡成功");
        alertMessage = `於「${data.club_name}」打卡成功`;
        $alertModal.modal('show');
    });

let $alertModal, $confirmModal;
let alertMessage = '';
let confirmMessage = '';
let confirmCallback = undefined;

$(function () {
    $alertModal = $('#alertModal');
    $confirmModal = $('#confirmModal');

    $alertModal.on('show.bs.modal', function (event) {
        let modal = $(this);
        modal.find('#alertMessage').text(alertMessage);
    });

    $confirmModal.on('show.bs.modal', function (event) {
        let modal = $(this);
        modal.find('#confirmMessage').html(confirmMessage.replace("\n", '<br/>'));
        modal.find('#confirmButton').on('click', function () {
            if (confirmCallback !== undefined) {
                confirmCallback();
            }
        })
    });
});
