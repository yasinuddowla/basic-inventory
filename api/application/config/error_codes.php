<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*Error Codes*/
define('ITEM_INSERT_FAILURE', [
    'status' => 200,
    'code' => 4207,
    'msg' => 'Item not created'
]);
define('ITEM_DELETE_FAILURE', [
    'status' => 200,
    'code' => 4208,
    'msg' => 'Item not deleted'
]);
define('ITEM_UPDATE_FAILURE', [
    'status' => 200,
    'code' => 4209,
    'msg' => 'Item update failed'
]);
define('ITEM_NOT_FOUND', [
    'status' => 200,
    'code' => 4210,
    'msg' => 'Item not found'
]);
define('USER_INSERT_FAILURE', [
    'status' => 400,
    'code' => 4211,
    'msg' => 'User registration failed'
]);
define('USER_UPDATE_FAILURE', [
    'status' => 400,
    'code' => 4212,
    'msg' => 'User information update failed'
]);
define('USER_NOT_FOUND', [
    'status' => 400,
    'code' => 4213,
    'msg' => 'User not found'
]);

define('UNAUTHORIZED', [
    'status' => 401,
    'code' => 4401,
    'msg' => 'Unauthorized'
]);
define('AUTHORIZATION_HEADER_NOT_FOUND', [
    'status' => 401,
    'code' => 4402,
    'msg' => 'Authorization header not found'
]);
define('FORBIDDEN', [
    'status' => 403,
    'code' => 4403,
    'msg' => 'Access forbidded'
]);
define('REQUEST_NOT_FOUND', [
    'status' => 404,
    'code' => 4404,
    'msg' => 'Request not found'
]);
define('REQUEST_METHOD_NOT_VALID', [
    'status' => 405,
    'code' => 4405,
    'msg' => 'Request method not valid'
]);
define('ACCESS_TOKEN_ERRORS', [
    'status' => 401,
    'code' => 4407,
    'msg' => 'Access token error'
]);
define('JWT_PROCESSING_ERROR', [
    'status' => 401,
    'code' => 4408,
    'msg' => 'JWT processing error'
]);
define('BAD_REQUEST', [
    'status' => 400,
    'code' => 4409,
    'msg' => 'Invalid request data'
]);
define('OK_BAD_REQUEST', [
    'status' => 200,
    'code' => 4410,
    'msg' => 'Invalid request data'
]);

define('SERVER_ERROR', [
    'status' => 500,
    'code' => 4500,
    'msg' => 'Internel Server Error'
]);
