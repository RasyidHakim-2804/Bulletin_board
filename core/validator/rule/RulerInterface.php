<?php

namespace Core\Validator\Rule;

interface RulerInterface
{
    public function validate($value): bool;

    public function getErrorMessage(string $nameVariable);
}