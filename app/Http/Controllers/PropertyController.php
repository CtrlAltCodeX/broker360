<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatePropertyAPIRequest;
use App\Repositories\PropertyRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash as FlashFlash;

class PropertyController extends AppBaseController
{
    /** @var PropertyRepository $propertyRepository*/
    private $propertyRepository;

    public function __construct(
        PropertyRepository $propertyRepository,
        public UserRepository $userRepository
    ) {
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * Display a listing of the User.
     */
    public function index(Request $request)
    {
        $properties = $this->propertyRepository->paginate(10);

        return view('admin.properties.index')
            ->with('properties', $properties);
    }

    /**
     * Show the form for creating a new User.
     */
    public function create()
    {
        $users = $this->userRepository->all();

        return view('admin.properties.create', compact('users'));
    }

    /**
     * Store a newly created User in storage.
     */
    public function store(CreatePropertyAPIRequest $request)
    {
        $input = $request->all();

        if ($input['show_price_ad'] == 'on') $input['show_price_ad'] = 1;
        
        $this->propertyRepository->create($input);

        FlashFlash::success('Properties saved successfully.');

        return redirect(route('admin.properties.index'));
    }

    /**
     * Display the specified User.
     */
    public function show($id)
    {
        $coontact = $this->propertyRepository->find($id);

        if (empty($coontact)) {
            FlashFlash::error('Properties not found');

            return redirect(route('properties.index'));
        }

        return view('properties.show')->with('coontact', $coontact);
    }

    /**
     * Show the form for editing the specified User.
     */
    public function edit($id)
    {
        $properties = $this->propertyRepository->find($id);

        $users = $this->userRepository->all();

        if (empty($properties)) {
            FlashFlash::error('Properties not found');

            return redirect(route('admin.properties.index'));
        }

        return view('admin.properties.edit', compact('users'))->with('properties', $properties);
    }

    /**
     * Update the specified User in storage.
     */
    public function update($id, CreatePropertyAPIRequest $request)
    {
        $user = $this->propertyRepository->find($id);

        $input = $request->all();

        if ($input['show_price_ad'] == 'on') $input['show_price_ad'] = 1;

        if (empty($user)) {
            FlashFlash::error('Properties not found');

            return redirect(route('admin.properties.index'));
        }

        $user = $this->propertyRepository->update($input, $id);

        FlashFlash::success('Properties updated successfully.');

        return redirect(route('admin.properties.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = $this->propertyRepository->find($id);

        if (empty($user)) {
            FlashFlash::error('Properties not found');

            return redirect(route('properties.index'));
        }

        $this->propertyRepository->delete($id);

        FlashFlash::success('Properties deleted successfully.');

        return redirect(route('admin.properties.index'));
    }
}
