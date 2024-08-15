<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateHelpAPIRequest;
use App\Http\Requests\API\UpdateHelpAPIRequest;
use App\Models\Help;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\HelpTutorialRepository;

/**
 * Class HelpAPIController
 */
class HelpTutorialAPIController extends AppBaseController
{
    public function __construct(public HelpTutorialRepository $helpTutorialRepository)
    {
    }

    /**
     * @OA\Get(
     *     path="/api/helps_tutorials",
     *     summary="Retrieve a list of helps",
     *     tags={"Helps"},
     *     @OA\Parameter(
     *         name="skip",
     *         in="query",
     *         description="Number of records to skip",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of records to return",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Helps retrieved successfully",
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
     *                 @OA\Items(
     *                     type="object",
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Helps retrieved successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $helps = $this->helpTutorialRepository->all(
            ['*'],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse('Helps Tutorial retrieved successfully', $helps->toArray());
    }

    /**
     * Store a newly created Help in storage.
     * POST /helps
     */
    public function store(CreateHelpAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $help = $this->helpTutorialRepository->create($input);

        return $this->sendResponse('Help saved successfully', $help->toArray());
    }

    /**
     * Display the specified Help.
     * GET|HEAD /helps/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Help $help */
        $help = $this->helpTutorialRepository->find($id);

        if (empty($help)) {
            return $this->sendError('Help not found');
        }

        return $this->sendResponse('Help retrieved successfully', $help->toArray());
    }

    /**
     * Update the specified Help in storage.
     * PUT/PATCH /helps/{id}
     */
    public function update($id, UpdateHelpAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Help $help */
        $help = $this->helpTutorialRepository->find($id);

        if (empty($help)) {
            return $this->sendError('Help not found');
        }

        $help = $this->helpTutorialRepository->update($input, $id);

        return $this->sendResponse('Help updated successfully', $help->toArray());
    }

    /**
     * Remove the specified Help from storage.
     * DELETE /helps/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Help $help */
        $help = $this->helpTutorialRepository->find($id);

        if (empty($help)) {
            return $this->sendError('Help not found');
        }

        $help->delete();

        return $this->sendResponse('Help deleted successfully');
    }
}
