<?php

namespace App\Exceptions\Clients;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class ClientExistsException extends AppException
{
    public function __construct(string $message = '客户软件已存在')
    {
        parent::__construct($message, ExceptionCode::CLIENT_EXISTS);
    }
}
