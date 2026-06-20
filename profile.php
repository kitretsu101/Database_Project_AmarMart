<?php
/**
 * SwiftMart – profile.php
 * My Profile: displays employee info, edit profile form,
 * password change form, and personal audit activity logs.
 *
 * DB Integration Points:
 * DB: SELECT e.*, b.branch_name
 *         FROM EMPLOYEES e JOIN BRANCHES b ON e.branch_id = b.branch_id
 *         WHERE e.emp_id = :session_user_id
 */
$pageTitle = 'My Profile';
$activeNav = 'profile';

$userInfo = [
  'id' => 'E001',
  'name' => 'Rahim Uddin',
  'role' => 'System Admin',
  'branch' => 'Gulshan Branch',
  'email' => 'rahim@swiftmart.com',
  'phone' => '01711-111111',
  'join_date' => '2022-01-10',
  'salary' => '৳45,000',
  'shift' => 'Morning Shift (08:00 AM - 04:00 PM)',
  'avatar' => 'RA',
];

$activities = [
  ['time' => 'Today, 22:15', 'action' => 'Authorized POS Discount (৳250)', 'target' => 'Invoice INV-2025-0842', 'status' => 'success'],
  ['time' => 'Today, 20:10', 'action' => 'Added New Inventory Item', 'target' => 'Colgate Toothpaste 150g', 'status' => 'info'],
  ['time' => 'Yesterday, 08:00', 'action' => 'Clock-In Attendance Scan', 'target' => 'Terminal Gulshan-01', 'status' => 'success'],
  ['time' => '2 days ago', 'action' => 'Created Purchase Order (PO-1094)', 'target' => 'Nestlé Bangladesh Ltd', 'status' => 'info'],
  ['time' => '3 days ago', 'action' => 'Modified Employee Shift', 'target' => 'Shift schedule change for E004', 'status' => 'warning'],
  ['time' => '5 days ago', 'action' => 'Updated Store Promo Campaign', 'target' => 'Ramadan Special Sale', 'status' => 'info'],
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
      <h1>👤 My Profile</h1>
      <div class="breadcrumb">
        🏠 Home <span>/</span> Profile
      </div>
    </div>
    <span class="badge badge-primary">Admin Access Active</span>
  </div>

  <!-- Two-Column Profile Grid -->
  <div class="dashboard-grid">
    
    <!-- Left Column: User Info Card & Activity Logs -->
    <div style="display:flex;flex-direction:column;gap:1.25rem">
      <!-- Profile Detail Card -->
      <div class="card" style="text-align:center;padding:2rem">
        <div style="width:96px;height:96px;border-radius:var(--radius-full);background:linear-gradient(135deg, var(--color-primary), var(--color-purple));color:#fff;font-size:2.5rem;font-weight:800;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;box-shadow:var(--shadow-md)">
          <?= $userInfo['avatar'] ?>
        </div>
        <h2><?= htmlspecialchars($userInfo['name']) ?></h2>
        <span class="badge badge-primary" style="margin-top:0.4rem"><?= $userInfo['role'] ?></span>
        <p style="margin-top:0.5rem;font-size:0.875rem">📍 Assigned: <strong><?= $userInfo['branch'] ?></strong></p>
        
        <hr style="border:0;border-top:1px solid var(--color-border-light);margin:1.5rem 0">
        
        <div style="display:flex;flex-direction:column;gap:0.75rem;text-align:left;font-size:0.875rem">
          <div style="display:flex;justify-content:space-between">
            <span style="color:var(--color-text-muted)">Employee ID:</span>
            <strong><?= $userInfo['id'] ?></strong>
          </div>
          <div style="display:flex;justify-content:space-between">
            <span style="color:var(--color-text-muted)">Email Address:</span>
            <strong><?= $userInfo['email'] ?></strong>
          </div>
          <div style="display:flex;justify-content:space-between">
            <span style="color:var(--color-text-muted)">Contact Phone:</span>
            <strong><?= $userInfo['phone'] ?></strong>
          </div>
          <div style="display:flex;justify-content:space-between">
            <span style="color:var(--color-text-muted)">Assigned Shift:</span>
            <strong>Morning</strong>
          </div>
          <div style="display:flex;justify-content:space-between">
            <span style="color:var(--color-text-muted)">Joining Date:</span>
            <strong><?= date('d M Y', strtotime($userInfo['join_date'])) ?></strong>
          </div>
        </div>
      </div>

      <!-- User Audit Log Feed -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">🕒 My Recent Activity Logs</h3>
          <span class="badge badge-gray">Last 6 logs</span>
        </div>
        
        <!-- Activity List -->
        <div style="display:flex;flex-direction:column;gap:1rem;margin-top:0.5rem">
          <?php foreach ($activities as $act): ?>
          <div style="display:flex;gap:0.75rem;align-items:start;font-size:0.85rem">
            <div style="width:8px;height:8px;border-radius:50%;background:<?= match($act['status']) {
              'success' => 'var(--color-accent)',
              'warning' => 'var(--color-warning)',
              'danger'  => 'var(--color-danger)',
              default   => 'var(--color-info)'
            } ?>;margin-top:6px;flex-shrink:0"></div>
            <div style="flex:1">
              <strong><?= htmlspecialchars($act['action']) ?></strong>
              <div style="font-size:0.75rem;color:var(--color-text-muted)"><?= htmlspecialchars($act['target']) ?> · <?= $act['time'] ?></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        
        <div class="alert alert-info" style="margin-top:1.5rem;font-size:0.75rem;line-height:1.4">
          ℹ️ <strong>Audit Trail Triggers:</strong> These rows are written directly by an Oracle database trigger <code>TRG_AUDIT_EMPLOYEE_ACTIONS</code> on modifications to <code>ORDERS</code>, <code>PRODUCTS</code>, or <code>SHIFTS</code>.
        </div>
      </div>
    </div>

    <!-- Right Column: Settings & Password Forms -->
    <div style="display:flex;flex-direction:column;gap:1.25rem">
      <!-- Edit Profile Card -->
      <div class="card">
        <div class="card-header" style="border-bottom:1px solid var(--color-border-light);padding-bottom:0.75rem;margin-bottom:1.25rem">
          <h3 class="card-title">⚙️ Edit Profile Information</h3>
        </div>
        <form id="editProfileForm" onsubmit="event.preventDefault(); SwiftMart.toasts.show('Profile information saved!', 'success')">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Full Name *</label>
              <input type="text" class="form-control" value="<?= htmlspecialchars($userInfo['name']) ?>" required/>
            </div>
            <div class="form-group">
              <label class="form-label">Contact Email *</label>
              <input type="email" class="form-control" value="<?= $userInfo['email'] ?>" required/>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Phone Number *</label>
              <input type="text" class="form-control" value="<?= $userInfo['phone'] ?>" required/>
            </div>
            <div class="form-group">
              <label class="form-label">Assigned Branch</label>
              <select class="form-control">
                <option selected>Gulshan Branch</option>
                <option>Dhanmondi Branch</option>
                <option>Mirpur Branch</option>
                <option>Uttara Branch</option>
                <option>Bashundhara Branch</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Shift Duration</label>
              <input type="text" class="form-control" value="<?= $userInfo['shift'] ?>" readonly style="background:#F1F5F9;cursor:not-allowed"/>
            </div>
            <div class="form-group">
              <label class="form-label">Joining Date</label>
              <input type="text" class="form-control" value="<?= $userInfo['join_date'] ?>" readonly style="background:#F1F5F9;cursor:not-allowed"/>
            </div>
          </div>
          <div class="alert alert-info">
            ℹ️ <strong>Oracle DB update:</strong> Executes <code>UPDATE EMPLOYEES SET full_name = :name, email = :email, phone = :phone WHERE emp_id = :id</code>.
          </div>
          <div style="text-align:right">
            <button class="btn btn-primary" type="submit">💾 Save Profile Info</button>
          </div>
        </form>
      </div>

      <!-- Change Password Card -->
      <div class="card">
        <div class="card-header" style="border-bottom:1px solid var(--color-border-light);padding-bottom:0.75rem;margin-bottom:1.25rem">
          <h3 class="card-title">🔑 Change Password</h3>
        </div>
        <form id="changePassForm" onsubmit="handlePasswordChange(event)">
          <div class="form-group">
            <label class="form-label">Current Password *</label>
            <input type="password" class="form-control" id="currPass" required/>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">New Password *</label>
              <input type="password" class="form-control" id="newPass" required placeholder="Min 6 characters"/>
            </div>
            <div class="form-group">
              <label class="form-label">Confirm New Password *</label>
              <input type="password" class="form-control" id="confPass" required/>
            </div>
          </div>
          <div class="alert alert-info">
            ℹ️ <strong>Oracle PL/SQL Auth:</strong> Calls <code>SEC_PKG.CHANGE_PASSWORD(:emp_id, :old_pass, :new_pass)</code> which verifies the password hash and updates the hash code in <code>EMPLOYEES</code> table.
          </div>
          <div style="text-align:right">
            <button class="btn btn-warning" type="submit">🔑 Update Password</button>
          </div>
        </form>
      </div>
    </div>

  </div>

</div><!-- /page-content -->
<?php include 'includes/footer.php'; ?>

<script>
function handlePasswordChange(e) {
  e.preventDefault();
  const curr = document.getElementById('currPass').value;
  const newP = document.getElementById('newPass').value;
  const conf = document.getElementById('confPass').value;
  
  if (newP.length < 6) {
    SwiftMart.toasts.show('New password must be at least 6 characters.', 'danger');
    return;
  }
  
  if (newP !== conf) {
    SwiftMart.toasts.show('Passwords do not match.', 'danger');
    return;
  }
  
  SwiftMart.toasts.show('Password successfully updated!', 'success');
  document.getElementById('changePassForm').reset();
}
</script>
