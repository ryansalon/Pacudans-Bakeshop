<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link id="favicon" rel="icon" type="image/jpeg" href="<?= base_url('assets/images/logo_and_bg/pacudans_logo.jpg') ?>">
    <title><?= esc($title ?? "Pacudan's Bakeshop & Coffee Bar") ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,700;12..96,800&family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --jade-deep: #143B31;
            --jade-raised: #1E4F42;
            --jade-hover: #0E2B23;
            --jade-tint: #CBE0D8;
            --amber-cta: #D97706;
            --amber-hover: #B45309;
            --amber-light: #FCD34D;
            --plaster-bg: #F6F2E9;
            --stone-soft: #ECE6D9;
            --card-bg: #FFFFFF;
            --ink-main: #1D1815;
            --ink-muted: #4E4942;
            --border-tile: rgba(20, 59, 49, 0.15);
            --border-tile-strong: rgba(20, 59, 49, 0.28);
            --glass-plaster: rgba(246, 242, 233, 0.94);

            /* Semantic aliases for Bootstrap & views */
            --primary-bg: var(--plaster-bg);
            --bg-soft: var(--stone-soft);
            --accent-color: var(--jade-deep);
            --secondary-accent: var(--amber-cta);
            --text-main: var(--ink-main);
            --text-muted: var(--ink-muted);
            --border-warm: var(--border-tile);
        }

        /* Browser surfaces */
        ::selection {
            background-color: var(--jade-deep);
            color: var(--plaster-bg);
        }

        html {
            scrollbar-width: thin;
            scrollbar-color: var(--jade-deep) var(--stone-soft);
            scroll-behavior: smooth;
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
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800;
            color: var(--ink-main);
            text-wrap: balance;
            letter-spacing: -0.025em;
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
            box-shadow: 0 10px 28px rgba(20, 59, 49, 0.06);
        }

        .surface-subtle {
            background-color: var(--stone-soft);
            border: 1px solid var(--border-tile);
            border-radius: 14px;
        }

        /* Volcanic-Jade Architectural Navbar */
        .site-navbar {
            background-color: var(--jade-deep);
            padding: 0.75rem 0;
            border-bottom: 6px solid var(--amber-cta);
            z-index: 1030;
            transition: box-shadow 0.25s ease, border-color 0.25s ease;
        }

        body.is-home .site-navbar {
            border-bottom: 0;
        }

        body.is-home .site-navbar.scrolled {
            border-bottom: 6px solid var(--amber-cta);
            box-shadow: 0 10px 28px rgba(14, 43, 35, 0.28);
        }

        .site-navbar .navbar-brand {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800;
            color: var(--plaster-bg);
            display: inline-flex;
            align-items: center;
            gap: 11px;
            letter-spacing: -0.02em;
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
            background-color: var(--amber-cta);
            color: var(--ink-main) !important;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.5rem 1.1rem;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            text-decoration: none;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }

        .nav-bag-pill:hover {
            background-color: #F59E0B;
            color: var(--ink-main) !important;
            transform: translateY(-1px);
        }

        .counter-badge {
            background: var(--amber-cta);
            color: var(--ink-main);
            font-size: 0.68rem;
            padding: 2px 6px;
            border-radius: 999px;
            border: 2px solid var(--jade-deep);
            font-weight: 800;
            line-height: 1.1;
        }

        /* Layout Spacing */
        .main-content {
            min-height: 78vh;
            padding-top: 96px;
            padding-bottom: 72px;
        }

        body.is-home .main-content {
            padding-top: 0;
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
            box-shadow: 0 8px 18px rgba(20, 59, 49, 0.22) !important;
        }

        .btn-amber {
            background-color: var(--amber-cta);
            color: var(--ink-main) !important;
            border: 2px solid var(--amber-cta);
            padding: 12px 28px;
            border-radius: 999px;
            font-weight: 800;
            transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
        }

        .btn-amber:hover,
        .btn-amber:focus {
            background-color: #F59E0B !important;
            border-color: #F59E0B !important;
            color: var(--ink-main) !important;
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
            border: 1.5px solid rgba(203, 224, 216, 0.55);
            color: var(--plaster-bg) !important;
            background: transparent;
            border-radius: 999px;
            font-weight: 600;
            padding: 11px 24px;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .btn-ghost-jade:hover {
            background-color: rgba(246, 242, 233, 0.12);
            border-color: var(--plaster-bg);
            color: #ffffff !important;
        }

        .btn:focus,
        .btn-check:focus + .btn,
        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.22rem rgba(217, 119, 6, 0.25) !important;
            border-color: var(--amber-cta) !important;
        }

        .card {
            border: 1px solid var(--border-tile);
            border-radius: 18px;
            background: var(--card-bg);
            box-shadow: 0 6px 20px rgba(20, 59, 49, 0.05);
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
            background: rgba(20, 59, 49, 0.1);
            color: var(--jade-deep);
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
            box-shadow: 0 18px 42px rgba(20, 59, 49, 0.18) !important;
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
            box-shadow: 0 24px 64px rgba(20, 59, 49, 0.2) !important;
        }

        .swal2-title {
            font-family: 'Bricolage Grotesque', sans-serif !important;
            font-weight: 800 !important;
            color: var(--ink-main) !important;
            font-size: 1.55rem !important;
        }

        .testimonial-card:hover {
            border-color: var(--accent-gold);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(176, 141, 87, 0.1);
        }

        .testimonial-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .testimonial-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 12px;
            border: 2px solid var(--cream-foam);
        }

        .testimonial-user-info {
            line-height: 1.2;
        }

        .testimonial-name {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .testimonial-handle {
            font-size: 0.85rem;
            color: #657786;
        }

        .testimonial-content {
            font-size: 1rem;
            color: #1c1c1c;
            line-height: 1.5;
        }

        .testimonial-content .highlight {
            color: var(--accent-gold);
            font-weight: 600;
        }

        .testimonial-timestamp {
            font-size: 0.8rem;
            color: #657786;
            margin-top: 1rem;
            display: block;
        }
    </style>
</head>
<body class="<?= (service('request')->getUri()->getPath() == '' || service('request')->getUri()->getPath() == '/') ? 'is-home' : '' ?>">

<!-- Branded Circular Preloader -->
<div id="preloader">
    <div class="loader-wrapper">
        <img src="<?= base_url('assets/images/logo_and_bg/pacudans_logo.jpg') ?>" class="loader-logo" alt="Logo">
        <div class="rotating-text" id="rotatingText">
            <!-- Text generated by JS -->
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">
            <img src="<?= base_url('assets/images/logo_and_bg/pacudans_logo.jpg') ?>" alt="Logo" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-right: 10px;">
            <div class="d-flex flex-column" style="line-height: 1;">
                <span style="font-size: 1.2rem;">PACUDAN'S</span>
                <small style="font-size: 0.6rem; font-weight: 400; text-transform: uppercase; letter-spacing: 1px;">Bakeshop & Coffee Bar</small>
            </div>
        </a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="bi bi-list fs-1 text-dark"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('menu') ?>">Menu</a></li>
                <li class="nav-item">
                    <a class="nav-link position-relative me-lg-2" href="<?= base_url('cart') ?>">
                        <i class="bi bi-bag"></i>
                        <?php 
                            $cart_count = 0;
                            if(session()->get('cart')) {
                                foreach(session()->get('cart') as $item) $cart_count += $item['quantity'];
                            }
                        ?>
                        <span id="cart-counter" class="position-absolute top-0 start-100 translate-middle <?= $cart_count > 0 ? '' : 'd-none' ?>"><?= $cart_count ?></span>
                    </a>
                </li>
                <?php if (session()->get('isLoggedIn')): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative me-lg-2 dropdown-toggle hide-caret" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
                            <i class="bi bi-bell"></i>
                            <span id="notif-counter" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" style="font-size: 0.55rem; padding: 3px 6px; border: 2px solid #fff;">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end notif-dropdown border-0" aria-labelledby="notifDropdown">
                            <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                                <span class="fw-bold small">Notifications</span>
                                <button class="btn btn-link btn-sm text-decoration-none p-0 small text-muted" onclick="markAllAsRead()">Mark all as read</button>
                            </div>
                            <div id="notif-list">
                                <!-- Notifications will be loaded here -->
                                <div class="notif-empty">
                                    <i class="bi bi-bell-slash fs-2 mb-2 d-block"></i>
                                    <span class="small">No new notifications</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle ms-lg-3" href="#" role="button" data-bs-toggle="dropdown">
                            <?= explode(' ', session()->get('name'))[0] ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2">
                            <li><a class="dropdown-item rounded-3" href="<?= base_url('profile') ?>">My Profile</a></li>
                            <li><a class="dropdown-item rounded-3" href="<?= base_url('favorites') ?>">My Favorites</a></li>
                            <?php if (session()->get('role') == 'admin'): ?>
                                <li><a class="dropdown-item rounded-3 fw-bold text-primary" href="<?= base_url('admin') ?>">Admin Panel</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item rounded-3 text-danger" href="<?= base_url('logout') ?>">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="btn btn-primary rounded-pill ms-lg-3 px-4 shadow-sm" href="<?= base_url('login') ?>">Sign In</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="main-content">
    <?= $this->renderSection('content') ?>
</div>

<footer class="footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 text-center text-lg-start">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-4">
                    <img src="<?= base_url('assets/images/logo_and_bg/pacudans_logo.jpg') ?>" alt="Logo" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; margin-right: 15px;">
                    <div class="d-flex flex-column text-start" style="line-height: 1.1;">
                        <span class="fw-bold fs-4" style="letter-spacing: -0.5px;">PACUDAN'S</span>
                        <small class="opacity-75" style="font-size: 0.7rem; font-weight: 400; text-transform: uppercase; letter-spacing: 1px;">Bakeshop & Coffee Bar</small>
                    </div>
                </div>
                <p class="opacity-75 small mb-4">Where every cup is brewed with passion and every pastry is baked with love. Your neighborhood spot for fresh daily treats.</p>
                <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                    <a href="https://www.fb.com/pacudanscoffee" target="_blank" class="btn btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-facebook"></i></a>
                    <a href="https://instagram.com/pacudanscoffee" target="_blank" class="btn btn-outline-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <h5 class="fw-bold mb-4">Quick Links</h5>
                <ul class="list-unstyled opacity-75 small">
                    <li class="mb-2"><a href="<?= base_url() ?>" class="text-white text-decoration-none">Home</a></li>
                    <li class="mb-2"><a href="<?= base_url('menu') ?>" class="text-white text-decoration-none">Our Menu</a></li>
                    <li class="mb-2"><a href="<?= base_url() ?>#about" class="text-white text-decoration-none">Our Story</a></li>
                    <li class="mb-2"><a href="<?= base_url() ?>#location" class="text-white text-decoration-none">Visit Us</a></li>
                </ul>
            </div>
            <div class="col-lg-4 text-center text-lg-end">
                <h5 class="fw-bold mb-4">Contact Info</h5>
                <ul class="list-unstyled opacity-75 small">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Mambajao, Camiguin Island</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i> 0963 921 6585</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i> pacudanscoffee@gmail.com</li>
                    <li class="mb-2"><i class="bi bi-clock me-2"></i> 8:00 AM - 9:00 PM</li>
                </ul>
            </div>
        </div>
        <hr class="my-5 opacity-10">
        <p class="text-center opacity-25 small mb-0">&copy; <?= date('Y') ?> Pacudan's Bakeshop & Coffee Bar. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Generate Circular Text for Preloader
    const text = "PACUDAN\'S BAKESHOP & COFFEE BAR • ";
    const container = document.getElementById('rotatingText');
    if (container) {
        for (let i = 0; i < text.length; i++) {
            let span = document.createElement('span');
            span.innerHTML = text[i];
            span.style.transform = `rotate(${i * (360 / text.length)}deg)`;
            container.appendChild(span);
        }
    }

    AOS.init({ duration: 800, once: true });
    
    function hidePreloader() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.style.opacity = '0';
            setTimeout(() => { preloader.style.visibility = 'hidden'; }, 500);
        }
    }

    window.addEventListener('load', hidePreloader);
    // Fallback: hide preloader after 3 seconds even if load event doesn't fire
    setTimeout(hidePreloader, 3000);

    window.addEventListener('scroll', function() {
        const nav = document.getElementById('mainNav');
        if (window.scrollY > 50) nav.classList.add('scrolled');
        else nav.classList.remove('scrolled');
    });

    // Global Flash Message Handler
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
            popup: 'premium-toast'
        },
        showClass: {
            popup: 'sileo-show'
        },
        hideClass: {
            popup: 'swal2-hide'
        },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    <?php if (session()->getFlashdata('msg')): ?>
        Toast.fire({
            icon: 'success',
            title: '<?= addslashes(session()->getFlashdata('msg')) ?>'
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        Toast.fire({
            icon: 'error',
            title: '<?= addslashes(session()->getFlashdata('error')) ?>'
        });
    <?php endif; ?>

    // Success Modal (Task 3)
    <?php if (session()->getFlashdata('popup_msg')): ?>
        Swal.fire({
            title: 'Order Placed Successfully!',
            text: '<?= addslashes(session()->getFlashdata('popup_msg')) ?>',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Order Again',
            cancelButtonText: 'Go to Home',
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
                window.location.href = '<?= base_url() ?>';
            }
        });
    <?php endif; ?>

    // Dynamic Event-Based Notifications (Task 5)
    <?php if (session()->get('isLoggedIn')): ?>
        let seenNotifications = [];

        function fetchNotifications() {
            fetch('<?= base_url('api/notifications/unread') ?>')
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        const counter = document.getElementById('notif-counter');
                        const list = document.getElementById('notif-list');
                        const count = result.count;
                        
                        if (count > 0) {
                            counter.textContent = count;
                            counter.classList.remove('d-none');
                            
                            let html = '';
                            result.data.forEach(notif => {
                                // Show toast for new notifications
                                if (!seenNotifications.includes(notif.id)) {
                                    Toast.fire({
                                        icon: 'info',
                                        title: notif.message,
                                        showCloseButton: true,
                                        timer: 10000 
                                    });
                                    seenNotifications.push(notif.id);
                                }

                                // Build list item
                                html += `
                                    <div class="dropdown-item p-3 border-bottom notif-item" onclick="handleNotifClick(event, ${notif.id}, '${notif.link || '#'}')">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="me-3">
                                                <p class="mb-1 small">${notif.message}</p>
                                                <small class="text-muted" style="font-size: 0.7rem;">${new Date(notif.created_at).toLocaleString()}</small>
                                            </div>
                                            <button class="btn btn-link btn-sm text-danger p-0" onclick="deleteNotif(event, ${notif.id})">
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
                                    <i class="bi bi-bell-slash fs-2 mb-2 d-block"></i>
                                    <span class="small">No new notifications</span>
                                </div>
                            `;
                        }
                    }
                })
                .catch(err => console.error('Error fetching notifications:', err));
        }

        function handleNotifClick(event, id, url) {
            // Mark as read and redirect
            fetch('<?= base_url('api/notifications/mark-read/') ?>' + id, { method: 'POST' })
                .then(() => {
                    if (url && url !== '#') {
                        // If it's a relative URL, prepend base_url
                        if (!url.startsWith('http')) {
                            window.location.href = '<?= base_url() ?>' + url;
                        } else {
                            window.location.href = url;
                        }
                    } else {
                        fetchNotifications();
                    }
                });
        }

        function deleteNotif(event, id) {
            event.stopPropagation(); // Don't trigger the item click
            fetch('<?= base_url('api/notifications/delete/') ?>' + id, { method: 'POST' })
                .then(() => fetchNotifications());
        }

        function markAllAsRead() {
            fetch('<?= base_url('api/notifications/mark-all-read') ?>', { method: 'POST' })
                .then(() => {
                    fetchNotifications();
                    document.getElementById('notif-counter').classList.add('d-none');
                });
        }

        // Clear badge when dropdown is shown
        document.getElementById('notifDropdown').addEventListener('show.bs.dropdown', function () {
            document.getElementById('notif-counter').classList.add('d-none');
        });

        // Initial fetch and set interval
        fetchNotifications();
        setInterval(fetchNotifications, 20000); // Check every 20 seconds
    <?php endif; ?>
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>

