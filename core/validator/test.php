<?php

interface ValidationRule
{
    public function validate($value): bool;
}

class RequiredRule implements ValidationRule
{
    public function validate($value): bool
    {
        return !empty($value);
    }
}

class MinLengthRule implements ValidationRule
{
    private $minLength;

    public function __construct($minLength)
    {
        $this->minLength = $minLength;
    }

    public function validate($value): bool
    {
        return strlen($value) >= $this->minLength;
    }
}

class RequestValidator
{
    private $rules = [];

    public function addRule(ValidationRule $rule)
    {
        $this->rules[] = $rule;
    }

    public function validate(array $data)
    {
        $errors = [];

        foreach ($this->rules as $rule) {
            foreach ($data as $key => $value) {
                if (!$rule->validate($value)) {
                    $errors[$key][] = get_class($rule) . ' validation failed.';
                }
            }
        }

        return $errors;
    }
}

// Contoh penggunaan:

// Buat instance validator
$validator = new RequestValidator();

// Tambahkan aturan validasi
$validator->addRule(new RequiredRule());
$validator->addRule(new MinLengthRule(3));

// Data yang akan divalidasi
$dataToValidate = [
    'username' => 'john_doe',
    'password' => 'pwd',
];

// Validasi data
$errors = $validator->validate($dataToValidate);

// Tampilkan pesan error jika ada
if (!empty($errors)) {
    foreach ($errors as $key => $errorMessages) {
        echo "Field: $key\n";
        foreach ($errorMessages as $errorMessage) {
            echo "- $errorMessage\n";
        }
        echo "\n";
    }
} else {
    echo "Data is valid!";
}
