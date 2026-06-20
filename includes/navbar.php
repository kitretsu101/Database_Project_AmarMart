<?php
/**
 * SwiftMart – includes/navbar.php
 * Top navigation bar: toggle, global search, notifications, profile.
 * Usage: include 'includes/navbar.php';
 *
 * DB: Notification count from ALERTS table
 *     DB: SELECT COUNT(*) FROM ALERTS WHERE is_read=0 AND user_id=:id
 */
?>
<header class="navbar" id="mainNavbar">

  <!-- Left: Toggle + Search -->
  <div class="navbar-left">
    <button class="toggle-btn" id="sidebarToggle" title="Toggle Sidebar (Ctrl+B)"
            aria-label="Toggle Sidebar">
      ☰
    </button>

    <div class="navbar-search">
      <span class="search-icon" style="font-size:0.9rem">🔍</span>
      <input type="text" id="globalSearch"
             placeholder="Search products, orders, customers…"
             autocomplete="off" />
      <span style="font-size:0.65rem;color:var(--color-text-light);white-space:nowrap">
        Ctrl+K
      </span>
    </div>
  </div>

  <!-- Right: Icons + Profile -->
  <div class="navbar-right">

    <!-- Live Clock -->
    <span id="liveClock"
          style="font-size:0.8rem;font-weight:600;color:var(--color-text-muted);padding:0 0.5rem;display:none">
    </span>

    <!-- Quick Add -->
    <button class="icon-btn" data-modal-open="addProductModal"
            title="Quick Add Product" style="display:flex;align-items:center;justify-content:center">
      ＋
    </button>

    <!-- Notifications -->
    <div class="dropdown" style="position:relative">
      <button class="icon-btn" id="notifBtn" title="Notifications" aria-label="Notifications">
        🔔
        <span class="badge-dot"></span>
      </button>

      <!-- Notification Panel -->
      <div class="notif-panel" id="notifPanel">
        <div class="notif-header">
          <h4 style="font-size:0.875rem;font-weight:700;color:var(--color-secondary)">
            Notifications
          </h4>
          <span class="badge badge-danger">12 New</span>
        </div>

        <div class="notif-list">
          <!-- DB: SELECT * FROM ALERTS WHERE is_read=0 ORDER BY created_at DESC FETCH FIRST 8 ROWS ONLY -->
          <div class="notif-item unread">
            <div class="notif-icon" style="background:#FEF2F2;color:#EF4444">⚠️</div>
            <div class="notif-info">
              <p><strong>Low Stock:</strong> Parachute Coconut Oil (12 left)</p>
              <span>5 min ago</span>
            </div>
          </div>
          <div class="notif-item unread">
            <div class="notif-icon" style="background:#FEF9C3;color:#CA8A04">⏰</div>
            <div class="notif-info">
              <p><strong>Expiry Alert:</strong> Yogurt batch expires in 2 days</p>
              <span>22 min ago</span>
            </div>
          </div>
          <div class="notif-item unread">
            <div class="notif-icon" style="background:#ECFDF5;color:#10B981">🚚</div>
            <div class="notif-info">
              <p><strong>Delivery Arrived:</strong> PO #PO-1093 from ACI Ltd</p>
              <span>1 hr ago</span>
            </div>
          </div>
          <div class="notif-item">
            <div class="notif-icon" style="background:#EFF6FF;color:#2563EB">🛒</div>
            <div class="notif-info">
              <p><strong>New Order:</strong> #INV-2047 – ৳4,850</p>
              <span>2 hr ago</span>
            </div>
          </div>
          <div class="notif-item">
            <div class="notif-icon" style="background:#F5F3FF;color:#7C3AED">👤</div>
            <div class="notif-info">
              <p><strong>New Customer:</strong> Arif Hossain registered</p>
              <span>3 hr ago</span>
            </div>
          </div>
        </div>

        <div class="notif-footer">
          <a href="notifications.php"
             style="font-size:0.8rem;font-weight:600;color:var(--color-primary)">
            View All Notifications →
          </a>
        </div>
      </div><!-- /notif-panel -->
    </div><!-- /dropdown -->

    <!-- Separator -->
    <div style="width:1px;height:24px;background:var(--color-border)"></div>

    <!-- Profile Dropdown -->
    <div class="dropdown" style="position:relative">
      <button class="profile-btn" id="profileBtn" aria-label="Profile menu">
        <div class="profile-avatar">RA</div>
        <!-- DB: SELECT full_name FROM EMPLOYEES WHERE emp_id = :session_id -->
        <span class="profile-name">Rahim Uddin</span>
        <span style="font-size:0.65rem;color:var(--color-text-muted)">▾</span>
      </button>

      <div class="dropdown-menu" id="profileMenu">
        <div style="padding:0.85rem 1rem;border-bottom:1px solid var(--color-border-light)">
          <p style="font-size:0.8rem;font-weight:700;color:var(--color-secondary);margin:0">Rahim Uddin</p>
          <p style="font-size:0.7rem;color:var(--color-text-muted);margin:0">System Admin · Gulshan Branch</p>
        </div>
        <a href="profile.php" class="dropdown-item">👤 My Profile</a>
        <a href="settings.php" class="dropdown-item">⚙️ Settings</a>
        <a href="notifications.php" class="dropdown-item">🔔 Notifications</a>
        <div class="dropdown-divider"></div>
        <a href="login.php" class="dropdown-item danger">🚪 Logout</a>
      </div>
    </div><!-- /dropdown -->

  </div><!-- /navbar-right -->
</header><!-- /navbar -->
