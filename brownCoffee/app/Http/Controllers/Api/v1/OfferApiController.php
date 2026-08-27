<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\OfferResource;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;

class OfferApiController extends Controller
{
    public function index(): JsonResponse
    {
        $offers = Offer::where('is_active', true)
            ->with(['product' => function ($q) {
                $q->where('is_active', true);
            }])
            ->get();

        return response()->json([
            'success' => true,
            'data' => OfferResource::collection($offers),
        ]);
    }
}
