<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Student;
use App\User;

Broadcast::channel('student.{student}', function (User $user, Student $student) {
    return $user->id == $student->user_id;
});

Broadcast::channel('admin.test', function (User $user) {
    return $user->can('broadcast.manage');
});
