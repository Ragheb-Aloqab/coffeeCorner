@extends('admin.layouts.admin')

@section('title', 'إعدادات النظام والتوصيل — برون كوفي')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-[#C8963E] flex items-center gap-2">
        <i class="fa-solid fa-sliders"></i>
        <span>إعدادات النظام والتوصيل</span>
      </h1>
      <p class="text-sm text-gray-400 mt-1">تحديد الحد الأدنى للطلب، وقت التوصيل، وحالة المحل</p>
    </div>
  </div>

  <div class="bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl p-6 shadow-xl">
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
      @csrf

      <!-- Min Order Amount -->
      <div>
        <label class="block text-sm font-semibold text-gray-200 mb-2 flex items-center gap-2">
          <i class="fa-solid fa-[#C8963E] fa-circle-exclamation text-[#C8963E]"></i>
          <span>الحد الأدنى للطلب (بالريال السعودي)</span>
        </label>
        <div class="relative">
          <input type="number" step="1" name="min_order_amount" value="{{ old('min_order_amount', $minOrderAmount) }}" required
            class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E] text-lg font-bold">
          <span class="absolute left-4 top-3.5 text-gray-400 text-sm">ر.س</span>
        </div>
        <p class="text-xs text-gray-400 mt-1.5">يتم تطبيق هذا الحد الأدنى في السلة وعند إنشاء الطلبات بالـ API تلقائياً.</p>
      </div>

      <!-- Delivery Time -->
      <div>
        <label class="block text-sm font-semibold text-gray-200 mb-2 flex items-center gap-2">
          <i class="fa-regular fa-clock text-[#C8963E]"></i>
          <span>مدة التوصيل المتوقعة</span>
        </label>
        <input type="text" name="delivery_time" value="{{ old('delivery_time', $deliveryTime) }}" required
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]"
          placeholder="مثال: 30 - 45 دقيقة">
      </div>

      <!-- Store Status -->
      <div>
        <label class="block text-sm font-semibold text-gray-200 mb-2 flex items-center gap-2">
          <i class="fa-solid fa-store text-[#C8963E]"></i>
          <span>حالة استقبال الطلبات بالمحل</span>
        </label>
        <select name="store_status" class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
          <option value="open" {{ $storeStatus === 'open' ? 'selected' : '' }}>🟢 المحل مفتوح ويستقبل الطلبات</option>
          <option value="closed" {{ $storeStatus === 'closed' ? 'selected' : '' }}>🔴 المحل مغلق حالياً</option>
        </select>
      </div>

      <button type="submit" class="w-full py-3.5 bg-[#C8963E] hover:bg-[#DFAC54] text-black font-bold rounded-xl transition text-lg mt-4 flex items-center justify-center gap-2">
        <i class="fa-solid fa-floppy-disk"></i>
        <span>حفظ التغييرات بالإعدادات</span>
      </button>
    </form>
  </div>

</div>
@endsection
