# System Build Log

## Pages Created

### 1. OrdersList Page
- **Purpose**: Display all orders in a clean table format with payment summary.
- **Location**: `app/Livewire/OrdersList.php` and `resources/views/livewire/orders-list.blade.php`
- **Route**: `/orders` (named `orders.list`)
- **Features**:
  - Table columns: Order ID, Customer Name, Total, Payment Type, Paid Amount, Remaining Amount
  - "View Details" button for each order
  - Uses Eloquent relationships: Order with user and installments
  - Calculates remaining amount based on payment type (cash vs installment)

### 2. OrderDetails Page
- **Purpose**: Show detailed information for a specific order, including customer info, products, and installment details if applicable.
- **Location**: `app/Livewire/OrderDetails.php` and `resources/views/livewire/order-details.blade.php`
- **Route**: `/orders/{orderId}` (named `order.details`)
- **Features**:
  - Displays customer name, total, payment type, paid amount
  - If installment: shows plan name, down payment, remaining amount, and "View Installment Details" button
  - Products table: name, quantity, price, total
  - Uses Eloquent relationships: Order with user, items.product, installments.plan
  - "Back to Orders" link

### 3. InstallmentDetails Page
- **Purpose**: Display all installment items for a given installment with payment actions.
- **Location**: `app/Livewire/InstallmentDetails.php` and `resources/views/livewire/installment-details.blade.php`
- **Route**: `/installments/{installmentId}` (named `installment.details`)
- **Features**:
  - Shows installment summary: total with interest, down payment, remaining amount
  - Table columns: Due Date, Amount, Paid Amount, Status (with color-coded badges), Actions
  - "Pay" button for unpaid items (opens modal)
  - Uses Eloquent relationships: Installment with items.payments
  - "Back to Orders" link

### 4. PaymentForm (Modal in InstallmentDetails)
- **Purpose**: Allow making payments for installment items.
- **Location**: Integrated into `InstallmentDetails.php` and view
- **Features**:
  - Modal form with amount input
  - Validation: required, numeric, min 0.01, not exceeding remaining
  - On submit: creates Payment record, updates InstallmentItem paid_amount and status, updates Installment remaining_amount, updates Order paid_amount
  - Status logic: 'paid' if fully paid, 'late' if overdue, 'pending' otherwise
  - Success/error messages

## Relationships Used
- Order belongsTo User
- Order hasMany OrderItem
- OrderItem belongsTo Product
- Order hasMany Installment
- Installment belongsTo InstallmentPlan
- Installment hasMany InstallmentItem
- InstallmentItem hasMany Payment
- Payment belongsTo Order and InstallmentItem

## Logic Implemented
- Remaining amount calculation: For cash orders, total - paid_amount; for installments, installment.remaining_amount
- Payment processing: Updates multiple models (Payment, InstallmentItem, Installment, Order)
- Status updates: Automatic status change for InstallmentItem based on paid_amount and due_date
- Validation: Prevents overpayment on installment items

## Technologies Used
- Laravel Livewire for reactive components
- Bootstrap for UI styling (cards, tables, buttons, modals)
- Eloquent ORM for database queries and relationships
- Laravel routing for clean URLs