<?php

namespace App\Exceptions\Products;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class ProductCategoryNotExistsException extends AppException
{
    public function __construct(string $message = '该产品类别不存在')
    {
        parent::__construct($message, ExceptionCode::PRODUCT_CATEGORY_NOT_EXISTS);
    }
}
