<?php

namespace App\Imports;

use App\Models\Contact;
use App\Helpers\Helpers;
use Maatwebsite\Excel\Concerns\ToModel;

class ContactsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Contact([
            'name'     => $row['name'],
            'date_of_birth'    => $row['date_of_birth'],
            'phone' => $row['phone'],
            'address' => $row['address'],
            'credit_card' => Helpers::hashCreditCard($row['credit_card']),
            'franchise' => Helpers::getCreditCardFranchise($row['credit_card']),
            'email' => $row['email']
        ]);
    }
}
