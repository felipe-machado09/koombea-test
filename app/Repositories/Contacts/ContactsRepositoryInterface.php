<?php

namespace App\Repositories\Contacts;

use App\Models\Contact;
use Illuminate\Http\Request;
use stdClass;

interface ContactsRepositoryInterface
{
    public function index();
    public function store(Request $request);
    public function import(Request $request);

}
