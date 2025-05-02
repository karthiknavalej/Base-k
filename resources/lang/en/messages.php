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
        'HTTP_BAD_GATEWAY' => 'Sql Error Occured',
        'HTTP_FORBIDDEN' => 'Not authorized',
        'HTTP_UNAUTHORIZED' => 'Unauthorized.',
        'HTTP_INTERNAL_SERVER_ERROR' => 'Something went wrong',
        'HTTP_RECORD_NOT_FOUND' => 'Record not found',

        /* Auth */
        'LOGIN_SUCCESS' => 'Login successful',
        'REGISTRATION_SUCCESS' => 'Registration successful',
        'FORGOT_SUCCESS' => 'Password sent to email successful.',
        'RESET_SUCCESS' => 'Password reset successfully',
        'TOKEN_EXPIRED' => 'Token expired.',
        'INVALID_CREDENTIALS' => 'Invalid email id or password.',
        'INVALID_EMAIL' => 'Invalid email id.',
        'INVALID_TOKEN' => 'Invalid token.',

        /* Records */
        'RECORD_LISTED' => 'Record listed successfully.',
        'RECORD_FETCHED' => 'Record fetched successfully.',
        'RECORD_STORED' => 'Record stored successfully.',
        'RECORD_UPDATED' => 'Record updated successfully.',
        'RECORD_DELETED' => 'Record deleted successfully.',
        'RECORD_EMPTY' => 'Record\'s not found.',

        /* Others */
        'RELATIONSHIP_NOT_FOUND' => 'Relationship not found',
        'HTTP_NOT_FOUND' => 'Not found',
        'HTTP_UNAUTHENTICATED' => 'Unauthenticated',

        'DOWNLOAD_SUCCESS' => 'File downloaded successfully.',
        'DOWNLOAD_FAIL' => 'File download Failed.',

        'SUCCESS' => 'Successfully.',


];
