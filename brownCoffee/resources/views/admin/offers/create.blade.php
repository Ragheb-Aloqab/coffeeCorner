@extends('admin.layouts.admin')

@section('title', 'إضافة عرض جديد — برون كوفي')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-bold text-[#C8963E]">إضافة عرض ترويجي جديد</h1>
    <a href="{{ route('admin.offers.index') }}" class="text-sm text-gray-400 hover:text-white">إلغاء والعودة</a>
  </div>

  <div class="bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl p-6 shadow-xl">
    <form action="{{ route('admin.offers.store') }}" method="POST" class="space-y-5">
      @csrf

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">اختر المنتج <span class="text-red-400">*</span></label>
        <select name="product_id" required class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
          <option value="">اختر المنتج المتاح</option>
          @foreach($products as $p)
            <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name_ar }} — ({{ number_format($p->price, 2) }} ر.س)</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">عنوان/شارة العرض <span class="text-red-400">*</span></label>
        <input type="text" name="label_ar" value="{{ old('label_ar', 'عرض اليوم') }}" required
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]"
          placeholder="مثال: عرض اليوم، الأكثر طلباً، أفضل قيمة">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">قيمة الخصم (بالريال السعودي)</label>
        <input type="number" step="0.5" name="discount_amount" value="{{ old('discount_amount', 0) }}" required
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]"
          placeholder="أدخل 0 إذا كان العرض بدون خصم مباشر">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">وصف العرض التشويقي</label>
        <textarea name="description" rows="3"
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]"
          placeholder="مثال: استمتع بكابتشينو برون كوفي المُعَد بعناية فائقة بخصم خاص اليوم">{{ old('description') }}</textarea>
      </div>

      <button type="submit" class="w-full py-3.5 bg-[#C8963E] hover:bg-[#DFAC54] text-black font-bold rounded-xl transition text-lg mt-4">
        تفعيل وإضافة العرض
      </button>
    </form>
  </div>

</div>
@endsection
