<?php
/**
 * SwiftMart – includes/sidebar.php
 * Collapsible sidebar navigation with role-based menus.
 * Usage: include 'includes/sidebar.php';
 *
 * DB: $activeNav is set on each page (e.g. 'dashboard')
 *     Role-based items will be filtered via Oracle session:
 *     SELECT role FROM EMPLOYEES WHERE emp_id = :session_user_id
 */
$activeNav = $activeNav ?? '';
?>
<aside class="sidebar" id="sidebar">

  <!-- Brand / Logo -->
  <div class="sidebar-brand">
    <div class="sidebar-logo">🛒</div>
    <div class="sidebar-brand-text">
      <h2>SwiftMart</h2>
      <span>ERP Management</span>
    </div>
  </div>

  <!-- Navigation -->
  <nav class="sidebar-nav" id="sidebarNav">

    <!-- ── Main ── -->
    <div class="nav-section-label">Main</div>

    <div class="nav-item">
      <a href="dashboard.php" class="nav-link <?= $activeNav === 'dashboard' ? 'active' : '' ?>">
        <span class="nav-icon">📊</span>
        <span class="nav-text">Dashboard</span>
      </a>
    </div>

    <!-- ── Operations ── -->
    <div class="nav-section-label">Operations</div>

    <div class="nav-item">
      <a href="pos.php" class="nav-link <?= $activeNav === 'pos' ? 'active' : '' ?>">
        <span class="nav-icon">🧾</span>
        <span class="nav-text">POS Billing</span>
      </a>
    </div>

    <div class="nav-item">
      <a href="inventory.php" class="nav-link <?= $activeNav === 'inventory' ? 'active' : '' ?>">
        <span class="nav-icon">📦</span>
        <span class="nav-text">Inventory</span>
        <span class="nav-badge" id="lowStockBadge">8</span>
      </a>
    </div>

    <div class="nav-item">
      <a href="products.php" class="nav-link <?= $activeNav === 'products' ? 'active' : '' ?>">
        <span class="nav-icon">🏷️</span>
        <span class="nav-text">Products & Categories</span>
      </a>
    </div>

    <div class="nav-item">
      <a href="promotions.php" class="nav-link <?= $activeNav === 'promotions' ? 'active' : '' ?>">
        <span class="nav-icon">🎯</span>
        <span class="nav-text">Offers & Promotions</span>
      </a>
    </div>

    <!-- ── People ── -->
    <div class="nav-section-label">People</div>

    <div class="nav-item">
      <a href="customers.php" class="nav-link <?= $activeNav === 'customers' ? 'active' : '' ?>">
        <span class="nav-icon">👥</span>
        <span class="nav-text">Customers & Loyalty</span>
      </a>
    </div>

    <div class="nav-item">
      <a href="employees.php" class="nav-link <?= $activeNav === 'employees' ? 'active' : '' ?>">
        <span class="nav-icon">🧑‍💼</span>
        <span class="nav-text">Employees & Shifts</span>
      </a>
    </div>

    <div class="nav-item">
      <a href="suppliers.php" class="nav-link <?= $activeNav === 'suppliers' ? 'active' : '' ?>">
        <span class="nav-icon">🚚</span>
        <span class="nav-text">Suppliers</span>
      </a>
    </div>

    <!-- ── Network ── -->
    <div class="nav-section-label">Network</div>

    <div class="nav-item">
      <a href="branches.php" class="nav-link <?= $activeNav === 'branches' ? 'active' : '' ?>">
        <span class="nav-icon">🏪</span>
        <span class="nav-text">Multi-Branch</span>
      </a>
    </div>

    <!-- ── Analytics ── -->
    <div class="nav-section-label">Analytics</div>

    <div class="nav-item">
      <a href="reports.php" class="nav-link <?= $activeNav === 'reports' ? 'active' : '' ?>">
        <span class="nav-icon">📈</span>
        <span class="nav-text">Reports & Analytics</span>
      </a>
    </div>

    <div class="nav-item">
      <a href="notifications.php" class="nav-link <?= $activeNav === 'notifications' ? 'active' : '' ?>">
        <span class="nav-icon">🔔</span>
        <span class="nav-text">Notifications</span>
        <span class="nav-badge">12</span>
      </a>
    </div>

    <!-- ── Account ── -->
    <div class="nav-section-label">Account</div>

    <div class="nav-item">
      <a href="profile.php" class="nav-link <?= $activeNav === 'profile' ? 'active' : '' ?>">
        <span class="nav-icon">👤</span>
        <span class="nav-text">My Profile</span>
      </a>
    </div>

    <div class="nav-item">
      <a href="settings.php" class="nav-link <?= $activeNav === 'settings' ? 'active' : '' ?>">
        <span class="nav-icon">⚙️</span>
        <span class="nav-text">Settings</span>
      </a>
    </div>

  </nav><!-- /sidebar-nav -->

  <!-- User Info (footer) -->
  <div class="sidebar-footer">
    <a href="profile.php" class="sidebar-user" style="text-decoration:none">
      <div class="sidebar-avatar">RA</div>
      <div class="sidebar-user-info">
        <!-- DB: SELECT full_name, role FROM EMPLOYEES WHERE emp_id = :session_id -->
        <h4>Rahim Uddin</h4>
        <span>System Admin</span>
      </div>
    </a>
  </div>

</aside><!-- /sidebar -->
