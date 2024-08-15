<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePropertyAPIRequest;
use App\Http\Requests\API\UpdatePropertyAPIRequest;
use App\Models\Property;
use App\Repositories\PropertyRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Mail\CustomMail;
use App\Models\Collaboration;
use App\Models\PropertyFeature;
use App\Models\PropertyType;
use App\Models\User;
use App\Repositories\PropertyImageRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;

/**
 * Class PropertyAPIController
 */
class PropertyAPIController extends AppBaseController
{
    private PropertyRepository $propertyRepository;

    public function __construct(
        PropertyRepository $propertyRepo,
        public PropertyImageRepository $propertyImageRepo,
    ) {
        $this->propertyRepository = $propertyRepo;
    }

    /**
     * @OA\Get(
     *     path="/api/properties",
     *     summary="Display a listing of the Properties",
     *     tags={"Properties"},
     *     @OA\Parameter(
     *         name="s",
     *         in="query",
     *         description="Search term to filter properties",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
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
     *     ),
     *    @OA\Property(
     *         property="street",
     *         type="string",
     *         description="Street"
     *     ),
     *     @OA\Property(
     *         property="corner_with",
     *         type="string",
     *         description="Cornor "
     *     ),
     *     @OA\Property(
     *         property="postal_code",
     *         type="integer",
     *         description="Postal Code"
     *     ),
     *     @OA\Property(
     *         property="property_features",
     *         type="string",
     *         description="property_features"
     *     ),
     *     @OA\Property(
     *         property="share_commission",
     *         type="integer",
     *         description="share_commission"
     *     ),
     *          @OA\Property(
     *         property="commission_percent",
     *         type="integer",
     *         description="commission_percent"
     *     ),
     *      @OA\Property(
     *         property="condition_sharing",
     *         type="string",
     *         description="condition_sharing"
     *     )
     * )
     *
     */
    public function index(Request $request): JsonResponse
    {
        $searchTerm = $request->input('s');
        $skip = $request->input('skip', 0);
        $limit = $request->input('limit', 10);

        $columns = ['type', 'ad_type', 'ad_desc', 'price', 'street', 'corner_with', 'postal_code', 'postal_code', 'postal_code']; // Add more columns as needed

        $properties = $this->propertyRepository->with('images')
            ->where(function ($query) use ($searchTerm, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', "%{$searchTerm}%");
                }
            })
            ->skip($skip)
            ->take($limit)
            ->get();

        return $this->sendResponse('Properties retrieved successfully', $properties->toArray());
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
     *             @OA\Property(property="user_id", type="integer", example="1"),
     *             @OA\Property(property="street", type="integer", example="1"),
     *             @OA\Property(property="corner_with", type="integer", example="1"),
     *             @OA\Property(property="postal_code", type="integer", example="1"),
     *             @OA\Property(property="property_features", type="integer", example="Features"),
     *             @OA\Property(property="share_commission", type="integer", example="1"),
     *             @OA\Property(property="commission_percent", type="integer", example="1"),
     *             @OA\Property(property="condition_sharing", type="integer", example="Sharing"),
     *             @OA\Property(property="price", type="integer", example="1"),
     *             @OA\Property(property="longitude_latitude", type="string", example="Sharing"),
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
     *                 @OA\Property(property="street", type="integer", example="1"),
     *                 @OA\Property(property="corner_with", type="integer", example="1"),
     *                 @OA\Property(property="postal_code", type="integer", example="1"),
     *                 @OA\Property(property="property_features", type="integer", example="Features"),
     *                 @OA\Property(property="share_commission", type="integer", example="1"),
     *                 @OA\Property(property="commission_percent", type="integer", example="1"),
     *                 @OA\Property(property="condition_sharing", type="integer", example="Sharing"),
     *                 @OA\Property(property="price", type="integer", example="1"),
     *                 @OA\Property(property="longitude_latitude", type="string", example="Sharing"),
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

        if (isset(request()->property_image)) {
            foreach (request()->property_image as $image) {
                if ($file = $image) {
                    if ($file instanceof UploadedFile) {
                        $profileImage = time() . "." . $file->getClientOriginalExtension();
    
                        $file->move('storage/property_image/', $profileImage);
    
                        $input['url'] = "/storage/property_image/" . "$profileImage";
                    }
                }
    
                $this->propertyImageRepo->create($input);
            }
        }

        return $this->sendResponse('Property saved successfully', $property->toArray());
    }

    /**
     * @OA\Get(
     *     path="/api/properties/{id}",
     *     summary="Display the specified Property",
     *     description="Get the details of a specific property by its ID.",
     *     operationId="showProperty",
     *     tags={"Properties"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the property to retrieve",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
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
     *                 @OA\Property(property="street", type="integer", example="1"),
     *                 @OA\Property(property="corner_with", type="integer", example="1"),
     *                 @OA\Property(property="postal_code", type="integer", example="1"),
     *                 @OA\Property(property="property_features", type="integer", example="Features"),
     *                 @OA\Property(property="share_commission", type="integer", example="1"),
     *                 @OA\Property(property="commission_percent", type="integer", example="1"),
     *                 @OA\Property(property="condition_sharing", type="integer", example="Sharing"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-05-21T13:45:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-05-21T13:45:00Z")
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Property retrieved successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Property not found",
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
     *                 example="Property not found"
     *             )
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Property $property */
        $property = $this->propertyRepository->find($id);

        if (empty($property)) {
            return $this->sendError('Property not found');
        }

        return $this->sendResponse('Property retrieved successfully', $property->toArray());
    }

    /**
     * @OA\Put(
     *     path="/properties/{id}",
     *     summary="Update the specified Property in storage",
     *     tags={"Properties"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of Property to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"type", "ad_type", "ad_desc", "operation_type", "show_price_ad", "bedroom", "bathrooms", "half_bath", "parking_lots", "construction", "year_construction", "number_plants", "number_floors", "monthly_maintence", "internal_key", "key_code", "user_id", "street", "corner_with", "postal_code", "property_features", "share_commission", "commission_percent", "condition_sharing"},
     *             @OA\Property(property="type", type="string", example="House"),
     *             @OA\Property(property="ad_type", type="string", example="Sale"),
     *             @OA\Property(property="ad_desc", type="string", example="A beautiful house"),
     *             @OA\Property(property="operation_type", type="string", example="Rent"),
     *             @OA\Property(property="show_price_ad", type="boolean", example=true),
     *             @OA\Property(property="bedroom", type="integer", example=3),
     *             @OA\Property(property="bathrooms", type="integer", example=2),
     *             @OA\Property(property="half_bath", type="integer", example=1),
     *             @OA\Property(property="parking_lots", type="integer", example=2),
     *             @OA\Property(property="construction", type="string", example="Brick"),
     *             @OA\Property(property="year_construction", type="integer", example=2020),
     *             @OA\Property(property="number_plants", type="integer", example=2),
     *             @OA\Property(property="number_floors", type="integer", example=1),
     *             @OA\Property(property="monthly_maintence", type="number", format="float", example=150.75),
     *             @OA\Property(property="internal_key", type="string", example="INT123"),
     *             @OA\Property(property="key_code", type="string", example="KC456"),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="street", type="string", example="Main St"),
     *             @OA\Property(property="corner_with", type="string", example="1st Ave"),
     *             @OA\Property(property="postal_code", type="string", example="12345"),
     *             @OA\Property(property="property_features", type="string", example="Features"),
     *             @OA\Property(property="share_commission", type="boolean", example=true),
     *             @OA\Property(property="commission_percent", type="number", format="float", example=5.5),
     *             @OA\Property(property="condition_sharing", type="string", example="Sharing conditions")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/Property"),
     *             @OA\Property(property="message", type="string", example="Property updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Property not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Property not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid input")
     *         )
     *     )
     * )
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

        return $this->sendResponse('Property updated successfully', $property->toArray());
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

    /**
     * @OA\Post(
     *     path="/api/properties/images",
     *     summary="Store property images",
     *     description="Uploads and stores property images.",
     *     tags={"Property Images"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="property_image",
     *                     type="array",
     *                     @OA\Items(type="string", format="binary"),
     *                     description="Array of property images to upload"
     *                 ),
     *                 @OA\Property(
     *                     property="property_id",
     *                     type="integer",
     *                     description="ID of the property"
     *                 ),
     *                 required={"property_image", "property_id"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property images inserted successfully",
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
     *                     @OA\Property(
     *                         property="url",
     *                         type="string",
     *                         example="/storage/property_image/1623847527.jpg"
     *                     ),
     *                     @OA\Property(
     *                         property="property_id",
     *                         type="integer",
     *                         example=1
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Property images inserted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object"
     *             )
     *         )
     *     )
     * )
     */
    public function storeImages()
    {
        request()->validate([
            'property_image' => 'required|array',
            'property_id' => 'required',
        ]);

        $input = request()->all();

        foreach (request()->property_image as $image) {
            if ($file = $image) {
                if ($file instanceof UploadedFile) {
                    $profileImage = time() . "." . $file->getClientOriginalExtension();

                    $file->move('storage/property_image/', $profileImage);

                    $input['url'] = "/storage/property_image/" . "$profileImage";
                }
            }

            $data[] = $this->propertyImageRepo->create($input);
        }

        return $this->sendResponse('Property images inserted successfully', $data);
    }

    /**
     * @OA\Get(
     *     path="/api/properties/{id}/images",
     *     summary="Get property images",
     *     tags={"Property Images"},
     *     description="Retrieve all images for a specific property by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the property",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
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
     *                 example="All Property images"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="url",
     *                         type="string",
     *                         example="http://example.com/images/1.jpg"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Property not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Property not found"
     *             )
     *         )
     *     )
     * )
     */
    public function getImages($id)
    {
        $images = $this->propertyImageRepo->findWhere(['property_id' => $id]);

        return $this->sendResponse('All Property images', $images);
    }

    /**
     * Retrieve property by user ID
     *
     * @OA\Get(
     *     path="/api/properties/{id}/user",
     *     summary="Retrieve property by user ID",
     *     tags={"Properties"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Property")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Property not found"
     *     )
     * )
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPropertyByUserId($id)
    {
        $propertyUser = $this->propertyRepository->with('images')
            ->findWhere(['user_id' =>  $id]);

        $collaborations = Collaboration::where('agent_id', auth()->user()->id)
            ->where('status', 1)
            ->get();

        $collaborationProperties = [];

        foreach ($collaborations as $collab) {
            $propertiesData = $this->propertyRepository
                ->findByField("user_id", $collab->user_id);

            foreach ($propertiesData as $property) {
                $collaborationProperties[] = $property->toArray();
            }
        }

        $allProperties = array_merge($collaborationProperties, $propertyUser->toArray());

        return $this->sendResponse('User Property', $allProperties);
    }

    /**
     * @OA\Put(
     *     path="/api/properties/{id}/status",
     *     summary="Update the status of a property",
     *     description="Update the status of a property by its ID",
     *     tags={"Properties"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the property to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="integer",
     *                 description="1"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Property status updated",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Property status updated"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/Property"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Property not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Property not found"
     *             )
     *         )
     *     )
     * )
     */
    public function updateStatus($id)
    {
        $property = $this->propertyRepository->update(['status' => request()->status], $id);

        return $this->sendResponse('Property status updated', $property);
    }

    /**
     * @OA\Post(
     *     path="/api/collaborations/invite",
     *     summary="Invite an agent to collaborate",
     *     tags={"Collaborations"},
     *     description="Invite an agent to collaborate with the user.",
     *     operationId="inviteCollaboration",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user_id",
     *                 type="integer",
     *                 description="ID of the user"
     *             ),
     *             @OA\Property(
     *                 property="agent_id",
     *                 type="integer",
     *                 description="ID of the agent"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Agent Invited",
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
     *                 example="Agent Invited"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Already Collaborated",
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
     *                 example="Already Collaborated"
     *             )
     *         )
     *     )
     * )
     */
    public function inviteCollaboration()
    {
        $collaborations = Collaboration::where('user_id', request()->user_id)
            ->where('agent_id', request()->agent_id)
            ->first();

        if ($collaborations) return $this->sendError('Already Collaborated');

        Collaboration::create([
            'user_id' => request()->user_id,
            'agent_id' => request()->agent_id
        ]);

        $agent = User::find(request()->agent_id);

        $user = User::find(request()->user_id);
        $data['subject'] = 'Collaboration';
        $data['message'] = $user->name . " Invited you to Collaborate";
        $data['collaboration'] = true;

        Mail::to($agent->email)->send(new CustomMail($data));

        return $this->sendResponse('Agent Invited');
    }

    /**
     * @OA\Get(
     *     path="/api/collaborations",
     *     summary="Get a list of collaborations for a user",
     *     tags={"Collaborations"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="ID of the user to fetch collaborations for"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="All Agents"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Collaboration")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     ),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     * 
     * @OA\Schema(
     *     schema="Collaboration",
     *     type="object",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="The ID of the collaboration"
     *     ),
     *     @OA\Property(
     *         property="user_id",
     *         type="integer",
     *         description="The ID of the user"
     *     ),
     *     @OA\Property(
     *         property="agent_id",
     *         type="integer",
     *         description="The ID of the agent"
     *     ),
     * )
     */
    public function getCollaboration()
    {
        $collaborationList = Collaboration::where('user_id', request()->user_id)->get();

        return $this->sendResponse('All Agents', $collaborationList);
    }

    /**
     * @OA\Get(
     *     path="/api/invitation-counts",
     *     summary="Get the count of invitations sent and received",
     *     tags={"Collaborations"},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="ID of the user",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="agent_id",
     *         in="query",
     *         description="ID of the agent",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
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
     *                 example="Invitation Sent"
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="integer",
     *                     example=5
     *                 ),
     *                 description="Array with the count of collaborations sent and received"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function invitationCounts(Request $request)
    {
        $collaborationsSent = Collaboration::where('user_id', $request->user_id)->count();
        $collaborationsReceived = Collaboration::where('agent_id', $request->agent_id)->count();

        $collaborations = [$collaborationsSent, $collaborationsReceived];

        return $this->sendResponse('Invitation Sent and Received', $collaborations);
    }

    /**
     * @OA\Post(
     *     path="/api/collaborations/stop",
     *     summary="Stop a collaboration",
     *     description="Stops a collaboration between a user and an agent",
     *     tags={"Collaborations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "agent_id"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="agent_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Collaboration stopped successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Collaboration Stop")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Bad request")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */
    public function stopCollaboration()
    {
        Collaboration::where('user_id', request()->user_id)
            ->where('agent_id', request()->agent_id)
            ->delete();

        return $this->sendResponse('Collaboration Stop');
    }

    /**
     * @OA\Get(
     *     path="/api/properties/type/all",
     *     operationId="getPropertyTypes",
     *     tags={"Properties"},
     *     summary="Get list of all property types",
     *     description="Returns a list of all property types",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PropertyType")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     * @OA\Schema(
     *     schema="PropertyType",
     *     type="object",
     *     title="Property Type",
     *     description="Property Type Model",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="ID of the property type"
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="Name of the property type"
     *     ),
     * )
     */
    public function getPropertyTypes()
    {
        $allTypes = PropertyType::all();

        return $this->sendResponse('Property Types', $allTypes);
    }

    /**
     * @OA\Get(
     *     path="/api/properties/features/all",
     *     summary="Get all property features",
     *     tags={"Properties"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all property features",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PropertyFeature")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     * @OA\Schema(
     *     schema="PropertyFeature",
     *     type="object",
     *     title="Property Feature",
     *     description="Schema for a Property Feature",
     *     @OA\Property(
     *         property="id",
     *         type="integer",
     *         description="The ID of the property feature"
     *     ),
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="The name of the property feature"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="The description of the property feature"
     *     ),
     *     @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         description="The creation timestamp of the property feature"
     *     ),
     *     @OA\Property(
     *         property="updated_at",
     *         type="string",
     *         format="date-time",
     *         description="The update timestamp of the property feature"
     *     )
     * )

     */
    public function getPropertyFeatures()
    {
        $allFeatures = PropertyFeature::select('category')
            ->groupBy('category')
            ->get()
            ->toArray();

        $data = [];
        foreach ($allFeatures as $allFeature) {
            $data[$allFeature['category']] = PropertyFeature::where('category', $allFeature['category'])
                ->get()
                ->toArray();
        }

        return $this->sendResponse('Property Features', $data);
    }
}
