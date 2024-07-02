<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMailAPIRequest;
use App\Http\Requests\API\UpdateMailAPIRequest;
use App\Models\Mail;
use App\Repositories\MailRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Mail\CustomMail;
use Illuminate\Support\Facades\Mail as FacadesMail;

/**
 * Class MailAPIController
 */
class MailAPIController extends AppBaseController
{
    private MailRepository $mailRepository;

    public function __construct(MailRepository $mailRepo)
    {
        $this->mailRepository = $mailRepo;
    }

    /**
     * @OA\Get(
     *     path="/api/mails",
     *     summary="Retrieve a list of mails",
     *     tags={"Mail"},
     *     description="Returns a list of mails",
     *     operationId="getMails",
     *     @OA\Parameter(
     *         name="skip",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Number of records to skip"
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Maximum number of records to return"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mails retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Mail")
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Mails retrieved successfully"
     *             )
     *         )
     *     )
     * )
     * 
     * @OA\Schema(
     *     schema="Mail",
     *     type="object",
     *     required={"id", "subject", "body"},
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="ID of the mail"
     *     ),
     *     @OA\Property(
     *         property="subject",
     *         type="string",
     *         description="Subject of the mail"
     *     ),
     *     @OA\Property(
     *         property="body",
     *         type="string",
     *         description="Body of the mail"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $mails = $this->mailRepository->all(
            ['*'],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse('Mails retrieved successfully', $mails->toArray());
    }


    /**
     * @OA\Post(
     *     path="/api/mails",
     *     summary="Store a newly created Mail",
     *     tags={"Mail"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"to", "subject", "message"},
     *             @OA\Property(property="to", type="string", example="example@example.com"),
     *             @OA\Property(property="subject", type="string", example="Subject of the mail"),
     *             @OA\Property(property="message", type="string", example="Message content here")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mail saved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="to", type="string", example="example@example.com"),
     *                 @OA\Property(property="subject", type="string", example="Subject of the mail"),
     *                 @OA\Property(property="message", type="string", example="Message content here"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-05-21T15:30:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-05-21T15:30:00Z")
     *             ),
     *             @OA\Property(property="message", type="string", example="Mail saved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error")
     *         )
     *     )
     * )
     */
    public function store(CreateMailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        FacadesMail::to($input['to'])->send(new CustomMail($input));

        $mail = $this->mailRepository->create($input);

        return $this->sendResponse('Mail saved successfully', $mail->toArray());
    }

    /**
     * Display the specified Mail.
     * GET|HEAD /mails/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Mail $mail */
        $mail = $this->mailRepository->find($id);

        if (empty($mail)) {
            return $this->sendError('Mail not found');
        }

        return $this->sendResponse('Mail retrieved successfully', $mail->toArray());
    }

    /**
     * Update the specified Mail in storage.
     * PUT/PATCH /mails/{id}
     */
    public function update($id, UpdateMailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Mail $mail */
        $mail = $this->mailRepository->find($id);

        if (empty($mail)) {
            return $this->sendError('Mail not found');
        }

        $mail = $this->mailRepository->update($input, $id);

        return $this->sendResponse('Mail updated successfully', $mail->toArray());
    }

    /**
     * @OA\Delete(
     *     path="/mails/{id}",
     *     summary="Remove the specified Mail from storage",
     *     tags={"Mail"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the Mail to be deleted",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mail deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Mail deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mail not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Mail not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error")
     *         )
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Mail $mail */
        $mail = $this->mailRepository->find($id);

        if (empty($mail)) {
            return $this->sendError('Mail not found');
        }

        $mail->delete();

        return $this->sendResponse('Mail deleted successfully');
    }
}
