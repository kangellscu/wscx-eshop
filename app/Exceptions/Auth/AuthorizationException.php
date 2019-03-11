<?php

namespace App\Exceptions\Auth;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class AuthorizationException extends AppException
{
    public function __construct(string $message = '您没有权限操作')
    {
        parent::__construct($message, ExceptionCode::AUTHORIZATION);
    }
}
