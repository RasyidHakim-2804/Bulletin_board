<?php

namespace Core\Validation\Validator;

interface ValidatorInterface
{
    public function validate($value): bool;

    public function getErrorMessage();
}