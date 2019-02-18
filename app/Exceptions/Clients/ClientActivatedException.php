<?php

namespace App\Exceptions\Clients;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class ClientActivatedException extends AppException
{
    public function __construct(string $message = '客户软件已激活')
    {
        parent::__construct($message, ExceptionCode::CLIENT_ACTIVED);
    }
}
