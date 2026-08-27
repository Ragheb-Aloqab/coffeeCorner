<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $minOrderAmount = Setting::get('min_order_amount', '30.00');
        $deliveryTime = Setting::get('delivery_time', '30 - 45 دقيقة');
        $storeStatus = Setting::get('store_status', 'open');

        return view('admin.settings.index', compact('minOrderAmount', 'deliveryTime', 'storeStatus'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'min_order_amount' => ['required', 'numeric', 'min:0'],
            'delivery_time' => ['required', 'string', 'max:255'],
            'store_status' => ['required', 'in:open,closed'],
        ]);

        Setting::set('min_order_amount', (string) $request->min_order_amount, 'الحد الأدنى للطلب');
        Setting::set('delivery_time', $request->delivery_time, 'وقت التوصيل المتوقع');
        Setting::set('store_status', $request->store_status, 'حالة استقبال الطلبات');

        return back()->with('success', 'تم حفظ إعدادات النظام والتوصيل بنجاح!');
    }
}
