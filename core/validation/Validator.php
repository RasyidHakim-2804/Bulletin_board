<?php

namespace Core\Validation;

use Core\Validation\Validator\ValidatorInterface;

class Validator
{
    protected $data;
    protected $rules = [];
    protected $errorMessages = null;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function addRule(ValidatorInterface $rule)
    {
        array_push($this->rules, $rule);
    }

    public function validate()
    {
        $error = [];
        foreach ($this->rules as $rule) {
            $result = $rule->validate($this->data);

            if (!$result) array_push($error, $rule->getErrorMessage());
        }

        $this->rules = [];

        if (!empty($error)) {
            $this->errorMessages = $error;
            return false;
        }

        return $this->data;
    }

    public function getError()
    {
        $error = $this->errorMessages;
        $this->errorMessages = null;
        
        return $error;
    }
}
