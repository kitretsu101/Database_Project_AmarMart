<?php
/**
 * SwiftMart – reports.php
 * Reports & Analytics dashboard.
 * Features KPI cards, horizontal bar breakdowns, ranking list tables,
 * recent sales log, and Oracle analytical SQL query comments.
 *
 * DB Integration Points:
 * DB: Oracle Analytical Functions:
 *     SELECT branch_name, SUM(total_amount) AS revenue,
 *            RANK() OVER (ORDER BY SUM(total_amount) DESC) as branch_rank
 *     FROM ORDERS JOIN BRANCHES USING(branch_id)
 *     GROUP BY branch_name
 */

$pageTitle = 'Reports & Analytics';
$activeNav = 'reports';

$kpis = [
  ['label' => 'Gross Profit Margin', 'value' => '24.8%', 'sub' => 'Avg margin', 'change' => '+1.2%', 'up' => true, 'icon' => '📈', 'class' => 'sales'],
  ['label' => 'Net Sales Revenue', 'value' => '৳84.25L', 'sub' => 'This month', 'change' => '+8.7%', 'up' => true, 'icon' => '💰', 'class' => 'revenue'],
  ['label' => 'Total Invoices', 'value' => '12,842', 'sub' => 'Transactions', 'change' => '+4.5%', 'up' => true, 'icon' => '🧾', 'class' => 'products'],
  ['label' => 'Average Basket Value', 'value' => '৳656', 'sub' => 'Per receipt', 'change' => '-1.8%', 'up' => false, 'icon' => '🛒', 'class' => 'customers'],
];

$salesTransactions = [
  ['inv' => 'INV-2025-0842', 'date' => '2025-07-20 22:15', 'branch' => 'Gulshan', 'cust' => 'Riya Sultana', 'pay' => 'Credit Card', 'items' => 4, 'disc' => '৳250', 'vat' => '৳420', 'total' => '৳8,820'],
  ['inv' => 'INV-2025-0841', 'date' => '2025-07-20 21:40', 'branch' => 'Uttara', 'cust' => 'Tariq Miah', 'pay' => 'Bkash', 'items' => 3, 'disc' => '৳0', 'vat' => '৳45', 'total' => '৳945'],
  ['inv' => 'INV-2025-0840', 'date' => '2025-07-20 21:12', 'branch' => 'Gulshan', 'cust' => 'Walk-in Client', 'pay' => 'Cash', 'items' => 2, 'disc' => '৳15', 'vat' => '৳22', 'total' => '৳462'],
  ['inv' => 'INV-2025-0839', 'date' => '2025-07-20 20:30', 'branch' => 'Dhanmondi', 'cust' => 'Arif Hossain', 'pay' => 'Credit Card', 'items' => 6, 'disc' => '৳120', 'vat' => '৳185', 'total' => '৳3,885'],
  ['inv' => 'INV-2025-0838', 'date' => '2025-07-20 19:45', 'branch' => 'Mirpur', 'cust' => 'Karim Ahmed', 'pay' => 'Cash', 'items' => 1, 'disc' => '৳0', 'vat' => '৳18', 'total' => '৳378'],
  ['inv' => 'INV-2025-0837', 'date' => '2025-07-20 18:22', 'branch' => 'Bashundhara', 'cust' => 'Walk-in Client', 'pay' => 'Nagad', 'items' => 5, 'disc' => '৳50', 'vat' => '৳110', 'total' => '৳2,310'],
];

$branchRankings = [
  ['rank' => 1, 'branch' => 'Gulshan Branch', 'revenue' => '৳28.45L', 'pct' => 100],
  ['rank' => 2, 'branch' => 'Uttara Branch', 'revenue' => '৳21.10L', 'pct' => 74],
  ['rank' => 3, 'branch' => 'Dhanmondi Branch', 'revenue' => '৳18.74L', 'pct' => 65],
  ['rank' => 4, 'branch' => 'Bashundhara Branch', 'revenue' => '৳15.67L', 'pct' => 55],
  ['rank' => 5, 'branch' => 'Mirpur Branch', 'revenue' => '৳14.21L', 'pct' => 49],
];

$cashierRankings = [
  ['rank' => 1, 'name' => 'Raju Mia', 'sales' => '৳8.45L', 'transactions' => 1240, 'branch' => 'Gulshan'],
  ['rank' => 2, 'name' => 'Mitu Akter', 'sales' => '৳6.12L', 'transactions' => 980, 'branch' => 'Mirpur'],
  ['rank' => 3, 'name' => 'Tarek Islam', 'sales' => '৳5.80L', 'transactions' => 840, 'branch' => 'Uttara'],
  ['rank' => 4, 'name' => 'Selim Reza', 'sales' => '৳4.95L', 'transactions' => 720, 'branch' => 'Dhanmondi'],
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
        <h1>📈 Reports & Analytics</h1>
        <div class="breadcrumb">
          🏠 Home <span>/</span> Reports
        </div>
      </div>
      <div style="display:flex;align-items:center;gap:0.75rem">
        <input type="date" class="form-control" value="2025-07-01" style="width:auto" />
        <span style="color:var(--color-text-light)">to</span>
        <input type="date" class="form-control" value="2025-07-20" style="width:auto" />
        <button class="btn btn-primary" onclick="window.print()">🖨 Print Report</button>
      </div>
    </div>

    <!-- KPI Cards -->
    <div class="stats-grid">
      <?php foreach ($kpis as $k): ?>
        <div class="stat-card <?= $k['class'] ?>">
          <div class="stat-icon"><?= $k['icon'] ?></div>
          <div class="stat-info">
            <div class="stat-value"><?= $k['value'] ?></div>
            <div class="stat-label"><?= $k['label'] ?></div>
            <div class="stat-change <?= $k['up'] ? 'positive' : 'negative' ?>">
              <?= $k['up'] ? '▲' : '▼' ?>   <?= $k['change'] ?> vs last period
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Two Column Layout: Charts -->
    <div class="dashboard-grid">

      <!-- Sales Revenue Trend -->
      <div class="chart-card">
        <div class="chart-header">
          <div>
            <div class="chart-title">Daily Sales Revenue (July)</div>
            <div class="chart-subtitle">BDT in thousands (July 1 – July 20)</div>
          </div>
          <span class="badge badge-success">Live Trend</span>
        </div>

        <!-- CSS Bar Chart representing July days -->
        <div
          style="display:flex;align-items:flex-end;justify-content:space-between;height:180px;padding-top:1rem;border-bottom:1px solid var(--color-border)">
          <?php
          $daysData = [45, 52, 38, 62, 70, 85, 40, 58, 66, 72, 80, 55, 60, 68, 75, 84, 91, 62, 78, 85];
          foreach ($daysData as $index => $val):
            $dayNum = $index + 1;
            ?>
            <div
              style="flex:1;display:flex;flex-direction:column;align-items:center;height:100%;justify-content:flex-end;margin:0 2px">
              <div
                style="height:<?= $val ?>%;width:100%;background:linear-gradient(to top, var(--color-primary), #60A5FA);border-radius:3px 3px 0 0;position:relative"
                title="July <?= $dayNum ?>: ৳<?= $val ?>k" class="report-bar">
                <span
                  style="display:none;position:absolute;top:-25px;left:50%;transform:translateX(-50%);background:var(--color-secondary);color:#fff;padding:2px 4px;font-size:0.6rem;border-radius:3px;z-index:1">৳<?= $val ?>k</span>
              </div>
              <span style="font-size:0.55rem;color:var(--color-text-light);margin-top:4px"><?= $dayNum ?></span>
            </div>
          <?php endforeach; ?>
        </div>
        <div
          style="margin-top:1rem;display:flex;justify-content:space-between;font-size:0.75rem;color:var(--color-text-muted)">
          <span>📅 July 1</span>
          <span>Weekly peaks occur on Fridays/Saturdays</span>
          <span>July 20 📅</span>
        </div>
      </div>

      <!-- Category Sales Breakdown -->
      <div class="chart-card">
        <div class="chart-header">
          <div>
            <div class="chart-title">Revenue by Department</div>
            <div class="chart-subtitle">Percentage Share Contribution</div>
          </div>
        </div>

        <!-- Horizontal percentage bar distribution -->
        <div style="display:flex;flex-direction:column;gap:0.95rem">
          <?php
          $cats = [
            ['name' => 'Grocery', 'share' => 32, 'color' => 'var(--color-primary)'],
            ['name' => 'Beverages', 'share' => 21, 'color' => 'var(--color-accent)'],
            ['name' => 'Dairy', 'share' => 18, 'color' => 'var(--color-purple)'],
            ['name' => 'Personal Care', 'share' => 14, 'color' => 'var(--color-warning)'],
            ['name' => 'Household', 'share' => 9, 'color' => 'var(--color-danger)'],
            ['name' => 'Snacks & Other', 'share' => 6, 'color' => 'var(--color-text-muted)'],
          ];
          foreach ($cats as $c):
            ?>
            <div>
              <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:4px">
                <strong><?= $c['name'] ?></strong>
                <span style="color:var(--color-text-muted)"><?= $c['share'] ?>% share</span>
              </div>
              <div style="height:8px;background:var(--color-border-light);border-radius:4px;overflow:hidden">
                <div style="width:<?= $c['share'] ?>%;height:100%;background:<?= $c['color'] ?>;border-radius:4px"></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- Rank columns -->
    <div class="dashboard-grid">
      <!-- Branch Rankings -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">🏪 Branch Rankings (Monthly Revenue)</h3>
        </div>
        <div class="table-wrapper">
          <table class="data-table">
            <thead>
              <tr>
                <th>Rank</th>
                <th>Branch</th>
                <th>Monthly revenue</th>
                <th>Performance</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($branchRankings as $b): ?>
                <tr>
                  <td>
                    <span class="rank-cell <?= $b['rank'] <= 3 ? ['top1', 'top2', 'top3'][$b['rank'] - 1] : '' ?>">
                      <?= $b['rank'] ?>
                    </span>
                  </td>
                  <td><strong><?= $b['branch'] ?></strong></td>
                  <td style="color:var(--color-accent);font-weight:700"><?= $b['revenue'] ?></td>
                  <td>
                    <div class="sold-bar" style="min-width:80px">
                      <div class="bar-bg">
                        <div class="bar-fill" style="width:<?= $b['pct'] ?>%;background:var(--color-primary)"></div>
                      </div>
                      <span class="text-xs text-muted"><?= $b['pct'] ?>%</span>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Cashier Rankings -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">🎖️ Top Performing Cashiers</h3>
        </div>
        <div class="table-wrapper">
          <table class="data-table">
            <thead>
              <tr>
                <th>Rank</th>
                <th>Cashier Name</th>
                <th>Sales amount</th>
                <th>Bills</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($cashierRankings as $c): ?>
                <tr>
                  <td>
                    <span class="rank-cell <?= $c['rank'] <= 3 ? ['top1', 'top2', 'top3'][$c['rank'] - 1] : '' ?>">
                      <?= $c['rank'] ?>
                    </span>
                  </td>
                  <td>
                    <strong><?= $c['name'] ?></strong>
                    <div style="font-size:0.65rem;color:var(--color-text-light)"><?= $c['branch'] ?> Branch</div>
                  </td>
                  <td style="color:var(--color-accent);font-weight:700"><?= $c['sales'] ?></td>
                  <td><strong><?= number_format($c['transactions']) ?></strong> bills</td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Detailed Sales Table -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">📖 Sales Transaction Log</h3>
        <div style="display:flex;gap:0.5rem">
          <input type="text" class="form-control" placeholder="Search invoices…" style="width:200px" id="logSearch"
            onkeyup="searchLog()" />
          <button class="btn btn-outline btn-sm">📥 Export CSV</button>
        </div>
      </div>
      <div class="table-wrapper">
        <table class="data-table" id="transactionTable">
          <thead>
            <tr>
              <th>Invoice ID</th>
              <th>Date & Time</th>
              <th>Branch</th>
              <th>Customer</th>
              <th>Payment Method</th>
              <th>Items</th>
              <th>Discount</th>
              <th>VAT</th>
              <th>Total Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($salesTransactions as $t): ?>
              <tr>
                <td><code style="font-weight:700"><?= $t['inv'] ?></code></td>
                <td><?= $t['date'] ?></td>
                <td><strong>🏪 <?= $t['branch'] ?></strong></td>
                <td><?= $t['cust'] ?></td>
                <td><span class="badge badge-gray"><?= $t['pay'] ?></span></td>
                <td><?= $t['items'] ?> items</td>
                <td style="color:var(--color-danger)"><?= $t['disc'] ?></td>
                <td style="color:var(--color-text-muted)"><?= $t['vat'] ?></td>
                <td style="color:var(--color-accent);font-weight:700"><?= $t['total'] ?></td>
                <td><button class="btn btn-outline btn-sm"
                    onclick="alert('Viewing Invoice details for <?= $t['inv'] ?>\n\nDB: SELECT * FROM ORDERS JOIN ORDER_ITEMS USING(order_id) WHERE invoice_no = :inv')">👁
                    View</button></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="alert alert-info" style="margin-top:1.5rem">
        <h4>📑 Oracle Database Query & Reports Plan:</h4>
        <p style="font-size:0.8rem;line-height:1.4;margin-top:0.25rem">
          • <strong>Reports SQL Query:</strong>
          <code>SELECT TRUNC(order_date) as sales_date, SUM(total_amount) as daily_revenue FROM ORDERS GROUP BY TRUNC(order_date) ORDER BY sales_date DESC</code>.<br>
          • <strong>Oracle PL/SQL Procedures:</strong> The print action calls
          <code>REPORTS_PKG.GENERATE_MONTHLY_SUMMARY(:branch_id, :start_date, :end_date)</code> to compute cashier
          rankings, branch comparisons, and categories percentage distributions.
        </p>
      </div>
    </div>

  </div><!-- /page-content -->
  <?php include 'includes/footer.php'; ?>

  <style>
    .report-bar:hover span {
      display: block !important;
    }

    .report-bar {
      cursor: pointer;
      transition: all var(--transition-fast);
    }

    .report-bar:hover {
      filter: brightness(1.15);
    }
  </style>

  <script>
    function searchLog() {
      const query = document.getElementById('logSearch').value.toLowerCase();
      const rows = document.querySelectorAll('#transactionTable tbody tr');
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(query)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }
  </script>