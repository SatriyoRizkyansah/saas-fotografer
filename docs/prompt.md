# Prompt for Building a Photographer SaaS Application (Laravel)

## 1. Context & Application Goals

Please generate the code for a Laravel-based SaaS (Software as a Service) application[cite: 1]. This application is intended for **Photographers (Owners)** who want to sell their photo products to **Customers** quickly in the field (e.g., at events or studios)[cite: 1].

**Key Features & Core Concepts (Must be implemented):**

- **Guest Checkout (No Login for Customers):** Customers **DO NOT NEED** to create an account or log in[cite: 1]. They will scan a QR Code printed on a banner or stand[cite: 1].
- **QR Code Transaction Flow:** The QR Code directs the customer to a specific product URL[cite: 1]. On that page, customers can view product details, fill in their personal data (Name, Email, WhatsApp), view the Owner's bank account details, and directly upload a manual transfer proof[cite: 1].
- **Transaction Tracking:** After a successful upload, the customer is redirected to an "Order Status" page using a unique URL (UUID) so they can check their order status without logging in[cite: 1].
- **Owner Validation:** The Owner (Photographer) logs into the dashboard, views incoming orders, checks the transfer proof images, and validates the order (Changing the status from Pending -> Valid)[cite: 1].
- _(Note: Ignore the subscription system from Super Admin to Owner for now. Focus strictly on the Owner and Customer features)[cite: 1]._

---

## 2. Technical Specifications

- **Framework:** Laravel (Latest version)[cite: 1]
- **Database:** MySQL / SQLite[cite: 1]
- **Styling:** Tailwind CSS (you may use Breeze/Jetstream for Owner authentication)[cite: 1]
- **Additional Packages:** `simplesoftwareio/simple-qrcode` (for generating QR Codes)[cite: 1]

---

## 3. Database Structure (Migrations & Models)

Please create the migrations and models with the appropriate relationships for the following tables[cite: 1]:

### a. `users` (Used as the Owner/Photographer)

- Default Laravel columns (name, email, password)[cite: 1].
- Additional columns: `bank_name`, `bank_account_number`, `bank_account_name` (to display payment info to the customer)[cite: 1].

### b. `categories`

- `id`, `owner_id` (foreign key to users), `name`, `timestamps`[cite: 1].

### c. `products`

- `id`, `owner_id` (foreign key to users), `category_id` (foreign key to categories), `name`, `description`, `price`, `timestamps`[cite: 1].

### d. `transactions`

- `id`, `uuid` (unique UUID for the customer's tracking URL)[cite: 1].
- `owner_id` (foreign key to users)[cite: 1].
- `product_id` (foreign key to products)[cite: 1].
- `customer_name` (string)[cite: 1].
- `customer_email` (string)[cite: 1].
- `customer_phone` (string)[cite: 1].
- `payment_proof` (string - file path for the transfer proof image)[cite: 1].
- `status` (enum/string: `pending`, `valid`, `rejected` - default is `pending`)[cite: 1].
- `timestamps`[cite: 1].

---

## 4. Module & Feature Requirements (Agent Tasks)

### Owner Module (Requires Login)

Create the Controller, Route, and View (Blade) for[cite: 1]:

1. **Dashboard:** Displays a summary of total products and pending transactions[cite: 1].
2. **Category Management:** CRUD operations for Categories[cite: 1].
3. **Product Management:** CRUD operations for Products[cite: 1]. On the product detail/index page, add a **Generate QR Code** feature containing a link to that specific product's checkout page (`/checkout/{product_id}`)[cite: 1].
4. **Transaction Management:**
   - A page listing incoming transactions[cite: 1].
   - A feature to view the transfer proof image (`payment_proof`)[cite: 1].
   - Buttons/Actions to change the `status` to `valid` or `rejected`[cite: 1].

### Customer Module (Public / No Login)

Create the Controller, Route, and View (Blade) for[cite: 1]:

1. **Product Checkout Page (`/checkout/{product_id}`):**
   - Displays product details and price[cite: 1].
   - Displays an input form for: Name, Email, WhatsApp Number[cite: 1].
   - Displays payment instructions (The specific Owner's Bank Account Number)[cite: 1].
   - Displays a file upload input for `payment_proof` (must be an image)[cite: 1].
   - Submitting this form should create a record in the `transactions` table and generate a UUID[cite: 1].
2. **Success & Tracking Page (`/order/status/{uuid}`):**
   - Displays a thank you message[cite: 1].
   - Displays the order status (Pending / Valid / Rejected)[cite: 1].
   - _(Note: This page serves as a reference for customers to refresh and check if the photographer has validated their payment)[cite: 1]._

---

## 5. Execution Instructions

Please provide the code step-by-step[cite: 1]:

1. Provide the code for **Migrations** and **Models** (including Eloquent relationships)[cite: 1].
2. Provide the code for **Routes** (`web.php`)[cite: 1].
3. Provide the code for **Controllers** (Owner/ProductController, Owner/TransactionController, Customer/CheckoutController)[cite: 1].
4. Provide a brief guide or examples for the main **Blade Views** (especially the guest checkout form and the owner's validation page)[cite: 1].
5. Do not forget to include request validation, especially for the transfer proof file upload (e.g., `mimes:jpg,jpeg,png`)[cite: 1].
