<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $preparingOrders = Order::where('status', 'preparing')->count();
        $activeProductsCount = Product::where('is_active', true)->count();
        $categoriesCount = Category::count();
        $offersCount = Offer::where('is_active', true)->count();
        $customersCount = User::where('role', 'customer')->count();

        $recentOrders = Order::with('items')->orderBy('id', 'desc')->take(6)->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'pendingOrders',
            'preparingOrders',
            'activeProductsCount',
            'categoriesCount',
            'offersCount',
            'customersCount',
            'recentOrders'
        ));
    }
}
