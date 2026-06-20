<?php
/**
 * SwiftMart – includes/footer.php
 * Closing tags, script includes, toast container.
 * Usage: include 'includes/footer.php'; (at bottom of each page)
 *
 * $extraScripts[] can be set before including to add page-specific JS.
 */
$extraScripts = $extraScripts ?? [];
$currentYear  = date('Y');
?>

  </div><!-- /page-content -->
</div><!-- /main-content -->

<!-- ═══════════════════════════════════════════════════════════
     GLOBAL SCRIPTS
═══════════════════════════════════════════════════════════ -->
<script src="js/app.js"></script>

<?php if (isset($includeDashboardJs) && $includeDashboardJs): ?>
  <script src="js/dashboard.js"></script>
<?php endif; ?>

<?php if (isset($includePosJs) && $includePosJs): ?>
  <script src="js/pos.js"></script>
<?php endif; ?>

<!-- Page-specific extra scripts -->
<?php foreach ($extraScripts as $src): ?>
  <script src="<?= htmlspecialchars($src) ?>"></script>
<?php endforeach; ?>

<!-- ── Footer Bar ─────────────────────────────────────────── -->
<div style="
  padding: 0.85rem 2rem;
  background: var(--color-surface);
  border-top: 1px solid var(--color-border-light);
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: 0.75rem;
  color: var(--color-text-muted);
">
  <span>© <?= $currentYear ?> <strong style="color:var(--color-primary)">SwiftMart ERP</strong> – Smart Supermarket & Retail Chain Management System</span>
  <span style="display:flex;align-items:center;gap:1rem">
    <span>🗃️ Oracle DB Ready</span>
    <span>|</span>
    <span>v2.0.0</span>
    <span>|</span>
    <span>University Database Project</span>
  </span>
</div>

</body>
</html>
