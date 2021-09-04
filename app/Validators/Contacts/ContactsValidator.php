<?php

namespace App\Validators\Contacts;

class ContactsValidator
{
    public const ERROR_MESSAGES = [
        'required'       => 'The field :attribute is required',
        'max'            => 'O :attribute deve ter no máximo :max caracteres',
        'min'            => 'O :attribute deve ter no mínimo :min caracteres',
        'regex'          => 'Name must contain letters, numbers, -',
        'phone.regex'    => 'Phone must contain (+00) 000 000 00 00 00 this format',
    ];

    public const NEW_PACKAGE_RULE = [
        'name' => 'required|regex:^([a-z0-9\s\-]+)$^',
        'date_of_birth' => 'required|date_format:Y-m-d',
        'address' => 'required',
        'phone' => 'required',
        'credit_card' => 'required',
        'email' => 'required|unique:contacts,email'
    ];
}
