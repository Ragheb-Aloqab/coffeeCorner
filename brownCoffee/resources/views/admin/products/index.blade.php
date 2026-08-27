@extends('admin.layouts.admin')

@section('title', 'إدارة المنتجات — برون كوفي')

@section('content')
<div class="space-y-6">

  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-[#C8963E] flex items-center gap-2">
        <i class="fa-solid fa-utensils"></i>
        <span>إدارة المنتجات وقائمة الطعام</span>
      </h1>
      <p class="text-sm text-gray-400 mt-1">إضافة وتعديل الأسعار، الصور، وإضافة الماتشا</p>
    </div>

    <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 bg-[#C8963E] text-black font-bold rounded-xl hover:bg-[#DFAC54] transition flex items-center gap-2">
      <i class="fa-solid fa-plus"></i>
      <span>إضافة منتج جديد</span>
    </a>
  </div>

  <!-- Search & Category Filter -->
  <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 bg-[#2C1A1D] p-4 rounded-xl border border-white/10">
    <div class="flex-1 w-full relative">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث باسم المنتج..."
        class="w-full pl-4 pr-10 py-2.5 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
      <i class="fa-solid fa-magnifying-glass absolute right-3 top-3.5 text-gray-400"></i>
    </div>

    <select name="category_id" onchange="this.form.submit()" class="w-full sm:w-48 py-2.5 px-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none">
      <option value="">جميع الأقسام</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name_ar }}</option>
      @endforeach
    </select>

    @if(request('search') || request('category_id'))
      <a href="{{ route('admin.products.index') }}" class="px-3 py-2 text-xs text-gray-400 hover:text-white">إعادة تعيين</a>
    @endif
  </form>

  <!-- Products Grid / Table -->
  <div class="bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
      <table class="custom-table">
        <thead>
          <tr>
            <th>الصورة والمنتج</th>
            <th>القسم</th>
            <th>السعر</th>
            <th>التقييم</th>
            <th>إضافة ماتشا</th>
            <th>الحالة</th>
            <th>إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $product)
            <tr>
              <td>
                <div class="flex items-center gap-3">
                  @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name_ar }}" class="w-12 h-12 rounded-xl object-cover border border-white/10">
                  @else
                    <div class="w-12 h-12 rounded-xl bg-black/40 flex items-center justify-center text-[#C8963E] text-xl border border-white/10">
                      <i class="{{ $product->icon }}"></i>
                    </div>
                  @endif
                  <div>
                    <p class="font-bold text-white">{{ $product->name_ar }}</p>
                    <p class="text-xs text-gray-400 line-clamp-1 max-w-xs">{{ $product->description }}</p>
                  </div>
                </div>
              </td>
              <td>
                <span class="text-xs px-3 py-1 rounded-full font-semibold" style="background-color: {{ $product->category?->color }}22; color: {{ $product->category?->color ?: '#C8963E' }}">
                  {{ $product->category?->name_ar }}
                </span>
              </td>
              <td class="font-bold text-lg text-[#C8963E]">{{ number_format($product->price, 2) }} ر.س</td>
              <td class="text-xs">
                <span class="text-amber-400 font-bold"><i class="fa-solid fa-star"></i> {{ $product->rating }}</span>
                <span class="text-gray-400">({{ $product->reviews_count }})</span>
              </td>
              <td>
                @if($product->has_matcha_addon)
                  <span class="text-xs bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded-full border border-emerald-500/30">
                    <i class="fa-solid fa-leaf"></i> متاحة (+5 ر.س)
                  </span>
                @else
                  <span class="text-xs text-gray-500">—</span>
                @endif
              </td>
              <td>
                @if($product->is_active)
                  <span class="badge-status bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">متاح</span>
                @else
                  <span class="badge-status bg-rose-500/20 text-rose-300 border border-rose-500/30">غير متاح</span>
                @endif
              </td>
              <td>
                <div class="flex items-center gap-2">
                  <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 bg-blue-500/20 text-blue-300 hover:bg-blue-500 hover:text-white rounded-lg text-xs transition">
                    <i class="fa-solid fa-pen"></i>
                  </a>
                  <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من رغبتك بحذف هذا المنتج؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 bg-rose-500/20 text-rose-300 hover:bg-rose-500 hover:text-white rounded-lg text-xs transition">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-12 text-gray-400">لا توجد منتجات تطابق البحث والفلتر</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($products->hasPages())
      <div class="p-4 border-t border-white/10">
        {{ $products->withQueryString()->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
