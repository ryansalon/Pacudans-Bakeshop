<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<div class="section-padding">
    <div class="container">
        <div class="mb-5">
            <a href="<?= base_url('menu') ?>" class="btn btn-outline-primary rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-arrow-left me-2"></i> Back to Menu
            </a>
        </div>

        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="card p-2 border-0 shadow-lg rounded-5 overflow-hidden reveal">
                    <?php if ($product['image_url']): ?>
                        <img src="<?= base_url($product['image_url']) ?>" class="img-fluid rounded-5 shadow-sm" alt="<?= esc($product['name']) ?>" style="min-height: 400px; width: 100%; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-light text-muted text-center py-5 rounded-5 h-100 d-flex flex-column justify-content-center" style="min-height: 400px;">
                            <i class="bi bi-image fs-1 opacity-25"></i>
                            <h5 class="mt-3">No Image Available</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-lg-6 ps-lg-5 reveal" style="transition-delay: 0.2s;">
                <div class="mb-4">
                    <span class="badge-category mb-3 d-inline-block">Special Treat</span>
                    <h1 class="display-5 mb-2"><?= esc($product['name']) ?></h1>
                    
                    <!-- Dynamic Price Display -->
                    <p class="display-6 text-primary mb-4 fw-bold" id="main-price">
                        ₱<?= number_format(!empty($variants) ? $variants[0]['price'] : $product['price'], 2) ?>
                    </p>
                    
                    <p class="lead text-muted mb-5"><?= esc($product['description']) ?></p>
                </div>

                <div class="card p-4 border-0 shadow-sm bg-white rounded-4 mb-4">
                    <form id="addToCartForm" action="<?= base_url('cart/add') ?>" method="post">
                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                        <input type="hidden" name="buy_now" id="buy_now_flag" value="0">
                        
                        <!-- Variant / Size Selection -->
                        <?php if (!empty($variants)): ?>
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 1px;">Select Size:</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($variants as $index => $v): ?>
                                        <input type="radio" class="btn-check" name="variant_id" id="v-<?= $v['variant_id'] ?>" 
                                               value="<?= $v['variant_id'] ?>" 
                                               data-price="<?= $v['price'] ?>"
                                               <?= $index === 0 ? 'checked' : '' ?>>
                                        <label class="btn btn-outline-primary rounded-pill px-4" for="v-<?= $v['variant_id'] ?>">
                                            <?= esc($v['size_name']) ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="row align-items-center mb-4">
                            <div class="col-auto">
                                <label class="form-label mb-0 fw-bold">Quantity:</label>
                            </div>
                            <div class="col-auto">
                                <div class="input-group" style="width: 140px;">
                                    <button class="btn btn-outline-secondary rounded-start-pill" type="button" onclick="this.nextElementSibling.stepDown()"><i class="bi bi-dash"></i></button>
                                    <input type="number" name="quantity" id="product-qty" class="form-control text-center border-secondary" value="1" min="1">
                                    <button class="btn btn-outline-secondary rounded-end-pill" type="button" onclick="this.previousElementSibling.stepUp()"><i class="bi bi-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3" id="orderBtn" onclick="document.getElementById('buy_now_flag').value='1'">
                                <i class="bi bi-bag-check me-2"></i> Order Now
                            </button>
                            
                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-outline-primary w-100 rounded-pill py-2" id="addBtn" onclick="document.getElementById('buy_now_flag').value='0'">
                                        <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-secondary w-100 rounded-pill py-2" id="favBtn" onclick="toggleFavorite(<?= $product['product_id'] ?>)">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 bg-white rounded-4 border shadow-sm text-center">
                            <i class="bi bi-shield-check text-primary fs-3"></i>
                            <p class="small mb-0 mt-2">Quality Guaranteed</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white rounded-4 border shadow-sm text-center">
                            <i class="bi bi-lightning-charge text-primary fs-3"></i>
                            <p class="small mb-0 mt-2">Fresh Daily</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Handle Variant Selection and Price Update
const variantRadios = document.querySelectorAll('input[name="variant_id"]');
const mainPrice = document.getElementById('main-price');
const qtyInput = document.getElementById('product-qty');

variantRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        const price = parseFloat(this.getAttribute('data-price')).toFixed(2);
        mainPrice.innerText = '₱' + price;
    });
});

document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    // If it's a "Buy Now" (Order Now) click, don't use AJAX, let the form submit normally
    if (document.getElementById('buy_now_flag').value === '1') {
        return; 
    }
    
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    const submitBtn = document.getElementById('addBtn');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Adding...';
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const counter = document.getElementById('cart-counter');
            counter.innerText = data.cart_count;
            counter.classList.remove('d-none');
            
            Toast.fire({
                icon: 'success',
                title: 'Added to Cart!',
                text: data.message
            });
            
            submitBtn.innerHTML = '<i class="bi bi-check2 me-2"></i>Added!';
            submitBtn.classList.replace('btn-outline-primary', 'btn-success');
            submitBtn.classList.add('text-white');
            
            setTimeout(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                submitBtn.classList.replace('btn-success', 'btn-outline-primary');
                submitBtn.classList.remove('text-white');
            }, 2000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

// Check Favorite Status on Load
document.addEventListener('DOMContentLoaded', function() {
    <?php if (session()->get('isLoggedIn')): ?>
    fetch('<?= base_url('favorites/check/') ?><?= $product['product_id'] ?>')
        .then(response => response.json())
        .then(data => {
            const favBtn = document.getElementById('favBtn');
            if (data.isFavorite) {
                favBtn.innerHTML = '<i class="bi bi-heart-fill"></i>';
                favBtn.classList.replace('btn-outline-secondary', 'btn-primary');
                favBtn.classList.add('text-white');
            }
            
            // Also sync navbar counter on load
            const favCounter = document.getElementById('fav-counter');
            if (favCounter && data.fav_count !== undefined) {
                favCounter.innerText = data.fav_count;
                if (data.fav_count > 0) favCounter.classList.remove('d-none');
                else favCounter.classList.add('d-none');
                
                const innerBadge = document.querySelector('.fav-badge-inner');
                if (innerBadge) innerBadge.innerText = data.fav_count;
            }
        });
    <?php endif; ?>
});

function toggleFavorite(productId) {
    fetch('<?= base_url('favorites/toggle/') ?>' + productId, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Toast.fire({
                icon: 'success',
                title: data.action === 'added' ? 'Saved to Favorites!' : 'Removed from Favorites',
                text: data.message
            });
            
            // Sync Favorites Counter in Navbar
            const favCounter = document.getElementById('fav-counter');
            if (favCounter) {
                favCounter.innerText = data.fav_count;
                if (data.fav_count > 0) favCounter.classList.remove('d-none');
                else favCounter.classList.add('d-none');
                
                // Also update the inner badge in the dropdown if it exists
                const innerBadge = document.querySelector('.fav-badge-inner');
                if (innerBadge) innerBadge.innerText = data.fav_count;
            }
            
            const favBtn = document.getElementById('favBtn');
            if (data.action === 'added') {
                favBtn.innerHTML = '<i class="bi bi-heart-fill"></i>';
                favBtn.classList.replace('btn-outline-secondary', 'btn-primary');
                favBtn.classList.add('text-white');
            } else {
                favBtn.innerHTML = '<i class="bi bi-heart"></i>';
                favBtn.classList.replace('btn-primary', 'btn-outline-secondary');
                favBtn.classList.remove('text-white');
            }
        } else {
            if (data.redirect) {
                Swal.fire({
                    title: 'Login Required',
                    text: 'Please sign in to save your favorite treats!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sign In Now',
                    cancelButtonText: 'Maybe Later',
                    customClass: {
                        popup: 'premium-swal',
                        confirmButton: 'premium-confirm',
                        cancelButton: 'premium-cancel'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = data.redirect;
                    }
                });
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        }
    });
}
</script>

<?= $this->endSection() ?>
