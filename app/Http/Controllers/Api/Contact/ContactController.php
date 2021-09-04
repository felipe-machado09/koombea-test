<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use App\Services\Contacts\ContactsService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $contactsService;

    public function __construct(ContactsService $contactsService)
    {
        $this->contactsService = $contactsService;

    }

    public function index(Request $request)
    {
        return $this->contactsService->index($request);
    }

    public function store(Request $request)
    {
        return $this->contactsService->store($request);
    }

    public function import(Request $request)
    {
        return $this->contactsService->import($request);
    }

}
