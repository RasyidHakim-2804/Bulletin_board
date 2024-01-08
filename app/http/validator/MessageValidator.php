<?php
namespace App\Http\Validator;


class MessageValidator extends BaseValidator
{
    public function __construct($request)
    {
        $request['body'] = rtrim($request['body']);
        $request['body'] = ltrim($request['body']);

        parent::__construct($request);
    }

    public function rules():array
    {
        return [
            'body' => [
                new \Core\Validator\Rule\Required(),
                new \Core\Validator\Rule\Min(10),
                new \Core\Validator\Rule\Max(200),
            ]
        ];
    }
}