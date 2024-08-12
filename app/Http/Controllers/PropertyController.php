<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatePropertyAPIRequest;
use App\Repositories\PropertyFeatureRepository;
use App\Repositories\PropertyImageRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\PropertyTypeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Laracasts\Flash\Flash as FlashFlash;

class PropertyController extends AppBaseController
{
    /** @var PropertyRepository $propertyRepository*/

    public function __construct(
        public PropertyRepository $propertyRepository,
        public PropertyImageRepository $propertyImageRepository,
        public UserRepository $userRepository,
        public PropertyTypeRepository $propertyTypeRepository,
        public PropertyFeatureRepository $propertyFeatureRepository
    ) {}

    /**
     * Display a listing of the User.
     */
    public function index(Request $request)
    {
        $properties = $this->propertyRepository
            ->with('types')
            ->paginate(10);

        return view('admin.properties.index')
            ->with('properties', $properties);
    }

    /**
     * Show the form for creating a new User.
     */
    public function create()
    {
        $users = $this->userRepository->all();

        $types = $this->propertyTypeRepository->all();

        $features = $this->propertyFeatureRepository->all();

        return view('admin.properties.create', compact('users', 'types', 'features'));
    }

    /**
     * Store a newly created User in storage.
     */
    public function store(CreatePropertyAPIRequest $request)
    {
        $input = $request->all();

        if ($input['show_price_ad'] == 'on') $input['show_price_ad'] = 1;

        $input['property_features'] = implode(',', request()->property_features);

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

                $input['property_id'] = $property->id;
                $data[] = $this->propertyImageRepository->create($input);
            }
        }

        FlashFlash::success('Properties saved successfully.');

        return redirect(route('admin.properties.index'));
    }

    /**
     * Display the specified User.
     */
    public function show($id)
    {
        $property = $this->propertyRepository->with('user')->find($id);

        if (empty($property)) {
            FlashFlash::error('Properties not found');

            return redirect(route('properties.index'));
        }

        return view('admin.properties.view')->with('property', $property);
    }

    /**
     * Show the form for editing the specified User.
     */
    public function edit($id)
    {
        $properties = $this->propertyRepository->find($id);

        $types = $this->propertyTypeRepository->all();

        $users = $this->userRepository->all();

        if (empty($properties)) {
            FlashFlash::error('Properties not found');

            return redirect(route('admin.properties.index'));
        }

        return view('admin.properties.edit', compact('users', 'types'))->with('properties', $properties);
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

        $input['property_features'] = implode(",", request()->property_features ?? []);

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
