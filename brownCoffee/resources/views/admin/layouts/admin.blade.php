<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'لوحة تحكم برون كوفي')</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <!-- Arabic Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg-dark: #1E1214;
      --bg-card: #2C1A1D;
      --bg-card-hover: #3A2327;
      --amber-primary: #C8963E;
      --amber-hover: #DFAC54;
      --text-main: #F3EBE1;
      --text-muted: #A3938F;
    }

    body {
      font-family: 'IBM Plex Sans Arabic', sans-serif;
      background-color: var(--bg-dark);
      color: var(--text-main);
    }

    .admin-sidebar {
      background-color: var(--bg-card);
      border-left: 1px solid rgba(200, 150, 62, 0.15);
    }

    .nav-link-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 16px;
      border-radius: 12px;
      color: var(--text-muted);
      transition: all 0.25s ease;
    }

    .nav-link-item:hover, .nav-link-item.active {
      background: linear-gradient(135deg, rgba(200, 150, 62, 0.2), rgba(200, 150, 62, 0.05));
      color: var(--amber-primary);
      border-right: 4px solid var(--amber-primary);
    }

    .stat-card {
      background-color: var(--bg-card);
      border: 1px solid rgba(200, 150, 62, 0.15);
      border-radius: 16px;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
    }

    .custom-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }

    .custom-table th {
      background-color: rgba(200, 150, 62, 0.08);
      color: var(--amber-primary);
      padding: 14px 16px;
      text-align: right;
      font-weight: 600;
    }

    .custom-table td {
      padding: 14px 16px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .custom-table tr:hover td {
      background-color: var(--bg-card-hover);
    }

    .badge-status {
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
  </style>
  @yield('styles')
</head>
<body class="min-h-screen flex flex-col md:flex-row">

  <!-- Sidebar -->
  <aside class="admin-sidebar w-full md:w-64 flex-shrink-0 p-4 flex flex-col justify-between min-h-screen">
    <div>
      <!-- Brand Logo -->
      <div class="flex items-center gap-3 p-3 mb-6 bg-black/20 rounded-xl border border-[#C8963E]/20">
        <div class="w-10 h-10 rounded-full bg-[#C8963E]/20 flex items-center justify-center text-[#C8963E] text-xl">
          <i class="fa-solid fa-mug-hot"></i>
        </div>
        <div>
          <h1 class="font-bold text-lg text-[#C8963E]">برون كوفي</h1>
          <p class="text-xs text-gray-400">لوحة التحكم والإدارة</p>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="space-y-1">
        <a href="{{ route('admin.dashboard') }}" class="nav-link-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <i class="fa-solid fa-[#C8963E] fa-chart-pie text-lg"></i>
          <span class="font-medium">الرئيسية والإحصائيات</span>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="nav-link-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
          <i class="fa-solid fa-receipt text-lg"></i>
          <span class="font-medium">إدارة الطلبات</span>
        </a>

        <a href="{{ route('admin.customers.index') }}" class="nav-link-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
          <i class="fa-solid fa-users text-lg"></i>
          <span class="font-medium">إدارة العملاء</span>
        </a>

        <a href="{{ route('admin.products.index') }}" class="nav-link-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
          <i class="fa-solid fa-utensils text-lg"></i>
          <span class="font-medium">المنتجات والقائمة</span>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="nav-link-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
          <i class="fa-solid fa-border-all text-lg"></i>
          <span class="font-medium">الأقسام والفئات</span>
        </a>

        <a href="{{ route('admin.offers.index') }}" class="nav-link-item {{ request()->routeIs('admin.offers.*') ? 'active' : '' }}">
          <i class="fa-solid fa-tags text-lg"></i>
          <span class="font-medium">العروض والخصومات</span>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="nav-link-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
          <i class="fa-solid fa-sliders text-lg"></i>
          <span class="font-medium">إعدادات النظام والتوصيل</span>
        </a>
      </nav>
    </div>

    <!-- User Profile & Logout -->
    <div class="pt-4 border-t border-white/10 mt-6">
      <div class="flex items-center justify-between p-2">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-full bg-[#C8963E] text-black font-bold flex items-center justify-center">
            {{ mb_substr(auth()->user()?->name ?? 'A', 0, 1) }}
          </div>
          <div class="text-sm">
            <p class="font-semibold text-white">{{ auth()->user()?->name ?? 'المدير' }}</p>
            <p class="text-xs text-gray-400">مشرف النظام</p>
          </div>
        </div>

        <form action="{{ route('admin.logout') }}" method="POST">
          @csrf
          <button type="submit" title="تسجيل الخروج" class="text-red-400 hover:text-red-300 p-2">
            <i class="fa-solid fa-arrow-right-from-bracket text-lg"></i>
          </button>
        </form>
      </div>
    </div>
  </aside>

  <!-- Main Content Area -->
  <main class="flex-1 p-6 md:p-8 overflow-y-auto">

    <!-- Flash Messages -->
    @if(session('success'))
      <div class="mb-6 p-4 rounded-xl bg-emerald-950/80 border border-emerald-500/30 text-emerald-300 flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-xl"></i>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    @if($errors->any())
      <div class="mb-6 p-4 rounded-xl bg-rose-950/80 border border-rose-500/30 text-rose-300">
        <div class="flex items-center gap-2 font-bold mb-2">
          <i class="fa-solid fa-triangle-exclamation"></i>
          <span>يرجى تصحيح الأخطاء التالية:</span>
        </div>
        <ul class="list-disc list-inside text-sm space-y-1">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>

  @yield('scripts')
</body>
</html>
