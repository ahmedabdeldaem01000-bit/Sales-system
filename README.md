# Point-of-Sale & Order Management System

A Laravel-based POS system with support for orders, installment payment plans, and PayPal integration. Designed for managing product inventory, employee sales, customer accounts, and complex payment workflows.

## Overview

This system provides a complete order management platform with the following core workflows:

- **Product & Inventory**: Track product inventory with barcode support and stock management
- **Sales Processing**: Create orders, manage order items, and track employee sales
- **Payment Flexibility**: Support for direct payments and installment-based payment plans with interest calculation
- **Supplier Management**: Manage supplier relationships and product purchases
- **Analytics**: Dashboard with monthly sales trends, top-performing products, and customer spending patterns
- **Payment Integration**: PayPal integration for online payments with webhook support
- **Notifications**: Automated email reminders for pending installment payments

## Core Features

### Product Management
- Create and manage products with unique barcodes
- Track inventory with quantity and cost price per product
- Monitor sold quantity and total cost

### Order Management
- Create orders linked to employees and customers
- Track order items with quantity and pricing
- Support multiple payment types (direct payment, installment)
- PayPal order integration for online payments

### Installment Plans
- Flexible installment plans with configurable months and interest rates
- Calculate total amount with interest for each plan
- Track down payments and remaining amounts
- Record payment history for each installment

### Payment Processing
- Direct order payments
- Installment payments tracked via installment items
- PayPal payment integration with order capture workflow
- Payment method tracking (cash, card, PayPal, etc.)

### Employee & Supplier Management
- Employee accounts with role-based access (admin/employee)
- Assign employees to sales orders
- Supplier contact management with soft delete support
- Track purchases from suppliers

### Sales Analytics & Reporting
- Dashboard with current month revenue and order counts
- Monthly sales trends visualization
- Top 5 selling products with order frequency
- Top 5 customers by spending
- Installment payment status reporting (pending amounts)
- Processing sales report (product-level sales summary)

### Notifications
- Email reminders for pending installment payments
- Database notifications for admin tracking
- PayPal payment link included in reminders

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Framework** | Laravel 12 |
| **Frontend** | React + Inertia.js |
| **Interactive Components** | Livewire 3 |
| **Database** | SQLite (default) / MySQL |
| **Authentication** | Laravel Sanctum |
| **Payment Gateway** | PayPal (srmklive/paypal ^3.1) |
| **Build Tool** | Vite |
| **CSS Framework** | Tailwind CSS |
| **Testing** | PHPUnit 11 |
| **Package Manager** | Composer / NPM |

## System Architecture

### Directory Structure

```
app/
├── Http/Controllers/          # Route handlers
│   ├── OrderController.php     # Order CRUD
│   ├── ProductController.php   # Product management
│   ├── InstallmentController.php # Payment plans
│   ├── PayPalController.php    # PayPal callbacks
│   ├── EmployeeController.php  # Staff management
│   ├── SupplierController.php  # Vendor management
│   ├── PurchaseController.php  # Inventory purchases
│   ├── home.php               # Dashboard logic
│   └── Api/
│       └── PayPalWebhookController.php
├── Models/                    # Eloquent models
│   ├── Order.php              # Orders with relationships
│   ├── OrderItem.php          # Order line items
│   ├── Product.php            # Product catalog
│   ├── Installment.php        # Payment plans
│   ├── InstallmentItem.php    # Individual installment payments
│   ├── InstallmentPlan.php    # Plan templates
│   ├── Payment.php            # Payment records
│   ├── Employee.php           # Staff accounts
│   ├── User.php               # Customer accounts
│   ├── Supplier.php           # Vendors
│   ├── Purchase.php           # Product purchases
│   ├── PurchaseItem.php       # Purchase line items
│   ├── ProcessingSale.php     # Sales aggregation
│   └── Payment.php
├── Livewire/                  # Interactive components
│   ├── OrdersList.php         # Order list component
│   ├── OrderDetails.php       # Order detail view
│   ├── InstallmentDetails.php # Installment tracking
│   └── ScanProduct.php        # Barcode scanner
├── Services/
│   └── PayPalService.php      # PayPal API integration
└── Notifications/
    └── InstallmentReminderNotification.php # Email reminders

routes/
├── web.php                    # Admin/employee routes
├── api.php                    # API endpoints
└── auth.php                   # Authentication routes

database/
├── migrations/               # Schema files
└── factories/               # Model factories

config/
├── paypal.php              # PayPal credentials config
└── [other Laravel configs]

resources/
├── views/                  # Blade templates
├── js/                     # React/Inertia frontend
└── css/                    # Tailwind CSS
```

### Architecture Pattern

- **MVC**: Controllers handle request logic, Models represent data, Views render responses
- **Eloquent ORM**: Database interaction via model relationships
- **Middleware**: Authentication and role-based access control
- **Service Layer**: PayPal payments abstracted in PayPalService
- **Livewire**: Real-time interactive components for forms and lists

## Database Design

### Core Tables

| Table | Purpose | Key Fields |
|-------|---------|-----------|
| `users` | Customer accounts | id, name, email, phone, address, image |
| `employees` | Staff accounts | id, name, email, password, role, phone, address |
| `products` | Inventory | id, name, barcode, quantity, current_quantity, price, cost_price, sold_quantity |
| `orders` | Sales transactions | id, employee_id, user_id, total, payment_type, paid_amount, paypal_order_id |
| `order_items` | Order line items | id, order_id, product_id, quantity, price |
| `suppliers` | Vendors | id, name, phone, email, address |
| `purchases` | Supplier orders | id, employee_id, supplier_id, total_price, quantity, unit_price |
| `purchase_items` | Purchase line items | id, purchase_id, product_id, quantity, price |

### Payment Tables

| Table | Purpose | Key Fields |
|-------|---------|-----------|
| `installment_plans` | Plan templates | id, name, months_count, interest_rate |
| `installments` | Order payment plans | id, order_id, plan_id, total_with_interest, down_payment, remaining_amount, start_date |
| `installment_items` | Individual payments | id, installment_id, amount, due_date, status, payment_link, paypal_order_id |
| `payments` | Payment records | id, order_id, installment_item_id, amount, method, payment_date |

### Additional Tables

| Table | Purpose |
|-------|---------|
| `processing_sales` | Aggregated sales by product |
| `debt_logs` | Customer payment status tracking |

## Installation Guide

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- SQLite or MySQL

### Setup Steps

1. **Clone and navigate to project**
```bash
cd system
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install Node dependencies**
```bash
npm install
```

4. **Create environment file**
```bash
cp .env.example .env
```

5. **Generate application key**
```bash
php artisan key:generate
```

6. **Configure PayPal credentials** (edit `.env`)
```
PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=your_client_id
PAYPAL_SANDBOX_CLIENT_SECRET=your_client_secret
PAYPAL_WEBHOOK_ID=your_webhook_id
```

7. **Run migrations**
```bash
php artisan migrate
```

8. **Create storage link**
```bash
php artisan storage:link
```

9. **Build frontend assets**
```bash
npm run build
```

## Usage

### Development Mode

Start all services (Laravel server, queue, Vite dev server):

```bash
composer run dev
```

Or with SSR support:

```bash
composer run dev:ssr
```

### Production Mode

```bash
php artisan serve
php artisan queue:work
npm run build
```

### Access Application

- **URL**: `http://localhost:8000`
- **Admin Routes**: Require `auth` + `role:admin` middleware
- **Employee Routes**: Require `auth` + `role:employee` middleware

## API Endpoints

### PayPal Webhook

```
POST /api/paypal/webhook
```
Receives PayPal transaction notifications and updates payment status.

### Web Routes

#### Admin-Only Routes

| Method | Route | Controller | Action |
|--------|-------|-----------|--------|
| GET | `/admin` | home | Dashboard display |
| GET | `/dashboard-home` | home | Dashboard data |
| GET/POST | `/product` | ProductController | CRUD operations |
| GET/POST | `/employee` | EmployeeController | Staff management |
| GET/POST | `/supplier` | SupplierController | Vendor management |
| GET/POST | `/purchase` | PurchaseController | Inventory purchases |
| GET/POST | `/installment` | InstallmentController | Payment plans |
| GET/POST | `/user` | UserController | Customer management |
| GET | `/orders` | OrderController | Order list |
| GET | `/orders/{orderId}` | OrderController | Order details |
| DELETE | `/products/bulk-delete` | ProductController | Batch delete products |
| DELETE | `/supplier/bulk-delete` | SupplierController | Batch delete suppliers |

#### Employee Routes

| Method | Route | Controller | Action |
|--------|-------|-----------|--------|
| GET/POST | `/employee-products` | ProductsEmployeeController | View assigned products |

#### Public Routes

| Method | Route | Controller | Action |
|--------|-------|-----------|--------|
| GET | `/paypal/success` | PayPalController | Payment success callback |
| GET | `/paypal/cancel` | PayPalController | Payment cancellation |

## Key Code Highlights

### Order Creation with PayPal Integration

Orders support multiple payment methods. PayPal orders are created via `PayPalService` and linked to `Order` model:

```php
// Order model stores paypal_order_id and payment_type
$order = Order::create([
    'employee_id' => $employeeId,
    'user_id' => $customerId,
    'total' => $totalAmount,
    'payment_type' => 'paypal', // 'cash', 'card', 'paypal'
    'paypal_order_id' => $paypalOrderId,
]);
```

### Installment Payment Calculation

Interest is applied based on selected plan:

```php
$installment = Installment::create([
    'order_id' => $order->id,
    'plan_id' => $planId, // e.g., 3 months at 5% interest
    'total_with_interest' => $order->total * (1 + $plan->interest_rate / 100),
    'down_payment' => $downPayment,
    'remaining_amount' => $totalWithInterest - $downPayment,
    'start_date' => now(),
]);
```

### Dashboard Analytics

Monthly sales trends and customer insights:

```php
// Monthly orders and revenue
$monthlyOrdersRaw = Order::selectRaw("
    MONTH(created_at) as month,
    COUNT(*) as count,
    SUM(total) as revenue
")
->whereYear('created_at', now()->year)
->groupByRaw("MONTH(created_at)")
->get();

// Top 5 products
$topProducts = OrderItem::selectRaw('product_id, COUNT(*) as order_count, SUM(quantity) as total_quantity')
    ->with('product')
    ->groupBy('product_id')
    ->orderByDesc('order_count')
    ->limit(5)
    ->get();
```

### Installment Reminder Notification

Automated email reminders for pending payments:

```php
// Send reminder with PayPal payment link
$user->notify(new InstallmentReminderNotification($installmentItem));

// Email includes:
// - Amount due
// - Due date
// - PayPal payment link (if available)
```

## Project Structure Details

### Models Relationships

```
Order
  ├── hasMany OrderItem
  ├── hasMany Installment
  ├── hasMany Payment
  ├── belongsTo Employee
  └── belongsTo User

Installment
  ├── hasMany InstallmentItem
  ├── belongsTo Order
  └── belongsTo InstallmentPlan

Product
  ├── belongsToMany Purchase (through purchase_items)

Employee
  ├── hasMany Order
  ├── hasMany Purchase
  └── hasManyThrough OrderItem (through Order)

User
  ├── hasMany Order

Supplier
  └── hasMany Purchase
```

## Limitations / Known Issues

### Missing Functionality (Based on Code Review)

1. **Invoices Module**: System uses "orders" but lacks formal invoice generation (comment in routes indicates this was planned)
2. **Stock Movement Tracking**: No dedicated table for inventory movements (purchases, sales, returns, waste)
3. **Invoice Status**: No invoice status tracking (paid/partial/overdue distinction)
4. **Backup & Restore**: Not implemented
5. **Profit Calculation**: No per-product or daily/monthly profit reports despite comments indicating intent
6. **Product Alerts**: 
   - Low stock warnings not fully implemented
   - High debt customer alerts not fully implemented
7. **Quantity Validation**: Product quantity management logic incomplete
8. **Order-Supplier Link**: No direct relationship between orders and suppliers
9. **Multi-currency Support**: PayPal hardcoded to USD
10. **Debt Logs**: Table exists but functionality unclear from models

### Incomplete Features

- **ProcessingSale**: Model exists but unclear how it's generated or maintained
- **ScanProduct**: Livewire component exists but scanner logic not reviewed
- **RestoreController**: Exists but purpose unclear
- **Settings Controller**: Directory exists but not integrated into routes

### API Coverage

- Only PayPal webhook implemented in API
- No REST endpoints for CRUD operations
- API routes minimal compared to web routes

## Future Improvements

Based on code comments and identified gaps:

1. **Formal Invoice System**
   - Create `invoices` and `invoice_items` tables
   - Track invoice status (draft, sent, paid, partial, overdue)
   - Generate PDF invoices with sequential numbering

2. **Stock Management**
   - Implement `stock_movements` table to log all inventory changes
   - Validate purchase/sales against available quantity
   - Generate low-stock alerts

3. **Financial Reporting**
   - Add per-product profit margin calculations
   - Generate daily, weekly, monthly profit reports
   - Implement financial dashboards

4. **Customer Debt Management**
   - Expand `debt_logs` functionality
   - Add debt aging reports
   - Implement collection workflows

5. **Admin Alerts**
   - Product-level alerts (low stock threshold)
   - Customer-level alerts (high debt threshold)
   - Real-time notification system

6. **API Expansion**
   - RESTful endpoints for all resources
   - Mobile app backend support
   - Third-party integrations

7. **Enhanced Payment Processing**
   - Support multiple currencies
   - Additional payment gateways (Stripe, etc.)
   - Recurring payment automation

8. **Data Export**
   - CSV/Excel export for reports
   - PDF report generation
   - Batch operations on exports

## Screenshots Section

*Screenshots would be placed here to demonstrate:*
- Dashboard with sales metrics and charts
- Product management interface
- Order creation workflow
- Installment payment tracking
- Payment processing with PayPal
- Employee sales report
- Supplier inventory management

*Visual documentation pending*

## Environment Variables

Key environment variables needed in `.env`:

```bash
APP_NAME="POS System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# PayPal
PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=YOUR_SANDBOX_CLIENT_ID
PAYPAL_SANDBOX_CLIENT_SECRET=YOUR_SANDBOX_CLIENT_SECRET
PAYPAL_WEBHOOK_ID=YOUR_WEBHOOK_ID
PAYPAL_CURRENCY=USD

# Mail (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

## Testing

Run tests with:

```bash
composer run test
```

PHPUnit is configured in `phpunit.xml` with SQLite database for testing.

## Development Commands

| Command | Purpose |
|---------|---------|
| `composer run dev` | Start dev server with queue and Vite |
| `composer run dev:ssr` | Start with SSR support |
| `composer run test` | Run PHPUnit tests |
| `npm run dev` | Build frontend in dev mode |
| `npm run build` | Build frontend for production |
| `php artisan migrate` | Run database migrations |
| `php artisan tinker` | Interactive PHP shell |
| `php artisan queue:listen` | Process queue jobs |

## License

MIT License - See LICENSE file for details

## Notes

- Application is partially in Arabic (comments, UI labels)
- PayPal integration requires sandbox credentials from developer.paypal.com
- Email notifications require configured mail driver in `.env`
- Queue processing supports email notifications and scheduled tasks
