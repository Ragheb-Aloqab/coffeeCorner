<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'delivery_address' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.addon_matcha' => ['nullable', 'boolean'],
            'payment_method' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $minOrder = (float) Setting::get('min_order_amount', 30.00);
        $subtotal = 0.00;
        $orderItemsData = [];

        foreach ($request->items as $itemData) {
            $product = Product::find($itemData['product_id']);
            if (! $product || ! $product->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => "المنتج رقم {$itemData['product_id']} غير متاح حالياً",
                ], 422);
            }

            $matchaAdded = ! empty($itemData['addon_matcha']) && $product->has_matcha_addon;
            $unitPrice = (float) $product->price + ($matchaAdded ? 5.00 : 0.00);
            $qty = (int) $itemData['quantity'];
            $lineTotal = $unitPrice * $qty;

            $subtotal += $lineTotal;

            $orderItemsData[] = [
                'product_id' => $product->id,
                'product_name' => $product->name_ar,
                'unit_price' => $unitPrice,
                'quantity' => $qty,
                'addon_details' => $matchaAdded ? ['matcha' => true, 'price' => 5.00] : null,
                'line_total' => $lineTotal,
            ];
        }

        if ($subtotal < $minOrder) {
            return response()->json([
                'success' => false,
                'message' => "الحد الأدنى للطلب هو {$minOrder} ر.س. يرجى إضافة عناصر بقيمة " . number_format($minOrder - $subtotal, 2) . " ر.س للمتابعة.",
            ], 422);
        }

        $orderNumber = Order::generateOrderNumber();
        $user = $request->user('sanctum');

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => $user?->id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'delivery_address' => $request->delivery_address ?? 'توصيل لباب البيت',
            'subtotal' => $subtotal,
            'discount' => 0.00,
            'delivery_fee' => 0.00,
            'total_amount' => $subtotal,
            'status' => 'pending',
            'payment_method' => $request->payment_method ?? 'cash',
            'payment_status' => 'pending',
            'notes' => $request->notes,
        ]);

        foreach ($orderItemsData as $item) {
            $item['order_id'] = $order->id;
            OrderItem::create($item);
        }

        $order->load('items');

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء الطلب بنجاح وهو قيد الانتظار',
            'data' => new OrderResource($order),
        ], 201);
    }

    public function index(Request $request): JsonResponse
    {
        $user = $request->user('sanctum');

        if ($user) {
            $orders = Order::where('user_id', $user->id)->with('items')->orderBy('id', 'desc')->get();
        } elseif ($request->filled('phone')) {
            $orders = Order::where('customer_phone', $request->phone)->with('items')->orderBy('id', 'desc')->get();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'يرجى تقديم رقم الهاتف أو تسجيل الدخول لعرض الطلبات',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => OrderResource::collection($orders),
        ]);
    }

    public function show($orderNumber): JsonResponse
    {
        $order = Order::where('order_number', $orderNumber)->with('items')->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new OrderResource($order),
        ]);
    }
}
