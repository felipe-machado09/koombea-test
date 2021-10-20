<?php

namespace App\Repositories\Representation;

use App\Models\Contact;
use Illuminate\Http\Request;
use stdClass;

interface RepresentationRepositoryInterface
{
    public function index(Request $request);
}
