<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Mail\OtpMail;
use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\Collaboration;
use App\Repositories\PermissionRepository;
use Illuminate\Http\UploadedFile;

/**
 * Class UserAPIController
 */
class UserAPIController extends AppBaseController
{
    public function __construct(
        public UserRepository $userRepository,
        public PermissionRepository $permissionRepository,
    ) {}

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Display a listing of the Users",
     *     description="Retrieve a list of users with optional pagination",
     *     operationId="getUsersList",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="skip",
     *         in="query",
     *         description="Number of records to skip for pagination",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of records to return",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Users retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *                 @OA\Property(property="number", type="string", example="+123456789"),
     *                 @OA\Property(property="agency_name", type="string", example="Agency XYZ"),
     *                 @OA\Property(property="lang", type="string", example="en"),
     *                 @OA\Property(property="timezone", type="string", example="UTC"),
     *                 @OA\Property(property="profile_url", type="string", example="http://example.com/profile.jpg")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $users = $this->userRepository->all(
            ['*'],
            $request->get('skip'),
            $request->get('limit')
        );

        $userData = [];
        foreach ($users as $key => $user) {
            $isExists = Collaboration::where('agent_id', $user->id)
                ->where('user_id', 1)
                ->exists();

            $userData[] = $user;
            $userData[$key]['collaboration'] = $isExists;
        }

        return $this->sendResponse('Users retrieved successfully', $userData);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="number", type="string", example="987654321"),
     *             @OA\Property(property="password", type="string", example="admin123"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="user@example.com"),
     *                     @OA\Property(property="number", type="string", example="user@example.com"),
     *                     @OA\Property(property="password", type="string", example="admin123"),
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="User registered successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid input data")
     *         )
     *     )
     * )
     * 
     *   @OA\Info(
     *     title="API Documentation",
     *     version="1.0.0",
     *     description="API documentation for the login endpoint",
     *     @OA\Contact(
     *         email="contact@example.com"
     *     )
     * )
     */
    public function store(CreateUserAPIRequest $request): JsonResponse
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'number' => 'required',
            'password' => 'required',
        ]);

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = $this->userRepository->create($input);

        $this->permissionRepository->create([
            'real_estate' => 'on',
            'publish_property' => 0,
            'website' => 0,
            'user_id' => $user->id,
            'plan_id' => 1,
        ]);

        return $this->sendResponse('User saved successfully', $user->toArray());
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Retrieve a user by ID",
     *     description="Retrieve a user by their unique ID",
     *     operationId="getUserById",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ),
     *         description="The ID of the user to retrieve"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User retrieved successfully",
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
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Updated User"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="user@example.com"
     *                 ),
     *                 @OA\Property(
     *                     property="number",
     *                     type="integer",
     *                     example=987456321
     *                 ),
     *                 @OA\Property(
     *                     property="agency_name",
     *                     type="string",
     *                     example="Example Agency"
     *                 ),
     *                 @OA\Property(
     *                     property="lang",
     *                     type="string",
     *                     example="English"
     *                 ),
     *                 @OA\Property(
     *                     property="timezone",
     *                     type="string",
     *                     example="Timezone"
     *                 ),
     *                 @OA\Property(
     *                     property="profile_url",
     *                     type="object",
     *                     additionalProperties={},
     *                     example={}
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="User retrieved successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
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
     *                 example="User not found"
     *             )
     *         )
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->with('permissions.plan')->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse('User retrieved successfully', $user->toArray());
    }

    /**
     * @OA\Post(
     *     path="/api/users/{id}",
     *     summary="Update the specified User in storage.",
     *     operationId="updateUser",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the user to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             ref="#/components/schemas/UpdateUserAPIRequest"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 type="object",
     *                 example={"success":true, "data":{"id":1, "name":"Updated User", "email":"user@example.com"}, "message":"User updated successfully"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 type="object",
     *                 example={"success":false, "message":"User not found"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 type="object",
     *                 example={"success":false, "message":"Bad request"}
     *             )
     *         )
     *     )
     * )
     * 
     * /**
     * @OA\Schema(
     *     schema="UpdateUserAPIRequest",
     *     type="object",
     *     required={"name", "email"},
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Updated User"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         example="user@example.com"
     *     ),
     *     @OA\Property(
     *         property="number",
     *         type="integer",
     *         example="987456321"
     *     ),
     *     @OA\Property(
     *         property="agency_name",
     *         type="string",
     *         example="Example Agency"
     *     ),
     *     @OA\Property(
     *         property="lang",
     *         type="string",
     *         example="English"
     *     ),
     *     @OA\Property(
     *         property="timezone",
     *         type="string",
     *         example="Timezone"
     *     ),
     *     @OA\Property(
     *         property="profile_url",
     *         type="object",
     *         example="{}"
     *     ),
     * )
     */
    public function update($id, UpdateUserAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        if ($file = $request->file('profile_url')) {
            if ($file instanceof UploadedFile) {
                $profileImage = time() . "." . $file->getClientOriginalExtension();

                $file->move('storage/profile/', $profileImage);

                $input['profile_url'] = "/storage/profile/" . "$profileImage";
            }
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse('User updated successfully', $user->toArray());
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendResponse('User deleted successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="JWT token"),
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="user@example.com")
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="User login successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid email or password")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only(['email', 'password'])))
            return $this->sendError('Unauthorized');

        $success['token'] = auth()->user()->createToken('test')->plainTextToken;
        $success['user'] = $this->userRepository->with('permissions.plan')->find(auth()->user()->id);

        return $this->sendResponse('User Login Successfully', $success);
    }

    /**
     * @OA\Post(
     *     path="/api/forget-password",
     *     summary="Send OTP to email for password reset",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OTP sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="OTP sent successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Email does not exist")
     *         )
     *     )
     * )
     */
    public function forgetPassword()
    {
        request()->validate([
            'email' => 'required'
        ]);

        $user = User::where('email', request()->email)->first();

        if (!$user)
            return $this->sendError('Email Does not exist');

        $otp = $this->generateOTP(4);

        Mail::to(request()->email)->send(new OtpMail($otp));

        $user->update(['otp' => $otp]);

        return $this->sendResponse('OTP send Successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/reset-password",
     *     summary="Reset password using OTP",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="otp", type="string", example="1234"),
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password successfully changed",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Password successfully changed")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Email does not exist")
     *         )
     *     )
     * )
     */
    public function resetPassword()
    {
        request()->validate([
            'otp' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', request()->email)
            ->first();

        if (!$user)
            return $this->sendError('Email Does not exist');

        $userWithOTP = User::where('email', request()->email)
            // ->where('status', 1)
            ->where('otp', request()->otp)
            ->first();

        if (!$userWithOTP)
            return $this->sendError('Invalid OTP');

        $userWithOTP->update(['password' => Hash::make(request()->password)]);

        return $this->sendResponse('Password Successfully changed');
    }

    /**
     * Generate Random Digits
     *
     * @return int
     */
    public function generateOTP($n)
    {
        $generator = "1357902468";
        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, rand() % strlen($generator), 1);
        }

        // Returning the result
        return $result;
    }

    /**
     * @OA\Get(
     *     path="/api/current/user",
     *     summary="Get Current User",
     *     description="Returns the current authenticated user",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Current User",
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
     *                 @OA\Property(property="user", type="object",
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         example="Updated User"
     *     ),
     *     @OA\Property(
     *         property="email",
     *         type="string",
     *         example="user@example.com"
     *     ),
     *     @OA\Property(
     *         property="number",
     *         type="integer",
     *         example="987456321"
     *     ),
     *     @OA\Property(
     *         property="agency_name",
     *         type="string",
     *         example="Example Agency"
     *     ),
     *     @OA\Property(
     *         property="lang",
     *         type="string",
     *         example="English"
     *     ),
     *     @OA\Property(
     *         property="timezone",
     *         type="string",
     *         example="Timezone"
     *     ),
     *     @OA\Property(
     *         property="profile_url",
     *         type="object",
     *         example="{}"
     *     ),
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Current User"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Please Login!!",
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
     *                 example="Please Login!!"
     *             )
     *         )
     *     )
     * )
     */
    public function currentUser()
    {
        if (!auth()->check()) return $this->sendError('Please Login!!');

        $user = $this->userRepository->with('permissions.plan')->find(auth()->user()->id);

        return $this->sendResponse('Current User', $user);
    }

    /**
     * @OA\Put(
     *     path="/api/update/template",
     *     summary="Update user template",
     *     description="Updates the template ID for the authenticated user",
     *     operationId="updateTemplate",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="template_id",
     *         in="query",
     *         required=true,
     *         description="Template ID to be updated",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Template Updated",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Template Updated"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function updateTemplate()
    {
        $this->userRepository->update(['template' => request()->template_id], auth()->user()->id);

        return $this->sendResponse('Template Updated', auth()->user());
    }
}
