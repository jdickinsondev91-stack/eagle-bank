<?php 

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountStoreRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Resources\AccountResource;
use App\Services\AccountService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    public function __construct(
        private AccountService $accountService
    ) {}

    public function index(): JsonResponse
    {
        //TODO - Implementation
        return response()->json(

        );
    }

    public function show(string $accountId): JsonResponse
    {
        try {

            $account = $this->accountService->getById($accountId);

            return response()->json([
                'status' => Response::HTTP_OK,
                'response' => new AccountResource($account)
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
        return response()->json([]);
    }

    public function store(AccountStoreRequest $request): JsonResponse
    {
        //TODO - Implementation
        return response()->json([]);
    }

    public function update(AccountUpdateRequest $request, string $accountId): JsonResponse
    {
        //TODO - Implementation
        return response()->json();
    }

    public function delete(string $accountId): JsonResponse
    {
        //TODO - Implementation
        return response()->json();
    }
}