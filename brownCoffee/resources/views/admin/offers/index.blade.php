@extends('admin.layouts.admin')

@section('title', 'إدارة العروض — برون كوفي')

@section('content')
<div class="space-y-6">

  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-[#C8963E] flex items-center gap-2">
        <i class="fa-solid fa-tags"></i>
        <span>عروض اليوم والخصومات المميزة</span>
      </h1>
      <p class="text-sm text-gray-400 mt-1">تحديد المنتجات المميزة وقيم الخصومات على الرئيسية</p>
    </div>

    <a href="{{ route('admin.offers.create') }}" class="px-4 py-2.5 bg-[#C8963E] text-black font-bold rounded-xl hover:bg-[#DFAC54] transition flex items-center gap-2">
      <i class="fa-solid fa-plus"></i>
      <span>إضافة عرض جديد</span>
    </a>
  </div>

  <div class="bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
      <table class="custom-table">
        <thead>
          <tr>
            <th>المنتج</th>
            <th>شارة العرض (Badge)</th>
            <th>الوصف الترويجي</th>
            <th>السعر الأصلي</th>
            <th>قيمة الخصم</th>
            <th>السعر النهائي</th>
            <th>إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($offers as $offer)
            <tr>
              <td>
                <div class="flex items-center gap-3">
                  @if($offer->product?->image_url)
                    <img src="{{ $offer->product->image_url }}" alt="{{ $offer->product->name_ar }}" class="w-10 h-10 rounded-xl object-cover">
                  @endif
                  <div>
                    <p class="font-bold text-white">{{ $offer->product?->name_ar }}</p>
                    <p class="text-xs text-gray-400">{{ $offer->product?->category?->name_ar }}</p>
                  </div>
                </div>
              </td>
              <td>
                <span class="text-xs font-bold px-3 py-1 bg-amber-500/20 text-amber-300 rounded-full border border-amber-500/30">
                  <i class="fa-solid fa-fire"></i> {{ $offer->label_ar }}
                </span>
              </td>
              <td class="text-sm text-gray-300">{{ $offer->description }}</td>
              <td class="text-gray-400 line-through">{{ number_format($offer->product?->price ?? 0, 2) }} ر.س</td>
              <td class="font-bold text-rose-400">
                {{ $offer->discount_amount > 0 ? '-' . number_format($offer->discount_amount, 2) . ' ر.س' : 'بدون خصم مباشر' }}
              </td>
              <td class="font-bold text-lg text-[#C8963E]">
                {{ number_format(($offer->product?->price ?? 0) - $offer->discount_amount, 2) }} ر.س
              </td>
              <td>
                <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من إلغاء هذا العرض؟')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="p-2 bg-rose-500/20 text-rose-300 hover:bg-rose-500 hover:text-white rounded-lg text-xs transition">
                    <i class="fa-solid fa-trash"></i> حذف العرض
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-8 text-gray-400">لا توجد عروض مضافة حالياً</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
