<?php

return [
    'checkout' => [
        // class of your domain object
        'class' => App\Models\Checkout::class,

        // name of the graph (default is "default")
        'graph' => 'checkout',

        // property of your object holding the actual state (default is "state")
        'property_path' => 'status',

        'metadata' => [
            'title' => 'Checkout',
        ],

        // list of all possible states
        'states' => [
            'new',
            'accepted',
            'processing',
            'paid',
            'pending',
            'denied',
            'cancelled',
            'disabled'
        ],

        // list of all possible transitions
        'transitions' => [
            'accept' => [
                'from' => ['new', 'denied'],
                'to' => 'accepted',
            ],
            'invite' => [
                'from' => ['new', 'denied', 'accepted', 'pending'],
                'to' => 'paid',
            ],
            'process' => [
                'from' => ['accepted'],
                'to' => 'processing',
            ],
            'pay' => [
                'from' => ['processing', 'pending'],
                'to' => 'paid',
            ],
            'hang' => [
                'from' => ['processing'],
                'to' => 'pending',
            ],
            'disable' => [
                'from' => ['processing'],
                'to' => 'disabled',
            ],
            'deny' => [
                'from' => ['new'],
                'to' => 'denied',
            ],
            'cancel' => [
                'from' => ['new', 'accepted', 'paid', 'pending'],
                'to' => 'cancelled',
            ],
        ],

        // list of all callbacks
        'callbacks' => [
            // will be called before applying a transition
            'before' => [
                'before_accept' => [
                    'on' => 'accept',
                    'do' => [App\Actions\AcceptCheckoutAction::class, 'before'],
                    'args' => ['object', 'event'],
                ],
                'before_cancel' => [
                    'on' => 'cancel',
                    'do' => [App\Actions\CancelCheckoutAction::class, 'before'],
                    'args' => ['object', 'event'],
                ],
                'before_deny' => [
                    'on' => 'deny',
                    'do' => [App\Actions\DenyCheckoutAction::class, 'before'],
                    'args' => ['object', 'event'],
                ],
                'before_invite' => [
                    'on' => 'invite',
                    'do' => [App\Actions\InviteCheckoutAction::class, 'before'],
                    'args' => ['object', 'event'],
                ],
                'before_pay' => [
                    'on' => 'pay',
                    'do' => [App\Actions\PayCheckoutAction::class, 'before'],
                    'args' => ['object', 'event'],
                ],
                'before_hang' => [
                    'on' => 'hang',
                    'do' => [App\Actions\HangCheckoutAction::class, 'before'],
                    'args' => ['object', 'event'],
                ],
            ],

            // will be called after applying a transition
            'after' => [
                'after_accept' => [
                    'on' => 'accept',
                    'do' => [App\Actions\AcceptCheckoutAction::class, 'after'],
                    'args' => ['object', 'event'],
                ],
                'after_cancel' => [
                    'on' => 'cancel',
                    'do' => [App\Actions\CancelCheckoutAction::class, 'after'],
                    'args' => ['object', 'event'],
                ],
                'after_deny' => [
                    'on' => 'deny',
                    'do' => [App\Actions\DenyCheckoutAction::class, 'after'],
                    'args' => ['object', 'event'],
                ],
                'after_invite' => [
                    'on' => 'invite',
                    'do' => [App\Actions\InviteCheckoutAction::class, 'after'],
                    'args' => ['object', 'event'],
                ],
                'after_pay' => [
                    'on' => 'pay',
                    'do' => [App\Actions\PayCheckoutAction::class, 'after'],
                    'args' => ['object', 'event'],
                ],
                'after_hang' => [
                    'on' => 'hang',
                    'do' => [App\Actions\HangCheckoutAction::class, 'after'],
                    'args' => ['object', 'event'],
                ],
                'history' => [
                    'do' => 'StateHistoryManager@storeHistory'
                ]
            ],
        ],
    ],
];
