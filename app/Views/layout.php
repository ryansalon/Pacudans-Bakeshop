<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link id="favicon" rel="icon" type="image/x-icon" href="<?= base_url('assets/images/logo_and_bg/pacudans_logo.jpg') ?>">
    <script>
        window.addEventListener('load', function() {
            const img = new Image();
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = 64;
                canvas.height = 64;
                
                // Create circular clipping path
                ctx.beginPath();
                ctx.arc(32, 32, 32, 0, Math.PI * 2);
                ctx.clip();
                
                // Draw image cropped to circle
                ctx.drawImage(img, 0, 0, 64, 64);
                
                // Update favicon link
                document.getElementById('favicon').href = canvas.toDataURL('image/png');
            };
            img.src = "<?= base_url('assets/images/logo_and_bg/pacudans_logo.jpg') ?>";
        });
    </script>
    <title><?= $title ?? 'Pacudan\'s Bakeshop & Coffee Bar' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary-mocha: #3d2b1f; /* Deep Espresso */
            --secondary-mocha: #5c4033; /* Rich Cocoa */
            --accent-gold: #b08d57; /* Sophisticated Muted Gold */
            --cream-foam: #fdfaf7; /* Elegant Off-white */
            --text-dark: #2a1b12; /* Warm Dark Brown */
            --bg-soft: #fcf9f6; 
            --glass-white: rgba(255, 255, 255, 0.92);
        }

        body { 
            background-color: var(--bg-soft); 
            color: var(--text-dark); 
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Premium Smooth Shadows */
        .shadow-premium {
            box-shadow: 0 20px 50px rgba(61, 43, 31, 0.08) !important;
        }

        /* Circular Branded Preloader */
        #preloader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: var(--bg-soft);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.6s;
        }

        .loader-wrapper {
            position: relative;
            width: 220px;
            height: 220px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader-logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            z-index: 10;
            box-shadow: 0 15px 35px rgba(61, 43, 31, 0.15);
            border: 3px solid #fff;
            animation: pulse 2.5s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); filter: brightness(1); }
            50% { transform: scale(1.03); filter: brightness(1.05); }
        }

        .rotating-text {
            position: absolute;
            width: 100%;
            height: 100%;
            animation: rotateText 12s linear infinite;
        }

        @keyframes rotateText {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .rotating-text span {
            position: absolute;
            left: 50%;
            transform-origin: 0 110px; /* Radius of the circle */
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 0.75rem;
            color: var(--accent-gold);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Rest of UI Styles */
        .navbar { 
            padding: 1.8rem 0; 
            transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1); 
            background: transparent !important;
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.96) !important;
            backdrop-filter: blur(20px);
            padding: 1rem 0;
            box-shadow: 0 10px 40px rgba(61, 43, 31, 0.06) !important;
            border-bottom: 1px solid rgba(176, 141, 87, 0.1);
        }

        /* Adjust link colors for transparency over dark backgrounds (Home Page) */
        body.is-home .navbar:not(.scrolled) .nav-link,
        body.is-home .navbar:not(.scrolled) .navbar-brand,
        body.is-home .navbar:not(.scrolled) .navbar-brand small,
        body.is-home .navbar:not(.scrolled) .bi-bag,
        body.is-home .navbar:not(.scrolled) .bi-list {
            color: #fff !important;
        }

        .nav-link {
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--accent-gold) !important;
        }

        .navbar-brand { 
            font-family: 'Outfit', sans-serif; 
            font-weight: 800; 
            color: var(--primary-mocha) !important; 
            letter-spacing: -0.5px;
        }

        .btn-primary { 
            background: var(--primary-mocha); 
            color: #fff;
            border: none; 
            padding: 14px 32px; 
            border-radius: 100px; 
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 10px 25px rgba(61, 43, 31, 0.15);
            transition: all 0.4s ease;
        }

        .btn-primary:hover {
            background: var(--accent-gold);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(176, 141, 87, 0.25);
            color: #fff;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-mocha);
            color: var(--primary-mocha);
            border-radius: 100px;
            font-weight: 700;
            padding: 12px 30px;
            transition: all 0.3s ease;
            box-shadow: none;
        }

        .btn-primary:hover, .btn-outline-primary:hover, 
        .btn-primary:active, .btn-outline-primary:active,
        .btn-primary:focus, .btn-outline-primary:focus {
            background: var(--accent-gold) !important;
            border-color: var(--accent-gold) !important;
            color: #fff !important;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(176, 141, 87, 0.25) !important;
        }

        /* Fix Bootstrap Focus Outline */
        .btn:focus, .btn-check:focus + .btn {
            box-shadow: 0 0 0 0.25rem rgba(176, 141, 87, 0.25) !important;
            outline: none !important;
        }

        .btn-primary:focus {
            box-shadow: 0 0 0 0.25rem rgba(61, 43, 31, 0.25) !important;
        }

        .card { 
            border: 1px solid rgba(176, 141, 87, 0.08); 
            border-radius: 30px; 
            background: #fff; 
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .main-content { min-height: 80vh; padding-top: 0; padding-bottom: 100px; }
        .footer { 
            background: var(--primary-mocha); 
            border-radius: 80px 80px 0 0; 
            padding: 100px 0 60px; 
            color: #fff; 
            margin-top: 80px; 
        }
        .section-padding { padding: 120px 0; }
        #cart-counter { 
            background: var(--accent-gold); 
            color: #fff; 
            font-size: 0.65rem; 
            padding: 3px 7px; 
            border-radius: 50px; 
            border: 2px solid #fff; 
            font-weight: 800;
        }

        .text-primary { color: var(--accent-gold) !important; }
        
        .sidebar-card { 
            border-radius: 30px; 
            padding: 30px; 
            background: #fff; 
            box-shadow: 0 15px 45px rgba(61, 43, 31, 0.04);
            border: 1px solid rgba(176, 141, 87, 0.1);
        }

        .sidebar-link {
            display: flex; align-items: center; padding: 15px 25px; margin-bottom: 10px; border-radius: 20px;
            text-decoration: none; color: var(--text-dark); font-weight: 600; transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .sidebar-link:hover {
            background: rgba(176, 141, 87, 0.05);
            color: var(--accent-gold);
        }

        .sidebar-link.active { 
            background: var(--primary-mocha); 
            color: #fff !important; 
            box-shadow: 0 10px 25px rgba(61, 43, 31, 0.2); 
        }

        /* Mobile Optimization */
        @media (max-width: 991.98px) {
            .navbar { padding: 1rem 0 !important; background: #fff !important; box-shadow: 0 5px 20px rgba(0,0,0,0.05) !important; }
            body.is-home .navbar:not(.scrolled) .nav-link,
            body.is-home .navbar:not(.scrolled) .navbar-brand,
            body.is-home .navbar:not(.scrolled) .bi-bag,
            body.is-home .navbar:not(.scrolled) .bi-list { color: var(--primary-mocha) !important; }
            .navbar-collapse { background: #fff; margin-top: 15px; border-radius: 24px; padding: 20px; box-shadow: 0 15px 30px rgba(0,0,0,0.1); border: 1px solid rgba(176, 141, 87, 0.1); }
            .section-padding { padding: 60px 0; }
            .display-1 { font-size: 3rem !important; }
            .display-4 { font-size: 2.2rem !important; }
            .display-5 { font-size: 1.8rem !important; }
            .footer { border-radius: 40px 40px 0 0; padding: 60px 0 40px; }
            .main-content { padding-top: 80px; }
            body.is-home .main-content { padding-top: 0; }
        }

        @media (max-width: 575.98px) {
            .container { padding-left: 25px; padding-right: 25px; }
            .btn-lg { width: 100%; margin-bottom: 10px; }
            .card { border-radius: 24px; }
        }

        /* Modernized SweetAlert2 Styling */
        .swal2-popup.premium-swal {
            border-radius: 24px !important;
            padding: 2.5rem 1.5rem !important;
            background: #ffffff !important;
            border: none !important;
            box-shadow: 0 25px 80px rgba(61, 43, 31, 0.18) !important;
        }

        .swal2-title {
            font-family: 'Outfit', sans-serif !important;
            font-weight: 800 !important;
            color: var(--primary-mocha) !important;
            font-size: 1.75rem !important;
            margin-bottom: 0.5rem !important;
        }

        .swal2-html-container {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            color: #555 !important;
            font-size: 1.05rem !important;
            line-height: 1.6 !important;
        }

        .swal2-icon {
            border-width: 3px !important;
            margin: 0 auto 1.5rem !important;
        }

        .swal2-actions {
            margin-top: 2rem !important;
            gap: 12px !important;
        }

        .swal2-confirm.premium-confirm {
            background: var(--primary-mocha) !important;
            color: #ffffff !important;
            border-radius: 100px !important;
            padding: 14px 40px !important;
            font-weight: 700 !important;
            font-size: 1rem !important;
            letter-spacing: 0.5px !important;
            transition: all 0.3s ease !important;
            border: none !important;
        }

        .swal2-confirm.premium-confirm:hover {
            background: var(--accent-gold) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 20px rgba(176, 141, 87, 0.2) !important;
        }

        .swal2-cancel.premium-cancel {
            background: #f1f1f1 !important;
            color: #444 !important;
            border-radius: 100px !important;
            padding: 14px 40px !important;
            font-weight: 700 !important;
            font-size: 1rem !important;
            transition: all 0.3s ease !important;
            border: none !important;
        }

        .swal2-cancel.premium-cancel:hover {
            background: #e5e5e5 !important;
        }

        /* Sileo-Inspired Premium Notification - Glassmorphism & Pill Shape */
        .swal2-popup.swal2-toast.premium-toast {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(20px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
            border-radius: 100px !important;
            padding: 10px 24px !important;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
            margin-top: 15px !important;
            min-width: 300px !important;
            display: flex !important;
            align-items: center !important;
            overflow: visible !important;
        }

        /* Physics-based entry animation that doesn't break SweetAlert's exit */
        div:where(.swal2-container).swal2-backdrop-show .premium-toast {
            animation: sileo-bounce 0.6s cubic-bezier(0.2, 0.9, 0.3, 1.1) forwards;
        }

        @keyframes sileo-bounce {
            0% { transform: translateY(-20px) scale(0.9); opacity: 0; }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }

        .swal2-toast .swal2-title {
            color: #1d1d1f !important;
            font-size: 0.95rem !important;
            font-weight: 600 !important;
            margin: 0 10px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            letter-spacing: -0.2px !important;
            padding: 0 !important;
        }

        /* Fix broken icon animations & alignment */
        .swal2-toast .swal2-icon {
            margin: 0 !important;
            min-width: 24px !important;
            height: 24px !important;
            width: 24px !important;
            border: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: visible !important;
        }

        /* High-Definition SVG Success Icon (Sileo/iOS Style) */
        .swal2-toast .swal2-icon.swal2-success {
            background-color: #34c759 !important; /* iOS Green */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23ffffff' viewBox='0 0 16 16'%3E%3Cpath d='M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.446z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: 60% !important;
            border-radius: 50% !important;
            border: none !important;
        }

        /* High-Definition SVG Error Icon (Sileo/iOS Style) */
        .swal2-toast .swal2-icon.swal2-error {
            background-color: #ff3b30 !important; /* iOS Red */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23ffffff' viewBox='0 0 16 16'%3E%3Cpath d='M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: 50% !important;
            border-radius: 50% !important;
            border: none !important;
        }

        /* Disable all SWAL default icon junk and pseudo-elements */
        .swal2-toast .swal2-icon::before,
        .swal2-toast .swal2-icon::after,
        .swal2-toast .swal2-icon *,
        .swal2-toast .swal2-icon *::before,
        .swal2-toast .swal2-icon *::after {
            display: none !important;
            content: none !important;
        }

        .swal2-timer-progress-bar {
            background: rgba(0, 0, 0, 0.05) !important;
            height: 2px !important;
            border-radius: 100px !important;
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
                    <a class="nav-link position-relative" href="<?= base_url('cart') ?>">
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
    const text = "PACUDAN'S BAKESHOP & COFFEE BAR • ";
    const container = document.getElementById('rotatingText');
    for (let i = 0; i < text.length; i++) {
        let span = document.createElement('span');
        span.innerHTML = text[i];
        span.style.transform = `rotate(${i * (360 / text.length)}deg)`;
        container.appendChild(span);
    }

    AOS.init({ duration: 800, once: true });
    
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        preloader.style.opacity = '0';
        setTimeout(() => { preloader.style.visibility = 'hidden'; }, 500);
    });

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
            title: '<?= session()->getFlashdata('msg') ?>'
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        Toast.fire({
            icon: 'error',
            title: '<?= session()->getFlashdata('error') ?>'
        });
    <?php endif; ?>
</script>
</body>
</html>

