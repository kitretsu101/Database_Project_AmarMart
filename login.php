<?php
/**
 * SwiftMart – login.php
 * Login page with branding, form, demo credentials.
 * DB: Authenticate via Oracle EMPLOYEES table.
 * DB: SELECT emp_id, full_name, password_hash, role, branch_id
 *         FROM EMPLOYEES WHERE email = :email AND is_active = 1
 */

session_start();

// Redirect if already logged in
/* DB: if (isset($_SESSION['user_id'])) header('Location: dashboard.php'); */

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  /* ── DB Auth Placeholder ──────────────────────────────────
   * $conn = oci_connect('swiftmart_user','password','//localhost/XEPDB1');
   * $sql  = "SELECT emp_id, full_name, password_hash, role
   *           FROM EMPLOYEES WHERE email = :email AND is_active = 1";
   * $stmt = oci_parse($conn, $sql);
   * oci_bind_by_name($stmt, ':email', $email);
   * oci_execute($stmt);
   * $row = oci_fetch_assoc($stmt);
   * if ($row && password_verify($password, $row['PASSWORD_HASH'])) {
   *   $_SESSION['user_id']   = $row['EMP_ID'];
   *   $_SESSION['user_name'] = $row['FULL_NAME'];
   *   $_SESSION['role']      = $row['ROLE'];
   *   header('Location: dashboard.php'); exit;
   * }
   * ──────────────────────────────────────────────────────── */

  // Demo credentials check (remove after Oracle integration)
  if ($email === 'admin@swiftmart.com' && $password === 'admin123') {
    header('Location: dashboard.php');
    exit;
  } else {
    $error = 'Invalid email or password. Try the demo credentials below.';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Login to SwiftMart ERP – Smart Supermarket Management System" />
  <title>Login | SwiftMart ERP</title>
  <link rel="icon"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🛒</text></svg>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/dashboard.css" />
  <link rel="stylesheet" href="css/responsive.css" />
</head>

<body style="margin:0;padding:0;background:var(--color-bg)">

  <div class="login-page">

    <!-- ── Left Panel (Branding) ────────────────────────────── -->
    <div class="login-left">
      <div class="login-brand">
        <div style="font-size:4rem;margin-bottom:0.75rem">🛒</div>
        <h2>SwiftMart</h2>
        <p>Smart Supermarket & Retail Chain<br>Management System</p>
      </div>

      <div class="login-feature-cards">
        <div class="login-feature-card">
          <span class="icon">📊</span>
          <div>
            <h5>Real-time Analytics</h5>
            <p>Live sales, revenue & inventory insights across all branches</p>
          </div>
        </div>
        <div class="login-feature-card">
          <span class="icon">🧾</span>
          <div>
            <h5>Smart POS Billing</h5>
            <p>Fast checkout with VAT, discounts & printable invoices</p>
          </div>
        </div>
        <div class="login-feature-card">
          <span class="icon">🏪</span>
          <div>
            <h5>Multi-Branch Control</h5>
            <p>Manage 5+ branches from a single dashboard</p>
          </div>
        </div>
        <div class="login-feature-card">
          <span class="icon">🎯</span>
          <div>
            <h5>Loyalty & Promotions</h5>
            <p>Bronze–Platinum tiers, flash sales & bundle offers</p>
          </div>
        </div>
      </div>
    </div>

    <!-- ── Right Panel (Form) ───────────────────────────────── -->
    <div class="login-right">
      <div class="login-box">

        <!-- Logo -->
        <div class="login-logo">
          <div class="login-logo-icon">🛒</div>
          <div>
            <h1>SwiftMart</h1>
            <span>ERP Management Portal</span>
          </div>
        </div>

        <h2 class="login-title">Welcome Back 👋</h2>
        <p class="login-subtitle">Sign in to your account to continue managing SwiftMart</p>

        <!-- Error Alert -->
        <?php if ($error): ?>
          <div class="alert alert-danger" style="margin-bottom:1rem">
            ❌
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="login.php" id="loginForm" novalidate>

          <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="admin@swiftmart.com"
              value="<?= htmlspecialchars($_POST['email'] ?? 'admin@swiftmart.com') ?>" required autocomplete="email" />
          </div>

          <div class="form-group">
            <label class="form-label" for="password">
              Password
              <a href="#" style="float:right;font-size:0.75rem;color:var(--color-primary);font-weight:500">
                Forgot password?
              </a>
            </label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password"
                placeholder="Enter your password" required autocomplete="current-password" />
              <button type="button" class="input-eye" id="togglePassword" title="Show password">👁</button>
            </div>
          </div>

          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
            <label class="form-check">
              <input type="checkbox" name="remember" id="rememberMe" checked />
              <span style="font-size:0.875rem;color:var(--color-text-muted)">Remember me</span>
            </label>
          </div>

          <button type="submit" class="btn btn-primary btn-lg w-full" id="loginBtn">
            🔐 Sign In to SwiftMart
          </button>

        </form>

        <!-- Demo Credentials -->
        <div class="demo-creds">
          <h6>🧪 Demo Credentials</h6>
          <p>Email: <code>admin@swiftmart.com</code></p>
          <p>Password: <code>admin123</code></p>
          <p style="margin-top:0.5rem;font-size:0.7rem">
            📌 Additional roles: cashier@swiftmart.com / manager@swiftmart.com
            <br>All demo passwords: <code>demo123</code>
          </p>
        </div>

        <p style="text-align:center;font-size:0.75rem;color:var(--color-text-light);margin-top:1.5rem">
          Powered by <strong style="color:var(--color-primary)">SwiftMart ERP v2.0</strong> ·
          Oracle DB Ready ·
          <a href="#" style="color:var(--color-primary)">Help</a>
        </p>

      </div>
    </div>
  </div>

  <script>
    // Password visibility toggle
    document.getElementById('togglePassword').addEventListener('click', function () {
      const pwdInput = document.getElementById('password');
      pwdInput.type = pwdInput.type === 'password' ? 'text' : 'password';
      this.textContent = pwdInput.type === 'password' ? '👁' : '🙈';
    });

    // Fill demo credentials on click
    document.querySelector('.demo-creds').addEventListener('click', function (e) {
      if (e.target.tagName === 'CODE') {
        const val = e.target.textContent;
        if (val.includes('@')) document.getElementById('email').value = val;
        else if (val.length <= 10) document.getElementById('password').value = val;
      }
    });

    // Login form submit animation
    document.getElementById('loginForm').addEventListener('submit', function () {
      const btn = document.getElementById('loginBtn');
      btn.innerHTML = '<span class="spinner" style="width:18px;height:18px;border-width:2px;display:inline-block;margin-right:0.5rem"></span> Signing In…';
      btn.disabled = true;
    });

    // Keyboard shortcut: Press Enter to quick-fill demo creds
    document.addEventListener('keydown', e => {
      if (e.key === 'F1') {
        e.preventDefault();
        document.getElementById('email').value = 'admin@swiftmart.com';
        document.getElementById('password').value = 'admin123';
      }
    });
  </script>
</body>

</html>