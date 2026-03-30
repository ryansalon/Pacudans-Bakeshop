<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="position-relative overflow-hidden p-5 text-center bg-light" style="background: url('<?= base_url('assets/images/logo_and_bg/cafe-bg.jpg') ?>') no-repeat center center; background-size: cover; min-height: 90vh; display: flex; align-items: center; border-radius: 0 0 80px 80px; position: relative;">
    <!-- Darker Overlay for better text readability -->
    <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: linear-gradient(to bottom, rgba(78, 52, 46, 0.85), rgba(78, 52, 46, 0.4));"></div>
    
    <div class="container py-5 position-relative text-white" style="z-index: 2;">
        <div data-aos="fade-down" data-aos-duration="1000">
            <h6 class="text-uppercase fw-bold mb-3 tracking-widest text-warning" style="letter-spacing: 4px;">Welcome to</h6>
            <h1 class="display-1 fw-bold mb-4">Pacudan's <br><span class="text-warning">Bakeshop & Coffee Bar</span></h1>
        </div>
        
        <p class="lead mb-5 col-lg-8 mx-auto opacity-90 fw-light" data-aos="fade-up" data-aos-delay="200">
            Your chill coffee place in Mambajao, Camiguin. Savor our handcrafted Coffee, Tea, Frappes, and Smoothies, or indulge in our fresh Breads, Cakes, and specially Customized Cakes made just for your celebrations.
        </p>
        
        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center" data-aos="fade-up" data-aos-delay="400">
            <a href="<?= base_url('menu') ?>" class="btn btn-primary btn-lg px-5 shadow-lg rounded-pill text-white">Explore Our Menu</a>
            <a href="#about" class="btn btn-outline-light btn-lg px-5 rounded-pill border-2">Our Story</a>
            <a href="#location" class="btn btn-outline-light btn-lg px-5 rounded-pill border-2">Find Us</a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="section-padding">
    <div class="container">
        <div class="row g-5 text-center">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="card p-5 h-100 border-0 shadow-sm hover-scale">
                    <div class="bg-soft rounded-circle d-inline-flex align-items-center justify-content-center mb-4 mx-auto shadow-sm text-primary" style="width: 90px; height: 90px; background: #fff;">
                        <i class="bi bi-award fs-1"></i>
                    </div>
                    <h4 class="fw-bold">Premium Quality</h4>
                    <p class="text-muted mb-0">We use only the finest organic ingredients sourced from local farmers to ensure every bite is perfect.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card p-5 h-100 border-0 shadow-sm hover-scale">
                    <div class="bg-soft rounded-circle d-inline-flex align-items-center justify-content-center mb-4 mx-auto shadow-sm text-primary" style="width: 90px; height: 90px; background: #fff;">
                        <i class="bi bi-cup-hot fs-1"></i>
                    </div>
                    <h4 class="fw-bold">Expert Baristas</h4>
                    <p class="text-muted mb-0">Our coffee is brewed by professionals who understand the art of the perfect roast and pour.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                <div class="card p-5 h-100 border-0 shadow-sm hover-scale">
                    <div class="bg-soft rounded-circle d-inline-flex align-items-center justify-content-center mb-4 mx-auto shadow-sm text-primary" style="width: 90px; height: 90px; background: #fff;">
                        <i class="bi bi-truck fs-1"></i>
                    </div>
                    <h4 class="fw-bold">Fast Delivery</h4>
                    <p class="text-muted mb-0">Order online and enjoy our fresh treats delivered straight to your doorstep within minutes.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daily Recommendations (Random) -->
<div class="section-padding bg-white position-relative" style="border-radius: 80px 80px 0 0;">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5" data-aos="fade-right">
            <div>
                <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Daily Surprises</h6>
                <h2 class="display-5 mb-0 fw-bold">Today is <?= $current_day ?>, <br><span class="text-primary">the go-to for today!</span></h2>
            </div>
            <a href="<?= base_url('menu') ?>" class="btn btn-outline-primary rounded-pill px-4 mt-3 mt-md-0">View Full Menu <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
        
        <?php if (empty($featured_products)): ?>
            <div class="text-center py-5 bg-soft rounded-5" data-aos="zoom-in">
                <i class="bi bi-cup-straw display-1 opacity-10"></i>
                <p class="mt-4 text-muted">Our kitchen is busy preparing... check back soon!</p>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php foreach ($featured_products as $index => $product): ?>
                    <div class="col" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="card h-100 p-3 border-0 shadow-sm">
                            <div class="position-relative overflow-hidden rounded-4">
                                <?php if ($product['image_url']): ?>
                                    <img src="<?= base_url($product['image_url']) ?>" class="card-img-top w-100 object-fit-cover transition-transform" alt="<?= esc($product['name']) ?>" style="height: 240px;">
                                <?php else: ?>
                                    <div class="bg-soft text-muted text-center py-5 h-100 d-flex flex-column justify-content-center" style="min-height: 240px;">
                                        <i class="bi bi-image fs-1 opacity-10"></i>
                                    </div>
                                <?php endif; ?>
                                <span class="badge bg-white text-dark position-absolute top-0 end-0 m-3 shadow-sm px-3 py-2 fw-bold">₱<?= number_format($product['price'], 2) ?></span>
                            </div>
                            <div class="card-body px-2 pt-4 text-center">
                                <h5 class="card-title fw-bold mb-2 text-truncate"><?= esc($product['name']) ?></h5>
                                <a href="<?= base_url('menu/' . $product['product_id']) ?>" class="btn btn-primary rounded-pill w-100 shadow-sm mt-3">Order Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- About Section -->
<div id="about" class="section-padding bg-white pb-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <img src="<?= base_url('assets/images/logo_and_bg/pacudan_bg.jpg') ?>" class="img-fluid rounded-5 shadow-2xl" alt="About Us" style="border-radius: 60px; height: 500px; width: 100%; object-fit: cover;">
                    <div class="position-absolute top-50 start-100 translate-middle d-none d-lg-block" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card p-4 shadow-lg border-0 bg-white rounded-4 text-center" style="width: 200px;">
                            <h2 class="fw-bold text-primary mb-0">100%</h2>
                            <p class="small text-muted mb-0">Made WIth Love</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ps-lg-5" data-aos="fade-left">
                <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Our Story</h6>
                <h2 class="display-4 mb-4 fw-bold">Baked with Passion, <br>Served with Love</h2>
                <p class="lead text-muted mb-4">Pacudan's Bakeshop & Coffee Bar started as a small family dream. Today, we are proud to be your favorite neighborhood spot for morning coffee and sweet celebrations.</p>
                
                <div class="row g-4 mb-5">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-2 me-3"><i class="bi bi-heart-fill"></i></div>
                            <span class="fw-bold">Family Recipes</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-2 me-3"><i class="bi bi-star-fill"></i></div>
                            <span class="fw-bold">Top Rated</span>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-outline-primary btn-lg rounded-pill px-5">Learn More</a>
            </div>
        </div>
    </div>
</div>

<!-- Visit Us Section -->
<div id="location" class="section-padding bg-soft" style="border-radius: 80px 80px 0 0;">
    <div class="container">
        <div class="text-center mb-5 reveal" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase mb-2 tracking-widest" style="letter-spacing: 2px;">Find Us</h6>
            <h2 class="display-5 mb-0 fw-bold">Visit Our Shop</h2>
            <p class="text-muted mt-3 col-lg-6 mx-auto">Come and experience the aroma of fresh coffee and newly baked pastries in person.</p>
        </div>

        <div class="row g-5 align-items-center mt-4">
            <div class="col-lg-5 reveal" data-aos="fade-right">
                <div class="card p-5 border-0 shadow-lg rounded-5 bg-white h-100">
                    <div class="mb-5">
                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-primary text-white rounded-circle p-3 me-4 shadow-sm">
                                <i class="bi bi-geo-alt fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Our Location</h5>
                                <p class="text-muted mb-0">Mambajao, Camiguin Island, Philippines</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="bg-primary text-white rounded-circle p-3 me-4 shadow-sm">
                                <i class="bi bi-clock fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Operating Hours</h5>
                                <p class="text-muted mb-0">Monday - Sunday<br>8:00 AM - 9:00 PM</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <div class="bg-primary text-white rounded-circle p-3 me-4 shadow-sm">
                                <i class="bi bi-envelope fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">Contact Us</h5>
                                <p class="text-muted mb-0">pacudanscoffee@gmail.com<br>0963 921 6585</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 reveal" data-aos="fade-left">
                <div class="card p-2 border-0 shadow-lg rounded-5 bg-white overflow-hidden position-relative" style="height: 500px;">
                    <!-- Embedded Google Map - With Pinpoint and Scroll Disabled -->
                    <iframe 
                        src="https://maps.google.com/maps?q=Pacudan's%20Bakeshop,%20Mambajao,%20Camiguin&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                        width="100%" 
                        height="100%" 
                        style="border:0; border-radius: 40px; pointer-events: none;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                    <!-- Overlay to prevent accidental interactions but allow clicking 'View Larger Map' if the iframe had it (pointer-events: none on iframe is safer for scroll) -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-transform { transition: transform 0.5s ease; }
    .card:hover .transition-transform { transform: scale(1.05); }
</style>

<?= $this->endSection() ?>
