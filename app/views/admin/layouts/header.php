<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Admin | ' . SITENAME ?></title>
    <link rel="icon" type="image/png" href="<?= URLROOT ?>/images/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= URLROOT ?>/css/admin.css">
</head>
<body>

<?php
$currentUrl = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$adminName  = $_SESSION['admin_name']  ?? 'Admin';
$adminEmail = $_SESSION['admin_email'] ?? '';
?>

<div class="admin-wrapper">

    <!-- ── SIDEBAR ─────────────────────────────────────── -->
    <aside class="admin-sidebar">

        <div class="sidebar-brand">
            <img src="<?= URLROOT ?>/images/logo.png" alt="Pinga Agro">
            <span>Content Management</span>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-nav-group">
                <span class="sidebar-nav-label">Main</span>
                <a href="<?= URLROOT ?>/admin"
                   class="sidebar-link <?= ($currentUrl === 'admin') ? 'active' : '' ?>">
                    <span class="icon">📊</span> Dashboard
                </a>
            </div>

            <div class="sidebar-nav-group">
                <span class="sidebar-nav-label">Content</span>
                <a href="<?= URLROOT ?>/admin/posts"
                   class="sidebar-link <?= (strpos($currentUrl, 'admin/posts') === 0 || strpos($currentUrl, 'admin/editpost') === 0) ? 'active' : '' ?>">
                    <span class="icon">📝</span> All Posts
                </a>
                <a href="<?= URLROOT ?>/admin/newpost"
                   class="sidebar-link <?= ($currentUrl === 'admin/newpost') ? 'active' : '' ?>">
                    <span class="icon">✏️</span> New Post
                </a>
            </div>

            <div class="sidebar-nav-group">
                <span class="sidebar-nav-label">Engagement</span>
                <a href="<?= URLROOT ?>/admin/contacts"
                   class="sidebar-link <?= (strpos($currentUrl, 'admin/contacts') === 0) ? 'active' : '' ?>">
                    <span class="icon">📬</span> Contact Submissions
                </a>
            </div>

            <div class="sidebar-nav-group">
                <span class="sidebar-nav-label">Site</span>
                <a href="<?= URLROOT ?>/" target="_blank" class="sidebar-link">
                    <span class="icon">🌐</span> View Website
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user-name"><?= htmlspecialchars($adminName) ?></div>
            <div class="sidebar-user-email"><?= htmlspecialchars($adminEmail) ?></div>
            <a href="<?= URLROOT ?>/admin/logout" class="sidebar-logout">
                <span>🚪</span> Sign Out
            </a>
        </div>

    </aside>
    <!-- ── END SIDEBAR ─────────────────────────────────── -->

    <!-- ── MAIN CONTENT AREA ───────────────────────────── -->
    <main class="admin-main">