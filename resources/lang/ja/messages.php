<?php

return [
        /*
        |--------------------------------------------------------------------------
        |  Language Lines
        |--------------------------------------------------------------------------
        |
        | The following language lines are used during api response for various
        | messages that we need to display to the user. You are free to modify
        | these language lines according to your application's requirements.
        |
        */

        /* Response codes */
        'HTTP_BAD_GATEWAY' => 'SQLエラーが発生しました',
        'HTTP_FORBIDDEN' => '許可されていません',
        'HTTP_UNAUTHORIZED' => '許可されていません',
        'HTTP_INTERNAL_SERVER_ERROR' => '何かが間違っていました。もう一度やり直してください',

        /* Auth */
        'LOGIN_SUCCESS' => 'ログイン成功',
        'REGISTRATION_SUCCESS' => '登録が成功',
        'FORGOT_SUCCESS' => 'メールへのパスワード送信が成功です。',
        'RESET_SUCCESS' => 'パスワードが正常にリセットされました。',
        'TOKEN_EXPIRED' => 'トークンの有効期限が切れました。',
        'INVALID_CREDENTIALS' => 'メールIDまたはパスワードが無効です。',
        'INVALID_EMAIL' => 'メールIDが無効です。',
        'INVALID_TOKEN' => 'トークンが無効です。',

        /* Records */
        'RECORD_LISTED' => '取得されました。',
        'RECORD_FETCHED' => 'レコードが正常にフェッチされました',
        'RECORD_STORED' => '保存されました。',
        'RECORD_UPDATED' => '正常に更新しました。',
        'RECORD_DELETED' => '削除しました。',
        'RECORD_EMPTY' => 'レコードがありません。',

        /* Others */
        'RELATIONSHIP_NOT_FOUND' => '関係ありません。',
        'HTTP_NOT_FOUND' => 'ページが見つかりません',
];
