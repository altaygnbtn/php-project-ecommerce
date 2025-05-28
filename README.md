# 🛍️ ShopEase

ShopEase is a simple PHP & MySQL e-commerce web application. It allows users to browse products, add them to a cart or wishlist, leave reviews, and place orders. Admins can manage products through a dedicated dashboard.

## Features

- User registration & login
- Product catalog with images and descriptions
- Shopping cart and checkout
- Wishlist (add/remove products)
- Product reviews and ratings
- Order history for users
- Admin panel for product management

## Requirements

- PHP 7.x or newer
- MySQL/MariaDB
- [XAMPP](https://www.apachefriends.org/index.html) or similar local server stack

## Setup Instructions

1. **Clone or Download the Repository**

   ```
   git clone https://github.com/yourusername/shopease.git
   ```

2. **Move the Project to Your Web Server Directory**

   For XAMPP, place the project folder in:
   ```
   /Applications/XAMPP/xamppfiles/htdocs/
   ```

3. **Create the Database**

   - Open phpMyAdmin or your MySQL client.
   - Create a new database, e.g., `shopease`.
   - Create other necessary tables (`users`, `products`, `orders`, `reviews`, etc.) as per your application schema.

4. **Configure Database Connection**

   - Edit `admin/db.php` and set your database credentials:

     ```php
     $mysqli = new mysqli('localhost', 'your_db_user', 'your_db_password', 'shopease');
     ```

5. **Start the Server**

   - Launch XAMPP and start Apache and MySQL.
   - Visit [http://localhost/php-ecommerce-project/store.php](http://localhost/php-ecommerce-project/store.php) in your browser.

## File Structure

```
php-ecommerce-project/
├── admin/
│   ├── uploads/
│   ├── db.php
│   ├── add_product.php
│   ├── manage_products.php
│   ├── save_product.php
│   ├── edit_product.php
│   ├── signup.php
│   ├── logout.php
│   └── login.php
├── cart.php
├── checkout.php
├── header.php
├── order_history.php
├── product_detail.php
├── store.php
├── wishlist.php

```


## License

This project is for educational purposes.

---

