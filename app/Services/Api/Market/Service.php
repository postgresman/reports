<?php

namespace App\Services\Api\Market;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class Service
{
    public function list(array $filters): JsonResponse
    {
        $user = \auth()->user();

        if($user->role->name === 'admin') {
            $markets = \App\Models\Market::all();
        } else {
            $markets = \auth()->user()->markets()->get();
        }

        return Response::json([
            'data' => $markets->sortBy('name')->pluck('name', 'id')->map(function ($name, $id) {
                return ['id' => $id, 'name' => $name];
            })->values(),
        ]);
    }
}