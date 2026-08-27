<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $query = Order::with('items')->orderBy('id', 'desc');

        if ($status && in_array($status, ['pending', 'preparing', 'out_for_delivery', 'delivered', 'cancelled'])) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:pending,preparing,out_for_delivery,delivered,cancelled'],
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;

        if ($request->status === 'delivered') {
            $order->payment_status = 'paid';
        }

        $order->save();

        return back()->with('success', "تم تحديث حالة الطلب ({$order->order_number}) بنجاح إلى " . $this->statusLabel($request->status));
    }

    private function statusLabel($status): string
    {
        return match ($status) {
            'pending' => 'قيد الانتظار',
            'preparing' => 'جاري التحضير',
            'out_for_delivery' => 'خرج للتوصيل',
            'delivered' => 'تم التوصيل',
            'cancelled' => 'ملغي',
            default => $status
        };
    }
}
