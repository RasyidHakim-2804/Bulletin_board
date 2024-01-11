<?php
namespace App\Http\Validator;


class MessageValidator extends RequestValidator
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
                new \Core\Validation\Validator\Required(),
                new \Core\Validation\Validator\Min(10),
                new \Core\Validation\Validator\Max(200),
            ],
            // 'test' => [
            //     new \Core\Validation\Validator\Required()
            // ]
        ];
    }
}