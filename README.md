# Foodie MV

Foodie MV is a web-based food ordering application for the Maldives. It allows customers to browse menus, place orders, and provides an admin interface for managing categories, food items, and orders.

## Features

- User-friendly menu browsing with category filtering
- Shopping cart functionality
- Order placement and management
- Admin dashboard for monitoring sales and order statistics
- Category and food item management for admins
- Responsive design for both customer and admin interfaces

## Technologies Used

- PHP 7.4+
- MySQL
- HTML5
- CSS3 (with Tailwind CSS)
- JavaScript
- Google Fonts (Inter for headings, Roboto for body text)

## Admin Table

- Drop Existing table and create new one

```mysql
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    user_name VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    verified_yn ENUM('Y', 'N') NOT NULL DEFAULT 'N',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

