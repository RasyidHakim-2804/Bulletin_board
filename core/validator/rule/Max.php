<?php
namespace Core\Validator\Rule;

class Max implements RulerInterface
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

    public function getErrorMessage(string $nameVariable)
    {
        return "{$nameVariable} is bigger than {$this->max}";
    }
}