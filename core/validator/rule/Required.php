<?php
namespace Core\Validator\Rule;

class Required implements RulerInterface
{
    private $required;

    public function __construct(bool $required)
    {
        $this->required = $required;
    }

    public function validate($value): bool
    {
        if($this->required) return !empty($value);

        return true;
    }

    public function getErrorMessage(string $nameVariable)
    {
        return "{$nameVariable} cannot empty";
    }
}