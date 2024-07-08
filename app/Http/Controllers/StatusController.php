<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Resources\StatusResource;
use App\Http\Resources\StatusCollection;
use App\Models\Status;
use App\Services\StatusService;

class StatusController
{
    private $statusService;

    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    public function index(Request $request)
    {
        $statuses = Status::all();

        if ($statuses) {
            return new JsonResponse(['success' => true, 'data' => (new StatusCollection($statuses))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }

    public function show(Request $request, $id)
    {
        $status = $this->statusService->getStatus($id);

        if ($status) {
            return new JsonResponse(['success' => true, 'data' => (new StatusResource($status))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }
}
