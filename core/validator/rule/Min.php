<?php
namespace Core\Validator\Rule;

class Min implements RulerInterface
{
    private $min;

    public function __construct($min)
    {
        $this->min = $min;
    }

    public function validate($value): bool
    {
        if(empty($value)) return true;

        if(is_string($value)) return strlen($value) >= $this->min;

        return $value >= $this->min;
    }

    public function getErrorMessage( $nameVariable)
    {
        return "{$nameVariable} is less than {$this->min}";
    }
}