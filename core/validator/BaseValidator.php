<?php

namespace Core\Validator;

use Core\Error\ErrorMessage;
use Core\Validator\Rule\RulerInterface;

abstract class BaseValidator
{
    private $request = [];
    private $validRequest;
    private $errors  = [];

    public function __construct(array $request)
    {
        $this->request = $request;
    }

    abstract public function rules(): array;

    public function validate(): bool
    {
        $requestKey = array_keys($this->request);
        $validRequest    = [];

        foreach ($this->rules() as $field => $rules) {
            /**
             * memeriksa apakah field dari rule tersedia pada request
             */
            if (in_array($field, $requestKey)) {

                $this->validRequest[$field] = $this->request[$field];

                foreach ($rules as $rule) {

                    /**
                     * @var RulerInterface $rule -
                     */
                    $valid = $rule->validate($this->request[$field]);

                    if(!$valid) {
                        array_push($this->errors, $rule->getErrorMessage($field));
                    }

                }
            } else {
                array_push($this->errors, "{$field} tidak ada dalam request, mohon periksa lagi");
            }
        }

        return empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getValidRequest()
    {
        return $this->validRequest;
    } 
}
