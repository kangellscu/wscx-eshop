<?php

namespace App\Exceptions\Admins;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class AdminPasswordIncorrectException extends AppException
{
    public function __construct(string $message = '密码错误')
    {
        parent::__construct($message, ExceptionCode::ADMIN_PASSWORD_INCORRECT);
    }
}
