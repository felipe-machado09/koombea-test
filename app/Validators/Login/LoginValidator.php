<?php

namespace App\Validators\Login;

class LoginValidator
{
    public const ERROR_MESSAGES = [
        'required'       => 'O campo :attribute é obrigatório',
        'max'            => 'O :attribute deve ter no máximo :max caracteres',
        'min'            => 'O :attribute deve ter no mínimo :min caracteres',
    ];

    public const NEW_PACKAGE_RULE = [
        'email' => 'required|email',
        'password' => 'required|min:6'
    ];
}
