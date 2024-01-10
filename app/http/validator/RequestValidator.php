<?php

namespace App\Http\Validator;

use Core\Validation\RequestValidator as BaseValidator;

abstract class RequestValidator extends BaseValidator
{

    public function __construct(array $requests)
    {
        parent::__construct($requests, $this->rules());
    }

    abstract protected function rules(): array;
}
