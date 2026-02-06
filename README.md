# QR Cafe Project Documentation

## Table of Contents
1. [Project Overview](#project-overview)
2. [Tech Stack](#tech-stack)
3. [Architecture](#architecture)
4. [Backend Documentation](#backend-documentation)
5. [Frontend & UI/UX](#frontend--uiux)
6. [Payment Integration (Midtrans)](#payment-integration-midtrans)
7. [Database Schema](#database-schema)
8. [Setup & Deployment](#setup--deployment)

---

## Project Overview
**QR Cafe** is a web-based ordering system designed for cafes. It allows customers to browse the menu, add items to a cart, and pay directly via QRIS (Midtrans) without logging in. The system also includes a comprehensive Admin Dashboard for managing menu items, orders, and viewing sales statistics.

---

## Tech Stack
*   **Framework:** Laravel 12 (PHP)
*   **Frontend:** Blade Templates, TailwindCSS (via CDN/local build), JavaScript (Alpine.js/Vanilla)
*   **Database:** MySQL
*   **Payment Gateway:** Midtrans (Snap API)
*   **Server Environment:** PHP 8.2+, Composer, Node.js (for asset compilation)

---

## Architecture
The project follows the standard **MVC (Model-View-Controller)** pattern provided by Laravel.

*   **Models:** Handle database interactions (Eloquent ORM).
*   **Views:** Blade templates for rendering UI.
*   **Controllers:** Handle business logic and request processing.
*   **Routes:** Defined in `routes/web.php`.
*   **Middleware:** `AdminMiddleware` for role-based access control.

---

## Backend Documentation
For detailed backend documentation, please refer to the specific files in the `docs/` directory:

1.  **[Backend Developer Guide](docs/backend-developer.md)**: Technical details on controllers, routing, data models, and server-side logic.
2.  **[Roles & Permissions](docs/backend-roles.md)**: Explanation of the RBAC system (Guest vs. Admin vs. System).

### Key Features
*   **Session-Based Cart:** Guests can shop without creating an account.
*   **Order Number Generation:** Auto-incrementing daily order numbers (e.g., `ORD-20231027-001`).
*   **Admin Dashboard:** Secure area for staff to manage operations.

---

## Frontend & UI/UX
The frontend is built using **Blade Templates** integrated with **TailwindCSS**.

### Public Pages
*   **Home:** Landing page with featured items.
*   **Menu:** Full product list with category filtering.
*   **Cart:** Manage selected items.
*   **Checkout:** Enter customer details (Name, Table Number, WhatsApp).
*   **Payment:** Midtrans Snap popup for payment execution.

### Admin Pages
*   **Login:** Secure entry point.
*   **Dashboard:** Statistics overview.
*   **Menu Management:** Forms for adding/editing products and uploading images.
*   **Order Management:** Lists for active and historical orders with status controls.

---

## Payment Integration (Midtrans)
The system uses **Midtrans Snap** for seamless payments.

### Workflow
1.  **Token Generation:** When a user clicks "Pay", `PaymentController@getSnapToken` calls Midtrans API to get a `snap_token`.
2.  **Popup:** The Snap.js library uses the token to show the payment popup.
3.  **Payment:** User completes payment (QRIS, E-Wallet, etc.).
4.  **Webhook:** Midtrans sends a POST request to `/payment/webhook`.
5.  **Status Update:** The webhook handler verifies the signature and updates the local order status to `'paid'`.

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
