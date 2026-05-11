<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('menu', 'Product::index');
$routes->get('menu/(:num)', 'Product::show/$1');
$routes->get('category/(:num)', 'Product::category/$1');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');
$routes->get('logout', 'Auth::logout');

$routes->get('cart', 'Cart::index');
$routes->post('cart/add', 'Cart::add');
$routes->get('cart/remove/(:any)', 'Cart::remove/$1');
$routes->post('cart/update', 'Cart::update');
$routes->get('checkout', 'Cart::checkout');
$routes->post('checkout/process', 'Cart::processCheckout');
$routes->get('profile', 'Auth::profile');
$routes->get('profile/order/(:num)', 'Auth::orderDetail/$1');

$routes->get('favorites', 'Favorites::index');
$routes->post('favorites/toggle/(:num)', 'Favorites::toggle/$1');
$routes->get('favorites/remove/(:num)', 'Favorites::remove/$1');
$routes->get('favorites/check/(:num)', 'Favorites::check/$1');
$routes->get('api/notifications/user', 'Home::checkOrderStatus');
$routes->get('api/notifications/count', 'Home::getNotificationCount');
$routes->get('api/notifications/unread', 'NotificationController::fetchUnread');
$routes->post('api/notifications/mark-read/(:num)', 'NotificationController::markAsRead/$1');
$routes->post('api/notifications/mark-all-read', 'NotificationController::markAllAsRead');
$routes->post('api/notifications/delete/(:num)', 'NotificationController::delete/$1');

$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    $routes->get('/', 'Admin::index');
    $routes->get('notifications', 'Admin::checkNewOrders');
    $routes->get('products', 'Admin::products');
    $routes->get('products/add', 'Admin::addProduct');
    $routes->post('products/store', 'Admin::storeProduct');
    $routes->get('categories', 'Admin::categories');
    $routes->get('orders', 'Admin::orders');
    $routes->get('orders/(:num)', 'Admin::viewOrder/$1');
    $routes->post('orders/update-status', 'Admin::updateOrderStatus');
});
