@extends('admin.layouts.admin')

@section('title', 'بيانات العميل ' . $customer->name . ' — برون كوفي')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <!-- Top bar -->
  <div class="flex items-center justify-between">
    <a href="{{ route('admin.customers.index') }}" class="text-sm text-gray-400 hover:text-[#C8963E] flex items-center gap-2">
      <i class="fa-solid fa-arrow-right"></i>
      <span>العودة لجدول العملاء</span>
    </a>
  </div>

  <!-- Customer Overview Card -->
  <div class="bg-[#2C1A1D] border border-[#C8963E]/30 rounded-2xl p-6 md:p-8 space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between pb-6 border-b border-white/10 gap-4">
      <div class="flex items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-[#C8963E]/20 text-[#C8963E] font-bold text-2xl flex items-center justify-center border border-[#C8963E]/30">
          {{ mb_substr($customer->name, 0, 1) }}
        </div>
        <div>
          <h2 class="text-2xl font-bold text-white">{{ $customer->name }}</h2>
          <p class="text-sm text-gray-400 font-mono">{{ $customer->email }} · {{ $customer->phone ?: 'بدون هاتف' }}</p>
          <p class="text-xs text-gray-500 mt-1">تاريخ الانضمام: {{ $customer->created_at->format('Y-m-d — h:i A') }}</p>
        </div>
      </div>

      <div class="flex items-center gap-4 text-left">
        <div class="p-3 bg-black/30 rounded-xl border border-white/5 text-center min-w-28">
          <p class="text-xs text-gray-400">إجمالي الطلبات</p>
          <p class="text-xl font-bold text-white mt-1">{{ $customer->orders_count }}</p>
        </div>
        <div class="p-3 bg-black/30 rounded-xl border border-white/5 text-center min-w-32">
          <p class="text-xs text-gray-400">إجمالي الإنفاق</p>
          <p class="text-xl font-bold text-[#C8963E] mt-1">{{ number_format($customer->orders_sum_total_amount ?? 0, 2) }} <small class="text-xs">ر.س</small></p>
        </div>
      </div>
    </div>

    <!-- Customer Orders History -->
    <div>
      <h3 class="text-lg font-bold text-[#C8963E] mb-4 flex items-center gap-2">
        <i class="fa-solid fa-clock-rotate-left"></i>
        <span>سجل الطلبات الخاصة بالعميل</span>
      </h3>

      <div class="overflow-x-auto">
        <table class="custom-table">
          <thead>
            <tr>
              <th>رقم الطلب</th>
              <th>المبلغ الإجمالي</th>
              <th>الحالة</th>
              <th>تاريخ الطلب</th>
              <th>إجراءات</th>
            </tr>
          </thead>
          <tbody>
            @forelse($customer->orders as $order)
              <tr>
                <td class="font-bold text-[#C8963E]">{{ $order->order_number }}</td>
                <td class="font-bold">{{ number_format($order->total_amount, 2) }} ر.س</td>
                <td>
                  @if($order->status === 'pending')
                    <span class="badge-status bg-amber-500/20 text-amber-300 border border-amber-500/30">قيد الانتظار</span>
                  @elseif($order->status === 'preparing')
                    <span class="badge-status bg-blue-500/20 text-blue-300 border border-blue-500/30">جاري التحضير</span>
                  @elseif($order->status === 'out_for_delivery')
                    <span class="badge-status bg-purple-500/20 text-purple-300 border border-purple-500/30">خرج للتوصيل</span>
                  @elseif($order->status === 'delivered')
                    <span class="badge-status bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">تم التوصيل</span>
                  @else
                    <span class="badge-status bg-rose-500/20 text-rose-300 border border-rose-500/30">ملغي</span>
                  @endif
                </td>
                <td class="text-xs text-gray-400">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                <td>
                  <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1.5 bg-white/10 hover:bg-[#C8963E] hover:text-black rounded-lg text-xs font-semibold transition">
                    عرض الفاتورة
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-8 text-gray-400">لا توجد طلبات سابقة لهذا العميل بعد</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

</div>
@endsection
