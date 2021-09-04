<?php

namespace App\Services\Contacts;

use Exception;
use Throwable;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Excel;
use App\Services\BaseService;
use App\Imports\ContactsImport;
use Illuminate\Support\Facades\Validator;
use App\Validators\Contacts\ContactsValidator;
use Symfony\Component\HttpFoundation\Response;
use App\Validators\Contacts\ContactsImportValidator;
use App\Repositories\Contacts\ContactsRepositoryInterface;

class ContactsService extends BaseService
{
    private $contactsRepository;

    public function __construct(ContactsRepositoryInterface $contactsRepository)
    {
        $this->contactsRepository = $contactsRepository;
    }

    public function index()
    {
        try {
            $contacts = $this->contactsRepository->index();
            $countItems = isset($contacts) ? true : false;

            if ($countItems) {
                return $this->sendResponse($contacts, [], Response::HTTP_OK);
            }

            return $this->sendError([], 'Contacts not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return $this->sendError([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return $this->sendError([], $t->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ContactsValidator::NEW_PACKAGE_RULE,
            ContactsValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 'Validation error.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $request->request->add(['franchise' => Helpers::getCreditCardFranchise($request->credit_card)]);
            $request->request->add(['credit_card' => Helpers::hashCreditCard($request->credit_card)]);

            $contact = $this->contactsRepository->store($request);

            return $this->sendResponse([], 'Contact created successfully!', Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->sendError([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return $this->sendError([], $t->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function import(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ContactsImportValidator::NEW_PACKAGE_RULE,
            ContactsImportValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 'Validation error.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {

            $contact = Excel::import(new ContactsImport,request()->file('file'));

            if ($contact) {
                return $this->sendResponse($contact, 'Contact imported successfully!', Response::HTTP_ACCEPTED);
            }

            return $this->sendError([], 'Contact not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return $this->sendError([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return $this->sendError([], $t->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
