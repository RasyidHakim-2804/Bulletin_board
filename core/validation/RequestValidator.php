<?php

namespace Core\Validation;

use Core\Validation\Validator\Required;
use Core\Validation\Validator\ValidatorInterface;

class RequestValidator
{
    protected $validator = [];
    protected $required = [];
    protected $requests;
    protected $error;

    public function __construct(array $requests, array $rules)
    {
        $this->requests = $requests;
        $this->makeValidators($rules);
    }

    protected function makeValidators(array $rulesRequest)
    {
        foreach ($rulesRequest as $name => $rules) {
            $validator = new Validator();

            /**
             * @var ValidatorInterface $rule -
             */
            foreach ($rules as $rule) {
               
                $validator->addRule($rule);

                if ($rule instanceof Required) $this->required[] = $name;
            }

            $this->validator[$name] = $validator;
        }
    }

    protected function setError($name, $validateError)
    {
        $error = [];

        foreach ($validateError as $errorMessage) {
            $error[] = "{$name} " . $errorMessage;
        }

        if (empty($this->error)) {
            $this->error = $error;
        } else {
            $this->error = array_merge($this->error, $error);
        }
    }

    protected function errorRequired($name)
    {
        $errorMessage = "no {$name} variable on request";

        if (empty($this->error)) {
            $this->error[] = $errorMessage;
        } else {
            $this->error[] = $errorMessage;
        }
    }

    public function validate()
    {
        $validRequest = [];

        foreach ($this->validator as $name => $validator) {
            /**
             * @var Validator $validator -
             */
            if (in_array($name, array_keys($this->requests))) {

                $validator->setData($this->requests[$name]);

                if (!$validator->validate()) {
                    $this->setError($name, $validator->getError());
                } else {
                    $validRequest[$name] = $this->requests[$name];
                }
            } else if (in_array($name, $this->required)) {

                $this->errorRequired($name);
            }
        }

        return empty($this->error) ? $validRequest : false;
    }

    public function getError()
    {
        return $this->error;
    }
}
