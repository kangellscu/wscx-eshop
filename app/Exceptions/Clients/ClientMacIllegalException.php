<?php

namespace App\Exceptions\Clients;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class ClientMacIllegalException extends AppException
{
    public function __construct(string $message = 'MAC地址不合法')
    {
        parent::__construct($message, ExceptionCode::CLIENT_MAC_ILLEGAL);
    }
}
