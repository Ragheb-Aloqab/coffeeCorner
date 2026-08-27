<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->orderBy('id', 'desc');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where('name_ar', 'like', "%{$search}%");
        }

        $products = $query->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable'],
            'image_file' => ['nullable', 'image', 'max:2048'],
            'icon' => ['nullable', 'string'],
            'has_matcha_addon' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $validated['image'] = $path;
        } elseif ($request->filled('image')) {
            $validated['image'] = $request->image;
        }

        $validated['has_matcha_addon'] = $request->boolean('has_matcha_addon');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['icon'] = $request->input('icon', 'fa-solid fa-mug-hot');

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'تم إضافة المنتج بنجاح!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable'],
            'image_file' => ['nullable', 'image', 'max:2048'],
            'icon' => ['nullable', 'string'],
            'has_matcha_addon' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            if ($product->image && ! str_starts_with($product->image, 'http')) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image_file')->store('products', 'public');
            $validated['image'] = $path;
        } elseif ($request->filled('image')) {
            $validated['image'] = $request->image;
        }

        $validated['has_matcha_addon'] = $request->boolean('has_matcha_addon');
        $validated['is_active'] = $request->boolean('is_active');

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'تم تحديث بيانات المنتج بنجاح!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'تم حذف المنتج بنجاح!');
    }
}
