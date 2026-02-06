# Backend Roles & Permissions Documentation

This document outlines the backend roles, their permissions, and the architectural implementation of access control in the application.

## 1. Overview
The application utilizes a simple Role-Based Access Control (RBAC) system with two primary human roles and one system actor:
1.  **Guest / Customer (Public)**
2.  **Administrator (Admin)**
3.  **System / Payment Gateway (Midtrans)**

## 2. Roles Detail

### 2.1. Guest / Customer (Public)
*   **Description:** Unauthenticated users visiting the cafe website.
*   **Access Level:** Public. No login required.
*   **Authentication:** None. Session-based cart management.
*   **Capabilities:**
    *   **View Content:** Browse Home, About, Contact, and Menu pages.
    *   **Cart Operations:** Add, update, and remove items from the shopping cart (stored in session).
    *   **Checkout:** Place orders (creates `Order` record).
    *   **Payment:** Initiate payments via Midtrans Snap (QRIS/E-Wallet).
*   **Key Controllers:**
    *   `App\Http\Controllers\HomeController`
    *   `App\Http\Controllers\MenuController`
    *   `App\Http\Controllers\CartController`
    *   `App\Http\Controllers\PaymentController` (Token generation)
*   **Routes:** `/`, `/menu`, `/keranjang`, `/process-payment`, `/payment/snap-token`.

### 2.2. Administrator (Admin)
*   **Description:** Store managers or staff responsible for menu and order management.
*   **Access Level:** Protected. Requires authentication and specific role.
*   **Authentication:** Standard Laravel Auth (Session).
*   **Authorization:**
    *   **Middleware:** `auth` AND `admin` (Alias for `App\Http\Middleware\AdminMiddleware`).
    *   **Logic:** Checks if `auth()->user()->role === 'admin'`.
*   **Capabilities:**
    *   **Dashboard:** View business statistics (total orders, revenue, menu counts).
    *   **Menu Management:** Full CRUD (Create, Read, Update, Delete) for Categories and Products.
        *   Upload product images.
        *   Toggle product availability.
    *   **Order Management:**
        *   View active orders and order history.
        *   Update order status (Cancel, Complete).
        *   *Note: Payment confirmation is now automated via Midtrans, but manual overrides exist.*
*   **Key Controllers:**
    *   `App\Http\Controllers\Admin\AuthController`
    *   `App\Http\Controllers\Admin\DashboardController`
    *   `App\Http\Controllers\Admin\MenuController`
    *   `App\Http\Controllers\Admin\OrderController`
*   **Routes Prefix:** `/admin/*`

### 2.3. System / Payment Gateway (Midtrans)
*   **Description:** Automated webhook interactions from the Midtrans Payment Gateway.
*   **Access Level:** Public endpoint, secured by logic.
*   **Authentication:** None (Server-to-Server).
*   **Security:**
    *   **CSRF Exclusion:** The `/payment/webhook` route is excluded from CSRF protection in `bootstrap/app.php`.
    *   **Validation:** Logic validates the existence of the order and the transaction status.
*   **Capabilities:**
    *   **Update Order Status:** Automatically marks orders as `'paid'` upon receiving `settlement` or `capture` notifications.
    *   **Update Transaction Data:** Stores `transaction_id` and `transaction_status` in the `orders` table.
*   **Key Controller:** `App\Http\Controllers\PaymentController@webhook`

## 3. Implementation Details

### Database Schema (Users)
The role is stored in the `users` table:
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(255) DEFAULT 'user', -- 'admin' or 'user' (customer)
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Middleware (`AdminMiddleware.php`)
Ensures strictly typed access control:
```php
public function handle(Request $request, Closure $next): Response
{
    // Check if user is logged in AND has 'admin' role
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        return redirect()->route('admin.login')->with('error', 'Anda tidak memiliki akses');
    }

    return $next($request);
}
```

### Route Protection
Routes are grouped in `routes/web.php` for clarity and security:
```php
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes (Login)
    Route::middleware('guest')->group(function () { ... });

    // Protected Admin routes
    Route::middleware(['auth', 'admin'])->group(function () {
        // Dashboard, Menu, Orders
    });
});
```
