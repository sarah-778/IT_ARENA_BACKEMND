# IT ARENA Backend Structure - Complete Analysis

## 📊 Database Schema & Models

### 1. **PRODUCTS TABLE**
**Migration**: `2026_03_03_125626_create_products_table.php`

**Columns**:
- `id` (Primary Key)
- `name` (string) - Product name
- `category` (string) - Category type (smartphones, laptops, etc.)
- `brand` (string) - Brand name (Apple, Samsung, Dell, etc.)
- `price` (decimal 15,2) - Unit price in UGX
- `stock` (integer) - Available quantity
- `isOEM` (boolean) - Genuine flag (default: true)
- `warranty` (string) - Warranty period (default: "6 Months")
- `image` (longText) - Base64 or file path for product photos
- `description` (text) - Product details
- `created_at`, `updated_at` (timestamps)

**Model**: [app/Models/Product.php](app/Models/Product.php)
**Controller**: [app/Http/Controllers/ProductController.php](app/Http/Controllers/ProductController.php)

**API Endpoints**:
- `GET /api/products` - Fetch all products
- `POST /api/products` - Create product (with image upload)
- `DELETE /api/products/{id}` - Delete product

---

### 2. **ORDERS TABLE**
**Migration**: `2026_03_16_133858_create_orders_table.php`

**Columns**:
- `id` (Primary Key)
- `order_number` (string, unique) - Format: "ITA-XXXX"
- `customer_name` (string) - Customer name
- `phone` (string) - Customer phone
- `email` (string) - Customer email
- `district` (string) - Delivery district (Kampala, etc.)
- `address` (text) - Full delivery address
- `items` (json) - Cart items array [id, name, qty, price]
- `subtotal` (decimal 15,2) - Items total in UGX
- `delivery_fee` (decimal 15,2) - Calculated based on district
- `total` (decimal 15,2) - Grand total (subtotal + delivery_fee)
- `status` (string) - Order status (pending, processing, delivered, cancelled)
- `created_at`, `updated_at` (timestamps)

**Model**: [app/Models/Order.php](app/Models/Order.php)
**Controller**: [app/Http/Controllers/OrderController.php](app/Http/Controllers/OrderController.php)

**API Endpoints**:
- `GET /api/orders` - Fetch all orders (admin)
- `POST /api/orders` - Create order (checkout)
- `PATCH /api/orders/{id}/status` - Update order status
- `DELETE /api/orders/{id}` - Delete/archive order

**Delivery Fee Logic**:
```
Kampala: 10,000 UGX
Other Districts: 20,000 UGX
```

---

### 3. **REPAIRS TABLE**
**Migration**: `2026_03_04_110827_create_repairs_table.php`

**Columns**:
- `id` (Primary Key)
- `type` (string) - Type: "user" (customer request) or "sample" (portfolio)
- `tracking_code` (string, unique) - Format: "ITA-XXXXXX" (only for user repairs)
- `status` (string) - Status (pending, diagnosing, repairing, completed)
- `name` (string) - Customer name (required for "user" type)
- `phone` (string) - Customer phone (required for "user" type)
- `email` (string) - Customer email (required for "user" type)
- `device` (string) - Device name (e.g., "iPhone 13 Pro Max")
- `issue` (text) - Problem description
- `date` (date) - Repair date (required for "user" type)
- `image` (string) - Evidence photo path
- `created_at`, `updated_at` (timestamps)

**Model**: [app/Models/Repair.php](app/Models/Repair.php)
**Controller**: [app/Http/Controllers/RepairController.php](app/Http/Controllers/RepairController.php)

**API Endpoints**:
- `GET /api/repairs` - Fetch all repairs
- `POST /api/repairs` - Create repair request/portfolio sample
- `GET /api/repairs/track/{code}` - Track repair by code
- `PATCH /api/repairs/{id}/status` - Update repair status
- `DELETE /api/repairs/{id}` - Delete repair record

**Type Logic**:
- **"user"**: Customer repair request → tracking_code generated → status starts as "pending"
- **"sample"**: Portfolio showcase → no tracking code → status set as "completed"

---

### 4. **MESSAGES TABLE**
**Migration**: `2026_04_21_071744_create_messages_table.php`

**Columns**:
- `id` (Primary Key)
- `name` (string) - Sender name
- `email` (string) - Sender email
- `phone` (string, nullable) - Sender phone
- `message` (text) - Message content
- `is_read` (boolean) - Read status (default: false)
- `created_at`, `updated_at` (timestamps)

**Model**: [app/Models/Message.php](app/Models/Message.php)
**Controller**: [app/Http/Controllers/MessageController.php](app/Http/Controllers/MessageController.php)

**API Endpoints**:
- `POST /api/contact` - Submit contact form message
- `GET /api/messages` - Fetch all messages (admin)

---

### 5. **USERS TABLE** (Built-in)
**Migration**: `0001_01_01_000000_create_users_table.php`

**Columns**:
- `id` (Primary Key)
- `name` (string) - User name
- `email` (string, unique) - User email
- `email_verified_at` (timestamp, nullable)
- `password` (string) - Hashed password
- `remember_token` (string, nullable)
- `created_at`, `updated_at` (timestamps)

**Model**: [app/Models/User.php](app/Models/User.php)
**Controller**: [app/Http/Controllers/AuthController.php](app/Http/Controllers/AuthController.php)

**API Endpoints**:
- `POST /api/register` - User registration
- `POST /api/login` - User login
- `POST /api/logout` - User logout
- `GET /api/user` - Get current user (auth required)
- `GET /api/users` - Get all users (auth required)
- `PUT /api/user/update` - Update profile (auth required)

---

## 🔐 Authentication

**Guard**: `web` (Session-based)
**Provider**: Eloquent (User model)
**Tokens**: Laravel Sanctum (Personal Access Tokens)

**Auth Routes**:
```php
Route::post('/register', [AuthController::class, 'register']);      // Public
Route::post('/login', [AuthController::class, 'login']);            // Public
Route::post('/logout', [AuthController::class, 'logout']);          // Protected
Route::get('/user', fn(Request $r) => $r->user());                  // Protected
Route::get('/users', fn() => User::all());                           // Protected
Route::put('/user/update', [AuthController::class, 'updateProfile']); // Protected
```

---

## 📁 File Organization

```
app/
├── Http/Controllers/
│   ├── AuthController.php          ✅ User registration & login
│   ├── ProductController.php       ✅ Product CRUD + image upload
│   ├── OrderController.php         ✅ Order management + checkout
│   ├── RepairController.php        ✅ Repair requests & tracking
│   ├── MessageController.php       ✅ Contact form & inquiries
│   └── UserController.php
├── Models/
│   ├── User.php                    ✅ User model with Sanctum
│   ├── Product.php                 ✅ Product model
│   ├── Order.php                   ✅ Order model
│   ├── Repair.php                  ✅ Repair model
│   └── Message.php                 ✅ Message model
└── Providers/
    └── Filament/
        └── AdminPanelProvider.php  ✅ Filament panel config

database/
├── migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 2026_03_03_125626_create_products_table.php
│   ├── 2026_03_04_110827_create_repairs_table.php
│   ├── 2026_03_16_133858_create_orders_table.php
│   └── 2026_04_21_071744_create_messages_table.php
└── seeders/
    └── DatabaseSeeder.php
```

---

## 🎯 Feature Checklist

### Products ✅
- [x] Create with image upload
- [x] Read (list all)
- [x] Update (edit)
- [x] Delete with image cleanup
- [x] Stock tracking
- [x] Category & brand filtering

### Orders ✅
- [x] Create (checkout flow)
- [x] Read (admin dashboard)
- [x] Update status (pending → processing → delivered)
- [x] Delete (archive)
- [x] Dynamic delivery fee calculation
- [x] Unique order number generation

### Repairs ✅
- [x] User repair requests with tracking codes
- [x] Portfolio samples (no tracking)
- [x] Image evidence upload
- [x] Status progression (pending → diagnosing → repairing → completed)
- [x] Track by code

### Messages ✅
- [x] Contact form submissions
- [x] Admin inbox view
- [x] Read/unread tracking
- [x] Timestamp tracking

### Users ✅
- [x] User registration
- [x] User login
- [x] Profile updates
- [x] Sanctum token authentication

---

## 🚀 Data Validation

All controllers implement robust validation:
- File size limits (5MB for images)
- Accepted formats (jpeg, png, jpg, webp)
- Required field checks
- Unique constraint enforcement
- Type casting (numeric, integer, etc.)

---

## 📝 Notes

- **Database**: SQLite (database/database.sqlite)
- **File Storage**: Local disk at storage/app/public/
- **Image Paths**: Stored relative (e.g., "products/xxx.jpg")
- **Date Format**: YYYY-MM-DD
- **Currency**: UGX (Ugandan Shilling)
- **Auth Guard**: Web (session-based for Filament)
- **API Guard**: Sanctum (token-based for mobile/frontend)

---

**Status**: ✅ **ALL SYSTEMS OPERATIONAL**
- Database: Migrated ✅
- Models: Defined ✅
- Controllers: Implemented ✅
- Filament Panel: Active ✅
- API Routes: Configured ✅
