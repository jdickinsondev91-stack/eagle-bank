<?php 

namespace App\Http\Controllers\V1;

use App\DTOs\TransactionDTO;
use App\Exceptions\InsufficientFundsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\TransactionResource;
use App\Services\Transactions\TransactionService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionService $transactionService
    ) {}

    public function store(TransactionStoreRequest $request, string $accountId): JsonResponse
    {
        try {
            $transaction = $this->transactionService->createTransaction(
                TransactionDTO::createFromRequestArray($request->validated()),
                $accountId
            );

            return response()->json([
                'status' => Response::HTTP_CREATED,
                'response' => new TransactionResource($transaction)
            ], Response::HTTP_CREATED);
            
        } catch (InsufficientFundsException $e) {
            return response()->json([
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $e->getMessage()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}