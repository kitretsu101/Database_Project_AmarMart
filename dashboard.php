<?php
/**
 * SwiftMart – dashboard.php
 * Main dashboard: KPI cards, revenue chart, top products,
 * recent activity feed, donut chart.
 *
 * DB Integration points marked with /* DB: ... */
 
$pageTitle          = 'Dashboard';
$activeNav          = 'dashboard';
$includeDashboardJs = true;

/* ── Dummy KPI Data (replace with Oracle queries) ─────────────
 * DB: SELECT SUM(total_amount) FROM ORDERS WHERE TRUNC(order_date)=TRUNC(SYSDATE)
 * DB: SELECT SUM(total_amount) FROM ORDERS WHERE EXTRACT(MONTH FROM order_date)=EXTRACT(MONTH FROM SYSDATE)
 * DB: SELECT COUNT(*) FROM PRODUCTS WHERE is_active=1
 * DB: SELECT COUNT(*) FROM CUSTOMERS
 * DB: SELECT COUNT(*) FROM EMPLOYEES WHERE is_active=1
 * DB: SELECT COUNT(*) FROM PRODUCTS WHERE stock_qty < min_stock_level
 */
$kpis = [
  ['label'=>'Today\'s Sales',    'value'=>'1,284',   'sub'=>'transactions',   'change'=>'+12.4%','up'=>true, 'icon'=>'🛒','class'=>'sales'],
  ['label'=>'Monthly Revenue',   'value'=>'৳84.2L',  'sub'=>'this month',     'change'=>'+8.7%', 'up'=>true, 'icon'=>'💰','class'=>'revenue'],
  ['label'=>'Total Products',    'value'=>'3,847',   'sub'=>'active items',   'change'=>'+45',   'up'=>true, 'icon'=>'🏷️','class'=>'products'],
  ['label'=>'Total Customers',   'value'=>'12,459',  'sub'=>'registered',     'change'=>'+234',  'up'=>true, 'icon'=>'👥','class'=>'customers'],
  ['label'=>'Total Employees',   'value'=>'187',     'sub'=>'across 5 branches','change'=>'+3', 'up'=>true, 'icon'=>'🧑‍💼','class'=>'employees'],
  ['label'=>'Low Stock Alerts',  'value'=>'8',       'sub'=>'need restocking','change'=>'-2',   'up'=>false,'icon'=>'⚠️','class'=>'alerts'],
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
      <h1>Dashboard</h1>
      <div class="breadcrumb">
        🏠 Home <span>/</span> Dashboard
      </div>
    </div>
    <div style="display:flex;align-items:center;gap:0.75rem">
      <select class="form-control" style="width:auto;padding:0.5rem 1rem">
        <option>Today</option>
        <option>This Week</option>
        <option selected>This Month</option>
        <option>This Year</option>
      </select>
      <button class="btn btn-primary">📊 Export Report</button>
    </div>
  </div>

  <!-- ── KPI Stats Grid ──────────────────────────────────── -->
  <div class="stats-grid">
    <?php foreach ($kpis as $k): ?>
    <div class="stat-card <?= $k['class'] ?>">
      <div class="stat-icon"><?= $k['icon'] ?></div>
      <div class="stat-info">
        <div class="stat-value"><?= $k['value'] ?></div>
        <div class="stat-label"><?= $k['label'] ?></div>
        <div class="stat-change <?= $k['up'] ? 'positive' : 'negative' ?>">
          <?= $k['up'] ? '▲' : '▼' ?> <?= $k['change'] ?> vs last month
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- ── Revenue Chart + Donut ──────────────────────────── -->
  <div class="dashboard-grid">

    <!-- Bar Chart -->
    <div class="chart-card">
      <div class="chart-header">
        <div>
          <div class="chart-title">Monthly Revenue Overview</div>
          <div class="chart-subtitle">January – July 2025 (in thousands BDT)</div>
        </div>
        <div class="chart-legend">
          <div class="legend-item">
            <div class="legend-dot" style="background:var(--color-primary)"></div>
            <span>Revenue</span>
          </div>
          <div class="legend-item">
            <div class="legend-dot" style="background:var(--color-accent)"></div>
            <span>Target</span>
          </div>
        </div>
      </div>
      <!-- DB: Populated by dashboard.js → DashboardModule.barChart -->
      <div class="bar-chart" id="revenueBarChart" style="height:180px;align-items:flex-end">
        <!-- Rendered by dashboard.js -->
      </div>
      <div style="display:flex;justify-content:space-between;margin-top:1rem;padding-top:0.75rem;border-top:1px solid var(--color-border-light)">
        <div style="text-align:center">
          <div style="font-size:1.1rem;font-weight:800;color:var(--color-primary)">৳84.2L</div>
          <div style="font-size:0.7rem;color:var(--color-text-muted)">Total Revenue</div>
        </div>
        <div style="text-align:center">
          <div style="font-size:1.1rem;font-weight:800;color:var(--color-accent)">৳91L</div>
          <div style="font-size:0.7rem;color:var(--color-text-muted)">Target</div>
        </div>
        <div style="text-align:center">
          <div style="font-size:1.1rem;font-weight:800;color:var(--color-warning)">92.5%</div>
          <div style="font-size:0.7rem;color:var(--color-text-muted)">Achievement</div>
        </div>
        <div style="text-align:center">
          <div style="font-size:1.1rem;font-weight:800;color:var(--color-purple)">৳6.8L</div>
          <div style="font-size:0.7rem;color:var(--color-text-muted)">Pending</div>
        </div>
      </div>
    </div>

    <!-- Donut Chart (Category Sales) -->
    <div class="chart-card">
      <div class="chart-header">
        <div>
          <div class="chart-title">Sales by Category</div>
          <div class="chart-subtitle">July 2025</div>
        </div>
      </div>
      <!-- DB: Populated by dashboard.js → DashboardModule.donut -->
      <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap" class="donut-wrap">
        <div class="donut-chart" id="donutChartEl">
          <div class="donut-center">32%<br><span style="font-size:0.6rem;font-weight:400;color:var(--color-text-muted)">Top</span></div>
        </div>
        <div style="flex:1;min-width:120px">
          <div id="donutLegend" style="display:flex;flex-direction:column;gap:0.5rem">
            <!-- Rendered by dashboard.js -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ── Top Products + Activity ────────────────────────── -->
  <div class="dashboard-grid">

    <!-- Top Selling Products -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">🏆 Top Selling Products</h3>
        <a href="products.php" class="btn btn-ghost btn-sm">View All →</a>
      </div>
      <!-- DB: SELECT p.product_name, c.category_name, SUM(oi.qty) AS sold,
                     SUM(oi.qty * oi.unit_price) AS revenue
               FROM ORDER_ITEMS oi JOIN PRODUCTS p ON oi.product_id=p.product_id
               JOIN CATEGORIES c ON p.category_id=c.category_id
               GROUP BY p.product_name, c.category_name
               ORDER BY sold DESC FETCH FIRST 6 ROWS ONLY -->
      <div class="table-wrapper">
        <table class="data-table" id="topProductsTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Product</th>
              <th>Category</th>
              <th>Sold</th>
              <th>Revenue</th>
              <th>Trend</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $topProducts = [
              ['rank'=>1,'emoji'=>'☕','name'=>'Nescafé Gold 200g',    'cat'=>'Beverages','sold'=>2847,'rev'=>'৳24.2L','pct'=>95],
              ['rank'=>2,'emoji'=>'🥭','name'=>'Pran Mango Juice 250ml','cat'=>'Beverages','sold'=>2410,'rev'=>'৳8.4L', 'pct'=>80],
              ['rank'=>3,'emoji'=>'🥚','name'=>'Egg (12 pcs)',          'cat'=>'Dairy',   'sold'=>1987,'rev'=>'৳32.8L','pct'=>75],
              ['rank'=>4,'emoji'=>'🍪','name'=>'Oreo Cookies 120g',     'cat'=>'Snacks',  'sold'=>1756,'rev'=>'৳16.7L','pct'=>65],
              ['rank'=>5,'emoji'=>'🧺','name'=>'Ariel Detergent 1kg',   'cat'=>'Household','sold'=>1490,'rev'=>'৳62.6L','pct'=>55],
              ['rank'=>6,'emoji'=>'🍜','name'=>'Maggi Noodles 75g',     'cat'=>'Grocery', 'sold'=>1340,'rev'=>'৳29.5L','pct'=>50],
            ];
            foreach ($topProducts as $p):
              $rankClass = $p['rank'] <= 3 ? ['top1','top2','top3'][$p['rank']-1] : '';
            ?>
            <tr>
              <td><span class="rank-cell <?= $rankClass ?>"><?= ['🥇','🥈','🥉','4','5','6'][$p['rank']-1] ?></span></td>
              <td>
                <div class="product-cell">
                  <div class="product-thumb"><?= $p['emoji'] ?></div>
                  <div class="product-meta">
                    <h5><?= $p['name'] ?></h5>
                    <span>SKU-<?= str_pad($p['rank'], 4, '0', STR_PAD_LEFT) ?></span>
                  </div>
                </div>
              </td>
              <td><span class="badge badge-primary"><?= $p['cat'] ?></span></td>
              <td><strong><?= number_format($p['sold']) ?></strong> units</td>
              <td style="color:var(--color-accent);font-weight:700"><?= $p['rev'] ?></td>
              <td>
                <div class="sold-bar" style="min-width:100px">
                  <div class="bar-bg"><div class="bar-fill" style="width:<?= $p['pct'] ?>%"></div></div>
                  <span class="text-xs text-muted"><?= $p['pct'] ?>%</span>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">🕐 Recent Activity</h3>
        <a href="notifications.php" class="btn btn-ghost btn-sm">All →</a>
      </div>
      <!-- Rendered by dashboard.js → DashboardModule.activityFeed -->
      <div class="activity-feed" id="activityFeed"></div>
    </div>
  </div>

  <!-- ── Branch Summary Row ──────────────────────────────── -->
  <div class="card mb-3">
    <div class="card-header">
      <h3 class="card-title">🏪 Branch Performance Today</h3>
      <a href="branches.php" class="btn btn-outline btn-sm">Manage Branches →</a>
    </div>
    <!-- DB: SELECT b.branch_name, SUM(o.total_amount) AS daily_rev,
                   COUNT(o.order_id) AS orders
             FROM BRANCHES b LEFT JOIN ORDERS o ON b.branch_id=o.branch_id
             AND TRUNC(o.order_date)=TRUNC(SYSDATE)
             GROUP BY b.branch_name ORDER BY daily_rev DESC -->
    <div class="table-wrapper">
      <table class="data-table">
        <thead>
          <tr><th>Branch</th><th>Manager</th><th>Today's Sales</th><th>Orders</th><th>Target</th><th>Status</th></tr>
        </thead>
        <tbody>
          <?php
          $branches = [
            ['name'=>'Gulshan Branch',    'mgr'=>'Karim Ahmed',  'sales'=>'৳2,45,800','orders'=>312,'target'=>'৳2,50,000','pct'=>98, 'status'=>'On Track'],
            ['name'=>'Dhanmondi Branch',  'mgr'=>'Sadia Islam',  'sales'=>'৳1,87,400','orders'=>248,'target'=>'৳2,00,000','pct'=>94, 'status'=>'On Track'],
            ['name'=>'Mirpur Branch',     'mgr'=>'Rafiq Hossain','sales'=>'৳1,42,100','orders'=>189,'target'=>'৳1,75,000','pct'=>81, 'status'=>'Behind'],
            ['name'=>'Uttara Branch',     'mgr'=>'Nasreen Khan', 'sales'=>'৳2,10,500','orders'=>278,'target'=>'৳2,10,000','pct'=>100,'status'=>'Achieved'],
            ['name'=>'Bashundhara Branch','mgr'=>'Tariq Miah',   'sales'=>'৳1,56,700','orders'=>207,'target'=>'৳1,80,000','pct'=>87, 'status'=>'On Track'],
          ];
          foreach ($branches as $b):
          ?>
          <tr>
            <td><strong>🏪 <?= $b['name'] ?></strong></td>
            <td><?= $b['mgr'] ?></td>
            <td style="font-weight:700;color:var(--color-accent)"><?= $b['sales'] ?></td>
            <td><?= $b['orders'] ?> orders</td>
            <td>
              <div class="sold-bar" style="min-width:90px">
                <div class="bar-bg"><div class="bar-fill" style="width:<?= $b['pct'] ?>%"></div></div>
                <span class="text-xs"><?= $b['pct'] ?>%</span>
              </div>
            </td>
            <td>
              <span class="badge <?= $b['pct']>=100?'badge-success':($b['pct']<85?'badge-danger':'badge-warning') ?>">
                <?= $b['status'] ?>
              </span>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div><!-- /page-content -->
<?php include 'includes/footer.php'; ?>
