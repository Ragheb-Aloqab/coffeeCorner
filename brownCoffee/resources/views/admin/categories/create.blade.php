@extends('admin.layouts.admin')

@section('title', 'إضافة قسم جديد — برون كوفي')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-bold text-[#C8963E]">إضافة قسم جديد للمنيو</h1>
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-400 hover:text-white">إلغاء والعودة</a>
  </div>

  <div class="bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl p-6 shadow-xl">
    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-5">
      @csrf

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">اسم القسم بالعربية <span class="text-red-400">*</span></label>
        <input type="text" name="name_ar" value="{{ old('name_ar') }}" required
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]"
          placeholder="مثال: فطائر، حلويات، مشروبات ساخنة">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">اسم القسم بالإنجليزية (اختياري)</label>
        <input type="text" name="name_en" value="{{ old('name_en') }}"
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]"
          placeholder="e.g. Fatayer, Sweets, Hot Coffee">
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2">أيقونة FontAwesome</label>
          <input type="text" name="icon" value="{{ old('icon', 'fa-solid fa-mug-hot') }}"
            class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]"
            placeholder="fa-solid fa-mug-hot">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2">لون الثيم (Color Code)</label>
          <input type="color" name="color" value="{{ old('color', '#C8963E') }}"
            class="w-full h-12 p-1 bg-black/30 border border-white/10 rounded-xl cursor-pointer">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">وصف مختصر للقسم</label>
        <textarea name="description" rows="3"
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]"
          placeholder="مثال: معجنات زبدانية هشة ومصنوعة بعناية يومياً">{{ old('description') }}</textarea>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2">ترتيب الظهور</label>
          <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}"
            class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
        </div>

        <div class="flex items-center pt-6">
          <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-300">
            <input type="checkbox" name="is_active" value="1" checked class="accent-[#C8963E] w-5 h-5 rounded">
            <span>تفعيل القسم وعرضه في القائمة والـ API</span>
          </label>
        </div>
      </div>

      <button type="submit" class="w-full py-3.5 bg-[#C8963E] hover:bg-[#DFAC54] text-black font-bold rounded-xl transition text-lg mt-4">
        حفظ القسم الجديد
      </button>
    </form>
  </div>

</div>
@endsection
