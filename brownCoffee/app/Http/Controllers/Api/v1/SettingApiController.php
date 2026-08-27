<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SettingApiController extends Controller
{
    public function index(): JsonResponse
    {
        $settings = Setting::all()->pluck('value', 'key');

        return response()->json([
            'success' => true,
            'data' => [
                'min_order_amount' => (float) ($settings['min_order_amount'] ?? 30.00),
                'delivery_time' => $settings['delivery_time'] ?? '30 - 45 دقيقة',
                'store_status' => $settings['store_status'] ?? 'open',
            ],
        ]);
    }
}
