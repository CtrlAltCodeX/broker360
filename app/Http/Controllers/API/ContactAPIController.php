<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateContactAPIRequest;
use App\Http\Requests\API\UpdateContactAPIRequest;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ContactAPIController
 */
class ContactAPIController extends AppBaseController
{
    private ContactRepository $contactRepository;

    public function __construct(ContactRepository $contactRepo)
    {
        $this->contactRepository = $contactRepo;
    }

    /**
     * @OA\Get(
     *     path="/api/contacts",
     *     operationId="getContactsList",
     *     tags={"Contacts"},
     *     summary="Get list of contacts",
     *     description="Returns list of contacts",
     *     @OA\Parameter(
     *         name="skip",
     *         in="query",
     *         description="Number of records to skip",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Maximum number of records to return",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Contact")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $contacts = $this->contactRepository->all(
            ['*'],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse('Contacts retrieved successfully', $contacts->toArray());
    }

    /**
     * @OA\Post(
     *     path="/api/contacts",
     *     summary="Store a newly created Contact in storage",
     *     tags={"Contacts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "email"},
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="position", type="string", example="Manager"),
     *             @OA\Property(property="company", type="string", example="Company Inc."),
     *             @OA\Property(property="fountain", type="string", example="Source"),
     *             @OA\Property(property="number", type="string", example="+1234567890"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="twitter", type="string", example="@johndoe"),
     *             @OA\Property(property="linkedin", type="string", example="linkedin.com/in/johndoe"),
     *             @OA\Property(property="skype", type="string", example="johndoe_skype"),
     *             @OA\Property(property="website", type="string", format="url", example="https://www.example.com"),
     *             @OA\Property(property="address", type="string", example="123 Main St, Anytown, USA"),
     *             @OA\Property(property="description", type="string", example="Description of the contact")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact saved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe"),
     *                 @OA\Property(property="position", type="string", example="Manager"),
     *                 @OA\Property(property="company", type="string", example="Company Inc."),
     *                 @OA\Property(property="fountain", type="string", example="Source"),
     *                 @OA\Property(property="number", type="string", example="+1234567890"),
     *                 @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *                 @OA\Property(property="twitter", type="string", example="@johndoe"),
     *                 @OA\Property(property="linkedin", type="string", example="linkedin.com/in/johndoe"),
     *                 @OA\Property(property="skype", type="string", example="johndoe_skype"),
     *                 @OA\Property(property="website", type="string", format="url", example="https://www.example.com"),
     *                 @OA\Property(property="address", type="string", example="123 Main St, Anytown, USA"),
     *                 @OA\Property(property="description", type="string", example="Description of the contact")
     *             ),
     *             @OA\Property(property="message", type="string", example="Contact saved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An error occurred")
     *         )
     *     )
     * )
     */
    public function store(CreateContactAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $contact = $this->contactRepository->create($input);

        return $this->sendResponse('Contact saved successfully', $contact->toArray());
    }


    /**
     * Display the specified Contact.
     * GET|HEAD /contacts/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Contact $contact */
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        return $this->sendResponse('Contact retrieved successfully', $contact->toArray());
    }

    /**
     * @OA\Put(
     *     path="/contacts/{id}",
     *     operationId="updateContact",
     *     tags={"Contacts"},
     *     summary="Update an existing contact",
     *     description="Updates a contact by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of contact to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateContactRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     * 
     * /**
     * @OA\Schema(
     *     schema="Contact",
     *     type="object",
     *     title="Contact",
     *     required={"name", "last_name"},
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="First name of the contact"
     *     ),
     *     @OA\Property(
     *         property="last_name",
     *         type="string",
     *         description="Last name of the contact"
     *     ),
     *     @OA\Property(
     *         property="position",
     *         type="string",
     *         description="Position of the contact in the company"
     *     ),
     *     @OA\Property(
     *         property="company",
     *         type="string",
     *         description="Company name"
     *     ),
     *     @OA\Property(
     *         property="fountain",
     *         type="string",
     *         description="Fountain details"
     *     ),
     *     @OA\Property(
     *         property="number",
     *         type="string",
     *         description="Contact number"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         description="Email address"
     *     ),
     *     @OA\Property(
     *         property="twitter",
     *         type="string",
     *         description="Twitter handle"
     *     ),
     *     @OA\Property(
     *         property="linkedin",
     *         type="string",
     *         description="LinkedIn profile"
     *     ),
     *     @OA\Property(
     *         property="skype",
     *         type="string",
     *         description="Skype ID"
     *     ),
     *     @OA\Property(
     *         property="website",
     *         type="string",
     *         description="Website URL"
     *     ),
     *     @OA\Property(
     *         property="address",
     *         type="string",
     *         description="Contact address"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="Description or notes about the contact"
     *     )
     * )
     *
     * @OA\Schema(
     *     schema="UpdateContactRequest",
     *     type="object",
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="First name of the contact"
     *     ),
     *     @OA\Property(
     *         property="last_name",
     *         type="string",
     *         description="Last name of the contact"
     *     ),
     *     @OA\Property(
     *         property="position",
     *         type="string",
     *         description="Position of the contact in the company"
     *     ),
     *     @OA\Property(
     *         property="company",
     *         type="string",
     *         description="Company name"
     *     ),
     *     @OA\Property(
     *         property="fountain",
     *         type="string",
     *         description="Fountain details"
     *     ),
     *     @OA\Property(
     *         property="number",
     *         type="string",
     *         description="Contact number"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         description="Email address"
     *     ),
     *     @OA\Property(
     *         property="twitter",
     *         type="string",
     *         description="Twitter handle"
     *     ),
     *     @OA\Property(
     *         property="linkedin",
     *         type="string",
     *         description="LinkedIn profile"
     *     ),
     *     @OA\Property(
     *         property="skype",
     *         type="string",
     *         description="Skype ID"
     *     ),
     *     @OA\Property(
     *         property="website",
     *         type="string",
     *         description="Website URL"
     *     ),
     *     @OA\Property(
     *         property="address",
     *         type="string",
     *         description="Contact address"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="Description or notes about the contact"
     *     )
     * )
     */
    public function update($id, UpdateContactAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Contact $contact */
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        $contact = $this->contactRepository->update($input, $id);

        return $this->sendResponse('Contact updated successfully', $contact->toArray());
    }

    /**
     * @OA\Delete(
     *     path="/contacts/{id}",
     *     operationId="deleteContact",
     *     tags={"Contacts"},
     *     summary="Delete an existing contact",
     *     description="Deletes a contact by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of contact to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Contact deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Contact not found"
     *             )
     *         )
     *     )
     * )
     *
     * Remove the specified Contact from storage.
     * DELETE /contacts/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Contact $contact */
        $contact = $this->contactRepository->find($id);

        if (empty($contact)) {
            return $this->sendError('Contact not found');
        }

        $contact->delete();

        return $this->sendResponse('Contact deleted successfully');
    }
}
