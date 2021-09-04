<?php

namespace App\Repositories\Contacts;

use App\Models\Contact;
use App\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactsRepositoryEloquent implements ContactsRepositoryInterface
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function index()
    {
        $contact = $this->contact->paginate(10);

        return $contact;
    }

    public function store(Request $request)
    {
        $contact = $this->contact->create($request->all());
        $contact->save();

        return $contact;
    }

    public function import(Request $request)
    {
        $contact = $this->contact
            ->find($id);

        if ($contact) {
            $contact->update($request->all());
        }

        return $contact ? $contact : [];
    }
}
