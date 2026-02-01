# Backend Developer Documentation

## Scope & Responsibilities
- Own server-side logic, authentication/authorization, session management, and data modeling.
- Implement and maintain controllers, routes, middleware, Eloquent models, and business rules.
- Manage database schema via migrations and imports, ensuring data integrity and performance.
- Configure environment, session/queue backends, logging, and error handling.

## Architecture Overview
- Routing: routes/web.php
- Controllers (public): app/Http/Controllers/MenuController.php, app/Http/Controllers/CartController.php
- Controllers (admin): app/Http/Controllers/Admin/AuthController.php, Admin/DashboardController.php, Admin/MenuController.php, Admin/OrderController.php
- Middleware: app/Http/Middleware/AdminMiddleware.php (registered in bootstrap/app.php)
- Models: app/Models/Category.php, app/Models/Product.php, app/Models/Order.php, app/Models/User.php
- Database:
  - Migrations: database/migrations
  - Import dump: database/caffe.sql
- Configuration: config/app.php, config/database.php, config/session.php, config/queue.php
- Environment: .env

## Data Model
- Users
  - Role-based access: admin, customer (role present in DB).
  - Used by AdminMiddleware and admin auth flow.
  - Table: database/caffe.sql (users)
- Categories
  - Fields: name, slug, order, is_active.
  - Relations: Category hasMany Product ordered by `order`.
  - Model: app/Models/Category.php
- Products
  - Fields: category_id, name, slug, description, price, image, is_available, order.
  - Relations: Product belongsTo Category.
  - Accessors: formatted price, image URL.
  - Model: app/Models/Product.php
- Orders
  - Fields: order_number, customer_name, table_number, whatsapp, subtotal, discount, total, status, payment_method, items (JSON).
  - Generation: Order::generateOrderNumber for daily incremental numbers.
  - Model: app/Models/Order.php; migrations create table and add payment_method column.
- Sessions
  - Database-backed sessions (table `sessions`), configured via session.php and .env.
- Jobs & Queue
  - Database driver; tables jobs, job_batches, failed_jobs via migrations/dump.

## Routing & Endpoints
- Public Routes (routes/web.php)
  - `/` → HomeController@index
  - `/menu` → MenuController@index
  - Cart:
    - `/keranjang` → CartController@index
    - `/cart/add/{product}` → CartController@add
    - `/cart/update/{product}` → CartController@update
    - `/cart/remove/{product}` → CartController@remove
  - Order flow:
    - `/proceed-to-confirmation` → CartController@proceedToConfirmation
    - `/konfirmasi-pesanan` → CartController@confirmation
    - `/proceed-to-payment` → CartController@proceedToPayment
    - `/detail-pembayaran` → CartController@paymentDetail
    - `/process-payment` → CartController@processPayment
- Admin Routes (prefix `admin`, name `admin.`)
  - Guest:
    - `/admin/login` GET → AuthController@showLogin
    - `/admin/login` POST → AuthController@login
  - Protected (middleware: `auth`, `admin`):
    - `/admin/dashboard` → DashboardController@index
    - `/admin/logout` POST → AuthController@logout
    - Menu CRUD:
      - `/admin/menu` (index), `/admin/menu/create`, `/admin/menu` POST (store),
        `/admin/menu/{id}/edit`, `/admin/menu/{id}` PUT (update),
        `/admin/menu/{id}` DELETE (destroy), `/admin/menu/{id}/toggle` POST (availability)
    - Orders:
      - `/admin/orders` (active list)
      - `/admin/orders/history` (filters + stats)
      - `/admin/orders/{id}` (show)
      - `/admin/orders/{id}/confirm` POST
      - `/admin/orders/{id}/complete` POST
      - `/admin/orders/{id}/cancel` POST
      - `/admin/orders/{id}` DELETE

## Authentication & Authorization
- Auth flow (admin):
  - Validates credentials; on success, checks `role === 'admin'`.
  - Regenerates session; redirects to dashboard.
  - Non-admin users are logged out with error feedback.
- Authorization:
  - AdminMiddleware ensures only authenticated admin users access admin routes.
  - Registered alias `admin` in bootstrap/app.php.
- Sessions:
  - Driver: `database`; table `sessions` pre-created (via migration/dump).

## Admin Back Office
- Dashboard: aggregates counts for menu items, orders by status.
- Menu Management:
  - List/search products (by name or category).
  - CRUD with image handling and availability toggle.
- Orders Management:
  - Active queue (pending/processing).
  - History with filters (search, status, payment method, date) and statistics (total orders, completed orders, revenue).

## Queues & Background Jobs
- Queue driver: `database`.
- Tables: jobs, job_batches, failed_jobs.
- Development: run `php artisan queue:listen --tries=1` to process jobs during dev.

## Error Handling & Logging
- Logging: `single`/`daily`/`stack` channels configurable via .env and config/logging.php.
- Controllers return appropriate responses and utilize Laravel’s exception handling.

## Configuration & Environment
- .env sets:
  - DB_CONNECTION=mysql
  - DB_HOST=127.0.0.1; DB_PORT=3306
  - DB_DATABASE=caffe; DB_USERNAME=root; DB_PASSWORD=
  - SESSION_DRIVER=database
  - QUEUE_CONNECTION=database
- Configuration files:
  - config/database.php, config/session.php, config/queue.php, config/app.php.

## Database Management
- Migrations establish baseline schema; the provided dump (database/caffe.sql) seeds production-like data.
- Order numbers generated per day to avoid collisions and maintain readability.
- JSON `items` field cast to array in Order model.

## Development Workflow
- Setup:
  - `composer install`
  - Copy `.env` and set DB credentials
  - `php artisan key:generate`
  - Import `database/caffe.sql` (or run `php artisan migrate --force`)
- Run:
  - `php artisan serve`
  - `php artisan queue:listen --tries=1`
  - `npm run dev`

## Testing & Quality
- Use PHPUnit for unit/feature tests.
- Recommended coverage:
  - Controllers: menu listing, cart operations, order lifecycle.
  - Middleware: admin access control.
  - Models: scopes (Category::active, Product::available), accessors, Order::generateOrderNumber.
  - Database: migrations intact, JSON casting for `items`.

## Performance & Security
- Eager load relations (e.g., products with category) to minimize queries.
- Validate/sanitize request input; avoid mass-assignment risks via `$fillable`.
- Enforce role-based access on admin routes; regenerate session on login.
- Store sessions and queue state in DB for reliability; manage APP_KEY securely.

## Extensibility Guidelines
- Payment methods: add options via orders table + controller validation; `payment_method` already present.
- API: add routes/api.php with resource controllers and Eloquent resources for mobile/SPA clients.
- Background tasks: enqueue notifications or reconciliations using database queue driver.
