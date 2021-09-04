<?php

namespace App\Services\Contacts;

use App\Repositories\Contacts\ContactsRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ContactsService extends BaseService
{
    private $contactsRepository;

    public function __construct(ContactsRepositoryInterface $contactsRepository)
    {
        $this->contactsRepository = $contactsRepository;
    }

    public function index(Request $request)
    {
        try {
            $filters = [];

            $contacts = $this->contactsRepository->index($filters);
            $countItems = isset($Contacts) ? true : false;

            if ($countItems) {
                return $this->sendResponse($Contacts, [], Response::HTTP_OK);
            }

            return $this->sendError([], 'Contacts not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return $this->sendError([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return $this->sendError([], $t->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(int $id)
    {
        try {
            $contact = $this->contactsRepository->show($id);
            $countItems = isset($Contact) ? true : false;

            if ($countItems) {
                return $this->sendResponse($Contact, [], Response::HTTP_OK);
            }

            return $this->sendError([], 'Contact not found.', Response::HTTP_NOT_FOUND);
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
            ContactValidator::NEW_PACKAGE_RULE,
            ContactValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 'Validation error.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $contact = $this->contactsRepository->store($request);

            return $this->sendResponse([], 'Contact created successfully!', Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->sendError([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return $this->sendError([], $t->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(int $id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ContactValidator::NEW_PACKAGE_RULE,
            ContactValidator::ERROR_MESSAGES
        );

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 'Validation error.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $contact = $this->contactsRepository->update($id, $request);

            if ($contact) {
                return $this->sendResponse($contact, 'Contact updated successfully!', Response::HTTP_ACCEPTED);
            }

            return $this->sendError([], 'Contact not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return $this->sendError([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return $this->sendError([], $t->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(int $id)
    {
        try {
            $contact = $this->contactsRepository->destroy($id);

            if ($contact) {
                return $this->sendResponse([], [], Response::HTTP_NO_CONTENT);
            }

            return $this->sendError([], 'Contact not found.', Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return $this->sendError([], $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Throwable $t) {
            return $this->sendError([], $t->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
