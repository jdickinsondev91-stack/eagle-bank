<?php

namespace App\Http\Controllers\V1;

use App\DTOs\AddressDTO;
use App\DTOs\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'This feature is not yet implemented.'
        ], Response::HTTP_NOT_IMPLEMENTED);
    }

    public function show(string $id): JsonResponse
    {
        try {
            $user = $this->userService->getById($id);

            return response()->json([
                'status' => Response::HTTP_OK,
                'response' => new UserResource($user)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function store(UserStoreRequest $request)
    {
        $userDto = UserDTO::create($request->validated());
        $addressDto = AddressDTO::create($request->input('address'));

        $user = $this->userService->createUser($userDto, $addressDto);
        
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'response' => new UserResource($user)
        ], Response::HTTP_CREATED);
    }

    //Request Object && ID
    public function update()
    {

    }

    //ID
    public function destroy() 
    {

    }
}