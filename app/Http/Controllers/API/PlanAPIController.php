<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePlanAPIRequest;
use App\Http\Requests\API\UpdatePlanAPIRequest;
use App\Models\Plan;
use App\Repositories\PlanRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class PlanAPIController
 */
class PlanAPIController extends AppBaseController
{
    private PlanRepository $planRepository;

    public function __construct(PlanRepository $planRepo)
    {
        $this->planRepository = $planRepo;
    }

    /**
     * @OA\Get(
     *     path="/api/plans",
     *     summary="Display a listing of the Plans",
     *     tags={"Plans"},
     *     @OA\Parameter(
     *         name="skip",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Plans retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Plan")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     * 
     * @OA\Schema(
     *     schema="Plan",
     *     type="object",
     *     title="Plan",
     *     properties={
     *         @OA\Property(property="id", type="integer", readOnly=true),
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="users", type="integer"),
     *         @OA\Property(property="website", type="string"),
     *         @OA\Property(property="payment_method", type="string"),
     *         @OA\Property(property="price", type="number", format="float"),
     *         @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
     *         @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true)
     *     }
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $plans = $this->planRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($plans->toArray(), 'Plans retrieved successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/plans",
     *     summary="Store a newly created Plan in storage",
     *     tags={"Plans"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "users", "website", "payment_method", "price"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="users", type="integer"),
     *             @OA\Property(property="website", type="string"),
     *             @OA\Property(property="payment_method", type="string"),
     *             @OA\Property(property="price", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Plan saved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Plan")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function store(CreatePlanAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $plan = $this->planRepository->create($input);

        return $this->sendResponse($plan->toArray(), 'Plan saved successfully');
    }

    /**
     * Display the specified Plan.
     * GET|HEAD /plans/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Plan $plan */
        $plan = $this->planRepository->find($id);

        if (empty($plan)) {
            return $this->sendError('Plan not found');
        }

        return $this->sendResponse($plan->toArray(), 'Plan retrieved successfully');
    }

    /**
     * Update the specified Plan in storage.
     * PUT/PATCH /plans/{id}
     */
    public function update($id, UpdatePlanAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Plan $plan */
        $plan = $this->planRepository->find($id);

        if (empty($plan)) {
            return $this->sendError('Plan not found');
        }

        $plan = $this->planRepository->update($input, $id);

        return $this->sendResponse($plan->toArray(), 'Plan updated successfully');
    }

    /**
     * Remove the specified Plan from storage.
     * DELETE /plans/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Plan $plan */
        $plan = $this->planRepository->find($id);

        if (empty($plan)) {
            return $this->sendError('Plan not found');
        }

        $plan->delete();

        return $this->sendSuccess('Plan deleted successfully');
    }
}
