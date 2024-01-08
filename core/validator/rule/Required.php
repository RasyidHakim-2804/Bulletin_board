<?php
namespace Core\Validator\Rule;

class Required implements RulerInterface
{
    public function validate($value): bool
    {
        return !empty($value);
    }

    public function getErrorMessage(string $nameVariable)
    {
        return "{$nameVariable} cannot empty";
    }
}