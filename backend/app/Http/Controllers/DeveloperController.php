<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\DeveloperRequest;
use App\Repositories\DeveloperRepositoryInterface;

class DeveloperController extends Controller
{
    public function __construct(
        private DeveloperRepositoryInterface $developerRepository
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->all();
        $response = $this->developerRepository->search($filters);
        return response()->json($response);
    }

    public function store(DeveloperRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $response = $this->developerRepository->create($data);
            return response()->json($response, 201);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '400',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $response = $this->developerRepository->getById($id);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '404',
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function update(DeveloperRequest $request, $id): JsonResponse
    {
        try {
            $data = $request->validated();
            $response = $this->developerRepository->update($id, $data);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'code' => '400',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function destroy(int $id): Response
    {
        try {
            $response = $this->developerRepository->delete($id);
            return response(null, 204);
        } catch (\Exception $e) {
            return response(null, 400);
        }
    }
}
