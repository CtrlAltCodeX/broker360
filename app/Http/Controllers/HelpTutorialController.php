<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\UpdateHelpAPIRequest;
use App\Models\Help;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\HelpTutorial;
use App\Repositories\HelpTutorialRepository;

class HelpTutorialController extends AppBaseController
{
    public function __construct(public HelpTutorialRepository $helpTutorialRepository) {}

    /**
     * Display a listing of the Helps.
     * GET|HEAD /helps
     */
    public function index(Request $request)
    {
        $helps = $this->helpTutorialRepository->paginate(10);

        return view('admin.help_tutorial.index', compact('helps'));
    }

    public function create()
    {
        return view('admin.help_tutorial.create');
    }

    /**
     * Store a newly created Help in storage.
     * POST /helps
     */
    public function store()
    {
        request()->validate([
            'title' => 'required',
            'link' => 'required',
        ]);

        $input = request()->all();

        $help = $this->helpTutorialRepository->create($input);

        return redirect()->route('help_tutorial.index');
    }

    /**
     * Display the specified help_tutorial.
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

    public function edit($id)
    {
        $help = $this->helpTutorialRepository->find($id);

        return view('admin.help_tutorial.edit', compact('help'));
    }

    /**
     * Update the specified Help in storage.
     * PUT/PATCH /helps/{id}
     */
    public function update($id)
    {
        $input = request()->all();

        /** @var Help $help */
        $help = $this->helpTutorialRepository->find($id);

        if (empty($help)) {
            return $this->sendError('Help not found');
        }

        $help = $this->helpTutorialRepository->update($input, $id);

        return redirect()->route('help_tutorial.index');
    }

    /**
     * Remove the specified Help from storage.
     * DELETE /helps/{id}
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Help $help */
        $help = $this->helpTutorialRepository->find($id);

        if (empty($help)) {
            return $this->sendError('Help not found');
        }

        $help->delete();

        return redirect()->route('help_tutorial.index');
    }
}
