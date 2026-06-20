<?php
/**
 * SwiftMart – branches.php
 * Multi-branch management: branch cards, stats, details.
 * DB: SELECT * FROM BRANCHES JOIN EMPLOYEES ON manager_id=emp_id
 *     JOIN ORDERS ON branch_id ORDER BY revenue DESC
 */
$pageTitle = 'Multi-Branch Management';
$activeNav = 'branches';

$branches = [
  ['id'=>'BR001','name'=>'Gulshan Branch',    'mgr'=>'Karim Ahmed',    'addr'=>'House 12, Road 5, Gulshan-1, Dhaka',   'phone'=>'02-9843210','revenue'=>'৳2,45,800','monthly'=>'৳48.5L','inv'=>'Excellent','emp'=>42,'products'=>1820,'status'=>'Active','pct'=>98,'emoji'=>'🏙️'],
  ['id'=>'BR002','name'=>'Dhanmondi Branch',  'mgr'=>'Sadia Islam',    'addr'=>'45 Dhanmondi R/A, Road 8A, Dhaka',     'phone'=>'02-9612345','revenue'=>'৳1,87,400','monthly'=>'৳37.2L','inv'=>'Good',     'emp'=>38,'products'=>1654,'status'=>'Active','pct'=>94,'emoji'=>'🏢'],
  ['id'=>'BR003','name'=>'Mirpur Branch',     'mgr'=>'Rafiq Hossain',  'addr'=>'Section 10, Mirpur, Dhaka-1216',        'phone'=>'02-9006789','revenue'=>'৳1,42,100','monthly'=>'৳28.8L','inv'=>'Low Stock', 'emp'=>31,'products'=>1430,'status'=>'Active','pct'=>81,'emoji'=>'🏬'],
  ['id'=>'BR004','name'=>'Uttara Branch',     'mgr'=>'Nasreen Khan',   'addr'=>'Sector 7, Uttara Model Town, Dhaka',   'phone'=>'02-8943211','revenue'=>'৳2,10,500','monthly'=>'৳42.1L','inv'=>'Good',     'emp'=>35,'products'=>1725,'status'=>'Active','pct'=>100,'emoji'=>'🏪'],
  ['id'=>'BR005','name'=>'Bashundhara Branch','mgr'=>'Tariq Miah',     'addr'=>'Block A, Bashundhara R/A, Dhaka',      'phone'=>'02-8440123','revenue'=>'৳1,56,700','monthly'=>'৳31.4L','inv'=>'Good',     'emp'=>33,'products'=>1580,'status'=>'Active','pct'=>87,'emoji'=>'🏭'],
];

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="main-content" id="mainContent">
<?php include 'includes/navbar.php'; ?>
<div class="page-content">

  <div class="page-header">
    <div class="page-header-left">
      <h1>🏪 Multi-Branch Management</h1>
      <div class="breadcrumb">🏠 Home <span>/</span> Branches</div>
    </div>
    <button class="btn btn-primary" data-modal-open="addBranchModal">➕ Add Branch</button>
  </div>

  <!-- Summary Stats -->
  <div class="grid-4 mb-3">
    <div class="stat-card" style="--stat-color:#2563EB;--stat-icon-bg:#EFF6FF"><div class="stat-icon">🏪</div><div class="stat-info"><div class="stat-value">5</div><div class="stat-label">Total Branches</div></div></div>
    <div class="stat-card" style="--stat-color:#10B981;--stat-icon-bg:#ECFDF5"><div class="stat-icon">✅</div><div class="stat-info"><div class="stat-value">5</div><div class="stat-label">Active Branches</div></div></div>
    <div class="stat-card" style="--stat-color:#8B5CF6;--stat-icon-bg:#F5F3FF"><div class="stat-icon">🧑‍💼</div><div class="stat-info"><div class="stat-value">179</div><div class="stat-label">Branch Employees</div></div></div>
    <div class="stat-card revenue"><div class="stat-icon">💰</div><div class="stat-info"><div class="stat-value">৳1.87Cr</div><div class="stat-label">Combined Monthly Rev</div></div></div>
  </div>

  <!-- Branch Cards Grid -->
  <div class="grid-auto mb-3">
    <?php foreach ($branches as $b):
      $invBadge = match($b['inv']) {
        'Excellent' => 'badge-success',
        'Good'      => 'badge-primary',
        'Low Stock' => 'badge-warning',
        default     => 'badge-gray'
      };
    ?>
    <div class="branch-card">
      <div class="branch-card-header">
        <div class="branch-flag"><?= $b['emoji'] ?></div>
        <div class="branch-name"><?= $b['name'] ?></div>
        <div style="font-size:0.8rem;color:rgba(255,255,255,0.7);margin-top:0.2rem"><?= $b['id'] ?></div>
        <div class="branch-status-dot"></div>
      </div>
      <div class="branch-card-body">
        <div class="branch-stat">
          <span>👤 Manager</span>
          <strong><?= $b['mgr'] ?></strong>
        </div>
        <div class="branch-stat">
          <span>📍 Address</span>
          <strong style="font-size:0.75rem;text-align:right;max-width:160px"><?= $b['addr'] ?></strong>
        </div>
        <div class="branch-stat">
          <span>📞 Phone</span>
          <strong><?= $b['phone'] ?></strong>
        </div>
        <div class="branch-stat">
          <span>💰 Today</span>
          <strong style="color:var(--color-accent)"><?= $b['revenue'] ?></strong>
        </div>
        <div class="branch-stat">
          <span>📊 Monthly</span>
          <strong><?= $b['monthly'] ?></strong>
        </div>
        <div class="branch-stat">
          <span>🧑‍💼 Employees</span>
          <strong><?= $b['emp'] ?></strong>
        </div>
        <div class="branch-stat">
          <span>📦 Products</span>
          <strong><?= number_format($b['products']) ?></strong>
        </div>
        <div class="branch-stat">
          <span>🗃 Inventory</span>
          <span class="badge <?= $invBadge ?>"><?= $b['inv'] ?></span>
        </div>
        <div style="margin-top:0.75rem">
          <div style="display:flex;justify-content:space-between;font-size:0.7rem;color:var(--color-text-muted);margin-bottom:0.25rem">
            <span>Target Achievement</span><span><?= $b['pct'] ?>%</span>
          </div>
          <div class="progress-bar-wrap"><div class="progress-bar" style="width:<?= $b['pct'] ?>%"></div></div>
        </div>
        <div style="display:flex;gap:0.4rem;margin-top:1rem">
          <button class="btn btn-outline btn-sm" style="flex:1" data-modal-open="branchDetailModal">📋 Details</button>
          <button class="btn btn-ghost btn-sm">✏️ Edit</button>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Branch Comparison Table -->
  <div class="card" style="padding:0">
    <div class="card-header" style="padding:1rem 1.25rem;border-bottom:1px solid var(--color-border-light)">
      <h3 class="card-title">📊 Branch Performance Comparison</h3>
    </div>
    <div class="table-wrapper" style="border:none;border-radius:0">
      <table class="data-table">
        <thead>
          <tr><th>Branch</th><th>Manager</th><th>Employees</th><th>Products</th><th>Daily Revenue</th><th>Monthly Revenue</th><th>Target</th><th>Inventory</th><th>Status</th></tr>
        </thead>
        <tbody>
          <?php foreach ($branches as $b): ?>
          <tr>
            <td><strong><?= $b['emoji'] ?> <?= $b['name'] ?></strong></td>
            <td><?= $b['mgr'] ?></td>
            <td><?= $b['emp'] ?></td>
            <td><?= number_format($b['products']) ?></td>
            <td style="color:var(--color-accent);font-weight:700"><?= $b['revenue'] ?></td>
            <td style="font-weight:600"><?= $b['monthly'] ?></td>
            <td>
              <div class="sold-bar" style="min-width:80px">
                <div class="bar-bg"><div class="bar-fill" style="width:<?= $b['pct'] ?>%"></div></div>
                <span class="text-xs"><?= $b['pct'] ?>%</span>
              </div>
            </td>
            <td><span class="badge <?= match($b['inv']){'Excellent'=>'badge-success','Good'=>'badge-primary','Low Stock'=>'badge-warning',default=>'badge-gray'} ?>"><?= $b['inv'] ?></span></td>
            <td><span class="badge badge-success"><?= $b['status'] ?></span></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Branch Detail Modal -->
<div class="modal-overlay" id="branchDetailModal">
  <div class="modal" style="max-width:560px">
    <div class="modal-header">
      <h2 class="modal-title">🏙️ Gulshan Branch – Details</h2>
      <button class="modal-close" data-modal-close="branchDetailModal">✕</button>
    </div>
    <div class="modal-body">
      <div class="grid-3 mb-2">
        <div style="text-align:center;padding:0.75rem;background:var(--color-bg);border-radius:var(--radius-md)">
          <div style="font-size:1.25rem;font-weight:800;color:var(--color-primary)">42</div>
          <div style="font-size:0.7rem;color:var(--color-text-muted)">Employees</div>
        </div>
        <div style="text-align:center;padding:0.75rem;background:var(--color-bg);border-radius:var(--radius-md)">
          <div style="font-size:1.25rem;font-weight:800;color:var(--color-accent)">1,820</div>
          <div style="font-size:0.7rem;color:var(--color-text-muted)">Products</div>
        </div>
        <div style="text-align:center;padding:0.75rem;background:var(--color-bg);border-radius:var(--radius-md)">
          <div style="font-size:1.25rem;font-weight:800;color:var(--color-warning)">৳48.5L</div>
          <div style="font-size:0.7rem;color:var(--color-text-muted)">Monthly Rev</div>
        </div>
      </div>
      <?php foreach ([['Daily Sales','৳2,45,800'],['Weekly Sales','৳17,20,600'],['Monthly Sales','৳48,50,000'],['Total Customers','2,847'],['Avg Basket Size','৳785'],['Top Product','Nescafé Gold 200g']] as $row): ?>
      <div class="metric-row">
        <span class="metric-label"><?= $row[0] ?></span>
        <span class="metric-value"><?= $row[1] ?></span>
      </div>
      <?php endforeach; ?>
      <div class="alert alert-info mt-2">ℹ️ Oracle DB: SELECT * FROM BRANCH_STATS WHERE branch_id = :id</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" data-modal-close="branchDetailModal">Close</button>
      <button class="btn btn-primary">📊 Full Report</button>
    </div>
  </div>
</div>

<!-- Add Branch Modal -->
<div class="modal-overlay" id="addBranchModal">
  <div class="modal">
    <div class="modal-header">
      <h2 class="modal-title">➕ Add New Branch</h2>
      <button class="modal-close" data-modal-close="addBranchModal">✕</button>
    </div>
    <div class="modal-body">
      <!-- DB: INSERT INTO BRANCHES (branch_name, manager_id, address, phone, open_date) VALUES (...) -->
      <div class="form-group"><label class="form-label">Branch Name *</label><input type="text" class="form-control" required/></div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Manager</label><select class="form-control"><option>Select Manager</option><?php foreach ($branches as $b): ?><option><?= $b['mgr'] ?></option><?php endforeach; ?></select></div>
        <div class="form-group"><label class="form-label">Phone</label><input type="tel" class="form-control"/></div>
      </div>
      <div class="form-group"><label class="form-label">Address *</label><textarea class="form-control" rows="2" required></textarea></div>
      <div class="form-group"><label class="form-label">Opening Date</label><input type="date" class="form-control"/></div>
      <div class="alert alert-info">ℹ️ Oracle DB: INSERT INTO BRANCHES table.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" data-modal-close="addBranchModal">Cancel</button>
      <button class="btn btn-primary" onclick="SwiftMart.toasts.show('Branch added!','success');SwiftMart.modals.close('addBranchModal')">💾 Save Branch</button>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
