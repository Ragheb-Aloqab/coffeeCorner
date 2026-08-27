@extends('admin.layouts.admin')

@section('title', 'إدارة العملاء — برون كوفي')

@section('content')
<div class="space-y-6">

  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-[#C8963E] flex items-center gap-2">
        <i class="fa-solid fa-users"></i>
        <span>إدارة العملاء وحسابات التطبيق</span>
      </h1>
      <p class="text-sm text-gray-400 mt-1">عرض قائمة العملاء المسجلين، إجمالي المبيعات، وسجل الطلبات</p>
    </div>
  </div>

  <!-- Search Filter -->
  <form action="{{ route('admin.customers.index') }}" method="GET" class="flex items-center gap-3 bg-[#2C1A1D] p-4 rounded-xl border border-white/10">
    <div class="flex-1 relative">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث باسم العميل، البريد، أو رقم الهاتف..."
        class="w-full pl-4 pr-10 py-2.5 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
      <i class="fa-solid fa-magnifying-glass absolute right-3 top-3.5 text-gray-400"></i>
    </div>
    <button type="submit" class="px-5 py-2.5 bg-[#C8963E] text-black font-bold rounded-xl hover:bg-[#DFAC54] transition">
      بحث
    </button>
    @if(request('search'))
      <a href="{{ route('admin.customers.index') }}" class="text-xs text-gray-400 hover:text-white px-2">إلغاء البحث</a>
    @endif
  </form>

  <!-- Customers Table -->
  <div class="bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
      <table class="custom-table">
        <thead>
          <tr>
            <th>العميل</th>
            <th>البريد الإلكتروني</th>
            <th>رقم الهاتف</th>
            <th>عدد الطلبات</th>
            <th>إجمالي الإنفاق</th>
            <th>تاريخ التسجيل</th>
            <th>إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($customers as $customer)
            <tr>
              <td>
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-full bg-[#C8963E]/20 text-[#C8963E] font-bold flex items-center justify-center border border-[#C8963E]/30">
                    {{ mb_substr($customer->name, 0, 1) }}
                  </div>
                  <div>
                    <p class="font-bold text-white">{{ $customer->name }}</p>
                    <p class="text-xs text-gray-400">عميل مسجل</p>
                  </div>
                </div>
              </td>
              <td class="text-sm text-gray-300 font-mono">{{ $customer->email }}</td>
              <td dir="ltr" class="text-right text-gray-300">{{ $customer->phone ?: '—' }}</td>
              <td class="text-center font-bold text-lg text-white">
                <span class="px-2.5 py-1 bg-white/5 rounded-lg border border-white/10">
                  {{ $customer->orders_count }}
                </span>
              </td>
              <td class="font-bold text-[#C8963E]">
                {{ number_format($customer->orders_sum_total_amount ?? 0, 2) }} ر.س
              </td>
              <td class="text-xs text-gray-400">{{ $customer->created_at->format('Y-m-d') }}</td>
              <td>
                <div class="flex items-center gap-2">
                  <a href="{{ route('admin.customers.show', $customer->id) }}" class="px-3 py-1.5 bg-[#C8963E]/20 text-[#C8963E] hover:bg-[#C8963E] hover:text-black rounded-lg text-xs font-semibold transition">
                    <i class="fa-solid fa-receipt"></i> سجل الطلبات
                  </a>
                  <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من رغبتك بحذف هذا العميل؟')">
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
              <td colspan="7" class="text-center py-12 text-gray-400">لا يوجد عملاء مسجلين يطابقون نتائج البحث</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($customers->hasPages())
      <div class="p-4 border-t border-white/10">
        {{ $customers->withQueryString()->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
