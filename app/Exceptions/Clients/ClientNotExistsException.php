<?php

namespace App\Exceptions\Clients;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class ClientNotExistsException extends AppException
{
    public function __construct(string $message = '客户软件不存在')
    {
        parent::__construct($message, ExceptionCode::CLIENT_NOT_EXISTS);
    }
}
