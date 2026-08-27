@extends('admin.layouts.admin')

@section('title', 'تفاصيل الطلب ' . $order->order_number . ' — برون كوفي')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

  <!-- Top bar -->
  <div class="flex items-center justify-between">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-400 hover:text-[#C8963E] flex items-center gap-2">
      <i class="fa-solid fa-arrow-right"></i>
      <span>العودة لجدول الطلبات</span>
    </a>

    <div class="flex items-center gap-3">
      <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="flex items-center gap-2">
        @csrf
        @method('PATCH')
        <label class="text-sm text-gray-300">تحديث الحالة:</label>
        <select name="status" onchange="this.form.submit()" class="py-2 px-4 rounded-xl text-sm font-bold bg-[#2C1A1D] border border-[#C8963E]/40 text-[#C8963E]">
          <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
          <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>جاري التحضير</option>
          <option value="out_for_delivery" {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}>خرج للتوصيل</option>
          <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
          <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>ملغي</option>
        </select>
      </form>
    </div>
  </div>

  <!-- Order Receipt Card -->
  <div class="bg-[#2C1A1D] border border-[#C8963E]/30 rounded-2xl p-6 md:p-8 space-y-6">

    <!-- Order Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 border-b border-white/10 gap-4">
      <div>
        <span class="text-xs font-bold text-[#C8963E] bg-[#C8963E]/10 px-3 py-1 rounded-full border border-[#C8963E]/20">فاتورة طلب برون كوفي</span>
        <h2 class="text-3xl font-bold text-white mt-2">{{ $order->order_number }}</h2>
        <p class="text-xs text-gray-400 mt-1">تاريخ إنشاء الطلب: {{ $order->created_at->format('Y-m-d — h:i A') }}</p>
      </div>

      <div class="text-left">
        <p class="text-xs text-gray-400">الإجمالي النهائي</p>
        <h3 class="text-3xl font-bold text-[#C8963E]">{{ number_format($order->total_amount, 2) }} <small class="text-sm">ر.س</small></h3>
      </div>
    </div>

    <!-- Customer Details & Delivery Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-black/30 rounded-xl border border-white/5">
      <div>
        <h4 class="text-sm font-semibold text-gray-400 mb-2 flex items-center gap-2">
          <i class="fa-solid fa-user text-[#C8963E]"></i> بيانات العميل
        </h4>
        <p class="text-base font-bold text-white">{{ $order->customer_name }}</p>
        <p class="text-sm text-gray-300 mt-1" dir="ltr" style="text-align: right;"><i class="fa-solid fa-phone text-xs"></i> {{ $order->customer_phone }}</p>
      </div>

      <div>
        <h4 class="text-sm font-semibold text-gray-400 mb-2 flex items-center gap-2">
          <i class="fa-solid fa-location-dot text-[#C8963E]"></i> عنوان والتجهيز
        </h4>
        <p class="text-sm text-gray-200">{{ $order->delivery_address ?: 'توصيل لباب البيت (Express Delivery)' }}</p>
        @if($order->notes)
          <p class="text-xs text-amber-300 bg-amber-500/10 p-2 rounded-lg mt-2"><i class="fa-solid fa-note-sticky"></i> ملاحظة: {{ $order->notes }}</p>
        @endif
      </div>
    </div>

    <!-- Line Items Table -->
    <div>
      <h4 class="text-base font-bold text-white mb-4 flex items-center gap-2">
        <i class="fa-solid fa-basket-shopping text-[#C8963E]"></i> عناصر السلة للطلب
      </h4>

      <div class="overflow-x-auto">
        <table class="custom-table">
          <thead>
            <tr>
              <th>المنتج</th>
              <th>السعر الفردي</th>
              <th>الكمية</th>
              <th>الإضافات</th>
              <th>المجموع</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->items as $item)
              <tr>
                <td class="font-semibold text-white">{{ $item->product_name }}</td>
                <td>{{ number_format($item->unit_price, 2) }} ر.س</td>
                <td class="font-bold">×{{ $item->quantity }}</td>
                <td>
                  @if(!empty($item->addon_details['matcha']))
                    <span class="text-xs bg-emerald-500/20 text-emerald-300 px-2.5 py-1 rounded-full border border-emerald-500/30">
                      <i class="fa-solid fa-leaf"></i> إضافة ماتشا (+5.00 ر.س)
                    </span>
                  @else
                    <span class="text-xs text-gray-500">بدون إضافات</span>
                  @endif
                </td>
                <td class="font-bold text-[#C8963E]">{{ number_format($item->line_total, 2) }} ر.س</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Calculation Footer -->
    <div class="pt-4 border-t border-white/10 flex flex-col items-end space-y-2 text-sm">
      <div class="flex justify-between w-full max-w-xs text-gray-400">
        <span>المجموع الفرعي:</span>
        <span class="text-white font-semibold">{{ number_format($order->subtotal, 2) }} ر.س</span>
      </div>
      <div class="flex justify-between w-full max-w-xs text-gray-400">
        <span>خدمة التوصيل:</span>
        <span class="text-emerald-400 font-semibold">مكفولة (مجاناً)</span>
      </div>
      <div class="flex justify-between w-full max-w-xs text-lg font-bold text-[#C8963E] pt-2 border-t border-white/10">
        <span>المجموع الإجمالي:</span>
        <span>{{ number_format($order->total_amount, 2) }} ر.س</span>
      </div>
    </div>

  </div>

</div>
@endsection
