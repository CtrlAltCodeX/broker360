<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\CreateHelpAPIRequest;
use App\Http\Requests\API\UpdateHelpAPIRequest;
use App\Models\Help;
use App\Repositories\HelpRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

class HelpController extends AppBaseController
{
    private HelpRepository $helpRepository;

    public function __construct(HelpRepository $helpRepo)
    {
        $this->helpRepository = $helpRepo;
    }

    /**
     * Display a listing of the Helps.
     * GET|HEAD /helps
     */
    public function index(Request $request)
    {
        $helps = $this->helpRepository->paginate(10);

        return view('admin.help.index', compact('helps'));
    }

    public function create()
    {
        return view('admin.help.create');
    }

    /**
     * Store a newly created Help in storage.
     * POST /helps
     */
    public function store()
    {
        request()->validate([
            'title' => 'required',
            'desc' => 'required',
        ]);

        $input = request()->all();

        $help = $this->helpRepository->create($input);

        return redirect()->route('help.index');
    }

    /**
     * Display the specified Help.
     * GET|HEAD /helps/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Help $help */
        $help = $this->helpRepository->find($id);

        if (empty($help)) {
            return $this->sendError('Help not found');
        }

        return $this->sendResponse('Help retrieved successfully', $help->toArray());
    }

    public function edit(Help $help)
    {
        return view('admin.help.edit', compact('help'));
    }

    /**
     * Update the specified Help in storage.
     * PUT/PATCH /helps/{id}
     */
    public function update($id, UpdateHelpAPIRequest $request)
    {
        $input = $request->all();

        /** @var Help $help */
        $help = $this->helpRepository->find($id);

        if (empty($help)) {
            return $this->sendError('Help not found');
        }

        $help = $this->helpRepository->update($input, $id);

        return redirect()->route('help.index');
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
        $help = $this->helpRepository->find($id);

        if (empty($help)) {
            return $this->sendError('Help not found');
        }

        $help->delete();

        return redirect()->route('help.index');
    }
}
