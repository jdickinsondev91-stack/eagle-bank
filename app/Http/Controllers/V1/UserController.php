<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
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
        $user = $this->userService->getById($id);
        return response()->json([
            'status' => Response::HTTP_OK,
            'response' => new UserResource($user)
        ]);
    }

    //Request Object
    public function store()
    {

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