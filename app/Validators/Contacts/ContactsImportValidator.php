<?php

namespace App\Validators\Contacts;

class ContactsImportValidator
{
    public const ERROR_MESSAGES = [
        'required'       => 'The field :attribute is required',
    ];

    public const NEW_PACKAGE_RULE = [
        'file' => 'required|mimes:csv,xlsx',
    ];
}
