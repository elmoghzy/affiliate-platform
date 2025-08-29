# Affiliate Platform

This is a Laravel-based affiliate platform for managing products and orders. It includes a Filament admin panel for administration.

## Requirements

- PHP 8.2+
- Composer
- Node.js & npm
- A database (SQLite, MySQL, etc.)

## Local Installation

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd affiliate-platform
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install NPM dependencies and build assets:**
    ```bash
    npm install
    npm run build
    ```

4.  **Environment Setup:**
    - Copy the example environment file:
      ```bash
      cp .env.example .env
      ```
    - Generate an application key:
      ```bash
      php artisan key:generate
      ```
    - Configure your database connection in the `.env` file (e.g., `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
    - Configure the following services in your `.env` file for notifications and tracking:
      ```env
      TIKTOK_PIXEL_ID=your_pixel_id
      TELEGRAM_BOT_TOKEN=your_bot_token
      TELEGRAM_CHAT_ID=your_chat_id
      ```

5.  **Run Migrations and Seeders:**
    This will set up the database schema and create a default admin user and sample products.
    ```bash
    php artisan migrate --seed
    ```

6.  **Serve the application:**
    ```bash
    php artisan serve
    ```

## Admin Panel

-   **URL:** `/admin`
-   **Default User:** `admin@affiliate-platform.com`
-   **Password:** `password`

## Features

-   **Product Management:** Create, edit, and manage products via the Filament admin panel. Products are translatable.
-   **Order Management:** View and manage incoming orders. Includes filtering and bulk status changes.
-   **Excel Export:** Export filtered lists of orders directly from the admin panel.
-   **Telegram Notifications:** Receive instant notifications for new orders in your Telegram chat.
-   **Frontend:** A simple product display page with an order form that captures UTM parameters.
-   **Security:** Includes a basic honeypot to prevent spam bot submissions.
