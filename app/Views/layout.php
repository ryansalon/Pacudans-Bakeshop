<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link id="favicon" rel="icon" type="image/jpeg" href="<?= base_url('assets/images/logo_and_bg/pacudans_logo.jpg') ?>">
    <title><?= esc($title ?? "Pacudan's Bakeshop & Coffee Bar") ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&family=Instrument+Serif:ital@0;1&family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --espresso-deep: #331E14;
            --espresso-raised: #472B1D;
            --espresso-hover: #24140D;
            --cream-tint: #EBDCCF;
            --ember-bold: #C84122;
            --ember-hover: #A63218;
            --ember-ink: #A63218;
            --ember-light: #FF9F7A;
            --cream-bg: #FAF4EB;
            --cream-soft: #EFE5D8;
            --card-bg: #FFFFFF;
            --ink-main: #24140D;
            --ink-muted: #5C463A;
            --border-tile: rgba(51, 30, 20, 0.15);
            --border-tile-strong: rgba(51, 30, 20, 0.28);
            --glass-plaster: rgba(250, 244, 235, 0.95);

            /* Semantic aliases for views & components */
            --jade-deep: var(--espresso-deep);
            --jade-raised: var(--espresso-raised);
            --jade-hover: var(--espresso-hover);
            --jade-tint: var(--cream-tint);
            --amber-cta: var(--ember-bold);
            --amber-hover: var(--ember-ink);
            --amber-light: var(--ember-light);
            --plaster-bg: var(--cream-bg);
            --stone-soft: var(--cream-soft);
            --primary-bg: var(--cream-bg);
            --bg-soft: var(--cream-soft);
            --accent-color: var(--espresso-deep);
            --secondary-accent: var(--ember-bold);
            --text-main: var(--ink-main);
            --text-muted: var(--ink-muted);
            --border-warm: var(--border-tile);
        }

        @view-transition {
            navigation: auto;
        }

        /* Instant top progress hairline during page transitions */
        #navProgressBar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0;
            background: var(--ember-light);
            z-index: 2000;
            opacity: 0;
            pointer-events: none;
            transition: width 0.35s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.18s ease;
        }

        #navProgressBar.is-loading {
            opacity: 1;
            width: 78%;
        }

        /* Browser surfaces */
        ::selection {
            background-color: var(--jade-deep);
            color: var(--plaster-bg);
        }

        html {
            scrollbar-width: thin;
            scrollbar-color: var(--jade-deep) var(--stone-soft);
        }

        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--stone-soft);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--jade-deep);
            border-radius: 999px;
            border: 2px solid var(--stone-soft);
        }

        input, textarea, select {
            caret-color: var(--amber-cta);
        }

        a {
            text-underline-offset: 0.22em;
        }

        :focus-visible {
            outline: 2px solid var(--amber-cta) !important;
            outline-offset: 2px !important;
        }

        .tabular-nums,
        .price-tag,
        .table td,
        .table th,
        .badge,
        input[type="number"],
        #main-price,
        #cart-counter,
        #notif-counter,
        #fav-counter {
            font-variant-numeric: tabular-nums;
        }

        html, body {
            max-width: 100%;
            overflow-x: clip;
        }

        main, section {
            max-width: 100%;
            overflow-x: clip;
        }

        body {
            background-color: var(--plaster-bg);
            color: var(--ink-main);
            font-family: 'Hanken Grotesk', sans-serif;
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6, .display-font {
            font-family: 'Young Serif', Georgia, serif;
            font-weight: 400;
            color: var(--ink-main);
            text-wrap: balance;
            letter-spacing: -0.015em;
        }

        .coffee-italic {
            font-family: 'Instrument Serif', Georgia, serif;
            font-style: italic;
            font-weight: 400;
            letter-spacing: 0;
        }

        p, .prose {
            max-width: 68ch;
        }

        .text-muted {
            color: var(--ink-muted) !important;
        }

        .text-primary {
            color: var(--jade-deep) !important;
        }

        .text-amber {
            color: var(--amber-hover) !important;
        }

        .bg-soft {
            background-color: var(--stone-soft) !important;
        }

        .bg-jade {
            background-color: var(--jade-deep) !important;
            color: var(--plaster-bg);
        }

        .surface-panel {
            background-color: var(--card-bg);
            border: 1px solid var(--border-tile);
            border-radius: 18px;
            box-shadow: 0 10px 28px rgba(51, 30, 20, 0.06);
        }

        .surface-subtle {
            background-color: var(--stone-soft);
            border: 1px solid var(--border-tile);
            border-radius: 14px;
        }

        /* Espresso Architectural Navbar */
        .site-navbar {
            background-color: var(--espresso-deep);
            padding: 0.75rem 0;
            border-bottom: 6px solid var(--ember-bold);
            z-index: 1030;
            transition: box-shadow 0.25s ease;
        }

        .site-navbar.scrolled {
            box-shadow: 0 10px 28px rgba(36, 20, 13, 0.28);
        }

        .site-navbar .navbar-brand {
            font-family: 'Young Serif', Georgia, serif;
            font-weight: 400;
            color: var(--plaster-bg);
            display: inline-flex;
            align-items: center;
            gap: 11px;
            letter-spacing: 0.01em;
        }

        .site-navbar .navbar-brand:hover {
            color: #ffffff;
        }

        .site-navbar .brand-sub {
            font-family: 'Hanken Grotesk', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: var(--jade-tint);
        }

        .site-navbar .nav-link {
            color: var(--jade-tint);
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.48rem 0.9rem !important;
            border-radius: 999px;
            transition: color 0.2s ease, background-color 0.2s ease;
        }

        .site-navbar .nav-link:hover,
        .site-navbar .nav-link.active {
            color: #ffffff;
            background-color: rgba(246, 242, 233, 0.1);
        }

        .nav-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--jade-tint) !important;
        }

        .nav-icon-btn:hover {
            background-color: rgba(246, 242, 233, 0.14);
            color: #ffffff !important;
        }

        .nav-bag-pill {
            background-color: var(--ember-bold);
            color: #FFFDF9 !important;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.5rem 1.15rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            text-decoration: none;
            box-shadow: 0 6px 16px rgba(200, 65, 34, 0.28);
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .nav-bag-pill:hover {
            background-color: var(--ember-hover);
            color: #FFFDF9 !important;
            transform: translateY(-1px);
        }

        @keyframes bagBump {
            0% { transform: scale(1); }
            35% { transform: scale(1.14); }
            70% { transform: scale(0.96); }
            100% { transform: scale(1); }
        }

        .nav-bag-pill.is-bumping {
            animation: bagBump 0.42s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .counter-badge {
            background: var(--ember-bold);
            color: #FFFDF9;
            font-size: 0.68rem;
            padding: 2px 6px;
            border-radius: 999px;
            border: 2px solid var(--espresso-deep);
            font-weight: 800;
            line-height: 1.1;
        }

        /* Layout Spacing */
        .main-content {
            min-height: 78vh;
            padding-top: 92px;
            padding-bottom: 72px;
        }

        body.is-home .main-content {
            padding-top: 76px;
        }

        /* Buttons & Controls */
        .btn-primary {
            background-color: var(--jade-deep);
            color: var(--plaster-bg) !important;
            border: 2px solid var(--jade-deep);
            padding: 11px 26px;
            border-radius: 999px;
            font-weight: 700;
            transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover,
        .btn-primary:active,
        .btn-primary:focus {
            background-color: var(--jade-hover) !important;
            border-color: var(--jade-hover) !important;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(51, 30, 20, 0.24) !important;
        }

        .btn-amber {
            background-color: var(--ember-bold);
            color: #FFFDF9 !important;
            border: 2px solid var(--ember-bold);
            padding: 12px 28px;
            border-radius: 999px;
            font-weight: 800;
            box-shadow: 0 8px 20px rgba(200, 65, 34, 0.24);
            transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }

        .btn-amber:hover,
        .btn-amber:focus {
            background-color: var(--ember-hover) !important;
            border-color: var(--ember-hover) !important;
            color: #FFFDF9 !important;
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            border: 1.5px solid var(--jade-deep);
            color: var(--jade-deep);
            background-color: transparent;
            border-radius: 999px;
            font-weight: 700;
            padding: 10px 24px;
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .btn-outline-primary:hover,
        .btn-outline-primary:active,
        .btn-outline-primary.active,
        .btn-check:checked + .btn-outline-primary {
            background-color: var(--jade-deep) !important;
            border-color: var(--jade-deep) !important;
            color: var(--plaster-bg) !important;
        }

        .btn-ghost-jade {
            border: 1.5px solid rgba(235, 220, 207, 0.55);
            color: var(--plaster-bg) !important;
            background: transparent;
            border-radius: 999px;
            font-weight: 600;
            padding: 11px 24px;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .btn-ghost-jade:hover {
            background-color: rgba(250, 244, 235, 0.12);
            border-color: var(--plaster-bg);
            color: #ffffff !important;
        }

        .btn:focus,
        .btn-check:focus + .btn,
        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.22rem rgba(200, 65, 34, 0.25) !important;
            border-color: var(--ember-bold) !important;
        }

        .card {
            border: 1px solid var(--border-tile);
            border-radius: 18px;
            background: var(--card-bg);
            box-shadow: 0 6px 20px rgba(51, 30, 20, 0.05);
            transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .card:hover {
            border-color: var(--border-tile-strong);
        }

        /* Admin Sub-Navigation */
        .admin-subnav {
            display: flex;
            flex-wrap: wrap;
            gap: 0.45rem;
            padding: 0.45rem;
            background: var(--stone-soft);
            border: 1px solid var(--border-tile);
            border-radius: 999px;
            margin-bottom: 2rem;
        }

        .admin-subnav a {
            text-decoration: none;
            color: var(--ink-main);
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.5rem 1.15rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .admin-subnav a:hover {
            background: rgba(51, 30, 20, 0.1);
            color: var(--espresso-deep);
        }

        .admin-subnav a.active {
            background: var(--jade-deep);
            color: var(--plaster-bg);
        }

        /* Footer */
        .footer {
            background: var(--jade-deep);
            border-top: 6px solid var(--amber-cta);
            padding: 68px 0 42px;
            color: var(--plaster-bg);
            margin-top: 64px;
        }

        .footer h5,
        .footer .brand-title {
            color: var(--plaster-bg);
        }

        .footer p,
        .footer li,
        .footer a,
        .footer small {
            color: var(--jade-tint);
        }

        .footer a:hover {
            color: var(--amber-light);
        }

        /* Notifications Dropdown */
        .notif-dropdown {
            width: 340px;
            max-height: 400px;
            overflow-y: auto;
            border-radius: 16px !important;
            box-shadow: 0 18px 42px rgba(51, 30, 20, 0.18) !important;
            border: 1px solid var(--border-tile) !important;
            margin-top: 10px !important;
            background: #ffffff;
        }

        .notif-item {
            white-space: normal;
            transition: background-color 0.15s ease;
            cursor: pointer;
        }

        .notif-item:hover {
            background-color: var(--plaster-bg);
        }

        .notif-empty {
            padding: 32px 20px;
            text-align: center;
            color: var(--ink-muted);
        }

        /* SweetAlert2 Styling */
        .swal2-popup.premium-swal {
            border-radius: 20px !important;
            padding: 2rem 1.5rem !important;
            background: #ffffff !important;
            border: 1px solid var(--border-tile) !important;
            box-shadow: 0 24px 64px rgba(51, 30, 20, 0.2) !important;
        }

        .swal2-title {
            font-family: 'Young Serif', Georgia, serif !important;
            font-weight: 400 !important;
            color: var(--ink-main) !important;
            font-size: 1.55rem !important;
        }

        .swal2-html-container {
            font-family: 'Hanken Grotesk', sans-serif !important;
            color: var(--ink-muted) !important;
            font-size: 1rem !important;
        }

        .swal2-confirm.premium-confirm {
            background: var(--jade-deep) !important;
            color: var(--plaster-bg) !important;
            border-radius: 999px !important;
            padding: 11px 28px !important;
            font-weight: 700 !important;
            border: none !important;
        }

        .swal2-cancel.premium-cancel {
            background: var(--stone-soft) !important;
            color: var(--ink-main) !important;
            border-radius: 999px !important;
            padding: 11px 28px !important;
            font-weight: 700 !important;
            border: 1px solid var(--border-tile) !important;
        }

        .swal2-popup.swal2-toast.premium-toast {
            background: #ffffff !important;
            border-radius: 999px !important;
            padding: 10px 22px !important;
            box-shadow: 0 12px 30px rgba(51, 30, 20, 0.16) !important;
            border: 1px solid var(--border-tile-strong) !important;
            margin-top: 14px !important;
            display: flex !important;
            align-items: center !important;
        }

        .swal2-toast .swal2-title {
            color: var(--ink-main) !important;
            font-size: 0.92rem !important;
            font-weight: 700 !important;
            margin: 0 10px !important;
            font-family: 'Hanken Grotesk', sans-serif !important;
        }

        /* Horizontal category strip with mobile right-edge plaster fade */
        .cat-strip-wrap {
            position: relative;
        }

        @media (max-width: 991.98px) {
            .cat-strip-wrap::after {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                bottom: 8px;
                width: 44px;
                background: linear-gradient(to left, var(--cream-bg) 15%, rgba(250, 244, 235, 0) 100%);
                pointer-events: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }

        @media (max-width: 991.98px) {
            .site-navbar .navbar-collapse {
                background: var(--jade-raised);
                margin-top: 12px;
                border-radius: 16px;
                padding: 14px;
                border: 1px solid rgba(246, 242, 233, 0.14);
            }
            .main-content {
                padding-top: 86px;
            }
            body.is-home .main-content {
                padding-top: 72px;
            }
        }
    </style>
</head>
<?php
    $currentPath = preg_replace('#^index\.php/?#', '', trim(uri_string(), '/'));
    $isHome = ($currentPath === '');
    $cart_count = 0;
    if (session()->get('cart')) {
        foreach (session()->get('cart') as $item) {
            $cart_count += (int) $item['quantity'];
        }
    }
    $fav_count = 0;
    if (session()->get('isLoggedIn')) {
        if (!session()->has('fav_count')) {
            $fav_count = (new \App\Models\FavoritesModel())
                ->where('user_id', session()->get('user_id'))
                ->countAllResults();
            session()->set('fav_count', $fav_count);
        } else {
            $fav_count = (int) session()->get('fav_count');
        }
    }
?>
<body class="<?= $isHome ? 'is-home' : '' ?>">
<div id="navProgressBar" aria-hidden="true"></div>

<nav class="navbar navbar-expand-lg fixed-top site-navbar" id="mainNav" aria-label="Main navigation">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">
            <svg width="40" height="40" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Pacudan's Logo" style="flex-shrink: 0;">
                <circle cx="24" cy="24" r="22.5" fill="#472B1D" stroke="#FF9F7A" stroke-width="2"/>
                <path d="M15 21H30V28C30 32.1421 26.6421 35.5 22.5 35.5C18.3579 35.5 15 32.1421 15 28V21Z" fill="#FAF4EB"/>
                <path d="M30 23H32.5C34.433 23 36 24.567 36 26.5C36 28.433 34.433 30 32.5 30H30" stroke="#FAF4EB" stroke-width="2.4" stroke-linecap="round"/>
                <path d="M19.5 17C19.5 15.2 21 14.5 21 12.8M25 17C25 15.2 26.5 14.5 26.5 12.8" stroke="#FF9F7A" stroke-width="2" stroke-linecap="round"/>
                <path d="M14 38H31" stroke="#C84122" stroke-width="2.4" stroke-linecap="round"/>
            </svg>
            <div class="d-flex flex-column" style="line-height: 1.05;">
                <span style="font-size: 1.15rem;">PACUDAN'S</span>
                <span class="brand-sub">Mambajao · Camiguin</span>
            </div>
        </a>

        <div class="d-flex align-items-center gap-2 d-lg-none">
            <a href="<?= base_url('cart') ?>" class="nav-bag-pill py-1 px-3" aria-label="Shopping Bag">
                <i class="bi bi-bag-fill"></i>
                <span id="cart-counter-mobile" class="tabular-nums"><?= $cart_count ?></span>
            </a>
            <button class="navbar-toggler border-0 shadow-none text-white p-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="bi bi-list fs-2"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link <?= $isHome ? 'active' : '' ?>" href="<?= base_url() ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (strpos($currentPath, 'menu') === 0 || strpos($currentPath, 'category') === 0) ? 'active' : '' ?>" href="<?= base_url('menu') ?>">Full Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>#location">Visit Shop</a>
                </li>

                <?php if (session()->get('role') === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($currentPath, 'admin') === 0 ? 'active' : '' ?>" href="<?= base_url('admin') ?>">Admin</a>
                    </li>
                <?php endif; ?>

                <?php if (session()->get('isLoggedIn')): ?>
                    <li class="nav-item">
                        <a class="nav-link nav-icon-btn position-relative" href="<?= base_url('favorites') ?>" title="Saved Favorites" aria-label="Saved Favorites">
                            <i class="bi bi-heart"></i>
                            <span id="fav-counter" class="position-absolute top-0 start-100 translate-middle counter-badge <?= $fav_count > 0 ? '' : 'd-none' ?>"><?= $fav_count ?></span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon-btn position-relative dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications" aria-label="Notifications">
                            <i class="bi bi-bell"></i>
                            <span id="notif-counter" class="position-absolute top-0 start-100 translate-middle counter-badge bg-danger text-white d-none">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end notif-dropdown" aria-labelledby="notifDropdown">
                            <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                                <span class="fw-bold small text-dark">Notifications</span>
                                <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 small text-muted" onclick="markAllAsRead()">Mark all read</button>
                            </div>
                            <div id="notif-list">
                                <div class="notif-empty">
                                    <i class="bi bi-bell-slash fs-3 mb-2 d-block"></i>
                                    <span class="small">No unread notifications</span>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-inline-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <span><?= esc(explode(' ', (string) session()->get('name'))[0]) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2">
                            <li><a class="dropdown-item rounded-3 py-2" href="<?= base_url('profile') ?>"><i class="bi bi-person me-2"></i>My Profile &amp; Orders</a></li>
                            <li><a class="dropdown-item rounded-3 py-2" href="<?= base_url('favorites') ?>"><i class="bi bi-heart me-2"></i>Saved Favorites</a></li>
                            <?php if (session()->get('role') === 'admin'): ?>
                                <li><a class="dropdown-item rounded-3 py-2 fw-bold text-primary" href="<?= base_url('admin') ?>"><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item rounded-3 py-2 text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPath === 'login' ? 'active' : '' ?>" href="<?= base_url('login') ?>">Sign In</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item ms-lg-2 d-none d-lg-block">
                    <a class="nav-bag-pill" href="<?= base_url('cart') ?>">
                        <i class="bi bi-bag-fill"></i>
                        <span>Bag (<span id="cart-counter" class="tabular-nums"><?= $cart_count ?></span>)</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="main-content">
    <?= $this->renderSection('content') ?>
</main>

<footer class="footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 text-center text-lg-start">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-3">
                    <svg width="46" height="46" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Pacudan's Logo" style="margin-right: 14px; flex-shrink: 0;">
                        <circle cx="24" cy="24" r="22.5" fill="#472B1D" stroke="#FF9F7A" stroke-width="2"/>
                        <path d="M15 21H30V28C30 32.1421 26.6421 35.5 22.5 35.5C18.3579 35.5 15 32.1421 15 28V21Z" fill="#FAF4EB"/>
                        <path d="M30 23H32.5C34.433 23 36 24.567 36 26.5C36 28.433 34.433 30 32.5 30H30" stroke="#FAF4EB" stroke-width="2.4" stroke-linecap="round"/>
                        <path d="M19.5 17C19.5 15.2 21 14.5 21 12.8M25 17C25 15.2 26.5 14.5 26.5 12.8" stroke="#FF9F7A" stroke-width="2" stroke-linecap="round"/>
                        <path d="M14 38H31" stroke="#C84122" stroke-width="2.4" stroke-linecap="round"/>
                    </svg>
                    <div class="d-flex flex-column text-start" style="line-height: 1.1;">
                        <span class="brand-title display-font fw-bold fs-4">PACUDAN'S</span>
                        <small style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em;">Bakeshop &amp; Coffee Bar</small>
                    </div>
                </div>
                <p class="small mb-4">Fresh morning breads, celebration cakes, and hot &amp; iced espresso pulled to order in Mambajao, Camiguin. Free local Cash on Delivery.</p>
                <div class="d-flex justify-content-center justify-content-lg-start gap-2">
                    <a href="https://www.fb.com/pacudanscoffee" target="_blank" rel="noopener" class="btn btn-ghost-jade rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" aria-label="Pacudan's Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="https://instagram.com/pacudanscoffee" target="_blank" rel="noopener" class="btn btn-ghost-jade rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" aria-label="Pacudan's Instagram"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 text-center text-sm-start">
                <h5 class="fw-bold mb-3">Counter Links</h5>
                <ul class="list-unstyled small d-grid gap-2">
                    <li><a href="<?= base_url() ?>" class="text-decoration-none">Home</a></li>
                    <li><a href="<?= base_url('menu') ?>" class="text-decoration-none">Full Menu</a></li>
                    <li><a href="<?= base_url() ?>#about" class="text-decoration-none">Our Story</a></li>
                    <li><a href="<?= base_url() ?>#location" class="text-decoration-none">Location &amp; Hours</a></li>
                </ul>
            </div>
            <div class="col-sm-6 col-lg-4 text-center text-sm-start">
                <h5 class="fw-bold mb-3">Visit the Café</h5>
                <ul class="list-unstyled small d-grid gap-2">
                    <li><i class="bi bi-geo-alt me-2"></i>Mambajao, Camiguin Island</li>
                    <li><i class="bi bi-telephone me-2"></i><a href="tel:09639216585" class="text-decoration-none tabular-nums">0963 921 6585</a></li>
                    <li><i class="bi bi-envelope me-2"></i><a href="mailto:pacudanscoffee@gmail.com" class="text-decoration-none">pacudanscoffee@gmail.com</a></li>
                    <li><i class="bi bi-clock me-2"></i>Daily, 8:00 AM – 9:00 PM</li>
                </ul>
            </div>
        </div>
        <hr class="my-4" style="border-color: rgba(235, 220, 207, 0.2);">
        <p class="text-center small mb-0 mx-auto">&copy; <?= date('Y') ?> Pacudan's Bakeshop &amp; Coffee Bar · Mambajao, Camiguin.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const navEl = document.getElementById('mainNav');
    const navBar = document.getElementById('navProgressBar');
    const syncNavScroll = () => {
        if (window.scrollY > 24) navEl.classList.add('scrolled');
        else navEl.classList.remove('scrolled');
    };
    window.addEventListener('scroll', syncNavScroll, { passive: true });
    syncNavScroll();

    document.addEventListener('click', (e) => {
        if (e.defaultPrevented || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;
        const a = e.target.closest && e.target.closest('a[href]');
        if (!a || a.origin !== location.origin || a.target === '_blank' || a.hasAttribute('download')) return;
        const href = a.getAttribute('href') || '';
        if (href.startsWith('#') || href.startsWith('javascript:')) return;
        if (a.pathname === location.pathname && a.search === location.search) return;
        if (navBar) navBar.classList.add('is-loading');
    });

    window.addEventListener('pageshow', () => {
        if (navBar) navBar.classList.remove('is-loading');
    });

    function updateBagCounters(count) {
        const d = document.getElementById('cart-counter');
        const m = document.getElementById('cart-counter-mobile');
        if (d) d.textContent = count;
        if (m) m.textContent = count;
        document.querySelectorAll('.nav-bag-pill').forEach(pill => {
            pill.classList.remove('is-bumping');
            void pill.offsetWidth;
            pill.classList.add('is-bumping');
        });
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
            popup: 'premium-toast'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    <?php if (session()->getFlashdata('msg')): ?>
        Toast.fire({
            icon: 'success',
            title: <?= json_encode((string) session()->getFlashdata('msg')) ?>
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        Toast.fire({
            icon: 'error',
            title: <?= json_encode((string) session()->getFlashdata('error')) ?>
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('popup_msg')): ?>
        Swal.fire({
            title: 'Order Placed Successfully',
            text: <?= json_encode((string) session()->getFlashdata('popup_msg')) ?>,
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Browse Menu',
            cancelButtonText: 'View My Orders',
            reverseButtons: true,
            customClass: {
                popup: 'premium-swal',
                confirmButton: 'premium-confirm',
                cancelButton: 'premium-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('menu') ?>';
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                window.location.href = '<?= base_url('profile') ?>';
            }
        });
    <?php endif; ?>

    <?php if (session()->get('isLoggedIn')): ?>
        let seenNotifications = [];

        function escapeHtml(str) {
            const div = document.createElement('div');
            div.textContent = str || '';
            return div.innerHTML;
        }

        function fetchNotifications() {
            fetch('<?= base_url('api/notifications/unread') ?>')
                .then(response => response.json())
                .then(result => {
                    if (result.status !== 'success') return;
                    const counter = document.getElementById('notif-counter');
                    const list = document.getElementById('notif-list');
                    const count = Number(result.count || 0);

                    if (count > 0) {
                        counter.textContent = count;
                        counter.classList.remove('d-none');

                        let html = '';
                        result.data.forEach(notif => {
                            const notifId = Number(notif.id);
                            if (!seenNotifications.includes(notifId)) {
                                Toast.fire({
                                    icon: 'info',
                                    title: notif.message,
                                    timer: 6500
                                });
                                seenNotifications.push(notifId);
                            }

                            const safeMsg = escapeHtml(notif.message);
                            const safeLink = encodeURIComponent(notif.link || '#');
                            const timeLabel = escapeHtml(new Date(notif.created_at).toLocaleString());

                            html += `
                                <div class="dropdown-item p-3 border-bottom notif-item" onclick="handleNotifClick(event, ${notifId}, '${safeLink}')">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="me-3">
                                            <p class="mb-1 small text-dark">${safeMsg}</p>
                                            <small class="text-muted tabular-nums" style="font-size: 0.72rem;">${timeLabel}</small>
                                        </div>
                                        <button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="deleteNotif(event, ${notifId})" aria-label="Dismiss notification">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            `;
                        });
                        list.innerHTML = html;
                    } else {
                        counter.classList.add('d-none');
                        list.innerHTML = `
                            <div class="notif-empty">
                                <i class="bi bi-bell-slash fs-3 mb-2 d-block"></i>
                                <span class="small">No unread notifications</span>
                            </div>
                        `;
                    }
                })
                .catch(err => console.error('Error fetching notifications:', err));
        }

        function handleNotifClick(event, id, encodedUrl) {
            const url = decodeURIComponent(encodedUrl || '#');
            fetch('<?= base_url('api/notifications/mark-read/') ?>' + id, { method: 'POST' })
                .then(() => {
                    if (url && url !== '#') {
                        window.location.href = url.startsWith('http') ? url : '<?= base_url() ?>' + url.replace(/^\//, '');
                    } else {
                        fetchNotifications();
                    }
                });
        }

        function deleteNotif(event, id) {
            event.stopPropagation();
            fetch('<?= base_url('api/notifications/delete/') ?>' + id, { method: 'POST' })
                .then(() => fetchNotifications());
        }

        function markAllAsRead() {
            fetch('<?= base_url('api/notifications/mark-all-read') ?>', { method: 'POST' })
                .then(() => {
                    document.getElementById('notif-counter').classList.add('d-none');
                    fetchNotifications();
                });
        }

        // Defer initial notification check so first paint & navigation never compete with polling
        if ('requestIdleCallback' in window) {
            requestIdleCallback(() => fetchNotifications(), { timeout: 1200 });
        } else {
            setTimeout(fetchNotifications, 600);
        }
        setInterval(() => {
            if (!document.hidden) fetchNotifications();
        }, 25000);
    <?php endif; ?>
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
