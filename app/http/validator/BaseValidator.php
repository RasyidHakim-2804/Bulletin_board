<?php
namespace App\Http\Validator;

use Core\Validator\Validator;

abstract class BaseValidator
{
    private $validator;
    protected $rules;

    public function __construct(array $request)
    {
        $this->validator = new Validator($request);
        $this->validator->rules($this->rules());        
    }

    abstract public function rules():array;
    
    public function validate()
    {
        return $this->validator->validate();
    }

    public function getErrors()
    {
        return $this->validator->getErrors();
    }

    public function getValidRequest()
    {
        return $this->validator->getValidRequest();
    } 

}