# Product Management Application

This is a simple product management application built with Laravel. It allows users to create, view, update, and delete products. Each product can have multiple variants, such as different sizes and colors. The application also includes search functionality and pagination.

## Features

- Create, edit, and delete products
- Add multiple variants (size, color) to each product
- Upload and manage product images
- Search products by title
- Paginate product listings
- Favicon support

## Requirements

- PHP >= 7.4
- Composer
- Laravel >= 8.x
- MySQL or any other supported database

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/yshyp/product-management
   cd product-management-app
2. **Install dependencies:**

    ```bash
    composer install

3. **Copy the example environment file and update the environment variables:**

    ```bash
    cp .env.example .env

4. **Generate an application key:**

    ```bash
    php artisan key:generate

5. **Run the database migrations:**

    ```bash
    php artisan migrate

6. **Set up the storage link:**

    ```bash
    php artisan storage:link

7. **Seed the database (optional):**

    ```bash
    php artisan db:seed

# Usage

1. **Start the development server:**

php artisan serve

2. **Access the application:**

Open your browser and navigate to http://localhost:8000.

3. **Create Products:**

Navigate to the product creation page and fill in the required fields (title, description, main image, variants).
Save the product to see it listed on the product index page.

4. **Search and Pagination:**

Use the search box to filter products by title.
Use the pagination links to navigate through different pages of products.

5. **Edit and Delete Products:**

Use the edit button (pencil icon) to update product details and variants.
Use the delete button (trash icon) to remove a product.

# Project Structure

Controllers: App\Http\Controllers\ProductController

Models: App\Models\Product, App\Models\ProductVariant

Views: resources/views/products

1.index.blade.php: Displays the product listing with search and pagination

2.create.blade.php: Form to create a new product

3.edit.blade.php: Form to edit an existing product

4.product_list.blade.php: Partial view for product list (used for live refresh)

# Custom Validation Messages

The ProductController includes custom validation messages for product fields. These messages ensure that users receive clear feedback when interacting with the forms.

# Favicon

A favicon has been added to the application. Place your favicon file in the public/images directory and update the link in the layouts/app.blade.php file.