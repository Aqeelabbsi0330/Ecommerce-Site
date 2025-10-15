# Ecommerce-Site

E-commerce API with Cart, Orders &amp; Payments Objective

# 🛒 E-Commerce API (Laravel Project)

## 🚀 Project Overview

This is a **fully functional e-commerce REST API** built with **Laravel 11**, designed to simulate a real-world online store.  
The system implements **JWT authentication**, **product management**, **shopping cart**, **order placement**, and **Stripe payment integration**.  
Only authenticated users can access protected routes, making it secure and production-ready.

---

## ⚙️ Features

-   **User Authentication & Authorization**
    -   JSON Web Token (JWT) based login & registration.
    -   Only logged-in users can access cart, orders, and payment endpoints.
-   **Product Management**
    -   Read-only product listing.
    -   Pre-populated products via factory/seeder.
-   **Shopping Cart**
    -   Add, update, or remove products.
    -   Each user has a personal cart.
-   **Order Management**
    -   Convert cart items into orders.
    -   Calculates total price and saves order items.
-   **Stripe Payment Integration**
    -   Test mode integration for secure payments.
    -   Generates PaymentIntent and returns client_secret to frontend.
-   **Secure & Validated**
    -   Stock validation before order creation.
    -   Proper error handling with HTTP status codes.

---

## 📦 Database Design

| Table         | Description                                               |
| ------------- | --------------------------------------------------------- |
| `users`       | Stores user info: name, email, password (hashed)          |
| `products`    | Product details: name, description, price, stock          |
| `carts`       | Temporary cart storage linked to users                    |
| `orders`      | Stores confirmed user orders with total amount and status |
| `order_items` | Details of each product in an order                       |

All tables use **foreign keys** to maintain relational integrity.

---

## 🔑 Authentication

-   Users register and log in to receive a **JWT token**.
-   Token is required to access **protected routes**:
    -   `/cart`
    -   `/orders`
    -   `/payments/checkout`

---

## 🛍 Shopping Cart & Orders

### 🧺 Cart Operations

| Method   | Endpoint            | Description               |
| -------- | ------------------- | ------------------------- |
| `POST`   | `/cart/add`         | Add product with quantity |
| `PUT`    | `/cart/update/{id}` | Update product quantity   |
| `DELETE` | `/cart/remove/{id}` | Remove product from cart  |
| `GET`    | `/cart`             | View current cart         |

### 📦 Order Operations

| Method | Endpoint         | Description                               |
| ------ | ---------------- | ----------------------------------------- |
| `POST` | `/orders/create` | Convert cart to order and calculate total |
| `GET`  | `/orders`        | View order history                        |

-   Validates stock before order creation.
-   Saves order items in `order_items` table.
-   Updates order status after successful payment.

---

## 💳 Stripe Payment Integration

-   Stripe is integrated in **Test Mode**.
-   Backend creates a **PaymentIntent** with total amount.
-   API returns `client_secret` to frontend for payment confirmation.
-   Payments are processed securely without storing card details.

## My routes

//
Route::post('/register', [UserController::class, 'register']);

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::middleware('jwt')->group(function () {
Route::post('/add-product', [ProductController::class, 'store']);
Route::get('/all-products', [ProductController::class, 'allProducts']);
//one Product
Route::get('/product/{id}', [ProductController::class, 'oneProduct']);
//update product
Route::put('/update-product/{id}', [ProductController::class, 'updateProduct']);
//

    //cart
    // add to cart
    Route::post('/add-to-cart', [CartController::class, 'store']); //if not exist it add to
    // card it exist it increase its quantity
    //view cart
    Route::get('/view-cart', [CartController::class, 'viewCart']);
    //remove from cart
    Route::delete('/remove-from-cart/{id}', [CartController::class, 'deleteCartItem']);
    //create Order
    Route::post('/add-order', [OrderController::class, 'store']);
    Route::get('/view-order', [OrderController::class, 'viewOrder']);
    Route::post('/payment', [PaymentController::class, 'processPayment']);

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com/)**
-   **[Tighten Co.](https://tighten.co)**
-   **[WebReinvent](https://webreinvent.com/)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
-   **[Cyber-Duck](https://cyber-duck.co.uk)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Jump24](https://jump24.co.uk)**
-   **[Redberry](https://redberry.international/laravel/)**
-   **[Active Logic](https://activelogic.com)**
-   **[byte5](https://byte5.de)**
-   **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
