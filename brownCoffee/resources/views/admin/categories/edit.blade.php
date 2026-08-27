@extends('admin.layouts.admin')

@section('title', 'تعديل قسم ' . $category->name_ar . ' — برون كوفي')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-bold text-[#C8963E]">تعديل بيانات القسم: {{ $category->name_ar }}</h1>
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-400 hover:text-white">إلغاء والعودة</a>
  </div>

  <div class="bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl p-6 shadow-xl">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-5">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">اسم القسم بالعربية <span class="text-red-400">*</span></label>
        <input type="text" name="name_ar" value="{{ old('name_ar', $category->name_ar) }}" required
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">اسم القسم بالإنجليزية (اختياري)</label>
        <input type="text" name="name_en" value="{{ old('name_en', $category->name_en) }}"
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2">أيقونة FontAwesome</label>
          <input type="text" name="icon" value="{{ old('icon', $category->icon) }}"
            class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2">لون الثيم (Color Code)</label>
          <input type="color" name="color" value="{{ old('color', $category->color) }}"
            class="w-full h-12 p-1 bg-black/30 border border-white/10 rounded-xl cursor-pointer">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">وصف مختصر للقسم</label>
        <textarea name="description" rows="3"
          class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">{{ old('description', $category->description) }}</textarea>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-300 mb-2">ترتيب الظهور</label>
          <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}"
            class="w-full px-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E]">
        </div>

        <div class="flex items-center pt-6">
          <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-300">
            <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} class="accent-[#C8963E] w-5 h-5 rounded">
            <span>تفعيل القسم وعرضه في القائمة</span>
          </label>
        </div>
      </div>

      <button type="submit" class="w-full py-3.5 bg-[#C8963E] hover:bg-[#DFAC54] text-black font-bold rounded-xl transition text-lg mt-4">
        تحديث بيانات القسم
      </button>
    </form>
  </div>

</div>
@endsection
