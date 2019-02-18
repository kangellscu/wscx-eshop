<?php

namespace App\Exceptions\Admins;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class AdminExistsException extends AppException
{
    public function __construct(string $message = '管理员已存在')
    {
        parent::__construct($message, ExceptionCode::ADMIN_EXISTS);
    }
}
