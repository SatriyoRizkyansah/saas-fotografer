# Prompt for Super Admin Module & Owner Storefront (Laravel SaaS)

## 1. Context & Application Goals

Building upon the previous Photographer SaaS application, I need to add two major features:

1. **Super Admin Module:** A centralized dashboard for the Super Admin to manage the registered Owners (Photographers). The Super Admin controls the subscription status (active/inactive) and the subscription expiration date.
2. **Owner Storefront (Public Landing Page):** Each Owner gets a unique public landing page accessed via a UUID (e.g., `/store/{owner_uuid}`). Owners can customize their application/store name (defaulting to "SnapPhoto"). When a customer visits this URL, they will see the Owner's custom store name and a catalog of products belonging exclusively to that Owner.

---

## 2. Database Structure Updates (Migrations)

Please provide the migration updates (or modify the previous `users` migration) to include the following:

### Update `users` table:

Add the following columns to handle roles, subscriptions, and storefront customization:

- `role` (string/enum: `super_admin`, `owner` - default is `owner`).
- `store_uuid` (UUID - unique identifier for the Owner's public landing page).
- `app_name` (string - default: `'SnapPhoto'`).
- `subscription_status` (boolean - `true` for active, `false` for inactive).
- `subscription_valid_until` (date or datetime - the expiration date of the subscription).

---

## 3. Module & Feature Requirements (Agent Tasks)

### A. Super Admin Module (Requires 'super_admin' Role)

Create the Middleware, Controller, Route, and View for:

1. **Super Admin Middleware:** Ensures only users with the `super_admin` role can access these routes.
2. **Owner Management Dashboard:**
    - A list/table of all registered Owners.
    - Display their current `subscription_status` and `subscription_valid_until`.
3. **Edit Subscription:**
    - A form/modal for the Super Admin to update an Owner's `subscription_status` (Active/Inactive) and extend/modify the `subscription_valid_until` date.

### B. Owner Module Updates (Requires 'owner' Role)

1. **Subscription Middleware:** Create a middleware that checks if the logged-in Owner's `subscription_status` is active AND `subscription_valid_until` has not passed. If expired/inactive, redirect them to a "Subscription Expired" notice page and block access to adding new products.
2. **Store Settings Page:**
    - A form for the Owner to update their `app_name` (e.g., changing it from "SnapPhoto" to "John Photography").
    - Display their unique Store URL (e.g., `domain.com/store/{store_uuid}`) so they can copy and share it or generate a QR code for their main storefront.

### C. Public Storefront Module (No Login Required)

Create the Controller, Route, and View for:

1. **Owner Landing Page (`/store/{store_uuid}`):**
    - Query the `users` table to find the Owner by `store_uuid`.
    - If the Owner's subscription is inactive/expired, display a "Store Unavailable" message.
    - If active, display the Owner's custom `app_name` as the page header/title.
    - Fetch and display all `products` belonging to this specific `owner_id`.
    - Each product displayed should have a "Buy Now" button that links to the existing Guest Checkout page (`/checkout/{product_id}`).

---

## 4. Execution Instructions

Please provide the code step-by-step:

1. Provide the code for the **Migration updates** for the `users` table.
2. Provide the code for **Middlewares** (`IsSuperAdmin` and `CheckSubscription`).
3. Provide the code for **Routes** (`web.php`), grouped logically for Super Admin, Owner, and Public Store.
4. Provide the code for **Controllers** (`SuperAdmin/OwnerManagementController`, `Owner/SettingsController`, `Customer/StoreController`).
5. Provide brief examples for the **Blade Views** (Super Admin table, Owner Settings form, and the Public Storefront page).
