<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>تسجيل الدخول — لوحة تحكم برون كوفي</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'IBM Plex Sans Arabic', sans-serif;
      background-color: #1E1214;
      color: #F3EBE1;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

  <div class="w-full max-w-md bg-[#2C1A1D] border border-[#C8963E]/20 rounded-2xl p-8 shadow-2xl">
    <div class="text-center mb-8">
      <div class="w-16 h-16 rounded-full bg-[#C8963E]/20 text-[#C8963E] text-3xl flex items-center justify-center mx-auto mb-4 border border-[#C8963E]/30">
        <i class="fa-solid fa-mug-hot"></i>
      </div>
      <h1 class="text-2xl font-bold text-[#C8963E]">لوحة تحكم برون كوفي</h1>
      <p class="text-sm text-gray-400 mt-1">سجّل دخولك للوصول للوحة إدارة المحل والطلبات</p>
    </div>

    @if(session('success'))
      <div class="mb-4 p-3 rounded-xl bg-emerald-950/80 border border-emerald-500/30 text-emerald-300 text-sm text-center">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="mb-4 p-3 rounded-xl bg-rose-950/80 border border-rose-500/30 text-rose-300 text-sm">
        {{ $errors->first() }}
      </div>
    @endif

    <form action="{{ route('admin.login') }}" method="POST" class="space-y-5">
      @csrf

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">البريد الإلكتروني</label>
        <div class="relative">
          <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
            <i class="fa-solid fa-envelope"></i>
          </span>
          <input type="email" name="email" value="{{ old('email', 'admin@browncoffee.com') }}" required
            class="w-full pr-10 pl-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E] transition"
            placeholder="admin@browncoffee.com">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-300 mb-2">كلمة المرور</label>
        <div class="relative">
          <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
            <i class="fa-solid fa-lock"></i>
          </span>
          <input type="password" name="password" value="password" required
            class="w-full pr-10 pl-4 py-3 bg-black/30 border border-white/10 rounded-xl text-white focus:outline-none focus:border-[#C8963E] transition"
            placeholder="••••••••">
        </div>
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-300">
          <input type="checkbox" name="remember" class="accent-[#C8963E] rounded">
          <span>تذكرني على هذا الجهاز</span>
        </label>
      </div>

      <button type="submit"
        class="w-full py-3.5 px-4 bg-gradient-to-r from-[#C8963E] to-[#DFAC54] hover:opacity-90 text-black font-bold rounded-xl shadow-lg transition flex items-center justify-center gap-2 text-lg">
        <i class="fa-solid fa-right-to-bracket"></i>
        <span>تسجيل الدخول</span>
      </button>
    </form>
  </div>

</body>
</html>
