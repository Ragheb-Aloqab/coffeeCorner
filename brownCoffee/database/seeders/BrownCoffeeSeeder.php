<?php

namespace Database\Seeders;

use App\Models\Addon;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BrownCoffeeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin User & Test Customer
        User::updateOrCreate(
            ['email' => 'admin@browncoffee.com'],
            [
                'name' => 'مدير النظام',
                'phone' => '0500000000',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'عميل برون كوفي',
                'phone' => '0555555555',
                'role' => 'customer',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Seed Settings
        Setting::set('min_order_amount', '30.00', 'الحد الأدنى للطلب بالريال السعودي');
        Setting::set('delivery_time', '30 - 45 دقيقة', 'وقت التوصيل المتوقع');
        Setting::set('store_status', 'open', 'حالة استقبال الطلبات في المحل (open/closed)');

        // 3. Seed Addon
        $matchaAddon = Addon::updateOrCreate(
            ['name_ar' => 'إضافة ماتشا'],
            [
                'name_en' => 'Matcha Addon',
                'description' => 'خلطة ماتشا يابانية فاخرة تُضاف إلى مشروبك',
                'price' => 5.00,
                'is_active' => true,
            ]
        );

        // 4. Seed Categories
        $categoriesData = [
            [
                'slug' => 'fatayer',
                'name_ar' => 'فطائر',
                'name_en' => 'Fatayer',
                'icon' => 'fa-solid fa-bread-slice',
                'color' => '#C8963E',
                'description' => 'فطائر شهية متنوعة',
                'sort_order' => 1,
            ],
            [
                'slug' => 'croissants',
                'name_ar' => 'كرواسون',
                'name_en' => 'Croissants',
                'icon' => 'fa-solid fa-cookie',
                'color' => '#8B6335',
                'description' => 'معجنات زبدانية هشة',
                'sort_order' => 2,
            ],
            [
                'slug' => 'sweets',
                'name_ar' => 'حلويات',
                'name_en' => 'Sweets',
                'icon' => 'fa-solid fa-cake-candles',
                'color' => '#A855F7',
                'description' => 'حلويات ومعجنات رائعة',
                'sort_order' => 3,
            ],
            [
                'slug' => 'coffee',
                'name_ar' => 'قهوة',
                'name_en' => 'Coffee',
                'icon' => 'fa-solid fa-mug-hot',
                'color' => '#4A2E2B',
                'description' => 'قهوة فنية مختارة',
                'sort_order' => 4,
            ],
            [
                'slug' => 'juices',
                'name_ar' => 'عصائر',
                'name_en' => 'Juices',
                'icon' => 'fa-solid fa-glass-water',
                'color' => '#16A34A',
                'description' => 'عصائر طازجة معصورة',
                'sort_order' => 5,
            ],
        ];

        $categoriesMap = [];
        foreach ($categoriesData as $c) {
            $cat = Category::updateOrCreate(['slug' => $c['slug']], $c);
            $categoriesMap[$c['slug']] = $cat->id;
        }

        // 5. Seed Products
        $productsData = [
            // فطائر
            [
                'cat' => 'fatayer',
                'name_ar' => 'فطيرة جبن',
                'description' => 'فطيرة دافئة محشوة بالجبن الأبيض الكريمي الطري',
                'price' => 12.00,
                'rating' => 4.8,
                'reviews_count' => 124,
                'image' => 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-bread-slice',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'fatayer',
                'name_ar' => 'فطيرة سبانخ',
                'description' => 'فطيرة شهية محشوة بالسبانخ المتبل بالتوابل الشرقية',
                'price' => 10.00,
                'rating' => 4.6,
                'reviews_count' => 98,
                'image' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-bread-slice',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'fatayer',
                'name_ar' => 'فطيرة لحم',
                'description' => 'فطيرة اللحم المفروم المتبل، مخبوزة بإتقان',
                'price' => 14.00,
                'rating' => 4.9,
                'reviews_count' => 203,
                'image' => 'https://images.unsplash.com/photo-1529042410759-befb1204b468?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-bread-slice',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'fatayer',
                'name_ar' => 'فطيرة زعتر',
                'description' => 'خلطة زعتر بلدي أصيل بزيت الزيتون البكر',
                'price' => 9.00,
                'rating' => 4.7,
                'reviews_count' => 176,
                'image' => 'https://images.unsplash.com/photo-1604329760661-e71dc83f8f26?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-bread-slice',
                'has_matcha_addon' => false,
            ],

            // كرواسون
            [
                'cat' => 'croissants',
                'name_ar' => 'كرواسون زبدة',
                'description' => 'كرواسون ذهبي هش على الطريقة الفرنسية الكلاسيكية',
                'price' => 11.00,
                'rating' => 4.8,
                'reviews_count' => 312,
                'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-cookie',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'croissants',
                'name_ar' => 'كرواسون لوز',
                'description' => 'مخبوز مرتين مع كريمة اللوز الفاخرة والرقائق',
                'price' => 14.00,
                'rating' => 4.9,
                'reviews_count' => 189,
                'image' => 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-cookie',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'croissants',
                'name_ar' => 'كرواسون شوكولاتة',
                'description' => 'محشو بكريمة الشوكولاتة الداكنة الغنية',
                'price' => 13.00,
                'rating' => 4.7,
                'reviews_count' => 241,
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-cookie',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'croissants',
                'name_ar' => 'كرواسون زعتر',
                'description' => 'كرواسون بالزعتر البلدي وزيت الزيتون الأصيل',
                'price' => 12.00,
                'rating' => 4.5,
                'reviews_count' => 134,
                'image' => 'https://images.unsplash.com/photo-1486427944299-d1955d23e34d?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-cookie',
                'has_matcha_addon' => false,
            ],

            // حلويات
            [
                'cat' => 'sweets',
                'name_ar' => 'كنافة',
                'description' => 'كنافة بالجبن والقطر المذاب، طرية وشهية بامتياز',
                'price' => 16.00,
                'rating' => 4.9,
                'reviews_count' => 456,
                'image' => 'https://images.unsplash.com/photo-1519676867240-f03562e64548?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-cake-candles',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'sweets',
                'name_ar' => 'بقلاوة',
                'description' => 'طبقات رقيقة من العجين بالمكسرات وشراب العسل',
                'price' => 13.00,
                'rating' => 4.7,
                'reviews_count' => 287,
                'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-cake-candles',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'sweets',
                'name_ar' => 'كيك لافا شوكولاتة',
                'description' => 'كيك دافئ بقلب من الشوكولاتة المنصهرة الساخنة',
                'price' => 18.00,
                'rating' => 4.9,
                'reviews_count' => 534,
                'image' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-cake-candles',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'sweets',
                'name_ar' => 'تشيز كيك',
                'description' => 'تشيز كيك نيويورك الكريمي بصوص الفراولة الطازجة',
                'price' => 17.00,
                'rating' => 4.8,
                'reviews_count' => 398,
                'image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-cake-candles',
                'has_matcha_addon' => false,
            ],

            // قهوة
            [
                'cat' => 'coffee',
                'name_ar' => 'كابتشينو',
                'description' => 'إسبريسو غني مع رغوة حليب مخملية ناعمة وفن لاتيه احترافي',
                'price' => 18.00,
                'rating' => 4.9,
                'reviews_count' => 612,
                'image' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-mug-hot',
                'has_matcha_addon' => true,
            ],

            // عصائر
            [
                'cat' => 'juices',
                'name_ar' => 'عصير برتقال طازج',
                'description' => 'برتقال فالنسيا معصور طازجاً بدون إضافات',
                'price' => 14.00,
                'rating' => 4.8,
                'reviews_count' => 289,
                'image' => 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-glass-water',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'juices',
                'name_ar' => 'مانجو مثلج',
                'description' => 'مانجو ألفونسو ممزوج مع لمسة ليمون منعشة',
                'price' => 16.00,
                'rating' => 4.7,
                'reviews_count' => 203,
                'image' => 'https://images.unsplash.com/photo-1553279768-865429fa0078?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-glass-water',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'juices',
                'name_ar' => 'بطيخ نعناع',
                'description' => 'بطيخ مثلج مع أوراق النعناع الطازجة المنعشة',
                'price' => 13.00,
                'rating' => 4.6,
                'reviews_count' => 167,
                'image' => 'https://images.unsplash.com/photo-1563114773-84221bd62daa?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-glass-water',
                'has_matcha_addon' => false,
            ],
            [
                'cat' => 'juices',
                'name_ar' => 'عصير أخضر',
                'description' => 'خيار وسبانخ وتفاح وزنجبيل لصحة مثالية',
                'price' => 15.00,
                'rating' => 4.5,
                'reviews_count' => 143,
                'image' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=800&q=80',
                'icon' => 'fa-solid fa-glass-water',
                'has_matcha_addon' => false,
            ],
        ];

        $productsMap = [];
        foreach ($productsData as $p) {
            $catId = $categoriesMap[$p['cat']];
            unset($p['cat']);
            $p['category_id'] = $catId;
            $prod = Product::updateOrCreate(['name_ar' => $p['name_ar']], $p);
            $productsMap[$p['name_ar']] = $prod->id;
        }

        // 6. Seed Offers
        $offersData = [
            [
                'product_name' => 'كابتشينو',
                'label_ar' => 'عرض اليوم',
                'discount_amount' => 0.00,
                'description' => 'كابتشينو برون كوفي الخاص المُعَد بعناية فائقة',
            ],
            [
                'product_name' => 'كيك لافا شوكولاتة',
                'label_ar' => 'الأكثر طلباً',
                'discount_amount' => 3.00,
                'description' => 'استمتع بكيك الشوكولاتة المنصهرة الساخنة بخصم خاص',
            ],
            [
                'product_name' => 'كرواسون زبدة',
                'label_ar' => 'أفضل قيمة',
                'discount_amount' => 2.00,
                'description' => 'كرواسون زبدة ذهبي هش على الطريقة الفرنسية الأصيلة',
            ],
            [
                'product_name' => 'عصير برتقال طازج',
                'label_ar' => 'طازج يومياً',
                'discount_amount' => 0.00,
                'description' => 'عصير برتقال طازج معصور أمامك مباشرة بدون إضافة سكر',
            ],
        ];

        foreach ($offersData as $o) {
            if (isset($productsMap[$o['product_name']])) {
                Offer::updateOrCreate(
                    ['product_id' => $productsMap[$o['product_name']]],
                    [
                        'label_ar' => $o['label_ar'],
                        'discount_amount' => $o['discount_amount'],
                        'description' => $o['description'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
