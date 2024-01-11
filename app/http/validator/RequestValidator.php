<?php

namespace App\Http\Validator;

use Core\Validation\RequestValidator as BaseValidator;

abstract class RequestValidator
{
    protected $validator;

    public function __construct(array $requests)
    {
        $this->validator = new BaseValidator($requests, $this->rules());
    }

    abstract protected function rules(): array;

    public function validate()
    {
        return $this->validator->validate();
    }

    public function getError()
    {
        return $this->validator->getError();
    }
}
