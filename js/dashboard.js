/**
 * SwiftMart – dashboard.js
 * Dashboard-specific JS: animated charts (CSS-driven),
 * live clock, activity feed ticker, sparklines.
 *
 * ─── Oracle DB Integration Points ────────────────────────────
 * DB: SELECT SUM(total_amount) FROM ORDERS
 *         WHERE TRUNC(order_date) = TRUNC(SYSDATE)
 * ─────────────────────────────────────────────────────────────
 */

'use strict';

document.addEventListener('DOMContentLoaded', () => {
  DashboardModule.init();
});

const DashboardModule = {

  init() {
    this.clock.init();
    this.barChart.init();
    this.donut.init();
    this.activityFeed.init();
    this.sparklines.init();
    this.recentOrders.init();
  },

  /* ── Live Clock ─────────────────────────────────────────── */
  clock: {
    init() {
      const el = document.getElementById('liveClock');
      if (!el) return;
      const update = () => {
        el.textContent = new Date().toLocaleTimeString('en-US', {
          hour: '2-digit', minute: '2-digit', second: '2-digit'
        });
      };
      update();
      setInterval(update, 1000);
    }
  },

  /* ── CSS Bar Chart (Revenue by Month) ──────────────────── */
  barChart: {
    /**
     * DB: SELECT TO_CHAR(order_date,'Mon') AS month,
     *            SUM(total_amount) AS revenue
     *     FROM ORDERS
     *     WHERE order_date >= ADD_MONTHS(SYSDATE,-6)
     *     GROUP BY TO_CHAR(order_date,'Mon'), EXTRACT(MONTH FROM order_date)
     *     ORDER BY EXTRACT(MONTH FROM order_date)
     */
    data: [
      { label: 'Jan', value: 72, color: '#2563EB' },
      { label: 'Feb', value: 58, color: '#2563EB' },
      { label: 'Mar', value: 85, color: '#2563EB' },
      { label: 'Apr', value: 64, color: '#2563EB' },
      { label: 'May', value: 91, color: '#10B981' },
      { label: 'Jun', value: 78, color: '#10B981' },
      { label: 'Jul', value: 95, color: '#10B981' },
    ],

    init() {
      const container = document.getElementById('revenueBarChart');
      if (!container) return;
      container.innerHTML = '';
      const max = Math.max(...this.data.map(d => d.value));

      this.data.forEach((item, i) => {
        const pct    = Math.round((item.value / max) * 100);
        const height = Math.round((item.value / max) * 160);
        const group  = document.createElement('div');
        group.className = 'bar-group';
        group.innerHTML = `
          <div class="bar" style="
            height: ${height}px;
            background: linear-gradient(180deg, ${item.color}cc, ${item.color});
            width: 100%;
            animation-delay: ${i * 80}ms;
            cursor: pointer;
          " title="৳${(item.value * 1000).toLocaleString()} Revenue"
             data-tooltip="${item.label}: ৳${(item.value * 1000).toLocaleString()}">
          </div>
          <span class="bar-label">${item.label}</span>`;
        container.appendChild(group);
      });
    }
  },

  /* ── Donut Chart ────────────────────────────────────────── */
  donut: {
    /**
     * DB: SELECT category_name, SUM(sale_qty) AS qty
     *     FROM ORDER_ITEMS OI
     *     JOIN PRODUCTS P ON OI.product_id = P.product_id
     *     JOIN CATEGORIES C ON P.category_id = C.category_id
     *     GROUP BY category_name
     *     ORDER BY qty DESC
     *     FETCH FIRST 5 ROWS ONLY
     */
    data: [
      { label: 'Beverages',  pct: 32, color: '#2563EB' },
      { label: 'Groceries',  pct: 24, color: '#10B981' },
      { label: 'Dairy',      pct: 18, color: '#F59E0B' },
      { label: 'Bakery',     pct: 14, color: '#EF4444' },
      { label: 'Others',     pct: 12, color: '#8B5CF6' },
    ],

    init() {
      const legend = document.getElementById('donutLegend');
      if (!legend) return;
      legend.innerHTML = this.data.map(d => `
        <div class="legend-item">
          <div class="legend-dot" style="background:${d.color}"></div>
          <span>${d.label} (${d.pct}%)</span>
        </div>`).join('');

      // Build conic-gradient for the donut
      const donut = document.getElementById('donutChartEl');
      if (donut) {
        let stops = [];
        let current = 0;
        this.data.forEach(d => {
          stops.push(`${d.color} ${current}% ${current + d.pct}%`);
          current += d.pct;
        });
        donut.style.background = `conic-gradient(${stops.join(', ')})`;
      }
    }
  },

  /* ── Activity Feed ──────────────────────────────────────── */
  activityFeed: {
    /**
     * DB: SELECT activity_type, description, created_at, user_name
     *     FROM ACTIVITY_LOG
     *     ORDER BY created_at DESC
     *     FETCH FIRST 10 ROWS ONLY
     */
    items: [
      { icon: '🛒', bg: '#EFF6FF', color: '#2563EB', msg: '<strong>New order #INV-2047</strong> placed by Riya Sultana – ৳4,850', time: '2 min ago' },
      { icon: '📦', bg: '#ECFDF5', color: '#10B981', msg: '<strong>Stock replenished:</strong> Nescafé Gold 200g (+500 units)', time: '15 min ago' },
      { icon: '⚠️', bg: '#FFFBEB', color: '#F59E0B', msg: '<strong>Low stock alert:</strong> Parachute Coconut Oil 500ml (12 left)', time: '28 min ago' },
      { icon: '👤', bg: '#F5F3FF', color: '#8B5CF6', msg: '<strong>New customer registered:</strong> Arif Hossain – Gold Tier', time: '1 hr ago' },
      { icon: '🏪', bg: '#EFF6FF', color: '#2563EB', msg: '<strong>Branch Dhanmondi</strong> daily target achieved (৳125,000)', time: '2 hr ago' },
      { icon: '🚚', bg: '#ECFDF5', color: '#10B981', msg: '<strong>Delivery confirmed</strong> from Pran-RFL Group – PO #PO-1092', time: '3 hr ago' },
      { icon: '❌', bg: '#FEF2F2', color: '#EF4444', msg: '<strong>Return processed:</strong> Order #INV-2031 – Biscuits (expired)', time: '4 hr ago' },
      { icon: '💰', bg: '#ECFDF5', color: '#10B981', msg: '<strong>Daily revenue:</strong> ৳842,500 across all 5 branches', time: '5 hr ago' },
    ],

    init() {
      const feed = document.getElementById('activityFeed');
      if (!feed) return;
      feed.innerHTML = this.items.map(item => `
        <div class="activity-item fade-in">
          <div class="activity-icon" style="background:${item.bg};color:${item.color}">${item.icon}</div>
          <div class="activity-info">
            <p>${item.msg}</p>
            <span class="activity-time">🕐 ${item.time}</span>
          </div>
        </div>`).join('');
    }
  },

  /* ── Sparklines ─────────────────────────────────────────── */
  sparklines: {
    init() {
      document.querySelectorAll('[data-sparkline]').forEach(el => {
        const values = el.dataset.sparkline.split(',').map(Number);
        const max    = Math.max(...values);
        el.innerHTML = values.map(v =>
          `<div class="spark" style="height:${Math.round((v/max)*100)}%;opacity:${0.4 + (v/max)*0.6}"></div>`
        ).join('');
      });
    }
  },

  /* ── Recent Orders (table data) ─────────────────────────── */
  recentOrders: {
    /**
     * DB: SELECT o.invoice_no, c.full_name, o.total_amount,
     *            o.payment_method, o.status, o.order_date
     *     FROM ORDERS o
     *     JOIN CUSTOMERS c ON o.customer_id = c.customer_id
     *     ORDER BY o.order_date DESC
     *     FETCH FIRST 5 ROWS ONLY
     */
    init() {
      // Data already rendered as HTML; JS adds hover highlight effect
      const rows = document.querySelectorAll('#recentOrdersTable tbody tr');
      rows.forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', () => {
          const inv = row.cells[0]?.textContent;
          if (inv) SwiftMart.toasts.show(`Viewing order ${inv}`, 'info', 2000);
        });
      });
    }
  }
};
