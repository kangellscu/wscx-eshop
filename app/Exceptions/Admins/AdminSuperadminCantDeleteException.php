<?php

namespace App\Exceptions\Admins;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class AdminSuperadminCantDeleteException extends AppException
{
    public function __construct(string $message = '超级管理员无法删除')
    {
        parent::__construct($message, ExceptionCode::ADMIN_SUPERADMIN_CANT_DELETE);
    }
}
