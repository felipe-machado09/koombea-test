<?php

namespace App\Repositories\Representation;

use App\Models\Contact;
use App\Support\Collection;
use Illuminate\Http\Request;
use App\Models\LogRepresentation;
use Illuminate\Support\Facades\Auth;

class RepresentationRepositoryEloquent implements RepresentationRepositoryInterface
{
    private $representation;

    public function __construct(LogRepresentation $representation)
    {
        $this->representation = $representation;
    }

    public function index(Request $request)
    {
        $representation = $this->representation->create($request->all());
        return $representation;
    }

    public function storeLog(Request $request)
    {
        $contact = $this->contact->create($request->all());
        $contact->save();

        return $contact;
    }


}
