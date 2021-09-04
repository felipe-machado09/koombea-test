<?php

namespace App\Services\Auth;

use stdClass;
use Exception;
use Throwable;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Http\Requests\LoginRequest;
use App\Validators\Login\LoginValidator;
use Illuminate\Support\Facades\Validator;
use App\Validators\User\RegisterValidator;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Auth\AuthRepositoryInterface;

class AuthService extends BaseService
{
    private $contactsRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }


    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            LoginValidator::NEW_PACKAGE_RULE,
            LoginValidator::ERROR_MESSAGES
        );
        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 'Validation error.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $user = $this->authRepository->login($request);
            $countItems = isset($user) ? true : false;
            $result = new stdClass();
            $result->token = $user;

            if ($countItems == true) {
                return $this->sendResponse($result, [], Response::HTTP_OK);
            }

            return $this->sendError([], 'Credentials not match', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return $this->sendError([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return $this->sendError([], $t->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            RegisterValidator::NEW_PACKAGE_RULE,
            RegisterValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 'Validation error.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $user = $this->authRepository->register($request);

            $result = new stdClass();
            $result->token = $user;

            return $this->sendResponse($result, 'User created successfully!', Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->sendError([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return $this->sendError([], $t->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function logout()
    {
        try {
            $user = $this->authRepository->logout();

            if ($user) {
                return $this->sendResponse([], 'Tokens Revoked', Response::HTTP_OK);
            }

            return $this->sendError([], 'User not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return $this->sendError([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return $this->sendError([], $t->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
