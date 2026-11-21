# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

- **Primary customers:** Mambajao and Camiguin Island locals ordering daily coffee, iced drinks, frappes, pastries, and whole celebration cakes for delivery or quick pickup.
- **Secondary users:** Café staff and owners operating the admin panel to monitor daily sales, manage product stock/pricing, and fulfill incoming orders.

## Product Purpose

Make ordering daily coffee, fresh baked pastries, and celebration cakes from Pacudan's Bakeshop & Coffee Bar fast, trustworthy, and effortless from both mobile phones and desktops—while giving staff an efficient dashboard to track orders and stock in real time.

## Positioning

A neighborhood Camiguin bakeshop and coffee bar combining morning Filipino breads and custom celebration cakes (Ube Custard, Choco Moist, Brazo Cupcakes, Cheese Ensaymada) with a full hot/iced espresso and frappe bar—ordered directly online with free local Cash-on-Delivery and real-time counter status updates.

## Operating Context

- **Location & hours:** Mambajao, Camiguin Island, Philippines; open daily 8:00 AM – 9:00 PM (`0963 921 6585`, `pacudanscoffee@gmail.com`).
- **Core customer flows:** Discover daily picks on Home → browse/search 7 menu categories → select drink size variants & quantity → save favorites → add to cart or direct-order checkout (Cash on Delivery) → receive live order completion notifications and inspect order history.
- **Core staff flows:** Monitor revenue and top/bottom selling items on Dashboard → review and update pending orders (`pending` → `completed` / `cancelled`) with customer delivery address & phone → manage inventory stock, pricing, and product photos.

## Capabilities and Constraints

- **Stack:** Existing CodeIgniter 4 (PHP) MVC application in `TEST/` with MySQL database, Bootstrap 5, Bootstrap Icons, SweetAlert2, and Chart.js.
- **Payment:** Cash on Delivery (active); GCash is planned/not yet active.
- **Redesign scope:** Full visual redesign of the entire customer storefront (`Home`, `Menu`, `Product Detail`, `Cart`, `Checkout`, `Favorites`, `Profile`, `Order Detail`, `Login`, `Register`) plus a matching, disciplined Admin Panel (`Dashboard`, `Orders`, `Order View`, `Inventory`, `Add Product`).
- **Constraints:** Preserve all working routes, database schemas, cart/variant logic, COD checkout flow, inventory logging, and notification APIs.

## Brand Commitments

- **Name:** Pacudan's Bakeshop & Coffee Bar.
- **Preserved logo:** `TEST/public/assets/images/logo_and_bg/pacudans_logo.jpg`.
- **Authenticity rule:** No fabricated customer testimonials or invented quotes; replace placeholder quotes with real café highlights, menu truth, and verifiable shop facts.

## Evidence on Hand

- **Brand & venue photography:**
  - `TEST/public/assets/images/logo_and_bg/pacudans_logo.jpg`
  - `TEST/public/assets/images/logo_and_bg/cafe-bg.jpg`
  - `TEST/public/assets/images/logo_and_bg/pacudan_bg.jpg`
  - `TEST/public/assets/images/logo_and_bg/bg_2.jpg`
  - `TEST/public/assets/images/logo_and_bg/bg_3.jpg`
- **38 real product photographs** across `TEST/public/assets/images/` (`hot_drinks/`, `ice_coffee/`, `frappe/`, `smoothies/`, `cakes/`, `breads_and_pastries/`, `sandwich_and_savory/`).
- **Verified catalog:** 7 categories and 38 menu items with real Philippine Peso (`₱`) pricing in `TEST/app/Database/Seeds/MenuSeeder.php`.
- **Absences not to fabricate:** No verified third-party customer reviews or press quotes on hand; do not invent quotes or ratings.

## Product Principles

1. **Appetite and clarity first:** Real product photography and transparent Peso pricing lead every browsing surface so locals can pick their daily order in seconds.
2. **Zero-friction mobile ordering:** Every menu item, category filter, size selector, cart adjustment, and COD checkout step must work effortlessly with one thumb on a phone.
3. **Honest neighborhood proof:** Showcase real bakeshop offerings, daily hours, Mambajao location, and genuine product details instead of filler marketing claims or fake testimonials.
4. **Cohesive storefront-to-counter experience:** The storefront invites appetite and warmth, while the Admin Panel carries the same visual identity in a calm, high-clarity operational register.

## Accessibility & Inclusion

- Target WCAG AA text and interactive control contrast (≥4.5:1 normal text, ≥3:1 large text/UI components), visible keyboard focus, semantic landmarks, and touch-friendly controls across mobile and desktop viewports.
