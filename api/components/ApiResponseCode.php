<?php

namespace api\components;

class ApiResponseCode
{
    const ERR_OK = 200;
    const ERR_LOGIN_REQUIRED = 401;
    const ERR_FORBIDDEN = 403;
    const ERR_METHOD_NOT_FOUND = 404;
    const ERR_NOT_FOUND = 3;
    const ERR_NOT_SAVED = 4;
    const ERR_DUPLICATE = 5;
    const ERR_INPUT_DATA_FORMAT = 6;
    const ERR_UNPROCCESSABLE_ENTITY = 422;
    const ERR_METHOD_NOT_ALLOW = 405;
    const ERR_INTERNAL_SERVER_ERROR = 500;

    public static function responsesExtras()
    {
        return [
            ApiResponseCode::ERR_OK => '',
            ApiResponseCode::ERR_LOGIN_REQUIRED => 'Login required to use this interface',
            ApiResponseCode::ERR_FORBIDDEN => 'Forbidden',
            ApiResponseCode::ERR_METHOD_NOT_FOUND => 'Method not found',
            ApiResponseCode::ERR_NOT_FOUND => 'Record not found',
            ApiResponseCode::ERR_NOT_SAVED => 'Error in saving',
            ApiResponseCode::ERR_DUPLICATE => 'Duplicated record',
            ApiResponseCode::ERR_INPUT_DATA_FORMAT => 'Input data format incompatible',
            ApiResponseCode::ERR_UNPROCCESSABLE_ENTITY => 'Unprocessable Entity',
            ApiResponseCode::ERR_METHOD_NOT_ALLOW => 'Method Not Allow',
            ApiResponseCode::ERR_INTERNAL_SERVER_ERROR => 'Internal Server Error',
        ];
    }

    public static function responseExtraFromCode($rc)
    {
        $al = ApiResponseCode::responsesExtras();

        return (isset($al[$rc])) ? $al[$rc] : null;
    }

    public static function responseMessages()
    {
        return [
            ApiResponseCode::ERR_OK => 'OK',
            ApiResponseCode::ERR_LOGIN_REQUIRED => 'ERR_LOGIN_REQUIRED',
            ApiResponseCode::ERR_FORBIDDEN => 'ERR_FORBIDDEN',
            ApiResponseCode::ERR_METHOD_NOT_FOUND => 'ERR_METHOD_NOT_FOUND',
            ApiResponseCode::ERR_NOT_FOUND => 'ERR_NOT_FOUND',
            ApiResponseCode::ERR_NOT_SAVED => 'ERR_NOT_SAVED',
            ApiResponseCode::ERR_DUPLICATE => 'ERR_DUPLICATED',
            ApiResponseCode::ERR_INPUT_DATA_FORMAT => 'ERR_INPUT_DATA_FORMAT',
            ApiResponseCode::ERR_METHOD_NOT_ALLOW => 'ERR_METHOD_NOT_ALLOW',
            ApiResponseCode::ERR_UNPROCCESSABLE_ENTITY => 'ERR_UNPROCCESSABLE_ENTITY',
            ApiResponseCode::ERR_INTERNAL_SERVER_ERROR => 'ERR_INTERNAL_SERVER_ERROR',
        ];
    }

    public static function responseMessageFromCode($rc)
    {
        $al = ApiResponseCode::responseMessages();

        return (isset($al[$rc])) ? $al[$rc] : null;
    }
}