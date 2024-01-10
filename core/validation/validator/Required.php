<?php
namespace Core\Validation\Validator;

class Required implements ValidatorInterface
{
    public function validate($value): bool
    {
        return !empty($value);
    }

    public function getErrorMessage()
    {
        return "variable cannot empty";
    }
}