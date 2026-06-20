<?php
/**
 * SwiftMart – customers.php
 * Customer list, membership tiers, loyalty points.
 * DB: SELECT * FROM CUSTOMERS JOIN MEMBERSHIPS ON ... ORDER BY created_at DESC
 */
$pageTitle = 'Customer Loyalty System';
$activeNav = 'customers';

$customers = [
  ['id'=>'C001','name'=>'Arif Hossain',   'phone'=>'01711-234567','email'=>'arif@email.com',   'tier'=>'Gold',    'points'=>4820,'spent'=>'৳1,24,500','since'=>'2022-01-15','orders'=>142,'status'=>'Active'],
  ['id'=>'C002','name'=>'Riya Sultana',   'phone'=>'01811-345678','email'=>'riya@email.com',   'tier'=>'Platinum','points'=>9240,'spent'=>'৳3,45,800','since'=>'2021-06-10','orders'=>287,'status'=>'Active'],
  ['id'=>'C003','name'=>'Karim Ahmed',    'phone'=>'01911-456789','email'=>'karim@email.com',  'tier'=>'Silver',  'points'=>1870,'spent'=>'৳47,200', 'since'=>'2023-03-22','orders'=>67, 'status'=>'Active'],
  ['id'=>'C004','name'=>'Nasreen Begum',  'phone'=>'01611-567890','email'=>'nasreen@email.com','tier'=>'Bronze',  'points'=>450, 'spent'=>'৳12,800', 'since'=>'2024-01-05','orders'=>23, 'status'=>'Active'],
  ['id'=>'C005','name'=>'Tariq Miah',     'phone'=>'01511-678901','email'=>'tariq@email.com',  'tier'=>'Gold',    'points'=>3680,'spent'=>'৳89,500', 'since'=>'2022-08-14','orders'=>108,'status'=>'Active'],
  ['id'=>'C006','name'=>'Fatema Khatun',  'phone'=>'01711-789012','email'=>'fatema@email.com', 'tier'=>'Silver',  'points'=>2140,'spent'=>'৳54,300', 'since'=>'2023-07-18','orders'=>78, 'status'=>'Active'],
  ['id'=>'C007','name'=>'Robiul Islam',   'phone'=>'01811-890123','email'=>'robiul@email.com', 'tier'=>'Platinum','points'=>8750,'spent'=>'৳2,87,600','since'=>'2020-11-30','orders'=>312,'status'=>'Active'],
  ['id'=>'C008','name'=>'Sadia Akter',    'phone'=>'01911-901234','email'=>'sadia@email.com',  'tier'=>'Gold',    'points'=>5120,'spent'=>'৳1,35,400','since'=>'2022-04-20','orders'=>167,'status'=>'Inactive'],
  ['id'=>'C009','name'=>'Mamun Rashid',   'phone'=>'01611-012345','email'=>'mamun@email.com',  'tier'=>'Bronze',  'points'=>290, 'spent'=>'৳8,900',  'since'=>'2024-05-12','orders'=>12, 'status'=>'Active'],
  ['id'=>'C010','name'=>'Halima Begum',   'phone'=>'01511-123456','email'=>'halima@email.com', 'tier'=>'Silver',  'points'=>1650,'spent'=>'৳41,700', 'since'=>'2023-09-08','orders'=>58, 'status'=>'Active'],
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
      <h1>👥 Customer Loyalty System</h1>
      <div class="breadcrumb">🏠 Home <span>/</span> Customers</div>
    </div>
    <div style="display:flex;gap:0.75rem">
      <button class="btn btn-outline">📥 Export</button>
      <button class="btn btn-primary" data-modal-open="addCustomerModal">➕ Add Customer</button>
    </div>
  </div>

  <!-- Membership Tier Cards -->
  <!-- DB: SELECT tier, COUNT(*) FROM CUSTOMERS GROUP BY tier -->
  <div class="grid-4 mb-3">
    <div class="membership-card bronze">
      <div class="membership-icon">🥉</div>
      <h3>Bronze</h3>
      <div class="membership-count">1,284</div>
      <p>0 – 999 points · 2% discount</p>
    </div>
    <div class="membership-card silver">
      <div class="membership-icon">🥈</div>
      <h3>Silver</h3>
      <div class="membership-count">4,512</div>
      <p>1,000 – 4,999 points · 5% discount</p>
    </div>
    <div class="membership-card gold">
      <div class="membership-icon">🥇</div>
      <h3>Gold</h3>
      <div class="membership-count">5,841</div>
      <p>5,000 – 14,999 points · 8% discount</p>
    </div>
    <div class="membership-card platinum">
      <div class="membership-icon">💎</div>
      <h3>Platinum</h3>
      <div class="membership-count">822</div>
      <p>15,000+ points · 12% discount</p>
    </div>
  </div>

  <!-- Filter + Search -->
  <div class="card mb-2" style="padding:1rem">
    <div class="filter-bar">
      <div class="search-box" style="flex:1;min-width:220px">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Search by name, phone, email…" data-table-search="customersTable"/>
      </div>
      <select class="form-control" style="width:auto">
        <option>All Tiers</option>
        <option>Bronze</option><option>Silver</option><option>Gold</option><option>Platinum</option>
      </select>
      <select class="form-control" style="width:auto">
        <option>All Status</option>
        <option>Active</option><option>Inactive</option>
      </select>
    </div>
  </div>

  <!-- Customer Table -->
  <div class="card" style="padding:0">
    <div class="card-header" style="padding:1rem 1.25rem;border-bottom:1px solid var(--color-border-light)">
      <h3 class="card-title">Customer List</h3>
      <span class="badge badge-primary">12,459 Customers</span>
    </div>
    <div class="table-wrapper" style="border:none;border-radius:0">
      <table class="data-table" id="customersTable">
        <thead>
          <tr>
            <th>ID</th><th>Name</th><th>Phone</th><th>Tier</th>
            <th>Points</th><th>Total Spent</th><th>Orders</th><th>Member Since</th><th>Status</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($customers as $c):
            $tierBadge = match($c['tier']) {
              'Bronze'   => 'badge-bronze',
              'Silver'   => 'badge-silver',
              'Gold'     => 'badge-gold',
              'Platinum' => 'badge-platinum',
              default    => 'badge-gray'
            };
          ?>
          <tr>
            <td><code style="font-size:0.75rem"><?= $c['id'] ?></code></td>
            <td>
              <div style="display:flex;align-items:center;gap:0.6rem">
                <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#2563EB,#10B981);display:flex;align-items:center;justify-content:center;font-size:0.8rem;font-weight:700;color:#fff;flex-shrink:0">
                  <?= strtoupper(substr($c['name'],0,1)) ?>
                </div>
                <div>
                  <div style="font-weight:600;font-size:0.875rem"><?= $c['name'] ?></div>
                  <div style="font-size:0.7rem;color:var(--color-text-muted)"><?= $c['email'] ?></div>
                </div>
              </div>
            </td>
            <td><?= $c['phone'] ?></td>
            <td><span class="badge <?= $tierBadge ?>"><?= $c['tier'] ?></span></td>
            <td>
              <strong style="color:var(--color-primary)"><?= number_format($c['points']) ?></strong>
              <span style="font-size:0.7rem;color:var(--color-text-muted)"> pts</span>
            </td>
            <td style="font-weight:600;color:var(--color-accent)"><?= $c['spent'] ?></td>
            <td><?= $c['orders'] ?></td>
            <td><?= date('d M Y', strtotime($c['since'])) ?></td>
            <td>
              <span class="badge <?= $c['status']==='Active' ? 'badge-success':'badge-gray' ?>">
                <?= $c['status'] ?>
              </span>
            </td>
            <td>
              <div class="actions">
                <button class="btn btn-ghost btn-sm" data-modal-open="customerProfileModal">👁</button>
                <button class="btn btn-outline btn-sm">✏️</button>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Loyalty Points Rules -->
  <div class="grid-2 mt-3">
    <div class="card">
      <div class="card-header"><h3 class="card-title">🎯 Points Earning Rules</h3></div>
      <!-- DB: SELECT * FROM LOYALTY_RULES ORDER BY min_spend -->
      <?php
      $rules = [
        ['spend'=>'৳100','earn'=>'1 point','note'=>'All purchases'],
        ['spend'=>'৳500+','earn'=>'6 points','note'=>'5% bonus'],
        ['spend'=>'৳2,000+','earn'=>'25 points','note'=>'Bulk bonus'],
        ['spend'=>'Birthday','earn'=>'2× points','note'=>'Special day multiplier'],
      ];
      foreach ($rules as $r): ?>
      <div class="metric-row">
        <div>
          <div class="metric-label"><?= $r['note'] ?></div>
          <div style="font-size:0.75rem;color:var(--color-text-light)">Spend <?= $r['spend'] ?></div>
        </div>
        <span class="badge badge-success"><?= $r['earn'] ?></span>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="card">
      <div class="card-header"><h3 class="card-title">🎁 Redemption Offers</h3></div>
      <?php
      $offers = [
        ['pts'=>100,  'reward'=>'৳10 off next purchase',  'badge'=>'badge-bronze'],
        ['pts'=>500,  'reward'=>'Free delivery voucher',  'badge'=>'badge-silver'],
        ['pts'=>1000, 'reward'=>'৳150 gift voucher',      'badge'=>'badge-gold'],
        ['pts'=>5000, 'reward'=>'Premium hamper worth ৳2,000','badge'=>'badge-platinum'],
      ];
      foreach ($offers as $o): ?>
      <div class="metric-row">
        <div>
          <div class="metric-label"><?= $o['reward'] ?></div>
        </div>
        <span class="badge <?= $o['badge'] ?>"><?= $o['pts'] ?> pts</span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>
<!-- Add Customer Modal -->
<div class="modal-overlay" id="addCustomerModal">
  <div class="modal">
    <div class="modal-header">
      <h2 class="modal-title">➕ Add New Customer</h2>
      <button class="modal-close" data-modal-close="addCustomerModal">✕</button>
    </div>
    <div class="modal-body">
      <!-- DB: INSERT INTO CUSTOMERS (full_name, phone, email, dob, gender) VALUES (...) -->
      <div class="form-row">
        <div class="form-group"><label class="form-label">Full Name *</label><input type="text" class="form-control" placeholder="e.g. Arif Hossain" required/></div>
        <div class="form-group"><label class="form-label">Phone *</label><input type="tel" class="form-control" placeholder="01XXXXXXXXX" required/></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Email</label><input type="email" class="form-control" placeholder="email@example.com"/></div>
        <div class="form-group"><label class="form-label">Date of Birth</label><input type="date" class="form-control"/></div>
      </div>
      <div class="form-group"><label class="form-label">Address</label><textarea class="form-control" rows="2" placeholder="Full address…"></textarea></div>
      <div class="alert alert-info">ℹ️ Oracle DB: INSERT INTO CUSTOMERS + assign Bronze tier automatically via trigger.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" data-modal-close="addCustomerModal">Cancel</button>
      <button class="btn btn-primary" onclick="SwiftMart.toasts.show('Customer registered!','success');SwiftMart.modals.close('addCustomerModal')">💾 Register</button>
    </div>
  </div>
</div>

<!-- Customer Profile Modal -->
<div class="modal-overlay" id="customerProfileModal">
  <div class="modal" style="max-width:500px">
    <div class="modal-header">
      <h2 class="modal-title">👤 Customer Profile</h2>
      <button class="modal-close" data-modal-close="customerProfileModal">✕</button>
    </div>
    <div class="modal-body">
      <div style="text-align:center;margin-bottom:1.5rem">
        <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#2563EB,#10B981);display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:800;color:#fff;margin:0 auto 0.75rem">R</div>
        <h3 style="margin:0">Riya Sultana</h3>
        <p style="margin:0">01811-345678 · riya@email.com</p>
        <span class="badge badge-platinum" style="margin-top:0.5rem">💎 Platinum Member</span>
      </div>
      <div class="grid-3" style="margin-bottom:1rem">
        <div style="text-align:center;padding:0.75rem;background:var(--color-bg);border-radius:var(--radius-md)">
          <div style="font-size:1.25rem;font-weight:800;color:var(--color-primary)">9,240</div>
          <div style="font-size:0.7rem;color:var(--color-text-muted)">Loyalty Points</div>
        </div>
        <div style="text-align:center;padding:0.75rem;background:var(--color-bg);border-radius:var(--radius-md)">
          <div style="font-size:1.25rem;font-weight:800;color:var(--color-accent)">287</div>
          <div style="font-size:0.7rem;color:var(--color-text-muted)">Total Orders</div>
        </div>
        <div style="text-align:center;padding:0.75rem;background:var(--color-bg);border-radius:var(--radius-md)">
          <div style="font-size:1.25rem;font-weight:800;color:var(--color-warning)">৳3.46L</div>
          <div style="font-size:0.7rem;color:var(--color-text-muted)">Total Spent</div>
        </div>
      </div>
      <div class="alert alert-success">🎁 Eligible for Platinum rewards. 760 points to next milestone!</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" data-modal-close="customerProfileModal">Close</button>
      <button class="btn btn-primary">📋 View Full History</button>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
