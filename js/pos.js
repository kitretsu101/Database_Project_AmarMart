/**
 * SwiftMart – pos.js
 * Point-of-Sale billing system:
 *   - Product catalogue (dummy data)
 *   - Add to cart / remove / quantity adjust
 *   - Discount & VAT calculation
 *   - Invoice generation & print
 *
 * ─── Oracle DB Integration Points ────────────────────────────
 * SELECT product_id, product_name, sale_price, stock_qty,
 *               barcode, emoji FROM PRODUCTS WHERE is_active=1
 * INSERT INTO ORDERS (invoice_no, customer_id, cashier_id,
 *               total_amount, discount, vat, payment_method, status)
 *         VALUES (:inv, :cust, :cashier, :total, :disc, :vat, :pay,'PAID')
 * INSERT INTO ORDER_ITEMS (order_id, product_id, qty, unit_price)
 *         VALUES (:oid, :pid, :qty, :price)
 * UPDATE PRODUCTS SET stock_qty = stock_qty - :qty
 *         WHERE product_id = :pid
 * ─────────────────────────────────────────────────────────────
 */

'use strict';

document.addEventListener('DOMContentLoaded', () => {
  POSModule.init();
});

const POSModule = {

  /* ── State ──────────────────────────────────────────────── */
  cart: [],
  vatRate: 0.05,       // 5% VAT
  selectedCustomer: null,

  /* ── Dummy Product Catalogue ────────────────────────────── */
  /* DB: Replace with PHP fetch from PRODUCTS table */
  products: [
    { id: 'P001', name: 'Nescafé Gold 200g',    price: 850,   emoji: '☕', category: 'Beverages', barcode: '8901030012873', stock: 142 },
    { id: 'P002', name: 'Ariel Detergent 1kg',  price: 420,   emoji: '🧺', category: 'Household', barcode: '8001841011', stock: 87  },
    { id: 'P003', name: 'Pran Mango Juice 250ml',price: 35,   emoji: '🥭', category: 'Beverages', barcode: '8912345001', stock: 320 },
    { id: 'P004', name: 'Fresh Milk 1L',         price: 110,  emoji: '🥛', category: 'Dairy',     barcode: '8901234001', stock: 200 },
    { id: 'P005', name: 'Whole Wheat Bread',     price: 75,   emoji: '🍞', category: 'Bakery',    barcode: '8909876001', stock: 54  },
    { id: 'P006', name: 'Colgate Toothpaste 150g',price:185,  emoji: '🪥', category: 'Personal',  barcode: '8901030009000', stock: 95 },
    { id: 'P007', name: 'Egg (12 pcs)',          price: 165,  emoji: '🥚', category: 'Dairy',     barcode: '8905678001', stock: 180 },
    { id: 'P008', name: 'Sunflower Oil 1L',      price: 285,  emoji: '🫙', category: 'Grocery',   barcode: '8903456001', stock: 112 },
    { id: 'P009', name: 'Parachute Coconut Oil', price: 245,  emoji: '🥥', category: 'Personal',  barcode: '8902790000', stock: 12  },
    { id: 'P010', name: 'Oreo Cookies 120g',     price: 95,   emoji: '🍪', category: 'Snacks',    barcode: '7622210713', stock: 230 },
    { id: 'P011', name: 'Maggi Noodles 75g',     price: 22,   emoji: '🍜', category: 'Grocery',   barcode: '8901058014', stock: 400 },
    { id: 'P012', name: 'Lipton Tea 100g',       price: 160,  emoji: '🍵', category: 'Beverages', barcode: '8710522010', stock: 78  },
    { id: 'P013', name: 'Lux Soap 125g',         price: 65,   emoji: '🧼', category: 'Personal',  barcode: '8710908011', stock: 160 },
    { id: 'P014', name: 'Pringles Original 165g',price: 350,  emoji: '🥫', category: 'Snacks',    barcode: '038000845', stock:  45  },
    { id: 'P015', name: 'Yakult 5-pack',         price: 280,  emoji: '🧃', category: 'Dairy',     barcode: '4902205000', stock: 60  },
    { id: 'P016', name: 'Brown Sugar 1kg',       price: 130,  emoji: '🍚', category: 'Grocery',   barcode: '8904567001', stock: 85  },
  ],

  /* ── Init ───────────────────────────────────────────────── */
  init() {
    this.renderCatalogue();
    this.bindSearch();
    this.bindCategoryFilter();
    this.bindDiscount();
    this.bindPaymentMethod();
    this.bindClear();
    this.bindCheckout();
    this.bindPrint();
    this.updateCartUI();
  },

  /* ── Render Product Buttons ─────────────────────────────── */
  renderCatalogue(filter = '', category = 'All') {
    const grid = document.getElementById('posProductGrid');
    if (!grid) return;

    const filtered = this.products.filter(p => {
      const matchQ   = p.name.toLowerCase().includes(filter.toLowerCase()) ||
                       p.barcode.includes(filter);
      const matchCat = category === 'All' || p.category === category;
      return matchQ && matchCat;
    });

    if (filtered.length === 0) {
      grid.innerHTML = `<div class="empty-state" style="grid-column:1/-1;padding:2rem">
        <div class="empty-state-icon">🔍</div>
        <h3>No Products Found</h3>
        <p>Try a different search term or category.</p></div>`;
      return;
    }

    grid.innerHTML = filtered.map(p => `
      <button class="pos-product-btn ${p.stock < 10 ? 'low-stock' : ''}"
              onclick="POSModule.addToCart('${p.id}')"
              ${p.stock === 0 ? 'disabled' : ''}
              title="${p.barcode}">
        <span class="emoji">${p.emoji}</span>
        <span class="name">${p.name}</span>
        <span class="price">৳${p.price.toLocaleString()}</span>
        ${p.stock < 10 ? `<span style="font-size:0.6rem;color:#EF4444">⚠ Low Stock</span>` : ''}
      </button>`).join('');
  },

  /* ── Add to Cart ────────────────────────────────────────── */
  addToCart(productId) {
    const product = this.products.find(p => p.id === productId);
    if (!product) return;

    const existing = this.cart.find(item => item.id === productId);
    if (existing) {
      if (existing.qty >= product.stock) {
        SwiftMart.toasts.show(`Max stock reached for ${product.name}`, 'warning');
        return;
      }
      existing.qty += 1;
    } else {
      this.cart.push({ ...product, qty: 1 });
    }
    this.updateCartUI();
    SwiftMart.toasts.show(`${product.emoji} ${product.name} added`, 'success', 1500);
  },

  /* ── Remove from Cart ───────────────────────────────────── */
  removeFromCart(productId) {
    this.cart = this.cart.filter(item => item.id !== productId);
    this.updateCartUI();
  },

  /* ── Change Quantity ────────────────────────────────────── */
  changeQty(productId, delta) {
    const item = this.cart.find(i => i.id === productId);
    if (!item) return;
    item.qty = Math.max(1, item.qty + delta);
    const maxStock = this.products.find(p => p.id === productId)?.stock || 999;
    if (item.qty > maxStock) {
      item.qty = maxStock;
      SwiftMart.toasts.show('Max stock reached', 'warning');
    }
    this.updateCartUI();
  },

  /* ── Update Cart UI ─────────────────────────────────────── */
  updateCartUI() {
    const cartItems   = document.getElementById('cartItems');
    const cartCount   = document.getElementById('cartCount');
    const cartEmpty   = document.getElementById('cartEmpty');
    const cartActions = document.getElementById('cartActions');

    if (!cartItems) return;

    // Update item count badge
    const totalItems = this.cart.reduce((s, i) => s + i.qty, 0);
    if (cartCount) cartCount.textContent = totalItems;

    if (this.cart.length === 0) {
      cartItems.innerHTML = `
        <div class="empty-state" id="cartEmpty" style="padding:2rem">
          <div class="empty-state-icon">🛒</div>
          <h3>Cart is Empty</h3>
          <p>Click a product to add it</p>
        </div>`;
      if (cartActions) cartActions.style.display = 'none';
    } else {
      if (cartEmpty) cartEmpty.remove();
      if (cartActions) cartActions.style.display = 'flex';

      cartItems.innerHTML = this.cart.map(item => `
        <div class="cart-item" id="cart-item-${item.id}">
          <span style="font-size:1.4rem">${item.emoji}</span>
          <div class="cart-item-info">
            <h5>${item.name}</h5>
            <span>৳${item.price.toLocaleString()} each</span>
          </div>
          <div class="qty-ctrl">
            <button class="qty-btn" onclick="POSModule.changeQty('${item.id}',-1)">−</button>
            <span class="qty-val">${item.qty}</span>
            <button class="qty-btn" onclick="POSModule.changeQty('${item.id}',+1)">+</button>
          </div>
          <div class="cart-item-price">৳${(item.price * item.qty).toLocaleString()}</div>
          <button class="cart-remove" onclick="POSModule.removeFromCart('${item.id}')" title="Remove">✕</button>
        </div>`).join('');
    }

    this.updateSummary();
  },

  /* ── Calculate & Update Summary ─────────────────────────── */
  updateSummary() {
    const subtotal   = this.cart.reduce((s, i) => s + i.price * i.qty, 0);
    const discountPct= parseFloat(document.getElementById('discountInput')?.value || 0);
    const discount   = subtotal * (discountPct / 100);
    const afterDisc  = subtotal - discount;
    const vat        = afterDisc * this.vatRate;
    const total      = afterDisc + vat;

    const set = (id, val) => {
      const el = document.getElementById(id);
      if (el) el.textContent = '৳' + val.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };

    set('summarySubtotal', subtotal);
    set('summaryDiscount', discount);
    set('summaryVAT',      vat);
    set('summaryTotal',    total);

    // Store for invoice generation
    this._lastSummary = { subtotal, discount, vat, total, discountPct };
  },

  /* ── Bind Search ────────────────────────────────────────── */
  bindSearch() {
    const input = document.getElementById('posSearch');
    if (!input) return;
    input.addEventListener('input', SwiftMart.utils.debounce(() => {
      const cat = document.getElementById('posCategoryFilter')?.value || 'All';
      this.renderCatalogue(input.value, cat);
    }, 250));
  },

  /* ── Category Filter ────────────────────────────────────── */
  bindCategoryFilter() {
    const btns = document.querySelectorAll('[data-pos-category]');
    btns.forEach(btn => {
      btn.addEventListener('click', () => {
        btns.forEach(b => b.classList.remove('active', 'btn-primary'));
        btn.classList.add('active', 'btn-primary');
        const search = document.getElementById('posSearch')?.value || '';
        this.renderCatalogue(search, btn.dataset.posCategory);
      });
    });
  },

  /* ── Discount Input ─────────────────────────────────────── */
  bindDiscount() {
    const input = document.getElementById('discountInput');
    if (!input) return;
    input.addEventListener('input', () => {
      let v = parseFloat(input.value);
      if (isNaN(v) || v < 0) v = 0;
      if (v > 100) v = 100;
      input.value = v;
      this.updateSummary();
    });
  },

  /* ── Payment Method ─────────────────────────────────────── */
  bindPaymentMethod() {
    document.querySelectorAll('[data-payment]').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('[data-payment]').forEach(b => b.classList.remove('btn-primary'));
        btn.classList.add('btn-primary');
        this._paymentMethod = btn.dataset.payment;
      });
    });
  },

  /* ── Clear Cart ─────────────────────────────────────────── */
  bindClear() {
    const btn = document.getElementById('clearCartBtn');
    if (!btn) return;
    btn.addEventListener('click', () => {
      if (this.cart.length === 0) return;
      if (confirm('Clear all items from cart?')) {
        this.cart = [];
        this.updateCartUI();
        SwiftMart.toasts.show('Cart cleared', 'warning');
      }
    });
  },

  /* ── Checkout / Generate Invoice ─────────────────────────── */
  bindCheckout() {
    const btn = document.getElementById('checkoutBtn');
    if (!btn) return;
    btn.addEventListener('click', () => {
      if (this.cart.length === 0) {
        SwiftMart.toasts.show('Cart is empty!', 'danger');
        return;
      }
      this.generateInvoice();
      SwiftMart.modals.open('invoiceModal');

      /* DB: PHP will execute:
         INSERT INTO ORDERS ... 
         INSERT INTO ORDER_ITEMS ...
         UPDATE PRODUCTS SET stock_qty = stock_qty - :qty ... */
    });
  },

  /* ── Generate Invoice ───────────────────────────────────── */
  generateInvoice() {
    const invoiceNo  = 'INV-' + Date.now().toString().slice(-6);
    const now        = new Date();
    const dateStr    = now.toLocaleDateString('en-GB', { day:'2-digit', month:'short', year:'numeric' });
    const timeStr    = now.toLocaleTimeString('en-US', { hour:'2-digit', minute:'2-digit' });
    const { subtotal, discount, vat, total, discountPct } = this._lastSummary || { subtotal:0, discount:0, vat:0, total:0, discountPct:0 };
    const payment    = this._paymentMethod || 'Cash';
    const cashier    = 'Rahim Uddin';  /* DB: SESSION['user_name'] */
    const branch     = 'Gulshan Branch'; /* DB: SESSION['branch_name'] */

    const itemsHtml = this.cart.map(item => `
      <tr>
        <td>${item.name}</td>
        <td style="text-align:center">${item.qty}</td>
        <td style="text-align:right">৳${item.price.toLocaleString()}</td>
        <td style="text-align:right">৳${(item.price*item.qty).toLocaleString()}</td>
      </tr>`).join('');

    const invoiceHtml = `
      <div style="font-family:'Inter',sans-serif;max-width:480px;margin:0 auto;padding:1.5rem">
        <!-- Header -->
        <div style="text-align:center;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:2px dashed #E2E8F0">
          <div style="font-size:2rem;margin-bottom:0.25rem">🛒</div>
          <h2 style="font-size:1.25rem;font-weight:800;color:#0F172A;margin:0">SwiftMart</h2>
          <p style="font-size:0.75rem;color:#64748B;margin:0.2rem 0">${branch}</p>
          <p style="font-size:0.7rem;color:#94A3B8">Tax ID: BD-2024-0019 | Phone: +880-2-12345678</p>
        </div>
        <!-- Invoice Meta -->
        <div style="display:flex;justify-content:space-between;font-size:0.78rem;color:#64748B;margin-bottom:1rem">
          <div>
            <div><strong style="color:#0F172A">Invoice No:</strong> ${invoiceNo}</div>
            <div><strong style="color:#0F172A">Cashier:</strong> ${cashier}</div>
            <div><strong style="color:#0F172A">Payment:</strong> ${payment}</div>
          </div>
          <div style="text-align:right">
            <div>${dateStr}</div>
            <div>${timeStr}</div>
            <div style="margin-top:0.25rem">
              <span style="background:#ECFDF5;color:#059669;padding:2px 8px;border-radius:99px;font-size:0.7rem;font-weight:700">PAID ✓</span>
            </div>
          </div>
        </div>
        <!-- Items Table -->
        <table style="width:100%;border-collapse:collapse;font-size:0.8rem;margin-bottom:1rem">
          <thead>
            <tr style="background:#F8FAFC;border-bottom:1px solid #E2E8F0">
              <th style="padding:0.5rem 0.25rem;text-align:left;color:#64748B;font-weight:700">Item</th>
              <th style="padding:0.5rem 0.25rem;text-align:center;color:#64748B;font-weight:700">Qty</th>
              <th style="padding:0.5rem 0.25rem;text-align:right;color:#64748B;font-weight:700">Price</th>
              <th style="padding:0.5rem 0.25rem;text-align:right;color:#64748B;font-weight:700">Total</th>
            </tr>
          </thead>
          <tbody>${itemsHtml}</tbody>
        </table>
        <!-- Totals -->
        <div style="border-top:2px dashed #E2E8F0;padding-top:1rem">
          <div style="display:flex;justify-content:space-between;font-size:0.8rem;color:#64748B;padding:0.2rem 0">
            <span>Subtotal</span><span>৳${subtotal.toLocaleString('en',{minimumFractionDigits:2})}</span>
          </div>
          ${discount > 0 ? `<div style="display:flex;justify-content:space-between;font-size:0.8rem;color:#EF4444;padding:0.2rem 0">
            <span>Discount (${discountPct}%)</span><span>-৳${discount.toLocaleString('en',{minimumFractionDigits:2})}</span>
          </div>` : ''}
          <div style="display:flex;justify-content:space-between;font-size:0.8rem;color:#64748B;padding:0.2rem 0">
            <span>VAT (5%)</span><span>৳${vat.toLocaleString('en',{minimumFractionDigits:2})}</span>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:1rem;font-weight:800;color:#0F172A;padding:0.6rem 0;border-top:1px solid #E2E8F0;margin-top:0.4rem">
            <span>TOTAL</span><span>৳${total.toLocaleString('en',{minimumFractionDigits:2})}</span>
          </div>
        </div>
        <!-- Footer -->
        <div style="text-align:center;margin-top:1.5rem;font-size:0.7rem;color:#94A3B8">
          <p>🙏 Thank you for shopping at SwiftMart!</p>
          <p>Carry this receipt for returns within 7 days.</p>
          <p style="margin-top:0.5rem;font-size:0.65rem">Powered by SwiftMart ERP v2.0</p>
        </div>
      </div>`;

    const el = document.getElementById('invoiceContent');
    if (el) el.innerHTML = invoiceHtml;
  },

  /* ── Print Invoice ──────────────────────────────────────── */
  bindPrint() {
    const btn = document.getElementById('printInvoiceBtn');
    if (!btn) return;
    btn.addEventListener('click', () => {
      const content = document.getElementById('invoiceContent')?.innerHTML;
      if (!content) return;
      const win = window.open('', '_blank', 'width=600,height=800');
      win.document.write(`
        <!DOCTYPE html><html>
        <head><title>SwiftMart Invoice</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
        <style>body{margin:0;padding:1rem;background:#fff}@media print{@page{margin:0.5cm}}</style>
        </head><body>${content}<script>window.onload=()=>{window.print();window.close()}<\/script></body></html>`);
      win.document.close();

      // New transaction: clear cart
      setTimeout(() => {
        this.cart = [];
        this.updateCartUI();
        SwiftMart.modals.close('invoiceModal');
        SwiftMart.toasts.show('Invoice printed & order saved!', 'success');
      }, 1000);
    });
  },

  /* ── Category List (derived from products) ──────────────── */
  get categories() {
    return ['All', ...new Set(this.products.map(p => p.category))];
  }
};
