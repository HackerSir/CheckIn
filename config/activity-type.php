<?php

return [
    /*
     * 各 model 對應的顯示路由
     */
    'route' => [
        \App\User::class     => 'user.show',
        \App\Club::class     => 'clubs.show',
        \App\TeaParty::class => 'tea-party.show',
    ],
];
