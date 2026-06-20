/**
 * SwiftMart – app.js
 * Global JavaScript: sidebar toggle, dropdowns, active nav,
 * modals, toasts, search, keyboard shortcuts.
 *
 * ─── Oracle DB Integration Points ────────────────────────────
 * All fetch/AJAX calls here will be replaced with PHP API
 * endpoints backed by Oracle DB (cx_Oracle / OCI8).
 * Marker: /* DB: <operation> *\/
 * ─────────────────────────────────────────────────────────────
 */

'use strict';

/* ── DOM Ready ──────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  SwiftMart.init();
});

/* ── SwiftMart Global Namespace ─────────────────────────────── */
const SwiftMart = {

  /* ── Initialise all modules ─────────────────────────────── */
  init() {
    this.sidebar.init();
    this.navbar.init();
    this.modals.init();
    this.dropdowns.init();
    this.tabs.init();
    this.tables.init();
    this.toasts.init();
    this.search.init();
    this.animations.init();
    this.setActiveNav();
    console.log('%cSwiftMart ERP Loaded ✓', 'color:#2563EB;font-weight:800;font-size:14px');
  },

  /* ═══════════════════════════════════════════════════════════
     SIDEBAR MODULE
  ═══════════════════════════════════════════════════════════ */
  sidebar: {
    el: null,
    overlay: null,
    isCollapsed: false,

    init() {
      this.el      = document.getElementById('sidebar');
      this.overlay = document.getElementById('sidebarOverlay');
      if (!this.el) return;

      // Toggle button (hamburger in navbar)
      const toggleBtn = document.getElementById('sidebarToggle');
      if (toggleBtn) toggleBtn.addEventListener('click', () => this.toggle());

      // Close on overlay click (mobile)
      if (this.overlay) {
        this.overlay.addEventListener('click', () => this.closeMobile());
      }

      // Restore collapsed state from localStorage
      this.isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
      if (this.isCollapsed) this.applyCollapsed();

      // Keyboard shortcut: Ctrl + B
      document.addEventListener('keydown', e => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
          e.preventDefault();
          this.toggle();
        }
      });

      // Handle window resize
      window.addEventListener('resize', () => this.handleResize());
    },

    toggle() {
      if (window.innerWidth <= 768) {
        this.toggleMobile();
      } else {
        this.isCollapsed = !this.isCollapsed;
        localStorage.setItem('sidebarCollapsed', this.isCollapsed);
        this.isCollapsed ? this.applyCollapsed() : this.removeCollapsed();
      }
    },

    applyCollapsed() {
      this.el.classList.add('collapsed');
      const mainContent = document.querySelector('.main-content');
      const navbar      = document.querySelector('.navbar');
      if (mainContent) mainContent.classList.add('sidebar-collapsed');
      if (navbar)      navbar.classList.add('sidebar-collapsed');
    },

    removeCollapsed() {
      this.el.classList.remove('collapsed');
      const mainContent = document.querySelector('.main-content');
      const navbar      = document.querySelector('.navbar');
      if (mainContent) mainContent.classList.remove('sidebar-collapsed');
      if (navbar)      navbar.classList.remove('sidebar-collapsed');
    },

    toggleMobile() {
      this.el.classList.toggle('mobile-open');
      if (this.overlay) this.overlay.classList.toggle('active');
    },

    closeMobile() {
      this.el.classList.remove('mobile-open');
      if (this.overlay) this.overlay.classList.remove('active');
    },

    handleResize() {
      if (window.innerWidth > 768) {
        this.el.classList.remove('mobile-open');
        if (this.overlay) this.overlay.classList.remove('active');
      }
    }
  },

  /* ═══════════════════════════════════════════════════════════
     NAVBAR MODULE
  ═══════════════════════════════════════════════════════════ */
  navbar: {
    init() {
      // Profile dropdown
      const profileBtn = document.getElementById('profileBtn');
      const profileMenu = document.getElementById('profileMenu');
      if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', e => {
          e.stopPropagation();
          profileMenu.classList.toggle('active');
          // Close notif panel if open
          const notifPanel = document.getElementById('notifPanel');
          if (notifPanel) notifPanel.classList.remove('active');
        });
      }

      // Notification panel
      const notifBtn  = document.getElementById('notifBtn');
      const notifPanel = document.getElementById('notifPanel');
      if (notifBtn && notifPanel) {
        notifBtn.addEventListener('click', e => {
          e.stopPropagation();
          notifPanel.classList.toggle('active');
          if (profileMenu) profileMenu.classList.remove('active');
        });
      }

      // Close all dropdowns on outside click
      document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu, .notif-panel')
          .forEach(el => el.classList.remove('active'));
      });
    }
  },

  /* ═══════════════════════════════════════════════════════════
     DROPDOWNS MODULE
  ═══════════════════════════════════════════════════════════ */
  dropdowns: {
    init() {
      document.querySelectorAll('[data-dropdown-toggle]').forEach(trigger => {
        trigger.addEventListener('click', e => {
          e.stopPropagation();
          const targetId = trigger.dataset.dropdownToggle;
          const menu = document.getElementById(targetId);
          if (!menu) return;
          const isOpen = menu.classList.contains('active');
          // Close all
          document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('active'));
          if (!isOpen) menu.classList.add('active');
        });
      });
    }
  },

  /* ═══════════════════════════════════════════════════════════
     MODALS MODULE
  ═══════════════════════════════════════════════════════════ */
  modals: {
    init() {
      // Open
      document.querySelectorAll('[data-modal-open]').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = btn.dataset.modalOpen;
          this.open(id);
        });
      });
      // Close buttons
      document.querySelectorAll('[data-modal-close]').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = btn.dataset.modalClose || btn.closest('.modal-overlay')?.id;
          this.close(id);
        });
      });
      // Close on overlay click
      document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
          if (e.target === overlay) this.close(overlay.id);
        });
      });
      // ESC key
      document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
          document.querySelectorAll('.modal-overlay.active').forEach(overlay => {
            this.close(overlay.id);
          });
        }
      });
    },

    open(id) {
      const overlay = document.getElementById(id);
      if (overlay) {
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
      }
    },

    close(id) {
      const overlay = document.getElementById(id);
      if (overlay) {
        overlay.classList.remove('active');
        document.body.style.overflow = '';
      }
    }
  },

  /* ═══════════════════════════════════════════════════════════
     TABS MODULE
  ═══════════════════════════════════════════════════════════ */
  tabs: {
    init() {
      document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const panelId = btn.dataset.tab;
          const group   = btn.closest('[data-tabs]') || btn.closest('.card') || btn.parentElement;
          // Deactivate siblings
          group.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          // Show panel
          const section = btn.closest('.card') || document.body;
          section.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
          const panel = document.getElementById(panelId);
          if (panel) panel.classList.add('active');
        });
      });
    }
  },

  /* ═══════════════════════════════════════════════════════════
     TABLES MODULE (sort, filter by search)
  ═══════════════════════════════════════════════════════════ */
  tables: {
    init() {
      // Table search filter
      document.querySelectorAll('[data-table-search]').forEach(input => {
        const tableId = input.dataset.tableSearch;
        const table   = document.getElementById(tableId);
        if (!table) return;
        input.addEventListener('input', () => {
          const q = input.value.toLowerCase();
          table.querySelectorAll('tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
          });
        });
      });

      // Row count badge
      document.querySelectorAll('.data-table').forEach(table => {
        const badge = document.querySelector(`[data-count="${table.id}"]`);
        if (badge) {
          badge.textContent = table.querySelectorAll('tbody tr').length;
        }
      });
    }
  },

  /* ═══════════════════════════════════════════════════════════
     TOASTS MODULE
  ═══════════════════════════════════════════════════════════ */
  toasts: {
    container: null,

    init() {
      this.container = document.getElementById('toastContainer');
      if (!this.container) {
        this.container = document.createElement('div');
        this.container.id = 'toastContainer';
        this.container.style.cssText = `
          position:fixed; bottom:1.5rem; right:1.5rem;
          display:flex; flex-direction:column; gap:0.65rem;
          z-index:9999; pointer-events:none;`;
        document.body.appendChild(this.container);
      }
    },

    show(message, type = 'success', duration = 3500) {
      const icons = { success: '✅', danger: '❌', warning: '⚠️', info: 'ℹ️' };
      const colors = {
        success: '#10B981', danger: '#EF4444',
        warning: '#F59E0B', info: '#2563EB'
      };
      const toast = document.createElement('div');
      toast.style.cssText = `
        display:flex; align-items:center; gap:0.6rem;
        background:#fff; border-left:4px solid ${colors[type]};
        border-radius:10px; padding:0.85rem 1.25rem;
        box-shadow:0 4px 20px rgba(0,0,0,0.12);
        font-size:0.875rem; font-weight:500; color:#1E293B;
        pointer-events:auto; max-width:320px;
        animation:fadeIn 0.3s ease;
        font-family:'Inter',sans-serif;`;
      toast.innerHTML = `<span style="font-size:1rem">${icons[type]}</span><span>${message}</span>`;
      this.container.appendChild(toast);
      setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(20px)';
        toast.style.transition = '0.3s ease';
        setTimeout(() => toast.remove(), 350);
      }, duration);
    }
  },

  /* ═══════════════════════════════════════════════════════════
     SEARCH MODULE (global navbar search)
  ═══════════════════════════════════════════════════════════ */
  search: {
    init() {
      const globalSearch = document.getElementById('globalSearch');
      if (!globalSearch) return;

      /* DB: SELECT * FROM PRODUCTS WHERE LOWER(product_name) LIKE :q
            UNION SELECT * FROM CUSTOMERS WHERE LOWER(name) LIKE :q */
      globalSearch.addEventListener('keydown', e => {
        if (e.key === 'Enter' && globalSearch.value.trim()) {
          SwiftMart.toasts.show(`Searching for "${globalSearch.value}"…`, 'info', 2000);
        }
      });
    }
  },

  /* ═══════════════════════════════════════════════════════════
     ANIMATIONS MODULE
  ═══════════════════════════════════════════════════════════ */
  animations: {
    init() {
      // Animate stat counters
      document.querySelectorAll('[data-count-to]').forEach(el => {
        const target = parseFloat(el.dataset.countTo);
        const prefix = el.dataset.prefix || '';
        const suffix = el.dataset.suffix || '';
        const isCurrency = el.dataset.currency === 'true';
        this.animateCounter(el, target, prefix, suffix, isCurrency);
      });

      // Fade-in on scroll (Intersection Observer)
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });

      document.querySelectorAll('.stat-card, .card, .branch-card, .product-card, .employee-card')
        .forEach(el => observer.observe(el));
    },

    animateCounter(el, target, prefix, suffix, isCurrency, duration = 1200) {
      const start     = performance.now();
      const startVal  = 0;

      const update = (timestamp) => {
        const elapsed  = timestamp - start;
        const progress = Math.min(elapsed / duration, 1);
        // Ease out cubic
        const ease     = 1 - Math.pow(1 - progress, 3);
        const current  = startVal + (target - startVal) * ease;
        const display  = isCurrency
          ? current.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 })
          : Math.round(current).toLocaleString('en-US');
        el.textContent = prefix + display + suffix;
        if (progress < 1) requestAnimationFrame(update);
      };
      requestAnimationFrame(update);
    }
  },

  /* ═══════════════════════════════════════════════════════════
     ACTIVE NAV HELPER
  ═══════════════════════════════════════════════════════════ */
  setActiveNav() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';
    document.querySelectorAll('.nav-link[href]').forEach(link => {
      const href = link.getAttribute('href').split('/').pop();
      if (href === currentPage) {
        link.classList.add('active');
      }
    });
  },

  /* ═══════════════════════════════════════════════════════════
     UTILITY HELPERS
  ═══════════════════════════════════════════════════════════ */
  utils: {
    formatCurrency(amount, currency = 'BDT') {
      return new Intl.NumberFormat('en-BD', {
        style: 'currency', currency,
        minimumFractionDigits: 2
      }).format(amount);
    },

    formatDate(date) {
      return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit', month: 'short', year: 'numeric'
      }).format(new Date(date));
    },

    debounce(fn, delay = 300) {
      let timer;
      return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => fn(...args), delay);
      };
    },

    generateId(prefix = 'SM') {
      return `${prefix}-${Date.now().toString(36).toUpperCase()}-${Math.random().toString(36).substr(2, 4).toUpperCase()}`;
    }
  }
};
