<?php
namespace Core\Validation\Validator;

class Max implements ValidatorInterface
{
    private $max;

    public function __construct($max)
    {
        $this->max = $max;
    }

    public function validate($value): bool
    {
        if(empty($value)) return true;

        if(is_string($value)) return strlen($value)<= $this->max;
        
        return $value <= $this->max;
    }

    public function getErrorMessage()
    {
        return "variable is bigger than {$this->max}";
    }
}