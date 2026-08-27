<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminOfferController extends Controller
{
    public function index()
    {
        $offers = Offer::with('product')->orderBy('id', 'desc')->get();
        return view('admin.offers.index', compact('offers'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.offers.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'label_ar' => ['required', 'string', 'max:255'],
            'discount_amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Offer::create($validated);

        return redirect()->route('admin.offers.index')->with('success', 'تم إضافة العرض الترويجي بنجاح!');
    }

    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();

        return redirect()->route('admin.offers.index')->with('success', 'تم حذف العرض بنجاح!');
    }
}
