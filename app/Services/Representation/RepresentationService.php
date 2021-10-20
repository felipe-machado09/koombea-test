<?php

namespace App\Services\Representation;

use Exception;
use Throwable;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Excel;
use App\Services\BaseService;
use Illuminate\Support\Facades\Validator;
use App\Validators\Representation\RepresentationValidator;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Representation\RepresentationRepositoryInterface;

class RepresentationService extends BaseService
{
    private $representationRepository;

    public function __construct(RepresentationRepositoryInterface $representationRepository)
    {
        $this->representationRepository = $representationRepository;
    }

    public function index(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            RepresentationValidator::NEW_PACKAGE_RULE,
            RepresentationValidator::ERROR_MESSAGES
        );


        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 'Validation error.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $representationRequest = $request->n;
            $n = [];
            for($i = 0; $i <= $representationRequest; $i++){
                $stringOrNumber = '';
                switch($i){
                    case $i % 3 == 0 && $i % 5 == 0 && $i % 7 == 0:
                        $stringOrNumber = "FizzBuzzJazz";
                    break;
                    case $i % 3 == 0 && $i % 5 == 0:
                        $stringOrNumber = "FizzBuzz";
                    break;
                    case $i % 3 == 0 && $i % 7 == 0:
                        $stringOrNumber = "FizzJazz";
                    break;
                    case $i % 5 == 0 && $i % 7 == 0:
                        $stringOrNumber = "BuzzJazz";
                    break;
                    case $i % 3 == 0:
                    $stringOrNumber = "Fizz";
                    break;
                    case $i % 5 == 0:
                        $stringOrNumber = "Buzz";
                    break;
                    case $i % 7 == 0:
                        $stringOrNumber = "Jazz";
                    break;
                    default:
                    $stringOrNumber = $i;

                }

                array_push($n, $stringOrNumber);

            }
            $data = json_encode($n);

            request()->request->add(['data' => $data]);

            $representation = $this->representationRepository->index($request);
            $countItems = isset($representation) ? true : false;

            if ($countItems) {
                return $this->sendResponse($representation, [], Response::HTTP_OK);
            }

            return $this->sendError([], 'Representation not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return $this->sendError([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return $this->sendError([], $t->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
