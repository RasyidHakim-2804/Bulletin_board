<?php

namespace App\Http\Validator;

use Core\Validation\RequestValidator as BaseValidator;

class RequestValidator extends BaseValidator
{

    public function __construct(array $requests)
    {
        parent::__construct($requests, $this->rules());
    }

    /**
     * function ini harus di overide
     */
    protected function rules(): array 
    {
        return [];
    }
}
