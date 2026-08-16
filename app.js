// ════════════════════════════════════════════════════
//  برون كوفي — بيانات المنتجات والحالة
// ════════════════════════════════════════════════════

// ─── بيانات الفئات ─────────────────────────────────
const CATEGORIES = [
  { id: 'fatayer',    name: 'فطائر',   icon: 'fa-solid fa-bread-slice',   desc: 'فطائر شهية متنوعة',      color: '#C8963E' },
  { id: 'croissants', name: 'كرواسون', icon: 'fa-solid fa-cookie',         desc: 'معجنات زبدانية هشة',     color: '#8B6335' },
  { id: 'sweets',     name: 'حلويات',  icon: 'fa-solid fa-cake-candles',   desc: 'حلويات ومعجنات رائعة',   color: '#A855F7' },
  { id: 'coffee',     name: 'قهوة',    icon: 'fa-solid fa-mug-hot',        desc: 'قهوة فنية مختارة',       color: '#4A2E2B' },
  { id: 'juices',     name: 'عصائر',   icon: 'fa-solid fa-glass-water',    desc: 'عصائر طازجة معصورة',    color: '#16A34A' },
];

const MATCHA_ADDON = {
  id: 'matcha',
  name: 'إضافة ماتشا',
  desc: 'خلطة ماتشا يابانية فاخرة تُضاف إلى مشروبك',
  price: 5,
};

const PRODUCTS = [
  // ── فطائر ──
  {
    id: 'f1', category: 'fatayer', name: 'فطيرة جبن',
    desc: 'فطيرة دافئة محشوة بالجبن الأبيض الكريمي الطري',
    price: 12, rating: 4.8, reviews: 124,
    img: 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-bread-slice'
  },
  {
    id: 'f2', category: 'fatayer', name: 'فطيرة سبانخ',
    desc: 'فطيرة شهية محشوة بالسبانخ المتبل بالتوابل الشرقية',
    price: 10, rating: 4.6, reviews: 98,
    img: 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-bread-slice'
  },
  {
    id: 'f3', category: 'fatayer', name: 'فطيرة لحم',
    desc: 'فطيرة اللحم المفروم المتبل، مخبوزة بإتقان',
    price: 14, rating: 4.9, reviews: 203,
    img: 'https://images.unsplash.com/photo-1529042410759-befb1204b468?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-bread-slice'
  },
  {
    id: 'f4', category: 'fatayer', name: 'فطيرة زعتر',
    desc: 'خلطة زعتر بلدي أصيل بزيت الزيتون البكر',
    price: 9, rating: 4.7, reviews: 176,
    img: 'https://images.unsplash.com/photo-1604329760661-e71dc83f8f26?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-bread-slice'
  },

  // ── كرواسون ──
  {
    id: 'c1', category: 'croissants', name: 'كرواسون زبدة',
    desc: 'كرواسون ذهبي هش على الطريقة الفرنسية الكلاسيكية',
    price: 11, rating: 4.8, reviews: 312,
    img: 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-cookie'
  },
  {
    id: 'c2', category: 'croissants', name: 'كرواسون لوز',
    desc: 'مخبوز مرتين مع كريمة اللوز الفاخرة والرقائق',
    price: 14, rating: 4.9, reviews: 189,
    img: 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-cookie'
  },
  {
    id: 'c3', category: 'croissants', name: 'كرواسون شوكولاتة',
    desc: 'محشو بكريمة الشوكولاتة الداكنة الغنية',
    price: 13, rating: 4.7, reviews: 241,
    img: 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-cookie'
  },
  {
    id: 'c4', category: 'croissants', name: 'كرواسون زعتر',
    desc: 'كرواسون بالزعتر البلدي وزيت الزيتون الأصيل',
    price: 12, rating: 4.5, reviews: 134,
    img: 'https://images.unsplash.com/photo-1486427944299-d1955d23e34d?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-cookie'
  },

  // ── حلويات ──
  {
    id: 's1', category: 'sweets', name: 'كنافة',
    desc: 'كنافة بالجبن والقطر المذاب، طرية وشهية بامتياز',
    price: 16, rating: 4.9, reviews: 456,
    img: 'https://images.unsplash.com/photo-1519676867240-f03562e64548?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-cake-candles'
  },
  {
    id: 's2', category: 'sweets', name: 'بقلاوة',
    desc: 'طبقات رقيقة من العجين بالمكسرات وشراب العسل',
    price: 13, rating: 4.7, reviews: 287,
    img: 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-cake-candles'
  },
  {
    id: 's3', category: 'sweets', name: 'كيك لافا شوكولاتة',
    desc: 'كيك دافئ بقلب من الشوكولاتة المنصهرة الساخنة',
    price: 18, rating: 4.9, reviews: 534,
    img: 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-cake-candles'
  },
  {
    id: 's4', category: 'sweets', name: 'تشيز كيك',
    desc: 'تشيز كيك نيويورك الكريمي بصوص الفراولة الطازجة',
    price: 17, rating: 4.8, reviews: 398,
    img: 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-cake-candles'
  },

  // ── قهوة ──
  {
    id: 'k1', category: 'coffee', name: 'كابتشينو',
    desc: 'إسبريسو غني مع رغوة حليب مخملية ناعمة وفن لاتيه احترافي',
    price: 18, rating: 4.9, reviews: 612,
    img: 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-mug-hot',
    hasMatchaAddon: true
  },

  // ── عصائر ──
  {
    id: 'j1', category: 'juices', name: 'عصير برتقال طازج',
    desc: 'برتقال فالنسيا معصور طازجاً بدون إضافات',
    price: 14, rating: 4.8, reviews: 289,
    img: 'https://images.unsplash.com/photo-1600271886742-f049cd451bba?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-glass-water'
  },
  {
    id: 'j2', category: 'juices', name: 'مانجو مثلج',
    desc: 'مانجو ألفونسو ممزوج مع لمسة ليمون منعشة',
    price: 16, rating: 4.7, reviews: 203,
    img: 'https://images.unsplash.com/photo-1553279768-865429fa0078?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-glass-water'
  },
  {
    id: 'j3', category: 'juices', name: 'بطيخ نعناع',
    desc: 'بطيخ مثلج مع أوراق النعناع الطازجة المنعشة',
    price: 13, rating: 4.6, reviews: 167,
    img: 'https://images.unsplash.com/photo-1563114773-84221bd62daa?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-glass-water'
  },
  {
    id: 'j4', category: 'juices', name: 'عصير أخضر',
    desc: 'خيار وسبانخ وتفاح وزنجبيل لصحة مثالية',
    price: 15, rating: 4.5, reviews: 143,
    img: 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=800&q=80',
    icon: 'fa-solid fa-glass-water'
  },
];

const TODAY_OFFERS = [
  { productId: 'k1', label: 'عرض اليوم',    discount: 0, desc: 'كابتشينو برون كوفي الخاص المُعَد بعناية فائقة' },
  { productId: 's3', label: 'الأكثر طلباً', discount: 3, desc: 'استمتع بكيك الشوكولاتة المنصهرة الساخنة بخصم خاص' },
  { productId: 'c1', label: 'أفضل قيمة',    discount: 2, desc: 'كرواسون زبدة ذهبي هش على الطريقة الفرنسية الاصيلة' },
  { productId: 'j1', label: 'طازج يومياً',  discount: 0, desc: 'عصير برتقال طازج معصور أمامك مباشرة بدون إضافة سكر' },
];

const MIN_ORDER = 30;

// ─── حالة التطبيق ────────────────────────────────────

const state = {
  currentScreen: 'splash',
  prevScreen: null,
  selectedCategoryId: null,
  selectedProductId: null,
  activeFilterCategory: 'all',
  searchQuery: '',
  productQty: 1,
  matchaAddonSelected: false,
  cart: [],
  activeOrder: null,
};

let cartIdCounter = 1;

// ─── دوال مساعدة ──────────────────────────────────────

function getProduct(id) { return PRODUCTS.find(p => p.id === id); }
function getCategory(id) { return CATEGORIES.find(c => c.id === id); }
function getProductsByCategory(catId) { return PRODUCTS.filter(p => p.category === catId); }

function calcCartTotals() {
  const subtotal = state.cart.reduce((s, i) => s + i.unitTotal * i.qty, 0);
  return { subtotal, total: subtotal };
}

function cartItemCount() { return state.cart.reduce((s, i) => s + i.qty, 0); }
function formatSAR(n) { return n.toFixed(2); }
function generateOrderId() { return 'BRN-' + Date.now().toString(36).toUpperCase(); }

function renderStars(rating) {
  const full = Math.floor(rating);
  const half = rating % 1 >= 0.5 ? 1 : 0;
  const empty = 5 - full - half;
  return `
    ${'<i class="fa-solid fa-star star-full"></i>'.repeat(full)}
    ${half ? '<i class="fa-solid fa-star-half-stroke star-full"></i>' : ''}
    ${'<i class="fa-regular fa-star star-empty"></i>'.repeat(empty)}
  `;
}

function imgTag(src, alt, cls = '') {
  return `<img src="${src}" alt="${alt}" class="${cls}" loading="lazy"
    onerror="this.onerror=null;this.parentElement.classList.add('img-error');this.style.display='none';">`;
}

// ─── منطق السلة ───────────────────────────────────────

function addToCart(productId, qty, addonMatcha) {
  const p = getProduct(productId);
  if (!p) return;
  const unitTotal = p.price + (addonMatcha ? MATCHA_ADDON.price : 0);
  const existing = state.cart.find(i => i.productId === productId && i.addonMatcha === addonMatcha);
  if (existing) {
    existing.qty += qty;
  } else {
    state.cart.push({ cartId: cartIdCounter++, productId, name: p.name, img: p.img, qty, basePrice: p.price, addonMatcha, unitTotal });
  }
}

function updateCartQty(cartId, delta) {
  const item = state.cart.find(i => i.cartId === cartId);
  if (!item) return;
  item.qty = Math.max(0, item.qty + delta);
  if (item.qty === 0) state.cart = state.cart.filter(i => i.cartId !== cartId);
}

function removeCartItem(cartId) { state.cart = state.cart.filter(i => i.cartId !== cartId); }

// ─── التنقل ───────────────────────────────────────────

let isNavigating = false;

function navigateTo(screenId, params = {}) {
  if (isNavigating) return;
  const currentEl = document.getElementById(state.currentScreen + '-screen');
  const nextEl    = document.getElementById(screenId + '-screen');
  if (!nextEl || state.currentScreen === screenId) return;

  isNavigating = true;
  const depthMap = { splash:0, home:1, category:2, product:3, cart:2, checkout:3, orders:2 };
  const goingBack = (depthMap[screenId]||0) < (depthMap[state.currentScreen]||0);

  if (currentEl) {
    currentEl.style.transition = 'transform 0.32s cubic-bezier(0.4,0,0.2,1),opacity 0.32s ease';
    currentEl.style.transform  = goingBack ? 'translateX(100%)' : 'translateX(-100%)';
    currentEl.style.opacity    = '0';
    setTimeout(() => {
      currentEl.classList.remove('active');
      currentEl.style.cssText = '';
    }, 330);
  }

  nextEl.style.cssText = `transition:none;transform:translateX(${goingBack?'-100%':'100%'});opacity:0`;
  nextEl.classList.add('active');
  requestAnimationFrame(() => requestAnimationFrame(() => {
    nextEl.style.transition = 'transform 0.32s cubic-bezier(0.4,0,0.2,1),opacity 0.32s ease';
    nextEl.style.transform  = 'translateX(0)';
    nextEl.style.opacity    = '1';
    setTimeout(() => {
      nextEl.style.cssText = '';
      isNavigating = false;
    }, 340);
  }));

  state.prevScreen = state.currentScreen;
  state.currentScreen = screenId;
  if (params.categoryId) state.selectedCategoryId = params.categoryId;
  if (params.productId)  state.selectedProductId  = params.productId;

  renderScreen(screenId);
  updateAllBadges();
  updateSidebarActive();
}

function goBack() {
  const map = {
    category:'home', product: state.prevScreen==='category'?'category':'home',
    cart: state.prevScreen||'home', checkout:'cart', orders:'home',
  };
  navigateTo(map[state.currentScreen]||'home');
}

// ─── مُوزِّع العرض ────────────────────────────────────

function renderScreen(id) {
  const fn = {home:renderHome, category:renderCategory, product:renderProduct,
               cart:renderCart, checkout:renderCheckout, orders:renderOrders};
  if (fn[id]) fn[id]();
  renderSidebarCart();
}

// ─── الشريط الجانبي ───────────────────────────────────

function renderSidebarCart() {
  const el = document.getElementById('sidebar-cart-summary');
  if (!el) return;
  const { total } = calcCartTotals();
  const count = cartItemCount();
  if (count === 0) {
    el.innerHTML = `<div class="sidebar-cart-empty"><i class="fa-solid fa-cart-shopping"></i><span>السلة فارغة</span></div>`;
    return;
  }
  const itemsHTML = state.cart.slice(0,3).map(item => `
    <div class="sidebar-cart-item">
      <div class="sci-img" style="background:url('${item.img}') center/cover"></div>
      <div class="sci-info">
        <div class="sci-name">${item.name}${item.addonMatcha?' <small>+ ماتشا</small>':''}</div>
        <div class="sci-price">${formatSAR(item.unitTotal*item.qty)} ر.س</div>
      </div>
      <span class="sci-qty">×${item.qty}</span>
    </div>
  `).join('');
  const more = count > 3 ? `<div class="sci-more">+${count-3} منتجات أخرى</div>` : '';
  el.innerHTML = `
    <div class="sidebar-cart-label"><i class="fa-solid fa-cart-shopping"></i> ملخص سلة الشراء</div>
    <div class="sidebar-cart-items">${itemsHTML}${more}</div>
    <div class="sidebar-cart-total">
      <span>المجموع</span>
      <span class="sct-val">${formatSAR(total)} ر.س</span>
    </div>
    <button class="sidebar-checkout-btn" onclick="navigateTo('cart')" ${total<MIN_ORDER?'disabled':''}>
      <i class="fa-solid fa-arrow-left"></i> ${total<MIN_ORDER?`أضف ${formatSAR(MIN_ORDER-total)} ر.س للطلب`:'إتمام الطلب'}
    </button>
  `;
}

function updateSidebarActive() {
  document.querySelectorAll('.sidebar-nav-link').forEach(el => {
    el.classList.remove('active');
    const screen = el.dataset.screen;
    if (screen === state.currentScreen ||
        (screen==='home' && ['category','product'].includes(state.currentScreen))) {
      el.classList.add('active');
    }
  });
}

// ─── الصفحة الرئيسية الديسكتوب والحيّة ─────────────────────

function renderHome() {
  const container = document.getElementById('home-content');
  if (!container) return;
  const hr = new Date().getHours();
  const greeting = hr<12?'صباح الخير':hr<17?'مساء الخير':'مساء النور';

  // تصفية المنتجات حسب البحث والفلتر
  let filteredProducts = PRODUCTS;
  if (state.activeFilterCategory !== 'all') {
    filteredProducts = filteredProducts.filter(p => p.category === state.activeFilterCategory);
  }
  if (state.searchQuery.trim() !== '') {
    const q = state.searchQuery.trim().toLowerCase();
    filteredProducts = filteredProducts.filter(p => p.name.toLowerCase().includes(q) || p.desc.toLowerCase().includes(q));
  }

  // الهيرو بنر للديسكتوب
  const heroHTML = `
    <div class="desktop-hero-banner">
      <div class="hero-bg-img" style="background-image:url('https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=1200&q=80')"></div>
      <div class="hero-content">
        <div class="hero-badge"><i class="fa-solid fa-crown"></i> المشروب الأكثر طلباً اليوم</div>
        <h2 class="hero-title">كابتشينو برون كوفي الفاخر</h2>
        <p class="hero-subtitle">إسبريسو غني مع رغوة حليب مخملية ناعمة ومحضرة بعناية فائقة لبداية يوم مثالية</p>
        <div class="hero-actions">
          <button class="hero-cta-btn" onclick="navigateTo('product',{productId:'k1'})">
            <i class="fa-solid fa-mug-hot"></i> اطلب الآن — 18.00 ر.س
          </button>
          <div class="hero-delivery-badge">
            <i class="fa-solid fa-truck-fast"></i> خدمة التوصيل السريع لباب بيتك (30 - 45 دقيقة)
          </div>
        </div>
      </div>
    </div>
  `;

  // شريط فلتر الفئات
  const catTabsHTML = `
    <div class="desktop-cat-tabs">
      <button class="cat-tab ${state.activeFilterCategory==='all'?'active':''}" onclick="setFilterCategory('all')">
        <i class="fa-solid fa-border-all"></i> الكل (${PRODUCTS.length})
      </button>
      ${CATEGORIES.map(c => `
        <button class="cat-tab ${state.activeFilterCategory===c.id?'active':''}" onclick="setFilterCategory('${c.id}')">
          <i class="${c.icon}"></i> ${c.name} (${getProductsByCategory(c.id).length})
        </button>
      `).join('')}
    </div>
  `;

  // شبكة العروض
  const offersHTML = TODAY_OFFERS.map(o => {
    const p = getProduct(o.productId);
    if (!p) return '';
    const finalPrice = p.price - o.discount;
    return `
      <div class="offer-card" role="article">
        <div class="offer-img-wrap">
          ${imgTag(p.img, p.name, 'offer-img')}
          <div class="offer-img-fallback"><i class="${p.icon}"></i></div>
          <div class="offer-badge"><i class="fa-solid fa-fire"></i> ${o.label}</div>
          ${o.discount>0?`<div class="offer-discount-tag">خصم ${o.discount} ر.س</div>`:''}
        </div>
        <div class="offer-body">
          <div class="offer-name">${p.name}</div>
          <div class="offer-desc">${o.desc}</div>
          <div class="offer-footer">
            <div class="offer-price-block">
              <span class="offer-price">${formatSAR(finalPrice)}</span>
              <span class="offer-sar"> ر.س</span>
              ${o.discount>0?`<span class="offer-old">${p.price} ر.س</span>`:''}
            </div>
            <button class="offer-btn" onclick="quickAddOffer('${o.productId}')" id="offer-btn-${o.productId}">
              <i class="fa-solid fa-plus"></i> اطلب الآن
            </button>
          </div>
        </div>
      </div>`;
  }).join('');

  // بطاقات الفئات الملونة
  const catsHTML = CATEGORIES.map(cat => {
    const count = getProductsByCategory(cat.id).length;
    return `
      <div class="cat-card" onclick="navigateTo('category',{categoryId:'${cat.id}'})" id="cat-card-${cat.id}" role="button" tabindex="0">
        <div class="cat-icon-wrap" style="background:${cat.color}22;color:${cat.color}">
          <i class="${cat.icon}"></i>
        </div>
        <div class="cat-name">${cat.name}</div>
        <div class="cat-desc">${cat.desc}</div>
        <div class="cat-count"><i class="fa-solid fa-tag"></i> ${count} منتج</div>
        <div class="cat-arrow"><i class="fa-solid fa-arrow-left"></i></div>
      </div>`;
  }).join('');

  // قائمة المنتجات المفلوترة
  const productsListHTML = filteredProducts.map(p => productCardHTML(p)).join('');

  container.innerHTML = `
    <div class="desktop-top-header">
      <div class="home-greeting">
        <div class="greeting-sub">${greeting} <i class="fa-solid fa-hand-wave" style="color:var(--amber)"></i></div>
        <h1 class="greeting-main">أهلاً بك في برون كوفي</h1>
      </div>
      <div class="desktop-search-wrap">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
        <input type="text" class="desktop-search-input" placeholder="ابحث عن قهوة، حلويات، فطائر..." value="${state.searchQuery}" oninput="onSearchInput(this.value)">
        ${state.searchQuery?`<button class="clear-search" onclick="onSearchInput('')"><i class="fa-solid fa-xmark"></i></button>`:''}
      </div>
    </div>

    ${heroHTML}

    <div class="section-header">
      <div class="section-label-wrap">
        <span class="section-label"><i class="fa-solid fa-star"></i> عروض ومميزات اليوم</span>
      </div>
    </div>
    <div class="offers-row" id="offers-row">${offersHTML}</div>

    <div class="section-divider"></div>

    <div class="section-header">
      <div class="section-label-wrap">
        <span class="section-label"><i class="fa-solid fa-border-all"></i> أقسام القائمة</span>
      </div>
    </div>
    <div class="cats-grid" id="cats-grid">${catsHTML}</div>

    <div class="section-divider"></div>

    <div class="section-header">
      <div class="section-label-wrap">
        <span class="section-label"><i class="fa-solid fa-utensils"></i> المنتجات (${filteredProducts.length})</span>
      </div>
      ${catTabsHTML}
    </div>
    <div class="products-grid" id="main-products-grid">
      ${filteredProducts.length ? productsListHTML : `
        <div class="no-results-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <div>عذراً، لم نجد أي منتجات تطابق "${state.searchQuery}"</div>
          <button class="cta-btn" onclick="onSearchInput('')">إعادة تعيين البحث</button>
        </div>`}
    </div>
  `;
}

function setFilterCategory(catId) {
  state.activeFilterCategory = catId;
  renderHome();
}

function onSearchInput(val) {
  state.searchQuery = val;
  renderHome();
}

function quickAddOffer(productId) {
  addToCart(productId, 1, false);
  showToast('<i class="fa-solid fa-circle-check"></i> تمت الإضافة إلى السلة!');
  updateAllBadges(); bumpBadge(); renderSidebarCart();
}

// ─── شاشة الفئة ───────────────────────────────────────

function renderCategory() {
  const cat = getCategory(state.selectedCategoryId);
  const prods = getProductsByCategory(state.selectedCategoryId);
  if (!cat) return;

  const hdr = document.getElementById('category-header');
  if (hdr) {
    const cnt = cartItemCount();
    hdr.innerHTML = `
      <button class="icon-btn" onclick="navigateTo('cart')" aria-label="السلة">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="cart-badge ${cnt>0?'visible':''}" id="cat-cart-badge">${cnt||''}</span>
      </button>
      <div class="hdr-center">
        <div class="hdr-icon" style="color:${cat.color}"><i class="${cat.icon}"></i></div>
        <div>
          <div class="hdr-title">${cat.name}</div>
          <div class="hdr-sub">${prods.length} منتج متاح</div>
        </div>
      </div>
      <button class="icon-btn" onclick="goBack()" aria-label="رجوع">
        <i class="fa-solid fa-chevron-right"></i>
      </button>`;
  }

  const container = document.getElementById('category-content');
  if (!container) return;

  container.innerHTML = `<div class="products-grid">${prods.map(p => productCardHTML(p)).join('')}</div>`;
}

function productCardHTML(p) {
  return `
    <div class="prod-card" onclick="navigateTo('product',{productId:'${p.id}'})" id="prod-card-${p.id}" role="button" tabindex="0">
      <div class="prod-img-wrap">
        ${imgTag(p.img, p.name, 'prod-img')}
        <div class="prod-img-fallback"><i class="${p.icon}"></i></div>
        ${p.hasMatchaAddon?'<div class="prod-badge-matcha"><i class="fa-solid fa-leaf"></i> ماتشا</div>':''}
      </div>
      <div class="prod-body">
        <div class="prod-name">${p.name}</div>
        <div class="prod-desc">${p.desc}</div>
        <div class="prod-rating">${renderStars(p.rating)} <span class="rating-val">${p.rating}</span> <span class="rating-cnt">(${p.reviews})</span></div>
        <div class="prod-footer">
          <div><span class="prod-price">${p.price}</span><span class="prod-sar"> ر.س</span></div>
          <button class="prod-add-btn" onclick="event.stopPropagation();quickAddProduct('${p.id}')" aria-label="إضافة ${p.name}">
            <i class="fa-solid fa-plus"></i>
          </button>
        </div>
      </div>
    </div>`;
}

function quickAddProduct(id) {
  addToCart(id,1,false);
  showToast('<i class="fa-solid fa-circle-check"></i> أُضيف إلى السلة!');
  updateAllBadges(); bumpBadge(); renderSidebarCart();
}

// ─── تفاصيل المنتج (عرض سينمائي للديسكتوب) ───────────────────

function renderProduct() {
  const p = getProduct(state.selectedProductId);
  if (!p) return;
  state.productQty = 1; state.matchaAddonSelected = false;

  const hdr = document.getElementById('product-header');
  if (hdr) {
    const cnt = cartItemCount();
    hdr.innerHTML = `
      <button class="icon-btn" onclick="navigateTo('cart')" aria-label="السلة">
        <i class="fa-solid fa-cart-shopping"></i>
        <span class="cart-badge ${cnt>0?'visible':''}" id="prod-cart-badge">${cnt||''}</span>
      </button>
      <div class="hdr-center"><div class="hdr-title">تفاصيل المنتج</div></div>
      <button class="icon-btn" onclick="goBack()" aria-label="رجوع">
        <i class="fa-solid fa-chevron-right"></i>
      </button>`;
  }

  const cat = getCategory(p.category);
  const matchaHTML = p.hasMatchaAddon ? `
    <div class="addon-card">
      <div class="addon-header">
        <i class="fa-solid fa-leaf addon-icon"></i>
        <span class="addon-title">إضافة اختيارية</span>
      </div>
      <div class="addon-row">
        <label class="toggle-wrap" aria-label="إضافة ماتشا">
          <input type="checkbox" id="matcha-checkbox" onchange="onMatchaToggle(this.checked)">
          <span class="toggle-track"><span class="toggle-thumb"></span></span>
        </label>
        <div class="addon-info">
          <div class="addon-name"><i class="fa-solid fa-leaf" style="color:var(--matcha)"></i> إضافة ماتشا يابانية</div>
          <div class="addon-desc">${MATCHA_ADDON.desc}</div>
          <div class="addon-price">+ ${MATCHA_ADDON.price} ر.س</div>
        </div>
      </div>
    </div>` : '';

  const container = document.getElementById('product-content');
  if (!container) return;

  container.innerHTML = `
    <div class="desktop-product-split">
      <div class="product-hero-wrap">
        ${imgTag(p.img, p.name, 'product-hero-img')}
        <div class="product-hero-fallback"><i class="${p.icon}"></i></div>
        <div class="product-hero-overlay"></div>
      </div>
      <div class="product-detail-body">
        <div class="product-detail-top">
          <span class="product-cat-tag"><i class="${cat?.icon||''}"></i> ${cat?.name||''}</span>
          <div class="product-detail-rating">${renderStars(p.rating)} <strong>${p.rating}</strong> <span>(${p.reviews} تقييم)</span></div>
        </div>
        <h2 class="product-detail-name">${p.name}</h2>
        <p class="product-detail-desc">${p.desc}</p>
        ${matchaHTML}
        <div class="product-detail-controls">
          <div>
            <div class="ctrl-label">السعر للوحدة</div>
            <div class="product-detail-price" id="detail-price">${p.price} <small>ر.س</small></div>
          </div>
          <div class="qty-selector" role="group" aria-label="الكمية">
            <button class="qty-btn" onclick="changeProductQty(1)" aria-label="زيادة"><i class="fa-solid fa-plus"></i></button>
            <span class="qty-val" id="qty-display">1</span>
            <button class="qty-btn" onclick="changeProductQty(-1)" aria-label="تقليل"><i class="fa-solid fa-minus"></i></button>
          </div>
        </div>
      </div>
    </div>`;

  updateATCBar();
}

function onMatchaToggle(v) { state.matchaAddonSelected=v; updateATCBar(); }

function changeProductQty(d) {
  state.productQty = Math.max(1, state.productQty+d);
  const el=document.getElementById('qty-display'); if(el) el.textContent=state.productQty;
  updateATCBar();
}

function updateATCBar() {
  const p=getProduct(state.selectedProductId); if(!p) return;
  const unit=p.price+(state.matchaAddonSelected?MATCHA_ADDON.price:0);
  const total=unit*state.productQty;
  const pEl=document.getElementById('atc-price-value'); if(pEl) pEl.textContent=`${formatSAR(total)} ر.س`;
  const dEl=document.getElementById('detail-price'); if(dEl) dEl.innerHTML=`${unit} <small>ر.س</small>`;
}

function doAddToCart() {
  addToCart(state.selectedProductId, state.productQty, state.matchaAddonSelected);
  updateAllBadges(); bumpBadge(); renderSidebarCart();
  showToast(`<i class="fa-solid fa-circle-check"></i> أُضيف ${state.productQty}× إلى السلة!`);
}

// ─── السلة (تقسيم ديسكتوب ذكي) ───────────────────────────

function renderCart() {
  const container = document.getElementById('cart-content');
  if (!container) return;
  const {subtotal,total} = calcCartTotals();
  const count = cartItemCount();
  const minMet = total >= MIN_ORDER;

  const hdrCount = document.getElementById('cart-header-count');
  if (hdrCount) hdrCount.textContent = count===0?'فارغة':`${count} منتج`;

  if (!state.cart.length) {
    container.innerHTML = `
      <div class="cart-empty">
        <div class="cart-empty-icon"><i class="fa-solid fa-cart-shopping"></i></div>
        <div class="cart-empty-title">سلتك فارغة</div>
        <div class="cart-empty-desc">تصفح الفئات وأضف ما يعجبك للبدء في طلبك.</div>
        <button class="cta-btn" onclick="navigateTo('home')">
          <i class="fa-solid fa-utensils"></i> تصفح القائمة
        </button>
      </div>`;
    return;
  }

  const itemsHTML = state.cart.map(item => `
    <div class="cart-item" id="cart-item-${item.cartId}">
      <div class="ci-img-wrap">
        ${imgTag(item.img||'', item.name, 'ci-img')}
        <div class="ci-img-fallback"><i class="fa-solid fa-utensils"></i></div>
      </div>
      <div class="ci-info">
        <div class="ci-name">${item.name}</div>
        ${item.addonMatcha?'<span class="ci-addon"><i class="fa-solid fa-leaf"></i> ماتشا</span>':''}
        <div class="ci-price">${item.unitTotal} ر.س / قطعة</div>
        <div class="ci-qty-row">
          <button class="ci-qty-btn" onclick="doUpdateCartQty(${item.cartId},1)"><i class="fa-solid fa-plus"></i></button>
          <span class="ci-qty-val">${item.qty}</span>
          <button class="ci-qty-btn" onclick="doUpdateCartQty(${item.cartId},-1)"><i class="fa-solid fa-minus"></i></button>
        </div>
      </div>
      <div class="ci-right">
        <div class="ci-total">${formatSAR(item.unitTotal*item.qty)} ر.س</div>
        <button class="ci-remove" onclick="doRemoveCartItem(${item.cartId})" aria-label="حذف">
          <i class="fa-solid fa-trash-can"></i>
        </button>
      </div>
    </div>`).join('');

  const prog = Math.min((total/MIN_ORDER)*100,100);
  const rem = Math.max(0,MIN_ORDER-total);

  container.innerHTML = `
    <div class="desktop-cart-split">
      <div class="cart-items-column">
        <div class="cart-items-list">${itemsHTML}</div>
      </div>
      <div class="cart-summary-column">
        <div class="min-bar ${minMet?'success':'warning'}">
          <div class="min-bar-row">
            <span class="min-bar-msg">
              <i class="fa-solid ${minMet?'fa-circle-check':'fa-circle-exclamation'}"></i>
              ${minMet?'تم الوصول للحد الأدنى!':'الحد الأدنى للطلب '+MIN_ORDER+' ر.س'}
            </span>
            <span class="min-bar-remain">${minMet?`${total.toFixed(2)} ر.س`:`باقي ${rem.toFixed(2)} ر.س`}</span>
          </div>
          <div class="min-bar-track"><div class="min-bar-fill" style="width:${prog}%"></div></div>
        </div>
        <div class="cart-summary-box">
          <div class="cs-row"><span class="cs-lbl">الإجمالي الفرعي (${count} منتج)</span><span class="cs-val">${formatSAR(subtotal)} ر.س</span></div>
          <div class="cs-row"><span class="cs-lbl">خدمة التوصيل السريع</span><span class="cs-val delivery">30 - 45 دقيقة</span></div>
          <div class="cs-divider"></div>
          <div class="cs-row total"><span class="cs-lbl">المجموع الكلي</span><span class="cs-val">${formatSAR(total)} ر.س</span></div>
        </div>
        <div class="cart-cta-wrap">
          <button class="cta-btn full" onclick="navigateTo('checkout')" ${!minMet?'disabled':''}>
            <i class="fa-solid fa-arrow-left"></i> إتمام الطلب
          </button>
          ${!minMet?`<p class="cart-min-note"><i class="fa-solid fa-info-circle"></i> أضف ${formatSAR(rem)} ر.س للمتابعة</p>`:''}
        </div>
      </div>
    </div>`;
}

function doUpdateCartQty(id,d) { updateCartQty(id,d); renderCart(); updateAllBadges(); renderSidebarCart(); }
function doRemoveCartItem(id) { removeCartItem(id); renderCart(); updateAllBadges(); renderSidebarCart(); }

// ─── الدفع ────────────────────────────────────────────

function renderCheckout() {
  const container = document.getElementById('checkout-content');
  if (!container) return;
  const {total} = calcCartTotals();
  const minMet = total >= MIN_ORDER;

  const itemsHTML = state.cart.map(i => `
    <div class="chk-item-row">
      <span class="chk-val">${formatSAR(i.unitTotal*i.qty)} ر.س</span>
      <span class="chk-lbl">${i.name}${i.addonMatcha?' + ماتشا':''} ×${i.qty}</span>
    </div>`).join('');

  container.innerHTML = `
    <div class="checkout-inner">
      <div class="chk-section">
        <div class="chk-section-title"><i class="fa-solid fa-truck"></i> خدمة التوصيل</div>
        <div class="delivery-option">
          <div class="do-check"><i class="fa-solid fa-circle-dot" style="color:var(--amber);font-size:1.1rem"></i></div>
          <div class="do-info">
            <div class="do-name">توصيل برون كوفي السريع</div>
            <div class="do-name-en">Express Delivery</div>
          </div>
          <div class="do-time"><i class="fa-regular fa-clock"></i> 30 - 45 دقيقة</div>
        </div>
        <div class="chk-note"><i class="fa-solid fa-info-circle"></i> سيتم تحضير وتوصيل طلبك طازجاً خلال 30 إلى 45 دقيقة.</div>
      </div>

      <div class="chk-section">
        <div class="chk-section-title"><i class="fa-solid fa-receipt"></i> ملخص الطلب</div>
        <div class="chk-items">${itemsHTML}</div>
        <div class="chk-divider"></div>
        <div class="chk-item-row total-row">
          <span class="chk-val bold">${formatSAR(total)} ر.س</span>
          <span class="chk-lbl bold">المجموع</span>
        </div>
      </div>

      ${!minMet?`
        <div class="min-alert">
          <i class="fa-solid fa-triangle-exclamation"></i>
          الحد الأدنى للطلب ${MIN_ORDER} ر.س. أضف ${formatSAR(MIN_ORDER-total)} ر.س للمتابعة.
        </div>`:''}

      <button class="confirm-btn" id="confirm-order-btn" onclick="confirmOrder()" ${!minMet?'disabled':''}>
        <i class="fa-solid fa-check"></i> تأكيد الطلب
      </button>
    </div>`;
}

function confirmOrder() {
  const {total} = calcCartTotals();
  if (total < MIN_ORDER) return;
  state.activeOrder = {
    id: generateOrderId(), items:[...state.cart], total,
    delivery:'توصيل برون كوفي', deliveryEn:'Express Delivery',
    deliveryTime:'30 - 45 دقيقة', placedAt:new Date(), status:'received',
  };
  state.cart = [];
  updateAllBadges(); renderSidebarCart(); navigateTo('orders');
}

// ─── الطلبات ───────────────────────────────────────────

function renderOrders() {
  const container = document.getElementById('orders-content');
  if (!container) return;
  if (!state.activeOrder) {
    container.innerHTML = `
      <div class="cart-empty">
        <div class="cart-empty-icon"><i class="fa-solid fa-receipt"></i></div>
        <div class="cart-empty-title">لا توجد طلبات نشطة</div>
        <div class="cart-empty-desc">بمجرد تأكيد طلبك، يمكنك متابعة حالته هنا.</div>
        <button class="cta-btn" onclick="navigateTo('home')"><i class="fa-solid fa-utensils"></i> ابدأ الطلب</button>
      </div>`;
    return;
  }
  const o = state.activeOrder;
  const steps = [
    { label:'استلام الطلب',    desc:'تم استلام طلبك بنجاح',            done:true,  active:false, icon:'fa-solid fa-check' },
    { label:'جاري التحضير',   desc:'فريقنا يعمل على تحضير طلبك',      done:false, active:true,  icon:'fa-solid fa-fire-burner' },
    { label:'في الطريق إليك', desc:'تم تسليمه لسائق التوصيل',        done:false, active:false, icon:'fa-solid fa-truck' },
    { label:'تم التسليم',      desc:'وصل طلبك! استمتع بوجبتك',         done:false, active:false, icon:'fa-solid fa-house-chimney' },
  ];
  const tl = steps.map(s=>`
    <div class="tl-item ${s.done?'done':''} ${s.active?'active':''}">
      <div class="tl-dot"><i class="${s.icon}"></i></div>
      <div class="tl-content">
        <div class="tl-name ${!s.done&&!s.active?'muted':''}">${s.label}</div>
        <div class="tl-desc">${s.desc}</div>
      </div>
    </div>`).join('');

  const itemsHTML = o.items.map(i=>`
    <div class="chk-item-row">
      <span class="chk-val">${formatSAR(i.unitTotal*i.qty)} ر.س</span>
      <span class="chk-lbl">${i.name}${i.addonMatcha?' + ماتشا':''} ×${i.qty}</span>
    </div>`).join('');

  container.innerHTML = `
    <div class="order-card">
      <div class="oc-header">
        <div class="oc-status"><i class="fa-solid fa-fire-burner"></i> جاري التحضير</div>
        <div class="oc-id"><i class="fa-solid fa-hashtag"></i> ${o.id}</div>
      </div>
      <div class="order-timeline">${tl}</div>
      <div class="order-details">
        <div class="chk-item-row"><span class="chk-val">${o.delivery}</span><span class="chk-lbl"><i class="fa-solid fa-truck"></i> التوصيل عبر</span></div>
        <div class="chk-item-row"><span class="chk-val">⏰ ${o.deliveryTime}</span><span class="chk-lbl">${o.deliveryEn}</span></div>
        <div class="chk-divider"></div>
        ${itemsHTML}
        <div class="chk-divider"></div>
        <div class="chk-item-row total-row"><span class="chk-val bold">${formatSAR(o.total)} ر.س</span><span class="chk-lbl bold">إجمالي الطلب</span></div>
      </div>
    </div>
    <div style="padding:0 16px 24px;max-width:500px;margin:0 auto">
      <button class="cta-btn full" onclick="navigateTo('home')"><i class="fa-solid fa-plus"></i> طلب جديد</button>
    </div>`;
}

// ─── تحديث الشارات ────────────────────────────────────

function updateAllBadges() {
  const count = cartItemCount();
  const text = count>0?count.toString():'';
  const visible = count>0;
  ['cat-cart-badge','prod-cart-badge','home-cart-badge','nav-cart-badge',
   'cat-nav-cart-badge','orders-nav-cart-badge','sidebar-cart-badge'].forEach(id=>{
    const el=document.getElementById(id);
    if(el){ el.textContent=text; el.classList.toggle('visible',visible); }
  });
  updateNavHighlight();
}

function bumpBadge() {
  ['home-cart-badge','nav-cart-badge','sidebar-cart-badge'].forEach(id=>{
    const el=document.getElementById(id);
    if(el){ el.classList.remove('bump'); void el.offsetWidth; el.classList.add('bump'); setTimeout(()=>el.classList.remove('bump'),400); }
  });
}

function updateNavHighlight() {
  const cur = state.currentScreen;
  document.querySelectorAll('.bottom-nav').forEach(nav => {
    const items = nav.querySelectorAll('.nav-item');
    items.forEach(item => {
      item.classList.remove('active');
      const onclickAttr = item.getAttribute('onclick') || '';
      if (cur === 'home' && (onclickAttr.includes("'home'") || onclickAttr === '')) {
        item.classList.add('active');
      } else if ((cur === 'category' || cur === 'product') && onclickAttr.includes("'category'")) {
        item.classList.add('active');
      } else if ((cur === 'cart' || cur === 'checkout') && onclickAttr.includes("'cart'")) {
        item.classList.add('active');
      } else if (cur === 'orders' && onclickAttr.includes("'orders'")) {
        item.classList.add('active');
      }
    });
  });
}

// ─── الإشعار المنبثق ──────────────────────────────────

let _toastTimer=null;
function showToast(msg) {
  const t=document.getElementById('toast'); if(!t) return;
  t.innerHTML=msg; t.classList.add('show');
  clearTimeout(_toastTimer);
  _toastTimer=setTimeout(()=>t.classList.remove('show'),2400);
}

// ─── تهيئة التطبيق ────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
  const splash=document.getElementById('splash-screen');
  if(splash) splash.classList.add('active');
  renderSidebarCart();
  setTimeout(()=>{
    const btn=document.getElementById('get-started-btn'); if(btn) btn.style.display='';
    const ld=document.getElementById('splash-loader'); if(ld) ld.style.display='none';
  },1800);
});

function startApp() { navigateTo('home'); }
