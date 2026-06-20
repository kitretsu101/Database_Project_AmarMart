<?php
/**
 * SwiftMart – pos.php
 * Point-of-Sale billing interface.
 * DB: All cart operations handled by js/pos.js
 *     Server-side order submission via PHP POST (Oracle insert placeholder)
 */
$pageTitle   = 'POS Billing System';
$activeNav   = 'pos';
$includePosJs = true;

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="main-content" id="mainContent">
<?php include 'includes/navbar.php'; ?>

<div class="page-content" style="padding:1rem">

  <!-- Page Header -->
  <div class="page-header" style="margin-bottom:1rem">
    <div class="page-header-left">
      <h1>🧾 POS Billing System</h1>
      <div class="breadcrumb">🏠 Home <span>/</span> POS Billing</div>
    </div>
    <div style="display:flex;align-items:center;gap:0.75rem">
      <span style="font-size:0.8rem;color:var(--color-text-muted)">
        Cashier: <strong>Rahim Uddin</strong> · Branch: <strong>Gulshan</strong>
        <!-- DB: $_SESSION['user_name'] / $_SESSION['branch_name'] -->
      </span>
      <span class="badge badge-success">● Terminal Active</span>
    </div>
  </div>

  <!-- POS Layout -->
  <div class="pos-layout">

    <!-- ── Left: Products ───────────────────────────────── -->
    <div class="pos-left">

      <!-- Search + Category Filter -->
      <div class="card" style="padding:1rem">
        <div style="display:flex;gap:0.75rem;margin-bottom:0.75rem;flex-wrap:wrap">
          <div class="search-box" style="flex:1;min-width:200px">
            <span class="search-icon">🔍</span>
            <input type="text" id="posSearch" placeholder="Search by name or scan barcode…" autocomplete="off"/>
          </div>
          <input type="text" class="form-control" placeholder="📷 Scan Barcode" style="width:180px" id="barcodeInput"/>
        </div>

        <!-- Category Buttons -->
        <div style="display:flex;gap:0.5rem;flex-wrap:wrap">
          <button class="btn btn-primary btn-sm active" data-pos-category="All">All</button>
          <button class="btn btn-ghost btn-sm" data-pos-category="Beverages">☕ Beverages</button>
          <button class="btn btn-ghost btn-sm" data-pos-category="Dairy">🥛 Dairy</button>
          <button class="btn btn-ghost btn-sm" data-pos-category="Grocery">🫙 Grocery</button>
          <button class="btn btn-ghost btn-sm" data-pos-category="Snacks">🍪 Snacks</button>
          <button class="btn btn-ghost btn-sm" data-pos-category="Household">🧺 Household</button>
          <button class="btn btn-ghost btn-sm" data-pos-category="Personal">🧼 Personal</button>
          <button class="btn btn-ghost btn-sm" data-pos-category="Bakery">🍞 Bakery</button>
        </div>
      </div>

      <!-- Product Grid -->
      <!-- DB: Populated by pos.js → POSModule.products (replace with Oracle fetch) -->
      <div class="card" style="flex:1;padding:1rem;overflow:hidden;display:flex;flex-direction:column">
        <div class="pos-products-grid" id="posProductGrid">
          <!-- Rendered by pos.js -->
        </div>
      </div>
    </div>

    <!-- ── Right: Cart + Summary ─────────────────────────── -->
    <div class="pos-right">

      <!-- Customer Search -->
      <div class="card" style="padding:1rem">
        <div class="form-group" style="margin-bottom:0.5rem">
          <label class="form-label" style="font-size:0.8rem">👤 Customer (Optional)</label>
          <!-- DB: SELECT customer_id, full_name, membership_tier FROM CUSTOMERS WHERE phone = :phone -->
          <div class="search-box">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="Search by phone or name…" id="customerSearch"/>
          </div>
        </div>
        <div id="customerInfo" style="font-size:0.75rem;color:var(--color-text-muted);display:flex;align-items:center;gap:0.5rem">
          <span>Walk-in Customer</span>
          <span class="badge badge-gray">No loyalty points</span>
        </div>
      </div>

      <!-- Cart -->
      <div class="cart-panel">
        <div class="cart-header">
          <span>🛒 Cart</span>
          <span class="badge badge-primary" id="cartCount">0</span>
        </div>
        <div class="cart-items" id="cartItems">
          <div class="empty-state" id="cartEmpty" style="padding:2rem">
            <div class="empty-state-icon">🛒</div>
            <h3>Cart is Empty</h3>
            <p>Click a product to add it</p>
          </div>
        </div>

        <!-- Summary -->
        <div class="cart-summary">
          <div class="form-row" style="gap:0.5rem;margin-bottom:0.5rem">
            <div class="form-group" style="margin-bottom:0">
              <label class="form-label" style="font-size:0.75rem">Discount %</label>
              <input type="number" class="form-control" id="discountInput" value="0" min="0" max="100" placeholder="0"/>
            </div>
            <div class="form-group" style="margin-bottom:0">
              <label class="form-label" style="font-size:0.75rem">VAT Rate</label>
              <input type="text" class="form-control" value="5%" readonly style="background:var(--color-bg)"/>
            </div>
          </div>
          <div class="summary-row">
            <span>Subtotal</span>
            <strong id="summarySubtotal">৳0.00</strong>
          </div>
          <div class="summary-row">
            <span>Discount</span>
            <strong id="summaryDiscount" style="color:var(--color-danger)">৳0.00</strong>
          </div>
          <div class="summary-row">
            <span>VAT (5%)</span>
            <strong id="summaryVAT">৳0.00</strong>
          </div>
          <div class="summary-total">
            <span>Total</span>
            <span id="summaryTotal">৳0.00</span>
          </div>
        </div>

        <!-- Payment Method -->
        <div style="padding:0 1.25rem">
          <label class="form-label" style="font-size:0.75rem;margin-bottom:0.5rem">Payment Method</label>
          <div style="display:flex;gap:0.5rem;flex-wrap:wrap">
            <button class="btn btn-primary btn-sm" data-payment="Cash">💵 Cash</button>
            <button class="btn btn-ghost btn-sm" data-payment="Card">💳 Card</button>
            <button class="btn btn-ghost btn-sm" data-payment="bKash">📱 bKash</button>
            <button class="btn btn-ghost btn-sm" data-payment="Nagad">📱 Nagad</button>
          </div>
        </div>

        <!-- Actions -->
        <div class="cart-actions" id="cartActions" style="display:none;flex-direction:column;gap:0.5rem">
          <button class="btn btn-primary btn-lg w-full" id="checkoutBtn">
            🧾 Generate Invoice
          </button>
          <button class="btn btn-ghost w-full" id="clearCartBtn">🗑 Clear Cart</button>
        </div>
      </div>

    </div><!-- /pos-right -->
  </div><!-- /pos-layout -->
</div><!-- /page-content -->

<!-- ── Invoice Modal ──────────────────────────────────────── -->
<div class="modal-overlay" id="invoiceModal">
  <div class="modal" style="max-width:520px">
    <div class="modal-header">
      <h2 class="modal-title">🧾 Invoice Preview</h2>
      <button class="modal-close" data-modal-close="invoiceModal">✕</button>
    </div>
    <div class="modal-body" style="padding:1rem">
      <div id="invoiceContent"><!-- Generated by pos.js --></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" data-modal-close="invoiceModal">Close</button>
      <button class="btn btn-outline" onclick="SwiftMart.toasts.show('Invoice sent via email!','success')">📧 Email</button>
      <button class="btn btn-primary" id="printInvoiceBtn">🖨 Print Invoice</button>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
