<?php

namespace App\Http\Controllers;

use App\Http\Requests\API\CreatePlanAPIRequest;
use App\Http\Requests\API\UpdatePlanAPIRequest;
use App\Models\Plan;
use App\Repositories\PlanRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PermissionRepository;
use App\Repositories\UserRepository;

/**
 * Class PlanAPIController
 */
class PlanController extends AppBaseController
{
    public function __construct(
        public PlanRepository $planRepository,
        public PermissionRepository $permissionRepository,
        public UserRepository $usersRepository
    ) {
    }

    /**
     * Index Function 
     */
    public function index(Request $request)
    {
        $plans = $this->planRepository->paginate(20);

        return view('admin.plans.index')
            ->with('plans', $plans);
    }

    /**
     * Show the form for creating a new User.
     */
    public function create()
    {
        $users = $this->usersRepository->all();

        return view('admin.plans.create', compact('users'));
    }

    public function store()
    {
        $input = request()->all();

        $plan = $this->planRepository->create($input);

        return redirect()->route('admin.plans.index')->with('success', 'Successfully Created');
    }

    /**
     * Display the specified Plan.
     * GET|HEAD /plans/{id}
     */
    public function show($id)
    {
        /** @var Plan $plan */
        $plan = $this->planRepository->find($id);

        if (empty($plan)) {
            return $this->sendError('Plan not found');
        }

        return $this->sendResponse($plan->toArray(), 'Plan retrieved successfully');
    }

    public function edit($id)
    {
        $plans = $this->planRepository->find($id);

        $users = $this->usersRepository->all();

        if (empty($plans)) {
            FlashFlash::error('plans not found');

            return redirect(route('admin.plans.index'));
        }

        return view('admin.plans.edit', compact('users', 'plans'));
    }

    /**
     * Update the specified Plan in storage.
     * PUT/PATCH /plans/{id}
     */
    public function update($id, UpdatePlanAPIRequest $request)
    {
        $input = $request->all();

        /** @var Plan $plan */
        $plan = $this->planRepository->find($id);

        if (empty($plan)) {
            return $this->sendError('Plan not found');
        }

        $plan = $this->planRepository->update($input, $id);

        return redirect()->route('admin.plans.index')->with('success', 'Successfully Updated');
    }

    /**
     * Remove the specified Plan from storage.
     * DELETE /plans/{id}
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Plan $plan */
        $plan = $this->planRepository->find($id);

        if (empty($plan)) {
            return $this->sendError('Plan not found');
        }

        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Successfully Deleted');
    }
}
