<?php
/**
 * SwiftMart – settings.php
 * Settings page: handles Company settings, UI Theme, Notification thresholds,
 * and Oracle DB synchronization preferences.
 *
 * DB Integration Points:
 * DB: SELECT config_key, config_value FROM STORE_CONFIG
 */
$pageTitle = 'Settings & Configurations';
$activeNav = 'settings';

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="main-content" id="mainContent">
<?php include 'includes/navbar.php'; ?>
<div class="page-content">

  <!-- Page Header -->
  <div class="page-header">
    <div class="page-header-left">
      <h1>⚙️ Settings & Configurations</h1>
      <div class="breadcrumb">
        🏠 Home <span>/</span> Settings
      </div>
    </div>
    <button class="btn btn-outline btn-sm" onclick="testDBConnection()">🔌 Test DB Connection</button>
  </div>

  <!-- Settings Grid Layout -->
  <div class="dashboard-grid">
    
    <!-- Left Column: Company & Receipt Settings -->
    <div style="display:flex;flex-direction:column;gap:1.25rem">
      
      <!-- Company Information -->
      <div class="card">
        <div class="card-header" style="border-bottom:1px solid var(--color-border-light);padding-bottom:0.5rem;margin-bottom:1.25rem">
          <h3 class="card-title">🏢 Company Information</h3>
        </div>
        <form onsubmit="event.preventDefault(); SwiftMart.toasts.show('Company settings saved!', 'success')">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Store / Company Name *</label>
              <input type="text" class="form-control" value="SwiftMart Supermarket Ltd." required/>
            </div>
            <div class="form-group">
              <label class="form-label">VAT Reg Number (BIN) *</label>
              <input type="text" class="form-control" value="001245980-0102" required/>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Primary Currency</label>
              <select class="form-control">
                <option selected>BDT (৳) - Bangladeshi Taka</option>
                <option>USD ($) - US Dollar</option>
                <option>EUR (€) - Euro</option>
              </select>
            </div>
            <div class="form-group">
              <label class="form-label">Tax / VAT Rate *</label>
              <input type="number" class="form-control" value="5" min="0" max="100" step="0.5" required/>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Contact Hotline *</label>
              <input type="text" class="form-control" value="+880 2-9843210" required/>
            </div>
            <div class="form-group">
              <label class="form-label">Head Office Address *</label>
              <input type="text" class="form-control" value="House 12, Road 5, Gulshan-1, Dhaka" required/>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Receipt Welcome Slogan</label>
            <input type="text" class="form-control" value="Thank you for shopping at SwiftMart! Come again."/>
          </div>
          <div class="alert alert-info" style="font-size:0.75rem;line-height:1.4">
            ℹ️ <strong>Oracle DB:</strong> Performs <code>UPDATE STORE_CONFIG SET config_value = :val WHERE config_key = :key</code>.
          </div>
          <div style="text-align:right">
            <button class="btn btn-primary" type="submit">💾 Save Company Info</button>
          </div>
        </form>
      </div>

      <!-- Receipt Print Configurations -->
      <div class="card">
        <div class="card-header" style="border-bottom:1px solid var(--color-border-light);padding-bottom:0.5rem;margin-bottom:1.25rem">
          <h3 class="card-title">🧾 Receipt Configurations</h3>
        </div>
        <form onsubmit="event.preventDefault(); SwiftMart.toasts.show('Receipt configurations updated!', 'success')">
          <div class="form-group">
            <label class="form-check" style="margin-bottom:0.75rem">
              <input type="checkbox" checked/>
              <span>Print Logo on POS Receipt</span>
            </label>
            <label class="form-check" style="margin-bottom:0.75rem">
              <input type="checkbox" checked/>
              <span>Print Customer Loyalty Tier and Points balance</span>
            </label>
            <label class="form-check" style="margin-bottom:0.75rem">
              <input type="checkbox"/>
              <span>Display cashier full name (instead of employee ID)</span>
            </label>
            <label class="form-check">
              <input type="checkbox" checked/>
              <span>Generate PDF Invoice automatically after cart checkout</span>
            </label>
          </div>
          <div style="text-align:right">
            <button class="btn btn-primary" type="submit">💾 Update Layout</button>
          </div>
        </form>
      </div>

    </div>

    <!-- Right Column: UI & Theme & Notifications Preferences -->
    <div style="display:flex;flex-direction:column;gap:1.25rem">
      
      <!-- Theme & Layout Preferences -->
      <div class="card">
        <div class="card-header" style="border-bottom:1px solid var(--color-border-light);padding-bottom:0.5rem;margin-bottom:1.25rem">
          <h3 class="card-title">🎨 Theme & Interface Settings</h3>
        </div>
        <form id="themeForm" onsubmit="event.preventDefault(); SwiftMart.toasts.show('Interface preferences saved!', 'success')">
          <div class="form-group">
            <label class="form-label">Color Scheme Theme</label>
            <select class="form-control" id="uiThemeSelector" onchange="changeThemeMock()">
              <option value="classic">Vibrant Classic Blue (Default)</option>
              <option value="navy">Enterprise Dark Navy</option>
              <option value="emerald">Sleek Green Emerald</option>
              <option value="purple">Premium Royal Purple</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Default Navigation Sidebar State</label>
            <select class="form-control">
              <option>Fully Expanded Sidebar (Default)</option>
              <option>Collapsed Icons Mode</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-check" style="margin-bottom:0.75rem">
              <input type="checkbox" checked/>
              <span>Enable layout micro-animations & transitions</span>
            </label>
            <label class="form-check">
              <input type="checkbox" checked/>
              <span>Enable POS sounds (beeps on barcode additions)</span>
            </label>
          </div>
          <div style="text-align:right">
            <button class="btn btn-primary" type="submit">💾 Save Preferences</button>
          </div>
        </form>
      </div>

      <!-- Notification Toggles -->
      <div class="card">
        <div class="card-header" style="border-bottom:1px solid var(--color-border-light);padding-bottom:0.5rem;margin-bottom:1.25rem">
          <h3 class="card-title">🔔 Notification & Alerts Configurations</h3>
        </div>
        <form onsubmit="event.preventDefault(); SwiftMart.toasts.show('Alert thresholds updated!', 'success')">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Low Stock Warning Threshold</label>
              <input type="number" class="form-control" value="50"/>
              <span class="form-hint">Alert triggers when qty falls below this.</span>
            </div>
            <div class="form-group">
              <label class="form-label">Expiry Warning Window</label>
              <input type="number" class="form-control" value="30"/>
              <span class="form-hint">Alert triggers (n) days before expiry.</span>
            </div>
          </div>
          
          <hr style="border:0;border-top:1px solid var(--color-border-light);margin:1rem 0">
          
          <div class="form-group">
            <label class="form-check" style="margin-bottom:0.75rem">
              <input type="checkbox" checked/>
              <span>Email notification for low stock events to Branch Manager</span>
            </label>
            <label class="form-check" style="margin-bottom:0.75rem">
              <input type="checkbox" checked/>
              <span>Send SMS alert to Suppliers for delayed purchase orders</span>
            </label>
            <label class="form-check">
              <input type="checkbox" checked/>
              <span>Push browser alerts for system log security warnings</span>
            </label>
          </div>
          <div style="text-align:right">
            <button class="btn btn-primary" type="submit">💾 Save Thresholds</button>
          </div>
        </form>
      </div>

      <!-- Oracle DB Sync settings -->
      <div class="card">
        <div class="card-header" style="border-bottom:1px solid var(--color-border-light);padding-bottom:0.5rem;margin-bottom:1.25rem">
          <h3 class="card-title">🔌 Oracle DB Connectivity Sync</h3>
        </div>
        <div style="font-size:0.825rem;color:var(--color-text-muted);line-height:1.5">
          <p style="margin-bottom:0.75rem">Current Status: <span class="badge badge-gray" id="dbStatusBadge">Offline (Static Demo)</span></p>
          <div class="form-group">
            <label class="form-label">Oracle TNS Service Name / Connection String</label>
            <input type="text" class="form-control" value="localhost:1521/XEPDB1" readonly style="background:#F1F5F9;cursor:not-allowed"/>
          </div>
          <div class="form-group">
            <label class="form-label">Data Sync Frequency</label>
            <select class="form-control" style="background:#F1F5F9;cursor:not-allowed" disabled>
              <option>Real-Time Sync (OCI8 Persistent)</option>
              <option selected>Hourly Batch updates</option>
              <option>Daily Cron updates</option>
            </select>
          </div>
        </div>
      </div>
      
    </div>

  </div>

</div><!-- /page-content -->
<?php include 'includes/footer.php'; ?>

<script>
function testDBConnection() {
  const badge = document.getElementById('dbStatusBadge');
  badge.className = 'badge badge-warning';
  badge.textContent = '🔌 Pinging Oracle TNS...';
  
  SwiftMart.toasts.show('Pinging Oracle 19c service...', 'info');
  
  setTimeout(() => {
    badge.className = 'badge badge-success';
    badge.textContent = '● Oracle DB Ready (Mocked)';
    SwiftMart.toasts.show('TNS listener connection successful! Oracle 19c is online.', 'success');
  }, 1200);
}

function changeThemeMock() {
  const select = document.getElementById('uiThemeSelector');
  const theme = select.value;
  let primaryColor = '#2563EB';
  let primaryDark = '#1D4ED8';
  let bannerBg = 'linear-gradient(135deg, #2563EB, #1D4ED8)';
  
  if (theme === 'navy') {
    primaryColor = '#1E293B';
    primaryDark = '#0F172A';
  } else if (theme === 'emerald') {
    primaryColor = '#10B981';
    primaryDark = '#059669';
  } else if (theme === 'purple') {
    primaryColor = '#8B5CF6';
    primaryDark = '#7C3AED';
  }
  
  document.documentElement.style.setProperty('--color-primary', primaryColor);
  document.documentElement.style.setProperty('--color-primary-dark', primaryDark);
  SwiftMart.toasts.show(`Theme updated to "${theme}".`, 'success');
}
</script>
