<?php
/**
 * SwiftMart – employees.php
 * Employee table, profile cards, shift schedules, role badges.
 * DB: SELECT * FROM EMPLOYEES JOIN BRANCHES ON ... JOIN SHIFTS ON ...
 */
$pageTitle = 'Employee & Shift Management';
$activeNav = 'employees';

$employees = [
  ['id'=>'E001','name'=>'Rahim Uddin',    'role'=>'Admin',          'branch'=>'Gulshan',    'email'=>'rahim@swiftmart.com',   'phone'=>'01711-111111','salary'=>'৳45,000','shift'=>'Morning','status'=>'Active', 'attendance'=>97,'avatar_color'=>'linear-gradient(135deg,#2563EB,#1D4ED8)'],
  ['id'=>'E002','name'=>'Karim Ahmed',    'role'=>'Branch Manager', 'branch'=>'Gulshan',    'email'=>'karim@swiftmart.com',   'phone'=>'01811-222222','salary'=>'৳35,000','shift'=>'Morning','status'=>'Active', 'attendance'=>94,'avatar_color'=>'linear-gradient(135deg,#10B981,#059669)'],
  ['id'=>'E003','name'=>'Sadia Islam',    'role'=>'Branch Manager', 'branch'=>'Dhanmondi',  'email'=>'sadia@swiftmart.com',   'phone'=>'01911-333333','salary'=>'৳35,000','shift'=>'Morning','status'=>'Active', 'attendance'=>96,'avatar_color'=>'linear-gradient(135deg,#8B5CF6,#7C3AED)'],
  ['id'=>'E004','name'=>'Raju Mia',       'role'=>'Cashier',        'branch'=>'Gulshan',    'email'=>'raju@swiftmart.com',    'phone'=>'01611-444444','salary'=>'৳18,000','shift'=>'Evening','status'=>'Active', 'attendance'=>89,'avatar_color'=>'linear-gradient(135deg,#F59E0B,#D97706)'],
  ['id'=>'E005','name'=>'Mitu Akter',     'role'=>'Cashier',        'branch'=>'Mirpur',     'email'=>'mitu@swiftmart.com',    'phone'=>'01511-555555','salary'=>'৳18,000','shift'=>'Night', 'status'=>'Active', 'attendance'=>91,'avatar_color'=>'linear-gradient(135deg,#EF4444,#DC2626)'],
  ['id'=>'E006','name'=>'Nasreen Khan',   'role'=>'Branch Manager', 'branch'=>'Uttara',     'email'=>'nasreen@swiftmart.com', 'phone'=>'01711-666666','salary'=>'৳35,000','shift'=>'Morning','status'=>'Active', 'attendance'=>98,'avatar_color'=>'linear-gradient(135deg,#0EA5E9,#0284C7)'],
  ['id'=>'E007','name'=>'Tarek Islam',    'role'=>'Cashier',        'branch'=>'Dhanmondi',  'email'=>'tarek@swiftmart.com',   'phone'=>'01811-777777','salary'=>'৳18,000','shift'=>'Morning','status'=>'Leave',  'attendance'=>82,'avatar_color'=>'linear-gradient(135deg,#6D28D9,#5B21B6)'],
  ['id'=>'E008','name'=>'Fatima Begum',   'role'=>'Cashier',        'branch'=>'Bashundhara','email'=>'fatima@swiftmart.com',  'phone'=>'01911-888888','salary'=>'৳18,000','shift'=>'Evening','status'=>'Active', 'attendance'=>93,'avatar_color'=>'linear-gradient(135deg,#10B981,#2563EB)'],
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
      <h1>🧑‍💼 Employee & Shift Management</h1>
      <div class="breadcrumb">🏠 Home <span>/</span> Employees</div>
    </div>
    <div style="display:flex;gap:0.75rem">
      <button class="btn btn-outline">📥 Export</button>
      <button class="btn btn-primary" data-modal-open="addEmployeeModal">➕ Add Employee</button>
    </div>
  </div>

  <!-- Stats -->
  <div class="grid-4 mb-3">
    <div class="stat-card employees"><div class="stat-icon">🧑‍💼</div><div class="stat-info"><div class="stat-value">187</div><div class="stat-label">Total Employees</div></div></div>
    <div class="stat-card" style="--stat-color:#10B981;--stat-icon-bg:#ECFDF5"><div class="stat-icon">✅</div><div class="stat-info"><div class="stat-value">172</div><div class="stat-label">Active Today</div></div></div>
    <div class="stat-card" style="--stat-color:#F59E0B;--stat-icon-bg:#FFFBEB"><div class="stat-icon">🌴</div><div class="stat-info"><div class="stat-value">11</div><div class="stat-label">On Leave</div></div></div>
    <div class="stat-card" style="--stat-color:#EF4444;--stat-icon-bg:#FEF2F2"><div class="stat-icon">❌</div><div class="stat-info"><div class="stat-value">4</div><div class="stat-label">Absent</div></div></div>
  </div>

  <!-- Tabs -->
  <div class="tabs">
    <button class="tab-btn active" data-tab="tabTable">📋 Employee List</button>
    <button class="tab-btn" data-tab="tabCards">🪪 Profile Cards</button>
    <button class="tab-btn" data-tab="tabShifts">🕐 Shift Schedule</button>
    <button class="tab-btn" data-tab="tabAttendance">📊 Attendance</button>
  </div>

  <!-- Tab: Employee List -->
  <div class="tab-panel active" id="tabTable">
    <div class="card" style="padding:0">
      <div class="card-header" style="padding:1rem 1.25rem;border-bottom:1px solid var(--color-border-light)">
        <div class="search-box" style="width:280px">
          <span class="search-icon">🔍</span>
          <input type="text" placeholder="Search employees…" data-table-search="empTable"/>
        </div>
        <span class="badge badge-primary"><?= count($employees) ?> Employees</span>
      </div>
      <div class="table-wrapper" style="border:none;border-radius:0">
        <table class="data-table" id="empTable">
          <thead>
            <tr><th>ID</th><th>Employee</th><th>Role</th><th>Branch</th><th>Shift</th><th>Salary</th><th>Attendance</th><th>Status</th><th>Actions</th></tr>
          </thead>
          <tbody>
            <?php foreach ($employees as $e):
              $roleBadge = match($e['role']) {
                'Admin'          => 'badge-danger',
                'Branch Manager' => 'badge-primary',
                'Cashier'        => 'badge-success',
                default          => 'badge-gray'
              };
              $statusBadge = match($e['status']) {
                'Active' => 'badge-success',
                'Leave'  => 'badge-warning',
                default  => 'badge-gray'
              };
            ?>
            <tr>
              <td><code style="font-size:0.75rem"><?= $e['id'] ?></code></td>
              <td>
                <div class="product-cell">
                  <div style="width:36px;height:36px;border-radius:50%;background:<?= $e['avatar_color'] ?>;display:flex;align-items:center;justify-content:center;font-size:0.85rem;font-weight:700;color:#fff;flex-shrink:0">
                    <?= strtoupper(substr($e['name'],0,1)) ?>
                  </div>
                  <div class="product-meta">
                    <h5><?= $e['name'] ?></h5>
                    <span><?= $e['email'] ?></span>
                  </div>
                </div>
              </td>
              <td><span class="badge <?= $roleBadge ?>"><?= $e['role'] ?></span></td>
              <td>🏪 <?= $e['branch'] ?></td>
              <td><span class="badge badge-info"><?= $e['shift'] ?></span></td>
              <td style="font-weight:600;color:var(--color-accent)"><?= $e['salary'] ?></td>
              <td>
                <div class="sold-bar" style="min-width:90px">
                  <div class="bar-bg"><div class="bar-fill" style="width:<?= $e['attendance'] ?>%"></div></div>
                  <span class="text-xs"><?= $e['attendance'] ?>%</span>
                </div>
              </td>
              <td><span class="badge <?= $statusBadge ?>"><?= $e['status'] ?></span></td>
              <td>
                <div class="actions">
                  <button class="btn btn-ghost btn-sm">👁</button>
                  <button class="btn btn-outline btn-sm">✏️</button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Tab: Profile Cards -->
  <div class="tab-panel" id="tabCards">
    <div class="grid-auto">
      <?php foreach ($employees as $e):
        $roleBadge = match($e['role']) { 'Admin'=>'badge-danger','Branch Manager'=>'badge-primary',default=>'badge-success' };
      ?>
      <div class="employee-card">
        <div class="employee-avatar" style="background:<?= $e['avatar_color'] ?>">
          <?= strtoupper(substr($e['name'],0,1)) ?>
        </div>
        <h4><?= $e['name'] ?></h4>
        <p><?= $e['phone'] ?></p>
        <div style="display:flex;gap:0.4rem;justify-content:center;margin:0.75rem 0;flex-wrap:wrap">
          <span class="badge <?= $roleBadge ?>"><?= $e['role'] ?></span>
          <span class="badge badge-info"><?= $e['shift'] ?></span>
          <span class="badge <?= $e['status']==='Active'?'badge-success':'badge-warning' ?>"><?= $e['status'] ?></span>
        </div>
        <div style="font-size:0.75rem;color:var(--color-text-muted);margin-bottom:0.75rem">
          🏪 <?= $e['branch'] ?> Branch
        </div>
        <div style="width:100%;margin-bottom:0.5rem">
          <div style="display:flex;justify-content:space-between;font-size:0.7rem;color:var(--color-text-muted);margin-bottom:0.25rem">
            <span>Attendance</span><span><?= $e['attendance'] ?>%</span>
          </div>
          <div class="progress-bar-wrap"><div class="progress-bar" style="width:<?= $e['attendance'] ?>%"></div></div>
        </div>
        <div style="display:flex;gap:0.4rem;margin-top:0.75rem">
          <button class="btn btn-outline btn-sm" style="flex:1">Profile</button>
          <button class="btn btn-ghost btn-sm">📧</button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Tab: Shift Schedule -->
  <div class="tab-panel" id="tabShifts">
    <!-- DB: SELECT * FROM SHIFTS JOIN EMPLOYEES ON ... WHERE shift_date = TRUNC(SYSDATE) -->
    <div class="grid-3">
      <?php
      $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
      $shifts = [
        'Morning' => ['color'=>'#2563EB','emp'=>['Rahim Uddin','Karim Ahmed','Raju Mia (Cashier)']],
        'Evening' => ['color'=>'#10B981','emp'=>['Mitu Akter (Cashier)','Fatima Begum (Cashier)']],
        'Night'   => ['color'=>'#8B5CF6','emp'=>['Nasreen Khan','Tarek Islam (Cashier)']],
      ];
      foreach (array_slice($days,0,6) as $day): ?>
      <div class="shift-card">
        <div class="shift-day"><?= $day ?></div>
        <?php foreach ($shifts as $label => $s): ?>
          <div class="shift-block">
            <div class="shift-color" style="background:<?= $s['color'] ?>"></div>
            <div>
              <span style="font-weight:600;color:var(--color-text)"><?= $label ?></span>
              <?php foreach ($s['emp'] as $name): ?>
                <div style="font-size:0.7rem;color:var(--color-text-muted)"><?= $name ?></div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Tab: Attendance -->
  <div class="tab-panel" id="tabAttendance">
    <div class="card">
      <div class="card-header"><h3 class="card-title">📊 Attendance Summary – June 2025</h3></div>
      <!-- DB: SELECT emp_id, COUNT(*) present, SUM(CASE WHEN status='ABSENT' THEN 1 ELSE 0 END) absent
               FROM ATTENDANCE WHERE EXTRACT(MONTH FROM att_date)=6 GROUP BY emp_id -->
      <div class="table-wrapper" style="border:none">
        <table class="data-table">
          <thead>
            <tr><th>Employee</th><th>Role</th><th>Present</th><th>Absent</th><th>Leave</th><th>Attendance %</th></tr>
          </thead>
          <tbody>
            <?php foreach ($employees as $e): ?>
            <tr>
              <td><strong><?= $e['name'] ?></strong></td>
              <td><span class="badge badge-primary"><?= $e['role'] ?></span></td>
              <td style="color:var(--color-accent);font-weight:600"><?= round($e['attendance']/100*26) ?></td>
              <td style="color:var(--color-danger)"><?= round((100-$e['attendance'])/100*26) ?></td>
              <td>1</td>
              <td>
                <div class="sold-bar" style="min-width:100px">
                  <div class="bar-bg"><div class="bar-fill" style="width:<?= $e['attendance'] ?>%"></div></div>
                  <span class="text-xs"><?= $e['attendance'] ?>%</span>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<!-- Add Employee Modal -->
<div class="modal-overlay" id="addEmployeeModal">
  <div class="modal" style="max-width:600px">
    <div class="modal-header">
      <h2 class="modal-title">➕ Add New Employee</h2>
      <button class="modal-close" data-modal-close="addEmployeeModal">✕</button>
    </div>
    <div class="modal-body">
      <!-- DB: INSERT INTO EMPLOYEES (...) VALUES (...) -->
      <div class="form-row">
        <div class="form-group"><label class="form-label">Full Name *</label><input type="text" class="form-control" required/></div>
        <div class="form-group"><label class="form-label">Employee ID</label><input type="text" class="form-control" placeholder="Auto-generated"/></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Role *</label>
          <select class="form-control" required>
            <option>Select Role</option><option>Admin</option><option>Branch Manager</option><option>Cashier</option>
          </select>
        </div>
        <div class="form-group"><label class="form-label">Branch *</label>
          <select class="form-control" required>
            <option>Select Branch</option><option>Gulshan</option><option>Dhanmondi</option><option>Mirpur</option><option>Uttara</option><option>Bashundhara</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Email</label><input type="email" class="form-control"/></div>
        <div class="form-group"><label class="form-label">Phone</label><input type="tel" class="form-control"/></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Salary (৳)</label><input type="number" class="form-control"/></div>
        <div class="form-group"><label class="form-label">Shift</label>
          <select class="form-control"><option>Morning</option><option>Evening</option><option>Night</option></select>
        </div>
      </div>
      <div class="alert alert-info">ℹ️ Oracle DB: INSERT INTO EMPLOYEES + INSERT INTO SHIFTS table.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" data-modal-close="addEmployeeModal">Cancel</button>
      <button class="btn btn-primary" onclick="SwiftMart.toasts.show('Employee added!','success');SwiftMart.modals.close('addEmployeeModal')">💾 Save</button>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
