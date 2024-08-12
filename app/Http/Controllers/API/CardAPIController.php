<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCardAPIRequest;
use App\Http\Requests\API\UpdateCardAPIRequest;
use App\Models\Card;
use App\Repositories\CardRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CardAPIController
 */
class CardAPIController extends AppBaseController
{
    private CardRepository $cardRepository;

    public function __construct(CardRepository $cardRepo)
    {
        $this->cardRepository = $cardRepo;
    }

    /**
     * @OA\Get(
     *     path="/api/cards",
     *     summary="Get a list of cards",
     *     tags={"Card"},
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
     *         description="Cards retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Card")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     * 
     * @OA\Schema(
     *     schema="Card",
     *     required={"number", "expiry", "cvv", "frequency"},
     *     @OA\Property(property="id", type="integer", format="int64"),
     *     @OA\Property(property="number", type="string", format="number", example="1234567812345678"),
     *     @OA\Property(property="expiry", type="string", format="date", example="12/24"),
     *     @OA\Property(property="cvv", type="string", example="123"),
     *     @OA\Property(property="frequency", type="string", example="monthly"),
     *     @OA\Property(property="created_at", type="string", format="date-time"),
     *     @OA\Property(property="updated_at", type="string", format="date-time")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $cards = $this->cardRepository->all(
            ['*'],
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse('Cards retrieved successfully', $cards->toArray());
    }

    /**
     * @OA\Post(
     *     path="/api/cards",
     *     summary="Store a newly created card",
     *     tags={"Card"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"number", "expiry", "cvv", "frequency"},
     *             @OA\Property(property="number", type="string", format="number", example="1234567812345678"),
     *             @OA\Property(property="expiry", type="string", format="date", example="12/24"),
     *             @OA\Property(property="cvv", type="string", example="123"),
     *             @OA\Property(property="frequency", type="string", example="monthly")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Card saved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Card")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function store(CreateCardAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $cards = $this->cardRepository->count();

        if (!$cards) {
            $card = $this->cardRepository->create($input);
        } else {
            $card = $this->cardRepository->first();

            $card->update(request()->all());
        }

        return $this->sendResponse('Card saved successfully', $card->toArray());
    }

    /**
     * Display the specified Card.
     * GET|HEAD /cards/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Card $card */
        $card = $this->cardRepository->find($id);

        if (empty($card)) {
            return $this->sendError('Card not found');
        }

        return $this->sendResponse($card->toArray(), 'Card retrieved successfully');
    }

    /**
     * Update the specified Card in storage.
     * PUT/PATCH /cards/{id}
     */
    public function update($id, UpdateCardAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Card $card */
        $card = $this->cardRepository->find($id);

        if (empty($card)) {
            return $this->sendError('Card not found');
        }

        $card = $this->cardRepository->update($input, $id);

        return $this->sendResponse($card->toArray(), 'Card updated successfully');
    }

    /**
     * Remove the specified Card from storage.
     * DELETE /cards/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Card $card */
        $card = $this->cardRepository->find($id);

        if (empty($card)) {
            return $this->sendError('Card not found');
        }

        $card->delete();

        return $this->sendResponse('Card deleted successfully');
    }
}
