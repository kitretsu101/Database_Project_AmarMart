<?php
/**
 * SwiftMart – suppliers.php
 * Supplier cards, purchase orders, delivery status.
 * DB: SELECT * FROM SUPPLIERS JOIN PURCHASE_ORDERS ON supplier_id
 */
$pageTitle = 'Supplier Management';
$activeNav = 'suppliers';

$suppliers = [
  ['id'=>'SUP001','name'=>'Nestlé Bangladesh Ltd','emoji'=>'☕','category'=>'FMCG','contact'=>'Farhan Kabir','phone'=>'01711-999000','email'=>'supply@nestle.com.bd','city'=>'Dhaka','orders'=>48,'pending'=>'৳3,40,000','status'=>'Active'],
  ['id'=>'SUP002','name'=>'Unilever Bangladesh Ltd','emoji'=>'🧴','category'=>'FMCG','contact'=>'Rina Das','phone'=>'01811-888100','email'=>'orders@unilever.bd','city'=>'Dhaka','orders'=>62,'pending'=>'৳5,12,000','status'=>'Active'],
  ['id'=>'SUP003','name'=>'PRAN-RFL Group','emoji'=>'🥭','category'=>'Food & Beverage','contact'=>'Kamal Ahmed','phone'=>'01911-777200','email'=>'b2b@pran.com','city'=>'Dhaka','orders'=>35,'pending'=>'৳2,10,000','status'=>'Active'],
  ['id'=>'SUP004','name'=>'ACI Limited','emoji'=>'💊','category'=>'Healthcare & FMCG','contact'=>'Sabrina Islam','phone'=>'01611-666300','email'=>'supply@aci.bd','city'=>'Dhaka','orders'=>29,'pending'=>'৳1,75,000','status'=>'Active'],
  ['id'=>'SUP005','name'=>'Olympic Industries','emoji'=>'🍪','category'=>'Bakery & Snacks','contact'=>'Tariq Hossain','phone'=>'01511-555400','email'=>'orders@olympic.bd','city'=>'Narayanganj','orders'=>21,'pending'=>'৳98,500','status'=>'Inactive'],
  ['id'=>'SUP006','name'=>'Rupchanda / Fresh','emoji'=>'🫙','category'=>'Edible Oil','contact'=>'Momin Khan','phone'=>'01711-444500','email'=>'supply@rupchanda.bd','city'=>'Chittagong','orders'=>19,'pending'=>'৳1,42,000','status'=>'Active'],
];

$purchaseOrders = [
  ['id'=>'PO-1094','supplier'=>'Nestlé Bangladesh','items'=>'Nescafé Gold × 500, Maggi × 1000','amount'=>'৳1,24,000','date'=>'2025-07-18','expected'=>'2025-07-22','status'=>'In Transit'],
  ['id'=>'PO-1093','supplier'=>'ACI Limited','items'=>'Colgate 150g × 800, Lux × 600','amount'=>'৳98,500','date'=>'2025-07-17','expected'=>'2025-07-20','status'=>'Delivered'],
  ['id'=>'PO-1092','supplier'=>'PRAN-RFL Group','items'=>'Mango Juice 250ml × 2000','amount'=>'৳70,000','date'=>'2025-07-16','expected'=>'2025-07-19','status'=>'Delivered'],
  ['id'=>'PO-1091','supplier'=>'Unilever Bangladesh','items'=>'Ariel 1kg × 300, Rin × 500','amount'=>'৳2,12,500','date'=>'2025-07-15','expected'=>'2025-07-18','status'=>'Delivered'],
  ['id'=>'PO-1090','supplier'=>'Olympic Industries','items'=>'Oreo 120g × 1500, Tiger × 1000','amount'=>'৳55,200','date'=>'2025-07-14','expected'=>'2025-07-21','status'=>'Pending'],
  ['id'=>'PO-1089','supplier'=>'Rupchanda / Fresh','items'=>'Sunflower Oil 1L × 600','amount'=>'৳1,71,000','date'=>'2025-07-13','expected'=>'2025-07-17','status'=>'Cancelled'],
];

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="main-content" id="mainContent">
<?php include 'includes/navbar.php'; ?>
<div class="page-content">

  <div class="page-header">
    <div class="page-header-left">
      <h1>🚚 Supplier Management</h1>
      <div class="breadcrumb">🏠 Home <span>/</span> Suppliers</div>
    </div>
    <div style="display:flex;gap:0.75rem">
      <button class="btn btn-outline" data-modal-open="purchaseOrderModal">📋 New Purchase Order</button>
      <button class="btn btn-primary" data-modal-open="addSupplierModal">➕ Add Supplier</button>
    </div>
  </div>

  <!-- Stats -->
  <div class="grid-4 mb-3">
    <div class="stat-card" style="--stat-color:#2563EB;--stat-icon-bg:#EFF6FF"><div class="stat-icon">🚚</div><div class="stat-info"><div class="stat-value">24</div><div class="stat-label">Total Suppliers</div></div></div>
    <div class="stat-card" style="--stat-color:#10B981;--stat-icon-bg:#ECFDF5"><div class="stat-icon">✅</div><div class="stat-info"><div class="stat-value">19</div><div class="stat-label">Active Suppliers</div></div></div>
    <div class="stat-card" style="--stat-color:#F59E0B;--stat-icon-bg:#FFFBEB"><div class="stat-icon">📦</div><div class="stat-info"><div class="stat-value">8</div><div class="stat-label">Pending Deliveries</div></div></div>
    <div class="stat-card revenue"><div class="stat-icon">💰</div><div class="stat-info"><div class="stat-value">৳14.8L</div><div class="stat-label">This Month Orders</div></div></div>
  </div>

  <!-- Supplier Cards -->
  <h3 style="margin-bottom:1rem;font-size:1rem;font-weight:700">🏭 Supplier Directory</h3>
  <div class="grid-auto mb-3">
    <?php foreach ($suppliers as $s): ?>
    <div class="supplier-card">
      <div class="supplier-logo"><?= $s['emoji'] ?></div>
      <h4 style="font-weight:700;color:var(--color-secondary);margin-bottom:0.25rem"><?= $s['name'] ?></h4>
      <p style="font-size:0.75rem;color:var(--color-text-muted);margin-bottom:0.75rem"><?= $s['category'] ?></p>
      <div style="display:flex;gap:0.4rem;flex-wrap:wrap;margin-bottom:0.75rem">
        <span class="badge badge-primary"><?= $s['id'] ?></span>
        <span class="badge <?= $s['status']==='Active'?'badge-success':'badge-gray' ?>"><?= $s['status'] ?></span>
      </div>
      <div class="metric-row" style="padding:0.35rem 0">
        <span style="font-size:0.75rem;color:var(--color-text-muted)">👤 Contact</span>
        <span style="font-size:0.75rem;font-weight:600"><?= $s['contact'] ?></span>
      </div>
      <div class="metric-row" style="padding:0.35rem 0">
        <span style="font-size:0.75rem;color:var(--color-text-muted)">📦 Total Orders</span>
        <span style="font-size:0.75rem;font-weight:600"><?= $s['orders'] ?></span>
      </div>
      <div class="metric-row" style="padding:0.35rem 0;border-bottom:none">
        <span style="font-size:0.75rem;color:var(--color-text-muted)">💳 Pending</span>
        <span style="font-size:0.75rem;font-weight:700;color:var(--color-warning)"><?= $s['pending'] ?></span>
      </div>
      <div style="display:flex;gap:0.4rem;margin-top:0.85rem">
        <button class="btn btn-outline btn-sm" style="flex:1">📞 Contact</button>
        <button class="btn btn-ghost btn-sm">📋 Orders</button>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Purchase Orders Table -->
  <div class="card" style="padding:0">
    <div class="card-header" style="padding:1rem 1.25rem;border-bottom:1px solid var(--color-border-light)">
      <h3 class="card-title">📋 Recent Purchase Orders</h3>
      <button class="btn btn-primary btn-sm" data-modal-open="purchaseOrderModal">➕ New PO</button>
    </div>
    <!-- DB: SELECT po.po_number, s.supplier_name, po.total_amount, po.order_date,
                   po.expected_date, po.status
             FROM PURCHASE_ORDERS po JOIN SUPPLIERS s ON po.supplier_id=s.supplier_id
             ORDER BY po.order_date DESC FETCH FIRST 10 ROWS ONLY -->
    <div class="table-wrapper" style="border:none;border-radius:0">
      <table class="data-table">
        <thead>
          <tr><th>PO Number</th><th>Supplier</th><th>Items</th><th>Amount</th><th>Order Date</th><th>Expected</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
          <?php foreach ($purchaseOrders as $po):
            $statusBadge = match($po['status']) {
              'Delivered'  => 'badge-success',
              'In Transit' => 'badge-primary',
              'Pending'    => 'badge-warning',
              'Cancelled'  => 'badge-danger',
              default      => 'badge-gray'
            };
          ?>
          <tr>
            <td><code style="color:var(--color-primary)"><?= $po['id'] ?></code></td>
            <td><strong><?= $po['supplier'] ?></strong></td>
            <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:0.8rem;color:var(--color-text-muted)"><?= $po['items'] ?></td>
            <td style="font-weight:700;color:var(--color-accent)"><?= $po['amount'] ?></td>
            <td><?= date('d M Y', strtotime($po['date'])) ?></td>
            <td><?= date('d M Y', strtotime($po['expected'])) ?></td>
            <td><span class="badge <?= $statusBadge ?>"><?= $po['status'] ?></span></td>
            <td>
              <div class="actions">
                <button class="btn btn-ghost btn-sm">👁</button>
                <?php if ($po['status']==='Pending'): ?>
                <button class="btn btn-success btn-sm" onclick="SwiftMart.toasts.show('PO marked as received','success')">✔ Receive</button>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Add Supplier Modal -->
<div class="modal-overlay" id="addSupplierModal">
  <div class="modal">
    <div class="modal-header">
      <h2 class="modal-title">➕ Add Supplier</h2>
      <button class="modal-close" data-modal-close="addSupplierModal">✕</button>
    </div>
    <div class="modal-body">
      <!-- DB: INSERT INTO SUPPLIERS (company_name, category, contact_person, phone, email, city) VALUES (...) -->
      <div class="form-group"><label class="form-label">Company Name *</label><input type="text" class="form-control" required/></div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Category</label><input type="text" class="form-control" placeholder="e.g. FMCG"/></div>
        <div class="form-group"><label class="form-label">City</label><input type="text" class="form-control"/></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Contact Person</label><input type="text" class="form-control"/></div>
        <div class="form-group"><label class="form-label">Phone</label><input type="tel" class="form-control"/></div>
      </div>
      <div class="form-group"><label class="form-label">Email</label><input type="email" class="form-control"/></div>
      <div class="alert alert-info">ℹ️ Oracle DB: INSERT INTO SUPPLIERS table.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" data-modal-close="addSupplierModal">Cancel</button>
      <button class="btn btn-primary" onclick="SwiftMart.toasts.show('Supplier added!','success');SwiftMart.modals.close('addSupplierModal')">💾 Save</button>
    </div>
  </div>
</div>

<!-- Purchase Order Modal -->
<div class="modal-overlay" id="purchaseOrderModal">
  <div class="modal" style="max-width:600px">
    <div class="modal-header">
      <h2 class="modal-title">📋 Create Purchase Order</h2>
      <button class="modal-close" data-modal-close="purchaseOrderModal">✕</button>
    </div>
    <div class="modal-body">
      <!-- DB: INSERT INTO PURCHASE_ORDERS + INSERT INTO PO_ITEMS -->
      <div class="form-row">
        <div class="form-group"><label class="form-label">Supplier *</label>
          <select class="form-control" required>
            <option>Select Supplier</option>
            <?php foreach ($suppliers as $s): ?><option><?= $s['name'] ?></option><?php endforeach; ?>
          </select>
        </div>
        <div class="form-group"><label class="form-label">Expected Date</label><input type="date" class="form-control"/></div>
      </div>
      <div class="form-group"><label class="form-label">Products & Quantities</label><textarea class="form-control" rows="4" placeholder="Product Name, Qty, Unit Price&#10;e.g. Nescafé Gold 200g, 500, 680"></textarea></div>
      <div class="form-group"><label class="form-label">Notes</label><textarea class="form-control" rows="2" placeholder="Special instructions..."></textarea></div>
      <div class="alert alert-info">ℹ️ Oracle DB: INSERT INTO PURCHASE_ORDERS + PO_ITEMS. Trigger auto-updates PRODUCTS stock on delivery.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" data-modal-close="purchaseOrderModal">Cancel</button>
      <button class="btn btn-primary" onclick="SwiftMart.toasts.show('Purchase Order created!','success');SwiftMart.modals.close('purchaseOrderModal')">📋 Create PO</button>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
