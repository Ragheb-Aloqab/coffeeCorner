@extends('admin.layouts.admin')

@section('title', 'إدارة الطلبات — برون كوفي')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-[#C8963E] flex items-center gap-2">
        <i class="fa-solid fa-receipt"></i>
        <span>إدارة الطلبات وتتبع الحالات</span>
      </h1>
      <p class="text-sm text-gray-400 mt-1">عرض وتحديث حالات الطلبات اللحظية</p>
    </div>
  </div>

  <!-- Status Tabs Filter -->
  <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-white/10">
    <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap {{ !$status ? 'bg-[#C8963E] text-black' : 'bg-black/30 text-gray-400 hover:text-white' }}">
      الكل ({{ \App\Models\Order::count() }})
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap {{ $status === 'pending' ? 'bg-amber-500 text-black' : 'bg-black/30 text-gray-400 hover:text-white' }}">
      قيد الانتظار ({{ \App\Models\Order::where('status', 'pending')->count() }})
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'preparing']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap {{ $status === 'preparing' ? 'bg-blue-500 text-white' : 'bg-black/30 text-gray-400 hover:text-white' }}">
      جاري التحضير ({{ \App\Models\Order::where('status', 'preparing')->count() }})
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'out_for_delivery']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap {{ $status === 'out_for_delivery' ? 'bg-purple-500 text-white' : 'bg-black/30 text-gray-400 hover:text-white' }}">
      خرج للتوصيل ({{ \App\Models\Order::where('status', 'out_for_delivery')->count() }})
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold whitespace-nowrap {{ $status === 'delivered' ? 'bg-emerald-500 text-white' : 'bg-black/30 text-gray-400 hover:text-white' }}">
      تم التوصيل ({{ \App\Models\Order::where('status', 'delivered')->count() }})
    </a>
  </div>

  <!-- Orders Table -->
  <div class="bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
      <table class="custom-table">
        <thead>
          <tr>
            <th>رقم الطلب</th>
            <th>اسم العميل</th>
            <th>الهاتف</th>
            <th>طريقة الدفع</th>
            <th>المبلغ الإجمالي</th>
            <th>تغيير حالة الطلب</th>
            <th>التاريخ</th>
            <th>إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($orders as $order)
            <tr>
              <td class="font-bold text-[#C8963E]">{{ $order->order_number }}</td>
              <td class="font-medium">{{ $order->customer_name }}</td>
              <td dir="ltr" class="text-right text-gray-300">{{ $order->customer_phone }}</td>
              <td>
                <span class="text-xs bg-black/30 px-2.5 py-1 rounded-lg border border-white/10">
                  {{ $order->payment_method === 'cash' ? 'الدفع عند الاستلام' : 'بطاقة / أبل باي' }}
                </span>
              </td>
              <td class="font-bold text-lg text-white">{{ number_format($order->total_amount, 2) }} ر.س</td>
              <td>
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline-block">
                  @csrf
                  @method('PATCH')
                  <select name="status" onchange="this.form.submit()"
                    class="py-1.5 px-3 rounded-xl text-xs font-bold border focus:outline-none transition cursor-pointer
                      {{ $order->status === 'pending' ? 'bg-amber-500/20 text-amber-300 border-amber-500/50' : '' }}
                      {{ $order->status === 'preparing' ? 'bg-blue-500/20 text-blue-300 border-blue-500/50' : '' }}
                      {{ $order->status === 'out_for_delivery' ? 'bg-purple-500/20 text-purple-300 border-purple-500/50' : '' }}
                      {{ $order->status === 'delivered' ? 'bg-emerald-500/20 text-emerald-300 border-emerald-500/50' : '' }}
                      {{ $order->status === 'cancelled' ? 'bg-rose-500/20 text-rose-300 border-rose-500/50' : '' }}">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                    <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>جاري التحضير</option>
                    <option value="out_for_delivery" {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}>خرج للتوصيل</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>إلغاء الطلب</option>
                  </select>
                </form>
              </td>
              <td class="text-xs text-gray-400">{{ $order->created_at->format('Y-m-d H:i') }}</td>
              <td>
                <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1.5 bg-[#C8963E]/20 text-[#C8963E] hover:bg-[#C8963E] hover:text-black rounded-lg text-xs font-semibold transition">
                  <i class="fa-solid fa-eye"></i> التفاصيل
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-12 text-gray-400">لا توجد طلبات تطابق الفلتر المالي</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($orders->hasPages())
      <div class="p-4 border-t border-white/10">
        {{ $orders->withQueryString()->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
