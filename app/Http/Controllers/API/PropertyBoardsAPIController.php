<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePropertyBoardsAPIRequest;
use App\Http\Requests\API\UpdatePropertyBoardsAPIRequest;
use App\Models\PropertyBoards;
use App\Repositories\PropertyBoardsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PropertyBoardsAPIController
 */
class PropertyBoardsAPIController extends AppBaseController
{
    private PropertyBoardsRepository $propertyBoardsRepository;

    public function __construct(PropertyBoardsRepository $propertyBoardsRepo)
    {
        $this->propertyBoardsRepository = $propertyBoardsRepo;
    }

    /**
     * Display a listing of the PropertyBoards.
     *
     * @OA\Get(
     *     path="/api/property-boards",
     *     operationId="getPropertyBoardsList",
     *     tags={"PropertyBoards"},
     *     summary="Get list of property boards",
     *     description="Returns list of property boards",
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
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PropertyBoard")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $propertyBoards = $this->propertyBoardsRepository->all(
            ['*'],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse('Property Boards retrieved successfully', $propertyBoards->toArray());
    }

    /**
     * @OA\Post(
     *     path="/api/property-boards",
     *     summary="Store a newly created PropertyBoards in storage",
     *     operationId="storePropertyBoards",
     *     tags={"PropertyBoards"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreatePropertyBoardsAPIRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property Boards saved successfully",
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
     *                 @OA\Items(ref="#/components/schemas/PropertyBoard")
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Property Boards saved successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Validation error"
     *             )
     *         )
     *     )
     * )
     * 
     * @OA\Schema(
     *     schema="CreatePropertyBoardsAPIRequest",
     *     type="object",
     *     required={"property_name", "property_value"},
     *     @OA\Property(
     *         property="name",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="user_id",
     *         type="integer"
     *     ),
     * )

     * @OA\Schema(
     *     schema="PropertyBoard",
     *     type="object",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         format="int64"
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string"
     *     ),
     *     @OA\Property(
     *         property="user_id",
     *         type="integer"
     *     ),
     * )

     */
    public function store(CreatePropertyBoardsAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $propertyBoards = $this->propertyBoardsRepository->create($input);

        return $this->sendResponse('Property Boards saved successfully', $propertyBoards->toArray());
    }

    /**
     * Display the specified PropertyBoards.
     * GET|HEAD /property-boards/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PropertyBoards $propertyBoards */
        $propertyBoards = $this->propertyBoardsRepository->find($id);

        if (empty($propertyBoards)) {
            return $this->sendError('Property Boards not found');
        }

        return $this->sendResponse('Property Boards retrieved successfully', $propertyBoards->toArray());
    }

    /**
     * Update the specified PropertyBoards in storage.
     * PUT/PATCH /property-boards/{id}
     */
    public function update($id, UpdatePropertyBoardsAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PropertyBoards $propertyBoards */
        $propertyBoards = $this->propertyBoardsRepository->find($id);

        if (empty($propertyBoards)) {
            return $this->sendError('Property Boards not found');
        }

        $propertyBoards = $this->propertyBoardsRepository->update($input, $id);

        return $this->sendResponse('PropertyBoards updated successfully', $propertyBoards->toArray());
    }

    /**
     * Remove the specified PropertyBoards from storage.
     * DELETE /property-boards/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PropertyBoards $propertyBoards */
        $propertyBoards = $this->propertyBoardsRepository->find($id);

        if (empty($propertyBoards)) {
            return $this->sendError('Property Boards not found');
        }

        $propertyBoards->delete();

        return $this->sendResponse('Property Boards deleted successfully');
    }
}
