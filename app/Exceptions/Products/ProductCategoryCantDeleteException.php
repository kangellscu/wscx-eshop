<?php

namespace App\Exceptions\Products;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class ProductCategoryCantDeleteException extends AppException
{
    public function __construct(string $message = '该产品类别无法删除')
    {
        parent::__construct($message, ExceptionCode::PRODUCT_CATEGORY_CANT_DELETE);
    }
}
