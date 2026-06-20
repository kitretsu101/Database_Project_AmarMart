<?php
/**
 * SwiftMart – notifications.php
 * Notifications & Alerts Center.
 * Handles low stock alerts, product expiry warnings, supplier delivery alerts,
 * and system logs with clear interactive controls.
 *
 * DB Integration Points:
 * DB: SELECT alert_id, title, description, category, severity, created_at, is_read
 *         FROM ALERTS WHERE user_id = :session_user_id AND is_active = 1
 *         ORDER BY created_at DESC
 */
$pageTitle = 'Notifications Center';
$activeNav = 'notifications';

$alerts = [
  // Low Stock
  ['id'=>'A001', 'cat'=>'Stock', 'title'=>'Low Stock: Whole Wheat Bread', 'desc'=>'Whole Wheat Bread stock is at 54 pcs (Reorder level is 40). Mirpur branch has 0 inventory.', 'time'=>'10 mins ago', 'severity'=>'warning', 'read'=>false],
  ['id'=>'A002', 'cat'=>'Stock', 'title'=>'Critical Stock Out: Sunflower Oil 1L', 'desc'=>'Sunflower Oil 1L has dropped to 8 bottles. Expected demand this weekend is 80 bottles.', 'time'=>'45 mins ago', 'severity'=>'danger', 'read'=>false],
  // Expiry
  ['id'=>'A003', 'cat'=>'Expiry', 'title'=>'Expiry Warning: Fresh Milk 1L', 'desc'=>'120 pcs of Fresh Milk 1L at Gulshan branch expire on 2025-07-25 (5 days remaining).', 'time'=>'2 hours ago', 'severity'=>'warning', 'read'=>false],
  ['id'=>'A004', 'cat'=>'Expiry', 'title'=>'Expired Stock: Yogurt 150g', 'desc'=>'45 packs of Greek Yogurt 150g expired yesterday. Write-off report required.', 'time'=>'1 day ago', 'severity'=>'danger', 'read'=>true],
  // Delivery
  ['id'=>'A005', 'cat'=>'Delivery', 'title'=>'Shipment Delayed: PO-1094', 'desc'=>'Nestlé Bangladesh purchase order PO-1094 expected on 22 Jul is delayed by 2 days due to transit issues.', 'time'=>'3 hours ago', 'severity'=>'warning', 'read'=>false],
  ['id'=>'A006', 'cat'=>'Delivery', 'title'=>'Delivery Received: PO-1092', 'desc'=>'ACI Limited order of Colgate and Lux successfully delivered and scanned into inventory at Uttara.', 'time'=>'5 hours ago', 'severity'=>'success', 'read'=>true],
  // System
  ['id'=>'A007', 'cat'=>'System', 'title'=>'Oracle DB Backup Completed', 'desc'=>'Automated full database backup to Oracle Cloud Storage completed successfully (Size: 1.42 GB).', 'time'=>'12 hours ago', 'severity'=>'info', 'read'=>true],
  ['id'=>'A008', 'cat'=>'System', 'title'=>'Security Alert: Login Attempt', 'desc'=>'Multiple login failures detected for user raju@swiftmart.com from terminal T-04 (IP: 192.168.1.104).', 'time'=>'2 days ago', 'severity'=>'warning', 'read'=>true],
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
      <h1>🔔 Notifications Center</h1>
      <div class="breadcrumb">
        🏠 Home <span>/</span> Notifications
      </div>
    </div>
    <div style="display:flex;gap:0.75rem">
      <button class="btn btn-outline btn-sm" onclick="markAllAsRead()">✓ Mark All as Read</button>
      <button class="btn btn-danger btn-sm" onclick="clearAllNotifications()">🗑 Clear All</button>
    </div>
  </div>

  <!-- Notification Filters / Tabs -->
  <div class="card mb-2" style="padding:1rem">
    <div style="display:flex;gap:0.5rem;flex-wrap:wrap" class="tab-list">
      <button class="btn btn-primary btn-sm notif-tab" onclick="switchTab('All')">All Alerts (<span id="count-All">8</span>)</button>
      <button class="btn btn-ghost btn-sm notif-tab" onclick="switchTab('Stock')">⚠️ Low Stock (<span id="count-Stock">2</span>)</button>
      <button class="btn btn-ghost btn-sm notif-tab" onclick="switchTab('Expiry')">📅 Expiry (<span id="count-Expiry">2</span>)</button>
      <button class="btn btn-ghost btn-sm notif-tab" onclick="switchTab('Delivery')">🚚 Deliveries (<span id="count-Delivery">2</span>)</button>
      <button class="btn btn-ghost btn-sm notif-tab" onclick="switchTab('System')">⚙️ System (<span id="count-System">2</span>)</button>
    </div>
  </div>

  <!-- Notification Feed -->
  <div style="display:flex;flex-direction:column;gap:1rem" id="notifContainer">
    <?php foreach ($alerts as $a):
      $sevColor = match($a['severity']) {
        'danger'  => 'border-left:4px solid var(--color-danger)',
        'warning' => 'border-left:4px solid var(--color-warning)',
        'success' => 'border-left:4px solid var(--color-accent)',
        'info'    => 'border-left:4px solid var(--color-info)',
        default   => 'border-left:4px solid var(--color-border)'
      };
      $unreadStyle = !$a['read'] ? 'background:#F8FAFC;font-weight:500;box-shadow:var(--shadow-md)' : '';
    ?>
    <div class="card notif-card" data-category="<?= $a['cat'] ?>" data-read="<?= $a['read']?'true':'false' ?>" id="alert-<?= $a['id'] ?>" style="padding:1.25rem;display:flex;align-items:start;gap:1rem;transition:all var(--transition-fast);<?= $sevColor ?>;<?= $unreadStyle ?>">
      
      <!-- Icon representation -->
      <div style="font-size:1.5rem;width:40px;height:40px;border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;background:#fff;box-shadow:var(--shadow-sm);flex-shrink:0">
        <?= match($a['cat']) {
          'Stock'    => '📦',
          'Expiry'   => '📅',
          'Delivery' => '🚚',
          'System'   => '⚙️',
          default    => '🔔'
        } ?>
      </div>

      <!-- Info -->
      <div style="flex:1">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.25rem;flex-wrap:wrap;gap:0.5rem">
          <h3 style="font-size:0.95rem;font-weight:700"><?= htmlspecialchars($a['title']) ?></h3>
          <span style="font-size:0.7rem;color:var(--color-text-light)"><?= $a['time'] ?></span>
        </div>
        <p style="font-size:0.825rem;color:var(--color-text-muted);margin-bottom:0.75rem"><?= htmlspecialchars($a['desc']) ?></p>
        
        <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap">
          <span class="badge <?= match($a['severity']) {
            'danger' => 'badge-danger',
            'warning' => 'badge-warning',
            'success' => 'badge-success',
            'info' => 'badge-info',
            default => 'badge-gray'
          } ?>"><?= strtoupper($a['severity']) ?></span>
          
          <span class="badge badge-gray"><?= $a['cat'] ?></span>
          
          <div style="margin-left:auto;display:flex;gap:0.5rem">
            <?php if (!$a['read']): ?>
              <button class="btn btn-outline btn-sm" style="padding:3px 10px;font-size:0.7rem" id="btn-read-<?= $a['id'] ?>" onclick="markAsRead('<?= $a['id'] ?>')">✓ Read</button>
            <?php endif; ?>
            <button class="btn btn-primary btn-sm" style="padding:3px 10px;font-size:0.7rem" onclick="resolveAlert('<?= $a['id'] ?>', '<?= $a['cat'] ?>')">🛠 Resolve</button>
            <button class="btn btn-ghost btn-sm" style="padding:3px 10px;font-size:0.7rem" onclick="deleteAlert('<?= $a['id'] ?>')">✕ Delete</button>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Empty State -->
  <div id="emptyNotifMessage" class="card" style="display:none;text-align:center;padding:4rem">
    <div style="font-size:3.5rem;margin-bottom:1rem">🔔</div>
    <h3>All Caught Up!</h3>
    <p>No notifications match the selected category.</p>
  </div>

  <div class="alert alert-info" style="margin-top:2rem">
    <h4>🔔 Oracle Database Integration Points:</h4>
    <p style="font-size:0.8rem;line-height:1.4;margin-top:0.25rem">
      • <strong>Automated Alerts:</strong> A database trigger <code>TRG_INVENTORY_ALERT</code> automatically inserts record into the <code>ALERTS</code> table whenever a product's <code>stock_qty</code> drops below <code>min_stock_level</code>.<br>
      • <strong>Status Updates:</strong> Clearing or marking alerts as read executes <code>UPDATE ALERTS SET is_read = 1 WHERE alert_id = :id</code>.
    </p>
  </div>

</div><!-- /page-content -->
<?php include 'includes/footer.php'; ?>

<script>
let currentTab = 'All';

function switchTab(tabName) {
  currentTab = tabName;
  
  // Highlight tab buttons
  document.querySelectorAll('.notif-tab').forEach(btn => {
    btn.className = 'btn btn-ghost btn-sm notif-tab';
  });
  event.currentTarget.className = 'btn btn-primary btn-sm notif-tab';
  
  filterCards();
}

function filterCards() {
  const cards = document.querySelectorAll('.notif-card');
  let visibleCount = 0;
  
  cards.forEach(card => {
    const cat = card.getAttribute('data-category');
    if (currentTab === 'All' || cat === currentTab) {
      card.style.display = 'flex';
      visibleCount++;
    } else {
      card.style.display = 'none';
    }
  });
  
  const emptyMsg = document.getElementById('emptyNotifMessage');
  const container = document.getElementById('notifContainer');
  
  if (visibleCount === 0) {
    emptyMsg.style.display = 'block';
    container.style.display = 'none';
  } else {
    emptyMsg.style.display = 'flex';
    container.style.display = 'flex';
    emptyMsg.style.display = 'none';
  }
}

function markAsRead(id) {
  const card = document.getElementById('alert-' + id);
  if (!card) return;
  
  card.style.background = '#fff';
  card.style.fontWeight = 'normal';
  card.style.boxShadow = 'var(--shadow-card)';
  card.setAttribute('data-read', 'true');
  
  const readBtn = document.getElementById('btn-read-' + id);
  if (readBtn) readBtn.remove();
  
  updateBadges();
  SwiftMart.toasts.show('Alert marked as read.', 'success');
}

function markAllAsRead() {
  document.querySelectorAll('.notif-card[data-read="false"]').forEach(card => {
    const id = card.id.replace('alert-', '');
    markAsRead(id);
  });
}

function resolveAlert(id, category) {
  let actionMsg = 'Resolving alert...';
  if (category === 'Stock') {
    actionMsg = 'Reordering stock items... Redirecting to Purchase Orders.';
    setTimeout(() => window.location.href = 'suppliers.php', 1500);
  } else if (category === 'Expiry') {
    actionMsg = 'Creating product clearance markdown or write-off entry.';
  } else if (category === 'Delivery') {
    actionMsg = 'Opening purchase order details...';
    setTimeout(() => window.location.href = 'suppliers.php', 1500);
  } else {
    actionMsg = 'Resolving system parameter configuration.';
  }
  
  SwiftMart.toasts.show(actionMsg, 'info');
  markAsRead(id);
}

function deleteAlert(id) {
  const card = document.getElementById('alert-' + id);
  if (!card) return;
  
  card.style.opacity = '0';
  card.style.transform = 'scale(0.9)';
  setTimeout(() => {
    card.remove();
    updateBadges();
    filterCards();
  }, 300);
}

function clearAllNotifications() {
  if (confirm('Clear all notifications? This will delete all logged messages.')) {
    document.querySelectorAll('.notif-card').forEach(card => card.remove());
    updateBadges();
    filterCards();
    SwiftMart.toasts.show('All alerts deleted.', 'danger');
  }
}

function updateBadges() {
  const categories = ['All', 'Stock', 'Expiry', 'Delivery', 'System'];
  
  categories.forEach(cat => {
    const selector = cat === 'All' ? '.notif-card' : `.notif-card[data-category="${cat}"]`;
    const count = document.querySelectorAll(selector).length;
    const countEl = document.getElementById('count-' + cat);
    if (countEl) countEl.textContent = count;
  });
}

// Initial count updates
document.addEventListener('DOMContentLoaded', updateBadges);
</script>
