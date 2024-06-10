<?php

namespace App\Http\Controllers;

use App\Repositories\ContactRepository;
use App\Repositories\PropertyBoardsRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\UserRepository;

class DashboardController extends AppBaseController
{

    public function __construct(
        public UserRepository $userRepository,
        public ContactRepository $contactRepository,
        public PropertyRepository $propertyRepository,
        public PropertyBoardsRepository $propertyBoardsRepository
    ) {
    }

    /**
     * Send a success response.
     *
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = $this->userRepository->all()
            ->count();

        $contacts = $this->contactRepository->all()
            ->count();

        $properties = $this->propertyRepository->all()
            ->count();

        $boards = $this->propertyBoardsRepository->all()
            ->count();

        return view('admin.content', compact('users', 'contacts', 'properties', 'boards'));
    }
}
