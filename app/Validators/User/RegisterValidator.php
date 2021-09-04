<?php

namespace App\Validators\User;

class RegisterValidator
{
    public const ERROR_MESSAGES = [
        'required'       => 'O campo :attribute é obrigatório',
        'max'            => 'O :attribute deve ter no máximo :max caracteres',
        'min'            => 'O :attribute deve ter no mínimo :min caracteres',
    ];

    public const NEW_PACKAGE_RULE = [
        'name' => 'required',
        'email' => 'required|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ];
}
