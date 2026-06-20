<?php
/**
 * SwiftMart – products.php
 * Products catalogue: Category cards, product grid, product detail view.
 *
 * DB Integration Points:
 * DB: SELECT p.product_id, p.product_name, c.category_name, b.brand_name,
 *               p.sale_price, p.stock_qty, p.emoji, p.aisle_number, p.shelf_number
 *         FROM PRODUCTS p
 *         JOIN CATEGORIES c ON p.category_id = c.category_id
 *         JOIN BRANDS b ON p.brand_id = b.brand_id
 *         WHERE p.is_active = 1
 *         ORDER BY c.category_name, p.product_name
 */
$pageTitle = 'Products & Categories';
$activeNav = 'products';

$categories = [
  ['name' => 'Beverages',     'icon' => '☕', 'count' => 542],
  ['name' => 'Household',     'icon' => '🧺', 'count' => 318],
  ['name' => 'Dairy',         'icon' => '🥛', 'count' => 421],
  ['name' => 'Bakery',        'icon' => '🍞', 'count' => 195],
  ['name' => 'Personal Care', 'icon' => '🧼', 'count' => 612],
  ['name' => 'Grocery',       'icon' => '🌾', 'count' => 1105],
  ['name' => 'Snacks',        'icon' => '🍪', 'count' => 654],
];

$products = [
  ['id' => 'P001', 'barcode'=>'8901030012873', 'name'=>'Nescafé Gold 200g',      'category'=>'Beverages',     'brand'=>'Nestlé',      'price'=>850,  'stock'=>142, 'emoji'=>'☕',  'location'=>'Aisle 3, Shelf B'],
  ['id' => 'P002', 'barcode'=>'8001841011345', 'name'=>'Ariel Detergent 1kg',    'category'=>'Household',     'brand'=>'P&G',         'price'=>420,  'stock'=>87,  'emoji'=>'🧺',  'location'=>'Aisle 8, Shelf A'],
  ['id' => 'P003', 'barcode'=>'8912345001234', 'name'=>'Pran Mango Juice 250ml', 'category'=>'Beverages',     'brand'=>'PRAN',        'price'=>35,   'stock'=>320, 'emoji'=>'🥭',  'location'=>'Aisle 3, Shelf D'],
  ['id' => 'P004', 'barcode'=>'8901234001122', 'name'=>'Fresh Milk 1L',          'category'=>'Dairy',         'brand'=>'Farm Fresh',  'price'=>90,   'stock'=>200, 'emoji'=>'🥛',  'location'=>'Aisle 2, Cold Box A'],
  ['id' => 'P005', 'barcode'=>'8909876001234', 'name'=>'Whole Wheat Bread',      'category'=>'Bakery',        'brand'=>'Olympic',     'price'=>65,   'stock'=>54,  'emoji'=>'🍞',  'location'=>'Aisle 1, Shelf C'],
  ['id' => 'P006', 'barcode'=>'8901030009000', 'name'=>'Colgate Toothpaste 150g','category'=>'Personal Care', 'brand'=>'Colgate',     'price'=>180,  'stock'=>95,  'emoji'=>'🪥',  'location'=>'Aisle 6, Shelf B'],
  ['id' => 'P007', 'barcode'=>'8905678001456', 'name'=>'Egg (12 pcs)',           'category'=>'Dairy',         'brand'=>'Aftab',       'price'=>150,  'stock'=>180, 'emoji'=>'🥚',  'location'=>'Aisle 2, Shelf F'],
  ['id' => 'P008', 'barcode'=>'8903456001789', 'name'=>'Sunflower Oil 1L',       'category'=>'Grocery',       'brand'=>'Rupchanda',   'price'=>220,  'stock'=>112, 'emoji'=>'🫙',  'location'=>'Aisle 4, Shelf A'],
  ['id' => 'P009', 'barcode'=>'8902790000123', 'name'=>'Parachute Coconut Oil',  'category'=>'Personal Care', 'brand'=>'Marico',      'price'=>340,  'stock'=>12,  'emoji'=>'🧴',  'location'=>'Aisle 6, Shelf D'],
  ['id' => 'P010', 'barcode'=>'7622210713456', 'name'=>'Oreo Cookies 120g',      'category'=>'Snacks',        'brand'=>'Nabisco',     'price'=>95,   'stock'=>230, 'emoji'=>'🍪',  'location'=>'Aisle 5, Shelf E'],
  ['id' => 'P011', 'barcode'=>'8901058014789', 'name'=>'Maggi Noodles 75g',      'category'=>'Grocery',       'brand'=>'Nestlé',      'price'=>30,   'stock'=>400, 'emoji'=>'🍜',  'location'=>'Aisle 4, Shelf C'],
  ['id' => 'P012', 'barcode'=>'8710522010456', 'name'=>'Lipton Tea 100g',        'category'=>'Beverages',     'brand'=>'Unilever',    'price'=>280,  'stock'=>8,   'emoji'=>'🍵',  'location'=>'Aisle 3, Shelf C'],
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
      <h1>🏷️ Products & Categories</h1>
      <div class="breadcrumb">🏠 Home <span>/</span> Products</div>
    </div>
    <div style="display:flex;gap:0.75rem;flex-wrap:wrap">
      <button class="btn btn-outline" data-modal-open="addProductModal">➕ Add Category</button>
      <button class="btn btn-primary" data-modal-open="addProductModal">➕ Add Product</button>
    </div>
  </div>

  <!-- ── Category Selection Row ── -->
  <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(130px, 1fr));gap:0.75rem;margin-bottom:1.5rem">
    <div class="card cat-card active" style="padding:1rem;text-align:center;cursor:pointer;border-top:4px solid var(--color-primary);transition:all var(--transition-fast)" onclick="filterCategory('')">
      <div style="font-size:1.75rem;margin-bottom:0.25rem">🏬</div>
      <h4 style="font-size:0.875rem;font-weight:600">All Items</h4>
      <span class="badge badge-primary" style="margin-top:0.35rem">3.8K</span>
    </div>
    <?php foreach ($categories as $c): ?>
    <div class="card cat-card" style="padding:1rem;text-align:center;cursor:pointer;transition:all var(--transition-fast)" onclick="filterCategory('<?= $c['name'] ?>')">
      <div style="font-size:1.75rem;margin-bottom:0.25rem"><?= $c['icon'] ?></div>
      <h4 style="font-size:0.875rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= $c['name'] ?></h4>
      <span class="badge badge-gray" style="margin-top:0.35rem"><?= $c['count'] ?></span>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Filter Bar -->
  <div class="card mb-2" style="padding:1rem">
    <div class="filter-bar" style="flex-wrap:wrap">
      <div class="search-box" style="flex:1;min-width:220px">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Search by name, barcode, brand or location…" id="prodSearch" onkeyup="searchProducts()"/>
      </div>
      <select class="form-control" style="width:auto" id="stockFilter" onchange="searchProducts()">
        <option value="">All Stock Status</option>
        <option value="instock">In Stock (Qty > 50)</option>
        <option value="lowstock">Low Stock (Qty ≤ 50)</option>
        <option value="outofstock">Out of Stock (Qty = 0)</option>
      </select>
      <select class="form-control" style="width:auto" id="sortFilter" onchange="searchProducts()">
        <option value="name_asc">Name: A to Z</option>
        <option value="name_desc">Name: Z to A</option>
        <option value="price_asc">Price: Low to High</option>
        <option value="price_desc">Price: High to Low</option>
        <option value="stock_desc">Stock: High to Low</option>
      </select>
      <button class="btn btn-ghost btn-sm" onclick="resetFilters()">🔄 Reset</button>
    </div>
  </div>

  <!-- Product Grid -->
  <!-- DB: SELECT * FROM PRODUCTS -->
  <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(260px, 1fr));gap:1.25rem" id="productGrid">
    <?php foreach ($products as $p):
      $isLow = $p['stock'] <= 50;
      $isOut = $p['stock'] == 0;
      $badge = $isOut ? 'badge-danger' : ($isLow ? 'badge-warning' : 'badge-success');
      $badgeText = $isOut ? 'Out of Stock' : ($isLow ? 'Low Stock' : 'In Stock');
    ?>
    <div class="card product-item-card" data-category="<?= htmlspecialchars($p['category']) ?>" data-name="<?= htmlspecialchars(strtolower($p['name'])) ?>" data-brand="<?= htmlspecialchars(strtolower($p['brand'])) ?>" data-barcode="<?= $p['barcode'] ?>" data-price="<?= $p['price'] ?>" data-stock="<?= $p['stock'] ?>" style="display:flex;flex-direction:column;justify-content:space-between;padding:1.25rem">
      <div>
        <!-- Card Header Area -->
        <div style="display:flex;justify-content:between;align-items:start;margin-bottom:0.75rem">
          <span class="badge badge-primary"><?= htmlspecialchars($p['category']) ?></span>
          <span class="badge <?= $badge ?>" style="margin-left:auto"><?= $badgeText ?></span>
        </div>

        <!-- Product Image Placeholder (Emoji) -->
        <div style="height:100px;background:var(--color-bg);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;font-size:3rem;margin-bottom:1rem;border:1px dashed var(--color-border)">
          <?= $p['emoji'] ?>
        </div>

        <!-- Product Details -->
        <h3 style="font-size:1rem;font-weight:700;margin-bottom:0.25rem"><?= htmlspecialchars($p['name']) ?></h3>
        <p style="font-size:0.75rem;margin-bottom:0.75rem">Brand: <strong><?= htmlspecialchars($p['brand']) ?></strong> | Loc: <?= htmlspecialchars($p['location']) ?></p>
        <code style="font-size:0.7rem;color:var(--color-text-light);display:block;margin-bottom:0.5rem">Barcode: <?= $p['barcode'] ?></code>
      </div>

      <!-- Price & Actions -->
      <div style="border-top:1px solid var(--color-border-light);padding-top:0.75rem;margin-top:0.5rem;display:flex;align-items:center;justify-content:space-between">
        <div>
          <span style="font-size:0.7rem;color:var(--color-text-muted);display:block">Price</span>
          <strong style="font-size:1.2rem;color:var(--color-primary)">৳<?= number_format($p['price']) ?></strong>
        </div>
        <div style="text-align:right">
          <span style="font-size:0.7rem;color:var(--color-text-muted);display:block">Stock</span>
          <strong style="font-size:0.875rem"><?= number_format($p['stock']) ?> pcs</strong>
        </div>
      </div>
      
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;margin-top:0.75rem">
        <button class="btn btn-outline btn-sm" onclick="showProductDetails(<?= htmlspecialchars(json_encode($p)) ?>)">👁 Details</button>
        <button class="btn btn-primary btn-sm" data-modal-open="editProductModal" onclick="setupEditModal(<?= htmlspecialchars(json_encode($p)) ?>)">✏️ Edit</button>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Empty State -->
  <div id="noProductsMessage" class="card" style="display:none;text-align:center;padding:3rem">
    <div style="font-size:3rem;margin-bottom:1rem">🔍</div>
    <h3>No Products Found</h3>
    <p>Try resetting the search or category filters.</p>
    <button class="btn btn-primary" style="margin-top:1rem;display:inline-flex" onclick="resetFilters()">Reset All Filters</button>
  </div>

</div><!-- /page-content -->

<!-- ── Product Details Modal ── -->
<div class="modal-overlay" id="productDetailsModal">
  <div class="modal" style="max-width:600px">
    <div class="modal-header">
      <h2 class="modal-title" id="mDetTitle">Product Details</h2>
      <button class="modal-close" data-modal-close="productDetailsModal">✕</button>
    </div>
    <div class="modal-body" style="padding-top:0.5rem">
      <div style="display:flex;gap:1.5rem;align-items:center;margin-bottom:1.5rem;background:var(--color-bg);padding:1rem;border-radius:var(--radius-lg)">
        <div id="mDetEmoji" style="font-size:4rem;background:#fff;width:80px;height:80px;border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;box-shadow:var(--shadow-sm)">☕</div>
        <div>
          <h3 id="mDetName" style="font-size:1.25rem">Product Name</h3>
          <span class="badge badge-primary" id="mDetCategory" style="margin-top:0.25rem">Category</span>
          <span class="badge badge-success" id="mDetStatus" style="margin-top:0.25rem">Status</span>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem">
        <div>
          <span style="font-size:0.75rem;color:var(--color-text-muted)">Barcode ID</span>
          <p style="font-weight:600" id="mDetBarcode">890123456</p>
        </div>
        <div>
          <span style="font-size:0.75rem;color:var(--color-text-muted)">Brand</span>
          <p style="font-weight:600" id="mDetBrand">BrandName</p>
        </div>
        <div>
          <span style="font-size:0.75rem;color:var(--color-text-muted)">Selling Price</span>
          <p style="font-weight:600;color:var(--color-primary)" id="mDetPrice">৳0.00</p>
        </div>
        <div>
          <span style="font-size:0.75rem;color:var(--color-text-muted)">Current Stock</span>
          <p style="font-weight:600" id="mDetStock">0 pcs</p>
        </div>
        <div>
          <span style="font-size:0.75rem;color:var(--color-text-muted)">ERP Location Shelf</span>
          <p style="font-weight:600" id="mDetLocation">Aisle 1, Shelf A</p>
        </div>
        <div>
          <span style="font-size:0.75rem;color:var(--color-text-muted)">Supplier Info</span>
          <p style="font-weight:600"><a href="suppliers.php" style="color:var(--color-primary);text-decoration:underline">View Suppliers 🔗</a></p>
        </div>
      </div>

      <div class="alert alert-info" style="margin-bottom:0">
        <h4>📦 Oracle Database Integration Points:</h4>
        <p style="font-size:0.8rem;line-height:1.4;margin-top:0.25rem">
          • <strong>Audit History:</strong> Fetch items audit trail via <code>SELECT * FROM PRODUCT_LOGS WHERE barcode = :barcode</code>.<br>
          • <strong>Oracle Procedure:</strong> Reorder trigger executes when <code>stock_qty <= reorder_level</code>.<br>
          • <strong>Inventory PL/SQL Package:</strong> Calls <code>INVENTORY_PKG.GET_STOCK_TREND(:barcode)</code>.
        </p>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-outline" data-modal-close="productDetailsModal">Close</button>
      <button class="btn btn-primary" data-modal-open="editProductModal" onclick="SwiftMart.modals.close('productDetailsModal')">Edit Item</button>
    </div>
  </div>
</div>

<!-- ── Add Product Modal ── -->
<div class="modal-overlay" id="addProductModal">
  <div class="modal" style="max-width:620px">
    <div class="modal-header">
      <h2 class="modal-title">➕ Add New Product</h2>
      <button class="modal-close" data-modal-close="addProductModal">✕</button>
    </div>
    <div class="modal-body">
      <form id="addProductForm">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Product Name *</label>
            <input type="text" class="form-control" placeholder="e.g. Fresh Milk 1L" required/>
          </div>
          <div class="form-group">
            <label class="form-label">Barcode</label>
            <input type="text" class="form-control" placeholder="e.g. 8901234001122"/>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Category *</label>
            <select class="form-control" required>
              <option value="">Select Category</option>
              <option>Beverages</option><option>Household</option><option>Dairy</option>
              <option>Bakery</option><option>Personal Care</option><option>Grocery</option><option>Snacks</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Brand</label>
            <input type="text" class="form-control" placeholder="e.g. Farm Fresh"/>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Sale Price (৳) *</label>
            <input type="number" class="form-control" placeholder="0.00" min="0" step="0.01" required/>
          </div>
          <div class="form-group">
            <label class="form-label">Stock Quantity *</label>
            <input type="number" class="form-control" placeholder="0" min="0" required/>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Aisle Number</label>
            <input type="text" class="form-control" placeholder="e.g. Aisle 3"/>
          </div>
          <div class="form-group">
            <label class="form-label">Shelf Number</label>
            <input type="text" class="form-control" placeholder="e.g. Shelf B"/>
          </div>
        </div>
        <div class="alert alert-info" style="margin-top:0.5rem">
          ℹ️ <strong>Oracle DB:</strong> This calls the PL/SQL procedure <code>ADD_NEW_PRODUCT(...)</code>.
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" data-modal-close="addProductModal">Cancel</button>
      <button class="btn btn-primary" onclick="SwiftMart.toasts.show('Product saved!', 'success'); SwiftMart.modals.close('addProductModal')">
        💾 Save Product
      </button>
    </div>
  </div>
</div>

<!-- ── Edit Product Modal ── -->
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
          <input type="text" class="form-control" id="editName"/>
        </div>
        <div class="form-group">
          <label class="form-label">Barcode</label>
          <input type="text" class="form-control" id="editBarcode" readonly style="background:#F1F5F9;cursor:not-allowed"/>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Sale Price (৳)</label>
          <input type="number" class="form-control" id="editPrice"/>
        </div>
        <div class="form-group">
          <label class="form-label">Stock Quantity</label>
          <input type="number" class="form-control" id="editStock"/>
        </div>
      </div>
      <div class="alert alert-info">
        ℹ️ <strong>Oracle DB:</strong> Performs <code>UPDATE PRODUCTS SET ... WHERE barcode = :barcode</code>.
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" data-modal-close="editProductModal">Cancel</button>
      <button class="btn btn-primary" onclick="SwiftMart.toasts.show('Product updated!', 'success'); SwiftMart.modals.close('editProductModal')">
        💾 Update Product
      </button>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
let selectedCategory = '';

function filterCategory(catName) {
  selectedCategory = catName;
  
  // Highlight active card
  document.querySelectorAll('.cat-card').forEach(card => {
    card.classList.remove('active');
    card.style.borderTop = 'none';
  });
  
  const targetCard = event.currentTarget;
  targetCard.classList.add('active');
  targetCard.style.borderTop = '4px solid var(--color-primary)';
  
  searchProducts();
}

function searchProducts() {
  const query = document.getElementById('prodSearch').value.toLowerCase();
  const stockFilter = document.getElementById('stockFilter').value;
  const sortFilter = document.getElementById('sortFilter').value;
  
  const cards = Array.from(document.querySelectorAll('.product-item-card'));
  let visibleCount = 0;
  
  cards.forEach(card => {
    const name = card.getAttribute('data-name');
    const brand = card.getAttribute('data-brand');
    const category = card.getAttribute('data-category');
    const barcode = card.getAttribute('data-barcode');
    const price = parseFloat(card.getAttribute('data-price'));
    const stock = parseInt(card.getAttribute('data-stock'));
    
    // Category match
    const categoryMatch = selectedCategory === '' || category === selectedCategory;
    
    // Query search match
    const queryMatch = name.includes(query) || brand.includes(query) || barcode.includes(query);
    
    // Stock match
    let stockMatch = true;
    if (stockFilter === 'instock') stockMatch = stock > 50;
    else if (stockFilter === 'lowstock') stockMatch = stock > 0 && stock <= 50;
    else if (stockFilter === 'outofstock') stockMatch = stock === 0;
    
    if (categoryMatch && queryMatch && stockMatch) {
      card.style.display = 'flex';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });
  
  // Handle empty state
  const noProductsMsg = document.getElementById('noProductsMessage');
  const grid = document.getElementById('productGrid');
  if (visibleCount === 0) {
    noProductsMsg.style.display = 'block';
    grid.style.display = 'none';
  } else {
    noProductsMsg.style.display = 'none';
    grid.style.display = 'grid';
  }
  
  // Sort cards if required
  if (visibleCount > 1) {
    sortItems(sortFilter);
  }
}

function sortItems(sortType) {
  const grid = document.getElementById('productGrid');
  const items = Array.from(grid.children);
  
  items.sort((a, b) => {
    if (a.id === 'noProductsMessage' || b.id === 'noProductsMessage') return 0;
    
    const nameA = a.getAttribute('data-name');
    const nameB = b.getAttribute('data-name');
    const priceA = parseFloat(a.getAttribute('data-price'));
    const priceB = parseFloat(b.getAttribute('data-price'));
    const stockA = parseInt(a.getAttribute('data-stock'));
    const stockB = parseInt(b.getAttribute('data-stock'));
    
    if (sortType === 'name_asc') return nameA.localeCompare(nameB);
    if (sortType === 'name_desc') return nameB.localeCompare(nameA);
    if (sortType === 'price_asc') return priceA - priceB;
    if (sortType === 'price_desc') return priceB - priceA;
    if (sortType === 'stock_desc') return stockB - stockA;
    return 0;
  });
  
  // Re-append items in sorted order
  items.forEach(item => grid.appendChild(item));
}

function resetFilters() {
  document.getElementById('prodSearch').value = '';
  document.getElementById('stockFilter').value = '';
  document.getElementById('sortFilter').value = 'name_asc';
  
  selectedCategory = '';
  document.querySelectorAll('.cat-card').forEach((card, index) => {
    card.classList.remove('active');
    card.style.borderTop = 'none';
    if (index === 0) {
      card.classList.add('active');
      card.style.borderTop = '4px solid var(--color-primary)';
    }
  });
  
  searchProducts();
}

function showProductDetails(product) {
  document.getElementById('mDetTitle').textContent = product.name;
  document.getElementById('mDetName').textContent = product.name;
  document.getElementById('mDetCategory').textContent = product.category;
  document.getElementById('mDetEmoji').textContent = product.emoji;
  document.getElementById('mDetBarcode').textContent = product.barcode;
  document.getElementById('mDetBrand').textContent = product.brand;
  document.getElementById('mDetPrice').textContent = '৳' + product.price.toLocaleString();
  document.getElementById('mDetStock').textContent = product.stock + ' pcs';
  document.getElementById('mDetLocation').textContent = product.location;
  
  const statusBadge = document.getElementById('mDetStatus');
  statusBadge.className = 'badge';
  if (product.stock === 0) {
    statusBadge.classList.add('badge-danger');
    statusBadge.textContent = 'Out of Stock';
  } else if (product.stock <= 50) {
    statusBadge.classList.add('badge-warning');
    statusBadge.textContent = 'Low Stock';
  } else {
    statusBadge.classList.add('badge-success');
    statusBadge.textContent = 'In Stock';
  }
  
  SwiftMart.modals.open('productDetailsModal');
}

function setupEditModal(product) {
  document.getElementById('editName').value = product.name;
  document.getElementById('editBarcode').value = product.barcode;
  document.getElementById('editPrice').value = product.price;
  document.getElementById('editStock').value = product.stock;
}
</script>
