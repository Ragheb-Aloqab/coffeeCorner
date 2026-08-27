@extends('admin.layouts.admin')

@section('title', 'الرئيسية والإحصائيات — برون كوفي')

@section('content')
<div class="space-y-8">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-black/20 p-6 rounded-2xl border border-[#C8963E]/20">
    <div>
      <h1 class="text-2xl font-bold text-[#C8963E] flex items-center gap-2">
        <i class="fa-solid fa-mug-hot"></i>
        <span>أهلاً بك في لوحة إتاحة وإدارة برون كوفي</span>
      </h1>
      <p class="text-sm text-gray-400 mt-1">متابعة لحظية للمبيعات، الطلبات النشطة، والمنتجات</p>
    </div>
    <div class="flex items-center gap-3">
      <a href="{{ route('admin.orders.index') }}" class="px-4 py-2.5 bg-[#C8963E] text-black font-bold rounded-xl hover:bg-[#DFAC54] transition flex items-center gap-2">
        <i class="fa-solid fa-receipt"></i>
        <span>إدارة الطلبات الحالية</span>
      </a>
    </div>
  </div>

  <!-- Key Metrics Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

    <!-- Total Sales -->
    <div class="stat-card p-6">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">إجمالي المبيعات</p>
          <h3 class="text-2xl font-bold text-[#C8963E] mt-1">{{ number_format($totalSales, 2) }} <small class="text-xs">ر.س</small></h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-[#C8963E]/10 text-[#C8963E] flex items-center justify-center text-xl">
          <i class="fa-solid fa-coins"></i>
        </div>
      </div>
      <p class="text-xs text-gray-500 mt-3"><i class="fa-solid fa-check text-emerald-400"></i> الطلبات غير الملغية</p>
    </div>

    <!-- Total Orders -->
    <div class="stat-card p-6">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">إجمالي الطلبات</p>
          <h3 class="text-2xl font-bold text-white mt-1">{{ $totalOrders }}</h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center text-xl">
          <i class="fa-solid fa-bag-shopping"></i>
        </div>
      </div>
      <p class="text-xs text-gray-500 mt-3">منذ انطلاق المنصة</p>
    </div>

    <!-- Pending & Active Orders -->
    <div class="stat-card p-6 border-amber-500/30">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold text-amber-400 uppercase tracking-wider">طلبات قيد الانتظار والتحضير</p>
          <h3 class="text-2xl font-bold text-amber-400 mt-1">{{ $pendingOrders + $preparingOrders }}</h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-xl animate-pulse">
          <i class="fa-solid fa-fire"></i>
        </div>
      </div>
      <p class="text-xs text-amber-300/80 mt-3">{{ $pendingOrders }} قيد الانتظار · {{ $preparingOrders }} جاري التحضير</p>
    </div>

    <!-- Active Products -->
    <div class="stat-card p-6">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">المنتجات الفعالة</p>
          <h3 class="text-2xl font-bold text-emerald-400 mt-1">{{ $activeProductsCount }}</h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-xl">
          <i class="fa-solid fa-utensils"></i>
        </div>
      </div>
      <p class="text-xs text-gray-500 mt-3">{{ $categoriesCount }} أقسام · {{ $offersCount }} عروض ترويجية</p>
    </div>

  </div>

  <!-- Recent Orders Table -->
  <div class="bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl p-6">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-lg font-bold text-[#C8963E] flex items-center gap-2">
        <i class="fa-solid fa-clock-rotate-left"></i>
        <span>أحدث الطلبات اللحظية</span>
      </h2>
      <a href="{{ route('admin.orders.index') }}" class="text-sm text-[#C8963E] hover:underline flex items-center gap-1">
        <span>عرض كافة الطلبات</span>
        <i class="fa-solid fa-arrow-left"></i>
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="custom-table">
        <thead>
          <tr>
            <th>رقم الطلب</th>
            <th>العميل</th>
            <th>رقم الهاتف</th>
            <th>العناصر</th>
            <th>المبلغ الإجمالي</th>
            <th>الحالة</th>
            <th>التاريخ</th>
            <th>إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentOrders as $order)
            <tr>
              <td class="font-bold text-[#C8963E]">{{ $order->order_number }}</td>
              <td>{{ $order->customer_name }}</td>
              <td dir="ltr" class="text-right">{{ $order->customer_phone }}</td>
              <td>
                <span class="text-xs bg-white/5 px-2.5 py-1 rounded-lg">
                  {{ $order->items->sum('quantity') }} عناصر
                </span>
              </td>
              <td class="font-bold">{{ number_format($order->total_amount, 2) }} ر.س</td>
              <td>
                @if($order->status === 'pending')
                  <span class="badge-status bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    <i class="fa-solid fa-hourglass-start"></i> قيد الانتظار
                  </span>
                @elseif($order->status === 'preparing')
                  <span class="badge-status bg-blue-500/20 text-blue-300 border border-blue-500/30">
                    <i class="fa-solid fa-fire"></i> جاري التحضير
                  </span>
                @elseif($order->status === 'out_for_delivery')
                  <span class="badge-status bg-purple-500/20 text-purple-300 border border-purple-500/30">
                    <i class="fa-solid fa-truck-fast"></i> خرج للتوصيل
                  </span>
                @elseif($order->status === 'delivered')
                  <span class="badge-status bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                    <i class="fa-solid fa-circle-check"></i> تم التوصيل
                  </span>
                @else
                  <span class="badge-status bg-rose-500/20 text-rose-300 border border-rose-500/30">
                    <i class="fa-solid fa-circle-xmark"></i> ملغي
                  </span>
                @endif
              </td>
              <td class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</td>
              <td>
                <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1.5 bg-white/10 hover:bg-[#C8963E] hover:text-black rounded-lg text-xs font-semibold transition">
                  تفاصيل
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-8 text-gray-400">لا توجد طلبات مسجلة حتى الآن</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
