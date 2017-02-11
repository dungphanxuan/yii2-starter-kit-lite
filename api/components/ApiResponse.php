<?php
namespace api\components;

use Yii;
use yii\web\Response;

class ApiResponse extends \yii\web\Response
{
    public $statusResponseCode;
    public $statusResponseMessage;
    public $statusResponseExtra;
    public $statusText;
    public $is_html = 1;
    public $is_json = 0;

    /**
     * Set response code and extra from code.
     *
     * Response extra will be filled based on $extraData value
     * If $extraData is null, response extra will be value from ApiResponseCode::responseExtraFromCode($code)
     * If $extraData is string, response extra will be filled with this value
     */
    public function fillStatusResponse($code, $extraData = null)
    {
        $responseExtra = ApiResponseCode::responseExtraFromCode($code);
        $responseMessage = ApiResponseCode::responseMessageFromCode($code);

        if ($extraData == null) {
            $statusResponseExtra = $responseExtra;
        } else {
            $statusResponseExtra = $extraData;
        }

        $this->statusResponseCode = $code;
        $this->statusResponseMessage = $responseMessage;
        $this->statusResponseExtra = $statusResponseExtra;
    }

    /**
     * Override send() method.
     *
     * $this->data member contains data released to client.
     */
    public function send()
    {
        $responseMessage = ApiResponseCode::responseMessageFromCode($this->statusResponseCode);

        if (!$this->is_html || $this->is_json || $this->isClientError) {
            if ($this->isClientError) {
                $dataOut = $this->data;

                if ($this->statusCode == 401) {   // Not authorized
                    $dataOut = null;
                    $this->fillStatusResponse(ApiResponseCode::ERR_LOGIN_REQUIRED);
                } else if ($this->statusCode == 403) {  // Forbidden
                    $dataOut = null;
                    $this->fillStatusResponse(ApiResponseCode::ERR_FORBIDDEN);
                } else if ($this->statusCode == 404) {  // Non found
                    $dataOut = null;
                    $this->fillStatusResponse(ApiResponseCode::ERR_METHOD_NOT_FOUND);
                } else if ($this->statusCode == 422) {  // Required field
                    $dataOut = null;
                    $this->fillStatusResponse(ApiResponseCode::ERR_UNPROCCESSABLE_ENTITY);
                } else if ($this->statusCode == 405) {  // Non Allow
                    $dataOut = null;
                    $this->fillStatusResponse(ApiResponseCode::ERR_METHOD_NOT_ALLOW);
                } else if ($this->statusCode == 500) {  // Non Allow
                    $dataOut = null;
                    $this->fillStatusResponse(ApiResponseCode::ERR_METHOD_NOT_ALLOW);
                }

                $errorMessage = !empty($this->statusText) ? $this->statusText : $this->statusResponseExtra;
                $exception = Yii::$app->errorHandler->exception;
                if ($exception !== null) {
                    $errorMessage = $exception->getMessage();
                }

                $this->data = [
                    'status' => 0,
                    'code' => $this->statusResponseCode,
                    'message' => $errorMessage
                ];
            } else {
                $resData = [];
                if (!empty($this->data)) {
                    $resData ['data'] = $this->data;
                }
                $resData1 = [
                    'status' => 1,
                    'code' => $this->statusResponseCode,
                    'message' => !empty($this->statusText) ? $this->statusText : $this->statusResponseExtra,
                ];

                $this->data = array_merge($resData1, $resData);
            }
        } else {
            if ($this->isClientError) {
                $this->format = Response::FORMAT_JSON;
            } else {
                $this->format = Response::FORMAT_HTML;
            }
        }

        parent::send();
    }

    public function init()
    {
        parent::init();

        $this->statusResponseCode = ApiResponseCode::ERR_OK;
    }


}