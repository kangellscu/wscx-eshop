<?php

namespace App\Exceptions\Clients;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class ClientNotActivateException extends AppException
{
    public function __construct(string $message = '客户软件未激活')
    {
        parent::__construct($message, ExceptionCode::CLIENT_NOT_ACTIVATE);
    }
}
