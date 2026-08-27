# توثيق واجهات برمجة التطبيقات (Brown Coffee API Documentation - v1)

مرحباً بك في دليل التوثيق الشامل للـ RESTful APIs الخاصة بمشروع **برون كوفي (Brown Coffee)**، المجهزة خصيصاً للربط والتكامل السلس مع تطبيق **فلاتر (Flutter)**.

---

## 1. المعلومات الأساسية (Base Configuration)

* **الرابط الأساسي (Base URL):** `http://localhost:8000/api/v1` (أو رابط الخادم لديك)
* **Headers المطلوبة في جميع الطلبات:**
  ```http
  Accept: application/json
  Content-Type: application/json
  ```
* **المصادقة (Authorization Header) للطلبات المحمية:**
  ```http
  Authorization: Bearer {YOUR_SANCTUM_TOKEN}
  ```

---

## 2. واجهات المصادقة والحساب (Authentication APIs)

### 1) تسجيل حساب جديد (Register)
* **Endpoint:** `POST /auth/register`
* **Request Body:**
  ```json
  {
    "name": "أحمد علي",
    "email": "ahmed@example.com",
    "phone": "0551234567",
    "password": "password123"
  }
  ```
* **Success Response (201 Created):**
  ```json
  {
    "success": true,
    "message": "تم إنشاء الحساب بنجاح",
    "data": {
      "user": {
        "id": 2,
        "name": "أحمد علي",
        "email": "ahmed@example.com",
        "phone": "0551234567",
        "role": "customer",
        "created_at": "2026-08-28 01:45:00"
      },
      "token": "1|AbCdEf123456789..."
    }
  }
  ```

---

### 2) تسجيل الدخول (Login)
* **Endpoint:** `POST /auth/login`
* **Request Body:**
  ```json
  {
    "email": "customer@example.com",
    "password": "password"
  }
  ```
* **Success Response (200 OK):**
  ```json
  {
    "success": true,
    "message": "تم تسجيل الدخول بنجاح",
    "data": {
      "user": {
        "id": 2,
        "name": "عميل برون كوفي",
        "email": "customer@example.com",
        "phone": "0555555555",
        "role": "customer",
        "created_at": "2026-08-28 01:40:00"
      },
      "token": "2|XyZ987654321..."
    }
  }
  ```

---

### 3) الملف الشخصي (Profile) [محمي - Auth Bearer Token]
* **Endpoint:** `GET /auth/profile`
* **Header Required:** `Authorization: Bearer {TOKEN}`
* **Response (200 OK):**
  ```json
  {
    "success": true,
    "data": {
      "id": 2,
      "name": "عميل برون كوفي",
      "email": "customer@example.com",
      "phone": "0555555555",
      "role": "customer",
      "created_at": "2026-08-28 01:40:00"
    }
  }
  ```

---

## 3. واجهات القائمة والمنتجات والعروض (Catalog & Offers APIs)

### 1) قائمة الأقسام الفعالة (Categories)
* **Endpoint:** `GET /categories`
* **Response (200 OK):**
  ```json
  {
    "success": true,
    "data": [
      {
        "id": 1,
        "slug": "fatayer",
        "name": "فطائر",
        "name_ar": "فطائر",
        "name_en": "Fatayer",
        "icon": "fa-solid fa-bread-slice",
        "color": "#C8963E",
        "desc": "فطائر شهية متنوعة",
        "sort_order": 1,
        "products_count": 4
      },
      {
        "id": 4,
        "slug": "coffee",
        "name": "قهوة",
        "name_ar": "قهوة",
        "name_en": "Coffee",
        "icon": "fa-solid fa-mug-hot",
        "color": "#4A2E2B",
        "desc": "قهوة فنية مختارة",
        "sort_order": 4,
        "products_count": 1
      }
    ]
  }
  ```

---

### 2) قائمة المنتجات والفلترة والبحث (Products)
* **Endpoint:** `GET /products`
* **Query Parameters (اختيارية):**
  * `category`: تصفية بحسب رقم القسم أو رمزه (مثال: `category=coffee` أو `category=1`)
  * `search`: بحث بالكلمة المفتاحية (مثال: `search=كابتشينو`)
* **Response (200 OK):**
  ```json
  {
    "success": true,
    "count": 1,
    "data": [
      {
        "id": 13,
        "category_id": 4,
        "name": "كابتشينو",
        "name_ar": "كابتشينو",
        "name_en": null,
        "desc": "إسبريسو غني مع رغوة حليب مخملية ناعمة وفن لاتيه احترافي",
        "price": 18,
        "image": "https://images.unsplash.com/photo-1572442388796-11668a67e53d?auto=format&fit=crop&w=800&q=80",
        "icon": "fa-solid fa-mug-hot",
        "rating": 4.9,
        "reviews": 612,
        "hasMatchaAddon": true,
        "is_active": true
      }
    ]
  }
  ```

---

### 3) تفاصيل منتج معين (Product Details)
* **Endpoint:** `GET /products/{id}`
* **Response (200 OK):**
  ```json
  {
    "success": true,
    "data": {
      "id": 13,
      "category_id": 4,
      "name": "كابتشينو",
      "price": 18,
      "hasMatchaAddon": true
    }
  }
  ```

---

### 4) قائمة عروض اليوم والخصومات (Today's Offers)
* **Endpoint:** `GET /offers`
* **Response (200 OK):**
  ```json
  {
    "success": true,
    "data": [
      {
        "id": 1,
        "productId": 13,
        "label": "عرض اليوم",
        "discount": 0,
        "desc": "كابتشينو برون كوفي الخاص المُعَد بعناية فائقة",
        "product": {
          "id": 13,
          "name": "كابتشينو",
          "price": 18
        }
      }
    ]
  }
  ```

---

## 4. واجهات إعدادات النظام والتوصيل (Settings API)

* **Endpoint:** `GET /settings`
* **Response (200 OK):**
  ```json
  {
    "success": true,
    "data": {
      "min_order_amount": 30,
      "delivery_time": "30 - 45 دقيقة",
      "store_status": "open"
    }
  }
  ```

---

## 5. واجهات إنشاء وتتبع الطلبات (Orders APIs)

### 1) إنشاء طلب جديد (Create Order)
* **Endpoint:** `POST /orders`
* **تنبيه:** يحتوي النظام على تحقق تلقائي من الحد الأدنى للطلب (`min_order_amount` = 30 ر.س). في حال كان الإجمالي أقل من 30 ر.س سيتم إرجاع خطأ `422 Unprocessable Entity`.
* **Request Body:**
  ```json
  {
    "customer_name": "أحمد علي",
    "customer_phone": "0551234567",
    "delivery_address": "الرياض - حي الملقا - شارع حائل",
    "payment_method": "cash",
    "notes": "الرجاء الاتصال قبل التوصيل",
    "items": [
      {
        "product_id": 13,
        "quantity": 2,
        "addon_matcha": true
      },
      {
        "product_id": 1,
        "quantity": 1,
        "addon_matcha": false
      }
    ]
  }
  ```
* **Success Response (201 Created):**
  ```json
  {
    "success": true,
    "message": "تم إنشاء الطلب بنجاح وهو قيد الانتظار",
    "data": {
      "id": 1,
      "orderNumber": "BRN-5F8A21B",
      "customerName": "أحمد علي",
      "customerPhone": "0551234567",
      "subtotal": 58,
      "totalAmount": 58,
      "status": "pending",
      "paymentMethod": "cash",
      "items": [
        {
          "id": 1,
          "productId": 13,
          "name": "كابتشينو",
          "unitPrice": 23,
          "qty": 2,
          "addonDetails": {
            "matcha": true,
            "price": 5
          },
          "lineTotal": 46
        },
        {
          "id": 2,
          "productId": 1,
          "name": "فطيرة جبن",
          "unitPrice": 12,
          "qty": 1,
          "lineTotal": 12
        }
      ],
      "createdAt": "2026-08-28 01:45:00"
    }
  }
  ```

---

### 2) تتبع حالة الطلب بالرقم (Track Order Status)
* **Endpoint:** `GET /orders/{orderNumber}`
* **مثال:** `GET /orders/BRN-5F8A21B`
* **Response (200 OK):**
  ```json
  {
    "success": true,
    "data": {
      "orderNumber": "BRN-5F8A21B",
      "customerName": "أحمد علي",
      "status": "preparing",
      "totalAmount": 58
    }
  }
  ```

---

### 3) عرض طلبات المستخدم (User Orders History)
* **Endpoint:** `GET /orders`
* **Query Parameter (في حال عدم تسجيل الدخول):** `GET /orders?phone=0551234567`
* **Response (200 OK):** قائمة الطلبات السابقة مع العناصر والحالات.

---
