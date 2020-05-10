<?php

/**
 * All config options:
 * https://getkirby.com/docs/reference/system/options
 */

return [
    'debug'  => true,
    'routes' => [
        [
            'pattern' => 'logout',
            'action'  => function () {

                if ($user = kirby()->user()) {
                    $user->logout();
                }

                go('login');
            }
        ]
    ]
];
