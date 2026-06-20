<?php
/**
 * SwiftMart – promotions.php
 * Offers & Promotions: banners, flash sale cards,
 * bundle offers, JS countdown timer.
 * DB: SELECT * FROM PROMOTIONS WHERE is_active=1 AND end_date > SYSDATE
 */
$pageTitle = 'Offers & Promotions';
$activeNav = 'promotions';

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<div class="main-content" id="mainContent">
<?php include 'includes/navbar.php'; ?>
<div class="page-content">

  <div class="page-header">
    <div class="page-header-left">
      <h1>🎯 Offers & Promotions</h1>
      <div class="breadcrumb">🏠 Home <span>/</span> Promotions</div>
    </div>
    <button class="btn btn-primary" data-modal-open="addPromoModal">➕ Create Promotion</button>
  </div>

  <!-- ── Promo Banners ─────────────────────────────────── -->
  <!-- DB: SELECT * FROM PROMOTIONS WHERE type='BANNER' AND is_active=1 -->
  <div class="grid-2 mb-3">
    <!-- Ramadan Sale Banner -->
    <div class="promo-banner" style="background:linear-gradient(135deg,#2563EB,#7C3AED)">
      <span class="badge badge-warning" style="margin-bottom:0.75rem">🔥 Active Campaign</span>
      <h2>Ramadan Special Sale</h2>
      <p style="margin-bottom:1.25rem">Up to 30% OFF on all grocery items<br>Valid: 25 Jun – 5 Jul 2025</p>
      <!-- Countdown -->
      <div class="countdown-grid" id="countdown1">
        <div class="countdown-block"><div class="num" id="c1d">00</div><div class="lbl">Days</div></div>
        <div class="countdown-block"><div class="num" id="c1h">00</div><div class="lbl">Hours</div></div>
        <div class="countdown-block"><div class="num" id="c1m">00</div><div class="lbl">Mins</div></div>
        <div class="countdown-block"><div class="num" id="c1s">00</div><div class="lbl">Secs</div></div>
      </div>
      <span class="big-emoji">🌙</span>
    </div>

    <!-- Summer Flash Sale -->
    <div class="promo-banner" style="background:linear-gradient(135deg,#10B981,#0EA5E9)">
      <span class="badge badge-warning" style="margin-bottom:0.75rem">⚡ Flash Sale</span>
      <h2>Summer Beverage Blast</h2>
      <p style="margin-bottom:1.25rem">Buy 2 Get 1 FREE on all beverages<br>Valid: 20 Jun – 20 Jul 2025</p>
      <div class="countdown-grid" id="countdown2">
        <div class="countdown-block"><div class="num" id="c2d">00</div><div class="lbl">Days</div></div>
        <div class="countdown-block"><div class="num" id="c2h">00</div><div class="lbl">Hours</div></div>
        <div class="countdown-block"><div class="num" id="c2m">00</div><div class="lbl">Mins</div></div>
        <div class="countdown-block"><div class="num" id="c2s">00</div><div class="lbl">Secs</div></div>
      </div>
      <span class="big-emoji">☀️</span>
    </div>
  </div>

  <!-- ── Flash Sale Products ────────────────────────── -->
  <h3 style="margin-bottom:1rem;font-weight:700">⚡ Flash Sale – Today Only</h3>
  <!-- DB: SELECT p.product_name, p.sale_price, pr.discount_pct
           FROM PROMOTIONS pr JOIN PROMO_PRODUCTS pp ON pr.promo_id=pp.promo_id
           JOIN PRODUCTS p ON pp.product_id=p.product_id
           WHERE pr.type='FLASH' AND TRUNC(pr.end_date)=TRUNC(SYSDATE) -->
  <div class="grid-4 mb-3">
    <?php
    $flashSales = [
      ['emoji'=>'☕','name'=>'Nescafé Gold 200g',  'orig'=>850, 'disc'=>20,'color'=>'linear-gradient(135deg,#FEF3C7,#FFFBEB)'],
      ['emoji'=>'🧴','name'=>'Dove Shampoo 200ml', 'orig'=>380, 'disc'=>15,'color'=>'linear-gradient(135deg,#EFF6FF,#F5F3FF)'],
      ['emoji'=>'🥚','name'=>'Egg (12 pcs)',        'orig'=>165, 'disc'=>10,'color'=>'linear-gradient(135deg,#ECFDF5,#EFF6FF)'],
      ['emoji'=>'🍪','name'=>'Oreo Cookies 120g',  'orig'=>95,  'disc'=>25,'color'=>'linear-gradient(135deg,#FEF2F2,#FFFBEB)'],
    ];
    foreach ($flashSales as $f):
      $salePrice = round($f['orig'] * (1 - $f['disc']/100));
    ?>
    <div class="flash-card">
      <div class="flash-card-img" style="background:<?= $f['color'] ?>">
        <span style="font-size:3.5rem"><?= $f['emoji'] ?></span>
      </div>
      <div style="position:absolute;top:0.75rem;right:0.75rem">
        <span class="badge badge-danger">-<?= $f['disc'] ?>%</span>
      </div>
      <div class="flash-card-body">
        <p style="font-size:0.8rem;font-weight:600;color:var(--color-secondary);margin-bottom:0.4rem"><?= $f['name'] ?></p>
        <div class="original-price">৳<?= $f['orig'] ?></div>
        <div class="sale-price">৳<?= $salePrice ?></div>
        <button class="btn btn-danger btn-sm w-full mt-2">🛒 Add to Cart</button>
      </div>
    </div>
    <style>.flash-card{position:relative}</style>
    <?php endforeach; ?>
  </div>

  <!-- ── Bundle Offers ──────────────────────────────── -->
  <h3 style="margin-bottom:1rem;font-weight:700">🎁 Bundle Offers</h3>
  <!-- DB: SELECT * FROM PROMOTIONS WHERE type='BUNDLE' AND is_active=1 -->
  <div class="grid-3 mb-3">
    <?php
    $bundles = [
      ['title'=>'Breakfast Bundle','emoji'=>'🥐','items'=>['Fresh Milk 1L', 'Whole Wheat Bread', 'Egg (12 pcs)', 'Nescafé Gold 50g'],'orig'=>640,'sale'=>499,'color'=>'#2563EB'],
      ['title'=>'Kitchen Essentials','emoji'=>'🫙','items'=>['Sunflower Oil 1L', 'Sugar 1kg', 'Salt 1kg', 'Flour 1kg'],'orig'=>580,'sale'=>440,'color'=>'#10B981'],
      ['title'=>'Hygiene Kit','emoji'=>'🧼','items'=>['Lux Soap 125g ×3', 'Colgate 150g', 'Dove Shampoo 200ml'],'orig'=>500,'sale'=>380,'color'=>'#8B5CF6'],
    ];
    foreach ($bundles as $b): ?>
    <div class="card" style="overflow:hidden">
      <div style="background:<?= $b['color'] ?>;padding:1.25rem;display:flex;align-items:center;gap:1rem">
        <span style="font-size:2.5rem"><?= $b['emoji'] ?></span>
        <div>
          <h3 style="color:#fff;margin:0"><?= $b['title'] ?></h3>
          <span class="badge badge-warning" style="margin-top:0.3rem">Save ৳<?= $b['orig']-$b['sale'] ?></span>
        </div>
      </div>
      <div style="padding:1rem">
        <ul style="list-style:none;margin-bottom:1rem">
          <?php foreach ($b['items'] as $item): ?>
          <li style="font-size:0.8rem;color:var(--color-text-muted);padding:0.25rem 0;border-bottom:1px solid var(--color-border-light)">
            ✓ <?= $item ?>
          </li>
          <?php endforeach; ?>
        </ul>
        <div style="display:flex;align-items:center;justify-content:space-between">
          <div>
            <div style="font-size:0.75rem;color:var(--color-text-muted);text-decoration:line-through">৳<?= $b['orig'] ?></div>
            <div style="font-size:1.25rem;font-weight:800;color:var(--color-danger)">৳<?= $b['sale'] ?></div>
          </div>
          <button class="btn btn-primary btn-sm">🛒 Buy Bundle</button>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- ── Active Promotions Table ────────────────────── -->
  <div class="card" style="padding:0">
    <div class="card-header" style="padding:1rem 1.25rem;border-bottom:1px solid var(--color-border-light)">
      <h3 class="card-title">📋 All Promotions</h3>
      <button class="btn btn-primary btn-sm" data-modal-open="addPromoModal">➕ Add</button>
    </div>
    <!-- DB: SELECT promo_id, promo_name, type, discount_pct, start_date, end_date, is_active
             FROM PROMOTIONS ORDER BY start_date DESC -->
    <div class="table-wrapper" style="border:none;border-radius:0">
      <table class="data-table">
        <thead>
          <tr><th>Promo ID</th><th>Name</th><th>Type</th><th>Discount</th><th>Start Date</th><th>End Date</th><th>Usage</th><th>Status</th><th>Actions</th></tr>
        </thead>
        <tbody>
          <?php
          $promos = [
            ['id'=>'PR001','name'=>'Ramadan Special',    'type'=>'Seasonal','disc'=>'Up to 30%','start'=>'2025-06-25','end'=>'2025-07-05','usage'=>'1,248','status'=>'Active'],
            ['id'=>'PR002','name'=>'Summer Bev Blast',   'type'=>'Flash',   'disc'=>'Buy 2 Get 1','start'=>'2025-06-20','end'=>'2025-07-20','usage'=>'847','status'=>'Active'],
            ['id'=>'PR003','name'=>'Breakfast Bundle',   'type'=>'Bundle',  'disc'=>'৳141 off','start'=>'2025-07-01','end'=>'2025-07-31','usage'=>'324','status'=>'Active'],
            ['id'=>'PR004','name'=>'Kitchen Essentials', 'type'=>'Bundle',  'disc'=>'৳140 off','start'=>'2025-07-01','end'=>'2025-07-31','usage'=>'210','status'=>'Active'],
            ['id'=>'PR005','name'=>'Eid Mega Sale',      'type'=>'Seasonal','disc'=>'25%','start'=>'2025-06-06','end'=>'2025-06-10','usage'=>'3,820','status'=>'Expired'],
          ];
          foreach ($promos as $p):
          ?>
          <tr>
            <td><code style="color:var(--color-primary)"><?= $p['id'] ?></code></td>
            <td><strong><?= $p['name'] ?></strong></td>
            <td><span class="badge badge-info"><?= $p['type'] ?></span></td>
            <td style="font-weight:700;color:var(--color-danger)"><?= $p['disc'] ?></td>
            <td><?= date('d M Y', strtotime($p['start'])) ?></td>
            <td><?= date('d M Y', strtotime($p['end'])) ?></td>
            <td><?= $p['usage'] ?> uses</td>
            <td><span class="badge <?= $p['status']==='Active'?'badge-success':'badge-gray' ?>"><?= $p['status'] ?></span></td>
            <td>
              <div class="actions">
                <button class="btn btn-outline btn-sm">✏️</button>
                <button class="btn btn-danger btn-sm" onclick="SwiftMart.toasts.show('Promotion deleted','danger')">🗑</button>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Add Promotion Modal -->
<div class="modal-overlay" id="addPromoModal">
  <div class="modal" style="max-width:580px">
    <div class="modal-header">
      <h2 class="modal-title">🎯 Create Promotion</h2>
      <button class="modal-close" data-modal-close="addPromoModal">✕</button>
    </div>
    <div class="modal-body">
      <!-- DB: INSERT INTO PROMOTIONS (promo_name, type, discount_pct, start_date, end_date, is_active) VALUES (...) -->
      <div class="form-group"><label class="form-label">Promotion Name *</label><input type="text" class="form-control" required/></div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Type</label>
          <select class="form-control"><option>Flash</option><option>Seasonal</option><option>Bundle</option><option>Clearance</option></select>
        </div>
        <div class="form-group"><label class="form-label">Discount %</label><input type="number" class="form-control" min="0" max="100"/></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label class="form-label">Start Date</label><input type="date" class="form-control"/></div>
        <div class="form-group"><label class="form-label">End Date</label><input type="date" class="form-control"/></div>
      </div>
      <div class="form-group"><label class="form-label">Applicable Products / Categories</label><input type="text" class="form-control" placeholder="e.g. All Beverages, or specific SKUs"/></div>
      <div class="alert alert-info">ℹ️ Oracle DB: INSERT INTO PROMOTIONS. PL/SQL trigger auto-calculates discounted prices.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" data-modal-close="addPromoModal">Cancel</button>
      <button class="btn btn-primary" onclick="SwiftMart.toasts.show('Promotion created!','success');SwiftMart.modals.close('addPromoModal')">🎯 Create</button>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>

<script>
/* ── Countdown Timer ──────────────────────────────────────────
 * DB: end_date fetched from PROMOTIONS table
 */
function startCountdown(endDateStr, dEl, hEl, mEl, sEl) {
  const end = new Date(endDateStr).getTime();
  const tick = () => {
    const diff = end - Date.now();
    if (diff <= 0) {
      [dEl,hEl,mEl,sEl].forEach(el => { if(el) el.textContent='00'; });
      return;
    }
    const d = Math.floor(diff / 86400000);
    const h = Math.floor((diff % 86400000) / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    const s = Math.floor((diff % 60000) / 1000);
    const pad = n => String(n).padStart(2,'0');
    if(dEl) dEl.textContent = pad(d);
    if(hEl) hEl.textContent = pad(h);
    if(mEl) mEl.textContent = pad(m);
    if(sEl) sEl.textContent = pad(s);
  };
  tick();
  setInterval(tick, 1000);
}

document.addEventListener('DOMContentLoaded', () => {
  startCountdown('2025-07-05T23:59:59',
    document.getElementById('c1d'), document.getElementById('c1h'),
    document.getElementById('c1m'), document.getElementById('c1s'));

  startCountdown('2025-07-20T23:59:59',
    document.getElementById('c2d'), document.getElementById('c2h'),
    document.getElementById('c2m'), document.getElementById('c2s'));
});
</script>
