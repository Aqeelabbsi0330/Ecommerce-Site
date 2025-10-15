# Ecommerce-Site
 E-commerce API with Cart, Orders &amp; Payments Objective
# 🛒 E-Commerce API (Laravel Project)

## 🚀 Project Overview
This is a **fully functional e-commerce REST API** built with **Laravel 11**, designed to simulate a real-world online store.  
The system implements **JWT authentication**, **product management**, **shopping cart**, **order placement**, and **Stripe payment integration**.  
Only authenticated users can access protected routes, making it secure and production-ready.

---

## ⚙️ Features
- **User Authentication & Authorization**
  - JSON Web Token (JWT) based login & registration.
  - Only logged-in users can access cart, orders, and payment endpoints.
- **Product Management**
  - Read-only product listing.
  - Pre-populated products via factory/seeder.
- **Shopping Cart**
  - Add, update, or remove products.
  - Each user has a personal cart.
- **Order Management**
  - Convert cart items into orders.
  - Calculates total price and saves order items.
- **Stripe Payment Integration**
  - Test mode integration for secure payments.
  - Generates PaymentIntent and returns client_secret to frontend.
- **Secure & Validated**
  - Stock validation before order creation.
  - Proper error handling with HTTP status codes.

---

## 📦 Database Design
| Table | Description |
|-------|-------------|
| `users` | Stores user info: name, email, password (hashed) |
| `products` | Product details: name, description, price, stock |
| `carts` | Temporary cart storage linked to users |
| `orders` | Stores confirmed user orders with total amount and status |
| `order_items` | Details of each product in an order |

All tables use **foreign keys** to maintain relational integrity.

---

## 🔑 Authentication
- Users register and log in to receive a **JWT token**.  
- Token is required to access **protected routes**:
  - `/cart`
  - `/orders`
  - `/payments/checkout`

---

## 🛍 Shopping Cart & Orders

### 🧺 Cart Operations
| Method | Endpoint | Description |
|---------|-----------|-------------|
| `POST` | `/cart/add` | Add product with quantity |
| `PUT` | `/cart/update/{id}` | Update product quantity |
| `DELETE` | `/cart/remove/{id}` | Remove product from cart |
| `GET` | `/cart` | View current cart |

### 📦 Order Operations
| Method | Endpoint | Description |
|---------|-----------|-------------|
| `POST` | `/orders/create` | Convert cart to order and calculate total |
| `GET` | `/orders` | View order history |

- Validates stock before order creation.
- Saves order items in `order_items` table.
- Updates order status after successful payment.

---

## 💳 Stripe Payment Integration
- Stripe is integrated in **Test Mode**.  
- Backend creates a **PaymentIntent** with total amount.  
- API returns `client_secret` to frontend for payment confirmation.  
- Payments are processed securely without storing card details.

## My routes
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

