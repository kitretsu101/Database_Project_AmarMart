<?php
/**
 * SwiftMart – includes/header.php
 * Reusable HTML <head> section.
 * Usage: include 'includes/header.php'; (set $pageTitle before including)
 *
 * DB Integration: Session auth check will be added here.
 *     DB: session_start(); verify $_SESSION['user_id'] via Oracle query
 */

// Default values
$pageTitle = $pageTitle ?? 'SwiftMart ERP';
$pageDesc = $pageDesc ?? 'SwiftMart – Smart Supermarket & Retail Chain Management System';
$activeNav = $activeNav ?? '';
$extraStyles = $extraStyles ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="<?= htmlspecialchars($pageDesc) ?>" />
  <meta name="theme-color" content="#2563EB" />

  <title><?= htmlspecialchars($pageTitle) ?> | SwiftMart ERP</title>

  <!-- Favicon (emoji fallback) -->
  <link rel="icon"
    href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🛒</text></svg>" />

  <!-- Google Fonts – Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/dashboard.css" />
  <link rel="stylesheet" href="css/responsive.css" />

  <!-- Page-specific extra styles -->
  <?php foreach ($extraStyles as $href): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($href) ?>" />
  <?php endforeach; ?>
</head>

<body>
  <!-- Sidebar Overlay (mobile) -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>