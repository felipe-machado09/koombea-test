<?php

namespace App\Http\Controllers\Api\Representation;

use App\Http\Controllers\Controller;
use App\Services\Representation\RepresentationService;
use Illuminate\Http\Request;

class RepresentationController extends Controller
{
    private $RepresentationService;

    public function __construct(RepresentationService $representationService)
    {
        $this->representationService = $representationService;

    }

    public function index(Request $request)
    {

        return $this->representationService->index($request);
    }


}
