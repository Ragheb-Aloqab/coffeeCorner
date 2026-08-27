@extends('admin.layouts.admin')

@section('title', 'إدارة الأقسام — برون كوفي')

@section('content')
<div class="space-y-6">

  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-[#C8963E] flex items-center gap-2">
        <i class="fa-solid fa-border-all"></i>
        <span>أقسام وفئات المنيو</span>
      </h1>
      <p class="text-sm text-gray-400 mt-1">إضافة وتعديل ترتيب وألوان الأقسام في القالب والـ API</p>
    </div>

    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2.5 bg-[#C8963E] text-black font-bold rounded-xl hover:bg-[#DFAC54] transition flex items-center gap-2">
      <i class="fa-solid fa-plus"></i>
      <span>إضافة قسم جديد</span>
    </a>
  </div>

  <div class="bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
      <table class="custom-table">
        <thead>
          <tr>
            <th>الأيقونة والاسم</th>
            <th>الرمز (Slug)</th>
            <th>الوصف</th>
            <th>عدد المنتجات</th>
            <th>الحالة</th>
            <th>الترتيب</th>
            <th>إجراءات</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $category)
            <tr>
              <td>
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg shadow-inner" style="background-color: {{ $category->color }}22; color: {{ $category->color }}">
                    <i class="{{ $category->icon }}"></i>
                  </div>
                  <div>
                    <p class="font-bold text-white">{{ $category->name_ar }}</p>
                    <p class="text-xs text-gray-400">{{ $category->name_en ?: $category->slug }}</p>
                  </div>
                </div>
              </td>
              <td class="font-mono text-xs text-amber-300">{{ $category->slug }}</td>
              <td class="text-sm text-gray-300">{{ $category->description }}</td>
              <td class="font-bold text-center">{{ $category->products_count }}</td>
              <td>
                @if($category->is_active)
                  <span class="badge-status bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">نشط</span>
                @else
                  <span class="badge-status bg-gray-500/20 text-gray-400 border border-gray-500/30">معطل</span>
                @endif
              </td>
              <td class="text-center font-bold">{{ $category->sort_order }}</td>
              <td>
                <div class="flex items-center gap-2">
                  <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2 bg-blue-500/20 text-blue-300 hover:bg-blue-500 hover:text-white rounded-lg text-xs transition">
                    <i class="fa-solid fa-pen"></i>
                  </a>
                  <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من رغبتك بحذف هذا القسم؟')">
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
              <td colspan="7" class="text-center py-8 text-gray-400">لا توجد أقسام مضافة بعد</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
