<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePropertyAPIRequest;
use App\Http\Requests\API\UpdatePropertyAPIRequest;
use App\Models\Property;
use App\Repositories\PropertyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PropertyAPIController
 */
class PropertyAPIController extends AppBaseController
{
    private PropertyRepository $propertyRepository;

    public function __construct(PropertyRepository $propertyRepo)
    {
        $this->propertyRepository = $propertyRepo;
    }

    /**
     * @OA\Get(
     *     path="/api/properties",
     *     summary="Display a listing of the Properties",
     *     tags={"Properties"},
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
     *         description="Maximum number of records to return",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Properties retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Property")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     * 
     * /**
     * @OA\Schema(
     *     schema="Property",
     *     type="object",
     *     title="Property",
     *     required={"type", "ad_type", "ad_desc", "operation_type"},
     *     @OA\Property(
     *         property="type",
     *         type="string",
     *         description="The type of the property"
     *     ),
     *     @OA\Property(
     *         property="ad_type",
     *         type="string",
     *         description="The type of ad"
     *     ),
     *     @OA\Property(
     *         property="ad_desc",
     *         type="string",
     *         description="The description of the ad"
     *     ),
     *     @OA\Property(
     *         property="operation_type",
     *         type="string",
     *         description="The type of operation"
     *     ),
     *     @OA\Property(
     *         property="show_price_ad",
     *         type="boolean",
     *         description="Whether to show the price in the ad"
     *     ),
     *     @OA\Property(
     *         property="bedroom",
     *         type="integer",
     *         description="The number of bedrooms"
     *     ),
     *     @OA\Property(
     *         property="bathrooms",
     *         type="integer",
     *         description="The number of bathrooms"
     *     ),
     *     @OA\Property(
     *         property="half_bath",
     *         type="integer",
     *         description="The number of half bathrooms"
     *     ),
     *     @OA\Property(
     *         property="parking_lots",
     *         type="integer",
     *         description="The number of parking lots"
     *     ),
     *     @OA\Property(
     *         property="construction",
     *         type="integer",
     *         description="The construction size"
     *     ),
     *     @OA\Property(
     *         property="year_construction",
     *         type="integer",
     *         description="The year of construction"
     *     ),
     *     @OA\Property(
     *         property="number_plants",
     *         type="integer",
     *         description="The number of plants"
     *     ),
     *     @OA\Property(
     *         property="number_floors",
     *         type="integer",
     *         description="The number of floors"
     *     ),
     *     @OA\Property(
     *         property="monthly_maintence",
     *         type="number",
     *         format="float",
     *         description="The monthly maintenance cost"
     *     ),
     *     @OA\Property(
     *         property="internal_key",
     *         type="string",
     *         description="The internal key"
     *     ),
     *     @OA\Property(
     *         property="key_code",
     *         type="string",
     *         description="The key code"
     *     ),
     *     @OA\Property(
     *         property="user_id",
     *         type="integer",
     *         description="User ID"
     *     )
     * )
     *
     */
    public function index(Request $request): JsonResponse
    {
        $properties = $this->propertyRepository->all(
            ['*'],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($properties->toArray(), 'Properties retrieved successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/properties",
     *     summary="Store a newly created Property in storage",
     *     tags={"Properties"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"type", "ad_type", "operation_type"},
     *             @OA\Property(property="type", type="string", example="residential"),
     *             @OA\Property(property="ad_type", type="string", example="sale"),
     *             @OA\Property(property="ad_desc", type="string", example="Beautiful house with garden"),
     *             @OA\Property(property="operation_type", type="string", example="rent"),
     *             @OA\Property(property="show_price_ad", type="boolean", example=true),
     *             @OA\Property(property="bedroom", type="integer", example=3),
     *             @OA\Property(property="bathrooms", type="integer", example=2),
     *             @OA\Property(property="half_bath", type="integer", example=1),
     *             @OA\Property(property="parking_lots", type="integer", example=2),
     *             @OA\Property(property="construction", type="number", format="float", example=120.5),
     *             @OA\Property(property="year_construction", type="integer", example=2015),
     *             @OA\Property(property="number_plants", type="integer", example=1),
     *             @OA\Property(property="number_floors", type="integer", example=2),
     *             @OA\Property(property="monthly_maintence", type="number", format="float", example=150.75),
     *             @OA\Property(property="internal_key", type="string", example="INT123"),
     *             @OA\Property(property="key_code", type="string", example="KEY456"),
     *             @OA\Property(property="user_id", type="integer", example="1")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property saved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="type", type="string", example="residential"),
     *                 @OA\Property(property="ad_type", type="string", example="sale"),
     *                 @OA\Property(property="ad_desc", type="string", example="Beautiful house with garden"),
     *                 @OA\Property(property="operation_type", type="string", example="rent"),
     *                 @OA\Property(property="show_price_ad", type="boolean", example=true),
     *                 @OA\Property(property="bedroom", type="integer", example=3),
     *                 @OA\Property(property="bathrooms", type="integer", example=2),
     *                 @OA\Property(property="half_bath", type="integer", example=1),
     *                 @OA\Property(property="parking_lots", type="integer", example=2),
     *                 @OA\Property(property="construction", type="number", format="float", example=120.5),
     *                 @OA\Property(property="year_construction", type="integer", example=2015),
     *                 @OA\Property(property="number_plants", type="integer", example=1),
     *                 @OA\Property(property="number_floors", type="integer", example=2),
     *                 @OA\Property(property="monthly_maintence", type="number", format="float", example=150.75),
     *                 @OA\Property(property="internal_key", type="string", example="INT123"),
     *                 @OA\Property(property="key_code", type="string", example="KEY456"),
     *                 @OA\Property(property="user_id", type="integer", example="1"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-05-21T13:45:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-05-21T13:45:00Z")
     *             ),
     *             @OA\Property(property="message", type="string", example="Property saved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation Error")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     */
    public function store(CreatePropertyAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $property = $this->propertyRepository->create($input);

        return $this->sendResponse($property->toArray(), 'Property saved successfully');
    }

    /**
     * Display the specified Property.
     * GET|HEAD /properties/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Property $property */
        $property = $this->propertyRepository->find($id);

        if (empty($property)) {
            return $this->sendError('Property not found');
        }

        return $this->sendResponse($property->toArray(), 'Property retrieved successfully');
    }

    /**
     * Update the specified Property in storage.
     * PUT/PATCH /properties/{id}
     */
    public function update($id, UpdatePropertyAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Property $property */
        $property = $this->propertyRepository->find($id);

        if (empty($property)) {
            return $this->sendError('Property not found');
        }

        $property = $this->propertyRepository->update($input, $id);

        return $this->sendResponse($property->toArray(), 'Property updated successfully');
    }

    /**
     * Remove the specified Property from storage.
     * DELETE /properties/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Property $property */
        $property = $this->propertyRepository->find($id);

        if (empty($property)) {
            return $this->sendError('Property not found');
        }

        $property->delete();

        return $this->sendResponse('Property deleted successfully');
    }
}
