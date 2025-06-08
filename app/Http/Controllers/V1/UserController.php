<?php

namespace App\Http\Controllers\V1;

use App\DTOs\AddressDTO;
use App\DTOs\UserDTO;
use App\Exceptions\HasAccountsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use AuthorizesRequests;

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

            $this->authorize('view', $user);

            return response()->json([
                'status' => Response::HTTP_OK,
                'response' => new UserResource($user)
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (AuthorizationException $e) {
            return response()->json([
                'status' => Response::HTTP_FORBIDDEN,
                'message' => 'Unauthorized access to user data.'
            ], Response::HTTP_FORBIDDEN);
        }
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $userDto = UserDTO::create($request->validated());
        $addressDto = AddressDTO::create($request->input('address'));

        $user = $this->userService->createUser($userDto, $addressDto);
        
        return response()->json([
            'status' => Response::HTTP_CREATED,
            'response' => new UserResource($user)
        ], Response::HTTP_CREATED);
    }

    public function update(UserUpdateRequest $request, string $userId): JsonResponse
    {
        $userDto = UserDTO::create(array_merge($request->validated(), ['id' => $userId]));
        $addressDto = AddressDTO::create($request->input('address'));

        try {
            $user = $this->userService->updateUser($userDto, $addressDto);      
        
            return response()->json([
                'status' => Response::HTTP_OK,
                'response' => new UserResource($user)
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy(string $userId): JsonResponse 
    {
        try {
            $this->userService->deleteUser($userId);

            return response()->json([
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        } catch (HasAccountsException $e) {
            return response()->json([
                'status' => Response::HTTP_CONFLICT,
                'message' => $e->getMessage()
            ], Response::HTTP_CONFLICT);
        }
    }
}