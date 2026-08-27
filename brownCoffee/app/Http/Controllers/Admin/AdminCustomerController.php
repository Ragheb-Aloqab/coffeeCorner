<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum(['orders' => function ($q) {
                $q->where('status', '!=', 'cancelled');
            }], 'total_amount')
            ->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum(['orders' => function ($q) {
                $q->where('status', '!=', 'cancelled');
            }], 'total_amount')
            ->with(['orders' => function ($q) {
                $q->orderBy('id', 'desc');
            }])
            ->findOrFail($id);

        return view('admin.customers.show', compact('customer'));
    }

    public function destroy($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'تم حذف حساب العميل بنجاح.');
    }
}
