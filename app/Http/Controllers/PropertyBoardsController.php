<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatePropertyAPIRequest;
use App\Http\Requests\API\CreatePropertyBoardsAPIRequest;
use App\Repositories\PropertyBoardsRepository;
use App\Repositories\PropertyRepository;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash as FlashFlash;

class PropertyBoardsController extends AppBaseController
{
    /** @var PropertyRepository $propertyRepository*/
    private $propertyboardRepo;

    public function __construct(PropertyBoardsRepository $propertyboardRepo)
    {
        $this->propertyboardRepo = $propertyboardRepo;
    }

    /**
     * Display a listing of the User.
     */
    public function index(Request $request)
    {
        $boards = $this->propertyboardRepo->paginate(10);

        return view('admin.property-board.index')
            ->with('boards', $boards);
    }

    /**
     * Show the form for creating a new User.
     */
    public function create()
    {
        return view('admin.property-board.create');
    }

    /**
     * Store a newly created User in storage.
     */
    public function store(CreatePropertyBoardsAPIRequest $request)
    {
        $input = $request->all();

        $this->propertyboardRepo->create($input);

        FlashFlash::success('Boards saved successfully.');

        return redirect(route('admin.boards.index'));
    }

    /**
     * Display the specified User.
     */
    public function show($id)
    {
        $coontact = $this->propertyboardRepo->find($id);

        if (empty($coontact)) {
            FlashFlash::error('Properties not found');

            return redirect(route('boards.index'));
        }

        return view('boards.show')->with('coontact', $coontact);
    }

    /**
     * Show the form for editing the specified User.
     */
    public function edit($id)
    {
        $boards = $this->propertyboardRepo->find($id);

        if (empty($boards)) {
            FlashFlash::error('Boards not found');

            return redirect(route('admin.boards.index'));
        }

        return view('admin.property-board.edit')->with('boards', $boards);
    }

    /**
     * Update the specified User in storage.
     */
    public function update($id, CreatePropertyBoardsAPIRequest $request)
    {
        $boards = $this->propertyboardRepo->find($id);

        if (empty($boards)) {
            FlashFlash::error('Properties not found');

            return redirect(route('admin.boards.index'));
        }

        $boards = $this->propertyboardRepo->update($request->all(), $id);

        FlashFlash::success('Properties updated successfully.');

        return redirect(route('admin.boards.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $boards = $this->propertyboardRepo->find($id);

        if (empty($boards)) {
            FlashFlash::error('Properties not found');

            return redirect(route('boards.index'));
        }

        $this->propertyboardRepo->delete($id);

        FlashFlash::success('Properties deleted successfully.');

        return redirect(route('admin.boards.index'));
    }
}
