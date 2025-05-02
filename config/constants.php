<?php
return [
        'regex' => [
                    'email' => "/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/",
                    'password' => "/^[A-Za-z0-9\d]{6,}$/i",
                    ],
        'sendgrid_template_ids' => [
            'FORGOT_PASSWORD' => 'd-4983699d7e2b4d23b6af0f5f268b91b2',
            'APPLICATION_REQUEST' => 'd-7f2f23235bee45579c6606890fc5a847',
            'SERVICE_REQUEST' => 'd-1098868d39b74c38aed88e37222aeeff',
            'WARRANTY_REQUEST' => 'd-7acefd052e6a4d19b2ca24dd42a7603c',
            'APPROVAL_PENDING' => 'd-7d568eece46f424c902d85b537371026',
            'USER_REGISTRATION' => 'd-602b7a95752941a58446c48bafbb7211'
        ],
        'TIME_ZONE' => 'Asia/Tokyo',
        'TOKEN_EXPIRY' => env('OUATH_TOKEN_EXPIRE_DAYS'),
    ];
