<?php
/**
 * SwiftMart – inventory.php
 * Product inventory table with search, filter, add/edit/delete modals.
 *
 * DB Integration Points:
 * DB: SELECT p.barcode, p.product_name, c.category_name, b.brand_name,
 *               p.unit, p.stock_qty, p.min_stock_level, p.expiry_date, p.is_active
 *         FROM PRODUCTS p
 *         JOIN CATEGORIES c ON p.category_id = c.category_id
 *         JOIN BRANDS b ON p.brand_id = b.brand_id
 *         ORDER BY p.product_name
 */

$pageTitle = 'Inventory Management';
$activeNav = 'inventory';

$products = [
  ['barcode' => '8901030012873', 'name' => 'Nescafé Gold 200g', 'category' => 'Beverages', 'brand' => 'Nestlé', 'unit' => 'pcs', 'stock' => 142, 'min' => 50, 'expiry' => '2025-12-31', 'status' => 'In Stock'],
  ['barcode' => '8001841011345', 'name' => 'Ariel Detergent 1kg', 'category' => 'Household', 'brand' => 'P&G', 'unit' => 'pcs', 'stock' => 87, 'min' => 30, 'expiry' => '2026-06-30', 'status' => 'In Stock'],
  ['barcode' => '8912345001234', 'name' => 'Pran Mango Juice 250ml', 'category' => 'Beverages', 'brand' => 'PRAN', 'unit' => 'pcs', 'stock' => 320, 'min' => 100, 'expiry' => '2025-09-15', 'status' => 'In Stock'],
  ['barcode' => '8901234001122', 'name' => 'Fresh Milk 1L', 'category' => 'Dairy', 'brand' => 'Farm Fresh', 'unit' => 'pcs', 'stock' => 200, 'min' => 80, 'expiry' => '2025-07-25', 'status' => 'In Stock'],
  ['barcode' => '8909876001234', 'name' => 'Whole Wheat Bread', 'category' => 'Bakery', 'brand' => 'Olympic', 'unit' => 'pcs', 'stock' => 54, 'min' => 40, 'expiry' => '2025-07-22', 'status' => 'Low Stock'],
  ['barcode' => '8901030009000', 'name' => 'Colgate Toothpaste 150g', 'category' => 'Personal', 'brand' => 'Colgate', 'unit' => 'pcs', 'stock' => 95, 'min' => 50, 'expiry' => '2027-01-01', 'status' => 'In Stock'],
  ['barcode' => '8905678001456', 'name' => 'Egg (12 pcs)', 'category' => 'Dairy', 'brand' => 'Aftab', 'unit' => 'dozen', 'stock' => 180, 'min' => 60, 'expiry' => '2025-07-28', 'status' => 'In Stock'],
  ['barcode' => '8903456001789', 'name' => 'Sunflower Oil 1L', 'category' => 'Grocery', 'brand' => 'Rupchanda', 'unit' => 'bottle', 'stock' => 112, 'min' => 50, 'expiry' => '2026-03-31', 'status' => 'In Stock'],
  ['barcode' => '8902790000123', 'name' => 'Parachute Coconut Oil', 'category' => 'Personal', 'brand' => 'Marico', 'unit' => 'bottle', 'stock' => 12, 'min' => 40, 'expiry' => '2026-08-01', 'status' => 'Critical'],
  ['barcode' => '7622210713456', 'name' => 'Oreo Cookies 120g', 'category' => 'Snacks', 'brand' => 'Nabisco', 'unit' => 'pcs', 'stock' => 230, 'min' => 80, 'expiry' => '2025-11-30', 'status' => 'In Stock'],
  ['barcode' => '8901058014789', 'name' => 'Maggi Noodles 75g', 'category' => 'Grocery', 'brand' => 'Nestlé', 'unit' => 'pcs', 'stock' => 400, 'min' => 150, 'expiry' => '2026-02-28', 'status' => 'In Stock'],
  ['barcode' => '8710522010456', 'name' => 'Lipton Tea 100g', 'category' => 'Beverages', 'brand' => 'Unilever', 'unit' => 'box', 'stock' => 8, 'min' => 30, 'expiry' => '2026-09-30', 'status' => 'Critical'],
  ['barcode' => '8710908011789', 'name' => 'Lux Soap 125g', 'category' => 'Personal', 'brand' => 'Unilever', 'unit' => 'pcs', 'stock' => 160, 'min' => 60, 'expiry' => '2027-06-30', 'status' => 'In Stock'],
  ['barcode' => '0380008459012', 'name' => 'Pringles Original 165g', 'category' => 'Snacks', 'brand' => 'Kellogg\'s', 'unit' => 'tin', 'stock' => 45, 'min' => 25, 'expiry' => '2025-10-15', 'status' => 'Low Stock'],
  ['barcode' => '4902205000123', 'name' => 'Yakult 5-pack', 'category' => 'Dairy', 'brand' => 'Yakult', 'unit' => 'pack', 'stock' => 60, 'min' => 30, 'expiry' => '2025-07-30', 'status' => 'In Stock'],
];

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="main-content" id="mainContent">
  <?php include 'includes/navbar.php'; ?>
  <div class="page-content">

    <!-- Page Header -->
    <div class="page-header">
      <div class="page-header-left">
        <h1>📦 Inventory Management</h1>
        <div class="breadcrumb">🏠 Home <span>/</span> Inventory</div>
      </div>
      <div style="display:flex;gap:0.75rem;flex-wrap:wrap">
        <button class="btn btn-outline" onclick="window.print()">🖨 Export</button>
        <button class="btn btn-primary" data-modal-open="addProductModal">➕ Add Product</button>
      </div>
    </div>

    <!-- Stats Row -->
    <div class="grid-4 mb-3">
      <div class="stat-card" style="--stat-color:#2563EB;--stat-icon-bg:#EFF6FF">
        <div class="stat-icon">📦</div>
        <div class="stat-info">
          <div class="stat-value">3,847</div>
          <div class="stat-label">Total Products</div>
        </div>
      </div>
      <div class="stat-card" style="--stat-color:#10B981;--stat-icon-bg:#ECFDF5">
        <div class="stat-icon">✅</div>
        <div class="stat-info">
          <div class="stat-value">3,621</div>
          <div class="stat-label">In Stock</div>
        </div>
      </div>
      <div class="stat-card" style="--stat-color:#F59E0B;--stat-icon-bg:#FFFBEB">
        <div class="stat-icon">⚠️</div>
        <div class="stat-info">
          <div class="stat-value">154</div>
          <div class="stat-label">Low Stock</div>
        </div>
      </div>
      <div class="stat-card" style="--stat-color:#EF4444;--stat-icon-bg:#FEF2F2">
        <div class="stat-icon">🚨</div>
        <div class="stat-info">
          <div class="stat-value">72</div>
          <div class="stat-label">Out of Stock</div>
        </div>
      </div>
    </div>

    <!-- Filter Bar -->
    <div class="card mb-2" style="padding:1rem">
      <div class="filter-bar" style="flex-wrap:wrap">
        <div class="search-box" style="flex:1;min-width:220px">
          <span class="search-icon">🔍</span>
          <input type="text" placeholder="Search by name, barcode, brand…" id="invSearch"
            data-table-search="inventoryTable" />
        </div>
        <select class="form-control" style="width:auto" id="catFilter">
          <option value="">All Categories</option>
          <option>Beverages</option>
          <option>Household</option>
          <option>Dairy</option>
          <option>Bakery</option>
          <option>Personal</option>
          <option>Grocery</option>
          <option>Snacks</option>
        </select>
        <select class="form-control" style="width:auto">
          <option value="">All Status</option>
          <option>In Stock</option>
          <option>Low Stock</option>
          <option>Critical</option>
        </select>
        <button class="btn btn-ghost btn-sm">🔄 Reset</button>
      </div>
    </div>

    <!-- Inventory Table -->
    <div class="card" style="padding:0">
      <div class="card-header" style="padding:1rem 1.25rem;border-bottom:1px solid var(--color-border-light)">
        <h3 class="card-title">Product Inventory</h3>
        <span class="badge badge-primary"><?= count($products) ?> Products</span>
      </div>
      <div class="table-wrapper" style="border:none;border-radius:0">
        <table class="data-table" id="inventoryTable">
          <thead>
            <tr>
              <th>Barcode</th>
              <th>Product Name</th>
              <th>Category</th>
              <th>Brand</th>
              <th>Unit</th>
              <th>Stock Qty</th>
              <th>Expiry Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $p):
              $statusClass = match ($p['status']) {
                'In Stock' => 'badge-success',
                'Low Stock' => 'badge-warning',
                'Critical' => 'badge-danger',
                default => 'badge-gray'
              };
              $stockColor = match ($p['status']) {
                'Low Stock' => 'color:var(--color-warning);font-weight:700',
                'Critical' => 'color:var(--color-danger);font-weight:700',
                default => 'font-weight:600'
              };
              $expiryDate = new DateTime($p['expiry']);
              $now = new DateTime();
              $diff = $now->diff($expiryDate)->days;
              $expiryWarn = $diff <= 30 && $expiryDate > $now;
              ?>
              <tr>
                <td><code style="font-size:0.7rem;color:var(--color-text-muted)"><?= $p['barcode'] ?></code></td>
                <td>
                  <strong><?= $p['name'] ?></strong>
                  <?php if ($p['stock'] < $p['min']): ?>
                    <span class="badge badge-danger" style="margin-left:0.5rem;font-size:0.6rem">⚠ Low</span>
                  <?php endif; ?>
                </td>
                <td><span class="badge badge-primary"><?= $p['category'] ?></span></td>
                <td style="color:var(--color-text-muted)"><?= $p['brand'] ?></td>
                <td><?= $p['unit'] ?></td>
                <td style="<?= $stockColor ?>">
                  <?= number_format($p['stock']) ?>
                  <div class="progress-bar-wrap" style="margin-top:4px;width:60px">
                    <div class="progress-bar" style="width:<?= min(100, round($p['stock'] / $p['min'] * 50)) ?>%"></div>
                  </div>
                </td>
                <td style="<?= $expiryWarn ? 'color:var(--color-warning);font-weight:600' : '' ?>">
                  <?= date('d M Y', strtotime($p['expiry'])) ?>
                  <?php if ($expiryWarn): ?> <span style="font-size:0.65rem">(<?= $diff ?>d)</span><?php endif; ?>
                </td>
                <td><span class="badge <?= $statusClass ?>"><?= $p['status'] ?></span></td>
                <td>
                  <div class="actions">
                    <button class="btn btn-ghost btn-sm" title="View" data-modal-open="viewProductModal">👁</button>
                    <button class="btn btn-outline btn-sm" title="Edit" data-modal-open="editProductModal">✏️</button>
                    <button class="btn btn-danger btn-sm" title="Delete"
                      onclick="confirmDelete('<?= htmlspecialchars($p['name']) ?>')">🗑</button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <!-- Pagination placeholder -->
      <div
        style="padding:1rem 1.25rem;display:flex;align-items:center;justify-content:space-between;border-top:1px solid var(--color-border-light)">
        <span style="font-size:0.8rem;color:var(--color-text-muted)">
          Showing 1–<?= count($products) ?> of 3,847 products
          <!-- DB: COUNT from paginated PRODUCTS query -->
        </span>
        <div style="display:flex;gap:0.4rem">
          <button class="btn btn-ghost btn-sm">← Prev</button>
          <button class="btn btn-primary btn-sm">1</button>
          <button class="btn btn-ghost btn-sm">2</button>
          <button class="btn btn-ghost btn-sm">3</button>
          <button class="btn btn-ghost btn-sm">Next →</button>
        </div>
      </div>
    </div>

  </div><!-- /page-content -->

  <!-- ── Add Product Modal ──────────────────────────────────── -->
  <div class="modal-overlay" id="addProductModal">
    <div class="modal" style="max-width:620px">
      <div class="modal-header">
        <h2 class="modal-title">➕ Add New Product</h2>
        <button class="modal-close" data-modal-close="addProductModal">✕</button>
      </div>
      <div class="modal-body">
        <!-- DB: INSERT INTO PRODUCTS (...) VALUES (...) -->
        <form id="addProductForm">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Product Name *</label>
              <input type="text" class="form-control" placeholder="e.g. Nescafé Gold 200g" required />
            </div>
            <div class="form-group">
              <label class="form-label">Barcode</label>
              <input type="text" class="form-control" placeholder="e.g. 8901030012873" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Category *</label>
              <select class="form-control" required>
                <option value="">Select Category</option>
                <option>Beverages</option>
                <option>Household</option>
                <option>Dairy</option>
                <option>Bakery</option>
                <option>Personal</option>
                <option>Grocery</option>
                <option>Snacks</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Brand</label>
              <input type="text" class="form-control" placeholder="e.g. Nestlé" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Cost Price (৳)</label>
              <input type="number" class="form-control" placeholder="0.00" min="0" step="0.01" />
            </div>
            <div class="form-group">
              <label class="form-label">Sale Price (৳) *</label>
              <input type="number" class="form-control" placeholder="0.00" min="0" step="0.01" required />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Stock Quantity *</label>
              <input type="number" class="form-control" placeholder="0" min="0" required />
            </div>
            <div class="form-group">
              <label class="form-label">Min Stock Level</label>
              <input type="number" class="form-control" placeholder="e.g. 50" min="0" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Unit</label>
              <select class="form-control">
                <option>pcs</option>
                <option>kg</option>
                <option>g</option>
                <option>L</option>
                <option>mL</option>
                <option>box</option>
                <option>dozen</option>
                <option>pack</option>
                <option>bottle</option>
                <option>tin</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Expiry Date</label>
              <input type="date" class="form-control" />
            </div>
          </div>
          <div class="alert alert-info" style="margin-top:0.5rem">
            ℹ️ <strong>Oracle DB:</strong> This form will call a PL/SQL procedure
            <code>ADD_PRODUCT(:barcode, :name, :category_id, :brand_id, :cost, :sale, :stock, :unit, :expiry)</code>
            after DB integration.
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-ghost" data-modal-close="addProductModal">Cancel</button>
        <button class="btn btn-primary"
          onclick="SwiftMart.toasts.show('Product saved! (DB placeholder)', 'success'); SwiftMart.modals.close('addProductModal')">
          💾 Save Product
        </button>
      </div>
    </div>
  </div>

  <!-- ── Edit Product Modal ──────────────────────────────────── -->
  <div class="modal-overlay" id="editProductModal">
    <div class="modal" style="max-width:620px">
      <div class="modal-header">
        <h2 class="modal-title">✏️ Edit Product</h2>
        <button class="modal-close" data-modal-close="editProductModal">✕</button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Product Name</label>
            <input type="text" class="form-control" value="Nescafé Gold 200g" />
          </div>
          <div class="form-group">
            <label class="form-label">Barcode</label>
            <input type="text" class="form-control" value="8901030012873" />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Sale Price (৳)</label>
            <input type="number" class="form-control" value="850" />
          </div>
          <div class="form-group">
            <label class="form-label">Stock Quantity</label>
            <input type="number" class="form-control" value="142" />
          </div>
        </div>
        <div class="alert alert-info">
          ℹ️ <strong>Oracle DB:</strong> UPDATE PRODUCTS SET ... WHERE product_id = :id
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-ghost" data-modal-close="editProductModal">Cancel</button>
        <button class="btn btn-primary"
          onclick="SwiftMart.toasts.show('Product updated!', 'success'); SwiftMart.modals.close('editProductModal')">
          💾 Update Product
        </button>
      </div>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>

  <script>
    function confirmDelete(name) {
      if (confirm(`Are you sure you want to delete "${name}"?\n\nDB: DELETE FROM PRODUCTS WHERE product_id = :id`)) {
        SwiftMart.toasts.show(`${name} deleted (DB placeholder)`, 'danger');
      }
    }
  </script>