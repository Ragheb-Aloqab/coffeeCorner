@extends('admin.layouts.admin')

@section('title', 'تعديل منتج ' . $product->name_ar . ' — برون كوفي')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-bold text-[#C8963E]">تعديل بيانات المنتج: {{ $product->name_ar }}</h1>
    <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-400 hover:text-white">إلغاء والعودة</a>
  </div>

  <div class="bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl p-6 shadow-xl">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">القسم <span class="text-red-400">*</span></label>
        <select name="category_id" required class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name_ar }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">اسم المنتج بالعربية <span class="text-red-400">*</span></label>
        <input type="text" name="name_ar" value="{{ old('name_ar', $product->name_ar) }}" required
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2">السعر (بالريال السعودي) <span class="text-red-400">*</span></label>
          <input type="number" step="0.5" name="price" value="{{ old('price', $product->price) }}" required
            class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2">أيقونة المنتج (FontAwesome)</label>
          <input type="text" name="icon" value="{{ old('icon', $product->icon) }}"
            class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">وصف المنتج</label>
        <textarea name="description" rows="3"
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">{{ old('description', $product->description) }}</textarea>
      </div>

      <!-- Image Source Selection -->
      <div class="p-4 bg-black/20 rounded-xl border border-white/10 space-y-4">
        <h4 class="text-sm font-semibold text-[#C8963E] flex items-center gap-2">
          <i class="fa-solid fa-image"></i> صورة المنتج الحالية
        </h4>

        @if($product->image_url)
          <div class="flex items-center gap-4">
            <img src="{{ $product->image_url }}" alt="{{ $product->name_ar }}" class="w-16 h-16 rounded-xl object-cover border border-[#C8963E]/40">
            <span class="text-xs text-gray-400">الصورة الحالية مفعلة</span>
          </div>
        @endif

        <div>
          <label class="block text-xs text-gray-300 mb-1">تغيير الصورة عبر الرفع من الجهاز:</label>
          <input type="file" name="image_file" accept="image/*" class="text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#C8963E] file:text-black">
        </div>

        <div class="text-center text-xs text-gray-500">— أو استبدال الرابط —</div>

        <div>
          <input type="url" name="image" value="{{ old('image', $product->image) }}"
            class="w-full px-4 py-2.5 bg-black/40 border border-white/10 rounded-xl text-sm text-white focus:outline-none focus:border-[#C8963E]">
        </div>
      </div>

      <!-- Toggles -->
      <div class="space-y-3 pt-2">
        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-300">
          <input type="checkbox" name="has_matcha_addon" value="1" {{ $product->has_matcha_addon ? 'checked' : '' }} class="accent-[#C8963E] w-5 h-5 rounded">
          <span>إتاحة خيار (إضافة ماتشا اليابانية + 5 ر.س) للمشتري</span>
        </label>

        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-300">
          <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="accent-[#C8963E] w-5 h-5 rounded">
          <span>تفعيل المنتج وإظهاره فوراً للمسخدمين وتطبيق فلاتر</span>
        </label>
      </div>

      <button type="submit" class="w-full py-3.5 bg-[#C8963E] hover:bg-[#DFAC54] text-black font-bold rounded-xl transition text-lg mt-4">
        تحديث المنتج
      </button>
    </form>
  </div>

</div>
@endsection
