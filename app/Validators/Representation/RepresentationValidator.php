<?php

namespace App\Validators\Representation;

class RepresentationValidator
{
    public const ERROR_MESSAGES = [
        'required'       => 'The field :attribute is required',
        'integer'       => 'The field :attribute must be integer.',
        'max'            => 'O :attribute deve ter no máximo :max caracteres',
        'min'            => 'O :attribute deve ter no mínimo :min caracteres',
        'regex'          => 'Name must contain letters, numbers, -',
        'phone.regex'    => 'Phone must contain (+00) 000 000 00 00 00 this format',
    ];

    public const NEW_PACKAGE_RULE = [
        'n' => 'required|integer',
    ];
}
