# God's Grace Produce - Jinja 🌾

A modern e-commerce marketplace platform connecting farmers and produce sellers in Jinja, Uganda directly with customers. Buy fresh, high-quality agricultural products online with an easy-to-use interface.

![License](https://img.shields.io/badge/License-MIT-green.svg)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-lightblue.svg)
![Status](https://img.shields.io/badge/Status-Active-success.svg)

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technologies](#technologies)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Running the Project](#running-the-project)
- [User Roles](#user-roles)
- [File Descriptions](#file-descriptions)
- [Usage Guide](#usage-guide)
- [Contributing](#contributing)
- [Contact](#contact)

---

## 🎯 Overview

God's Grace Produce is a two-sided marketplace where:
- **Farmers & Sellers** can upload their agricultural products
- **Customers** can browse, purchase, and leave reviews
- **Platform** handles orders, payments tracking, and customer testimonials

This project was built to support local farmers in Jinja, Uganda by providing a digital platform to reach more customers.

---

## ✨ Features

### For Customers
✅ User registration and authentication  
✅ Browse products from multiple sellers  
✅ Advanced product details view  
✅ Shopping cart with quantity management  
✅ Secure checkout process  
✅ Order tracking and history  
✅ Write product testimonials and ratings  
✅ Customer dashboard  

### For Sellers
✅ Seller registration  
✅ Product upload with images  
✅ Edit and manage products  
✅ View customer orders  
✅ Track sales and revenue  
✅ Receive customer testimonials  
✅ Dedicated seller dashboard  

### General Features
✅ Responsive design (mobile & desktop)  
✅ Secure password hashing  
✅ Session management  
✅ Role-based access control  
✅ Dynamic testimonials section  
✅ Search and filter functionality  
✅ Attractive UI with Poppins font & Font Awesome icons  

---

## 🛠️ Technologies

| Technology | Purpose |
|-----------|---------|
| **PHP** | Backend server-side scripting |
| **MySQL** | Database management |
| **HTML5** | Markup & structure |
| **CSS3** | Styling & responsive design |
| **JavaScript** | Client-side interactions |
| **XAMPP** | Local development environment |
| **Font Awesome 6.5** | Icons |
| **Google Fonts (Poppins)** | Typography |

---

## 📁 Project Structure

```
god's-grace-produce/
│
├── config/
│   └── db.php                 # Database connection
│
├── uploads/
│   ├── hero.jpg              # Hero section background
│   ├── logo.png              # Site logo
│   └── [product-images]/     # User uploaded product images
│
├── index.php                 # Homepage with featured products
├── register.php              # User registration (customer/seller)
├── login.php                 # User login
├── logout.php                # Session destruction
├── profile.php               # User profile settings
│
├── shop.php                  # Product marketplace
├── product_details.php       # Individual product page
├── cart.php                  # Shopping cart
├── add_to_cart.php          # Add product to session cart
├── checkout.php              # Order checkout & placement
│
├── customer_dashboard.php    # Customer main dashboard
├── orders.php                # View customer orders
├── add_review.php            # Submit product testimonial
│
├── seller_dashboard.php      # Seller main dashboard
├── add_product.php           # Sellers upload new products
├── edit_product.php          # Sellers edit existing products
├── manage_products.php       # Sellers manage all products
├── seller_orders.php         # View orders for seller's products
│
├── database.sql              # Database schema & tables
└── README.txt               # Quick setup guide
```

---

## 💾 Installation

### Prerequisites
- **XAMPP** (Apache + MySQL + PHP)
- **Git** (optional)
- **Text Editor** (VS Code recommended)
- **Modern Web Browser**

### Steps

1. **Install XAMPP**
   - Download from [apachefriends.org](https://www.apachefriends.org/)
   - Install on your computer

2. **Clone or Download Project**
   ```bash
   # Clone repository
   git clone https://github.com/yourusername/gods-grace-produce.git

   # Or download ZIP and extract
   ```

3. **Copy to XAMPP Directory**
   ```
   Copy the project folder to: C:/xampp/htdocs/
   Rename folder to: godsgrace_project
   ```

4. **Start XAMPP**
   - Open XAMPP Control Panel
   - Click **Start** for Apache and MySQL

5. **Import Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Click **Import** tab
   - Select `database.sql` file
   - Click **Go** to create tables

6. **Configure Database Connection** (if needed)
   - Edit `config/db.php`
   - Verify MySQL credentials match your setup

7. **Access the Project**
   ```
   http://localhost/godsgrace_project
   ```

---

## 🗄️ Database Setup

### Database Structure

The project uses 4 main tables:

**users**
- id (Primary Key)
- fullname
- email (Unique)
- password (hashed)
- role (customer/seller)
- created_at

**products**
- id (Primary Key)
- name
- description
- price
- image
- seller_name
- created_at

**orders**
- id (Primary Key)
- user_id
- customer_name
- seller_name
- product_name
- price
- quantity
- total
- status (Pending/Completed)
- created_at

**reviews**
- id (Primary Key)
- customer_name
- seller_name
- rating (1-5)
- review
- created_at

### Import Database

```bash
# Via phpMyAdmin:
1. Go to http://localhost/phpmyadmin
2. Click "Import"
3. Select database.sql
4. Click "Go"

# Via Command Line:
mysql -u root -p < database.sql
```

---

## 🚀 Running the Project

### Development Server

```bash
# Start XAMPP services
1. Open XAMPP Control Panel
2. Start Apache
3. Start MySQL
4. Access: http://localhost/godsgrace_project
```

### First-Time Setup

1. **Create Test Accounts**
   - Register as **Customer**
   - Register as **Seller (Admin)**

2. **Test Customer Flow**
   - Browse shop
   - Add items to cart
   - Checkout
   - View orders

3. **Test Seller Flow**
   - Login as seller
   - Upload products
   - View customer orders

---

## 👥 User Roles

### Customer Role
- Browse and search products
- Add items to shopping cart
- Place orders
- View order history
- Write testimonials
- Access personal dashboard

**Default Routes:**
- Dashboard: `/customer_dashboard.php`
- Shop: `/shop.php`
- Orders: `/orders.php`

### Seller Role (Admin)
- Upload and manage products
- Edit product details
- Delete products
- View customer orders
- Track sales revenue
- View customer testimonials

**Default Routes:**
- Dashboard: `/seller_dashboard.php`
- Add Products: `/add_product.php`
- Manage: `/manage_products.php`

### Access Control
- Unauthorized access redirects to login
- Role-based route protection on all pages
- Session validation on protected pages

---

## 📄 File Descriptions

### Core Pages

| File | Purpose | Role |
|------|---------|------|
| `index.php` | Homepage with featured products | Public |
| `register.php` | User registration form | Public |
| `login.php` | User authentication | Public |
| `shop.php` | Product marketplace | Public |

### Customer Files

| File | Purpose |
|------|---------|
| `customer_dashboard.php` | Customer main hub |
| `orders.php` | View purchase history |
| `cart.php` | Shopping cart management |
| `add_to_cart.php` | Add product to cart |
| `checkout.php` | Order confirmation |
| `add_review.php` | Submit testimonial |

### Seller Files

| File | Purpose |
|------|---------|
| `seller_dashboard.php` | Seller main hub |
| `add_product.php` | Upload new product |
| `manage_products.php` | Edit/delete products |
| `edit_product.php` | Product modification |
| `seller_orders.php` | View incoming orders |

### Utility Files

| File | Purpose |
|------|---------|
| `config/db.php` | MySQL database connection |
| `profile.php` | User profile & password settings |
| `logout.php` | Session termination |
| `database.sql` | Database schema |

---

## 📖 Usage Guide

### For Customers

1. **Register Account**
   - Click "Register" on homepage
   - Select "Customer" role
   - Fill in details and submit

2. **Browse Products**
   - Click "Shop" in navigation
   - View all available products
   - See seller name and price

3. **Add to Cart**
   - Click "Add To Cart" button
   - Quantity can be adjusted in cart

4. **Checkout**
   - Click "Cart" → "Proceed To Checkout"
   - Review order details
   - Click "Place Order"

5. **Track Orders**
   - Go to "Dashboard" → "My Orders"
   - View all purchase history

6. **Write Testimonial**
   - Go to "Dashboard"
   - Scroll to "Write A Testimonial"
   - Submit rating and review

### For Sellers

1. **Register as Seller**
   - Click "Register"
   - Select "Seller (Admin)" role
   - Complete registration

2. **Upload Products**
   - Go to "Dashboard" → "Add Product"
   - Fill product details
   - Upload product image
   - Click "Upload Product"

3. **Manage Products**
   - Go to "Manage Products"
   - Click "Edit" to modify
   - Click "Delete" to remove

4. **View Orders**
   - Go to "Dashboard" → "View Orders"
   - See all customer orders for your products
   - Track customer names and quantities

5. **Monitor Sales**
   - Dashboard shows:
     - Total products uploaded
     - Number of orders
     - Total revenue (UGX)
     - Customer testimonials

---

## 🔐 Security Features

- ✅ Password hashing with `password_hash()`
- ✅ SQL injection prevention with `mysqli_real_escape_string()`
- ✅ Session-based authentication
- ✅ Role-based access control
- ✅ Protected routes with login checks
- ✅ Secure file uploads with unique naming

---

## 📱 Responsive Design

The project is fully responsive and works on:
- ✅ Desktop computers
- ✅ Tablets
- ✅ Mobile phones (360px and up)

CSS media queries ensure layouts adapt to all screen sizes.

---

## 🎨 Styling & UI

- **Font**: Google Fonts - Poppins
- **Icons**: Font Awesome 6.5.1
- **Colors**:
  - Primary Green: `#0f5132`
  - Secondary Green: `#198754`
  - Accent Orange: `#ff9800`
  - Warning Yellow: `#ffc107`

---

## 📝 Sample Test Data

### Test Account - Customer
- Email: `customer@test.com`
- Password: `password123`

### Test Account - Seller
- Email: `seller@test.com`
- Password: `password123`

---

## 🐛 Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| "Database connection failed" | Check MySQL is running in XAMPP |
| "Page not found (404)" | Verify project folder is in `htdocs` |
| "Images not displaying" | Check `uploads/` folder exists with write permissions |
| "Login not working" | Ensure database is imported correctly |
| "CORS errors" | This is local, shouldn't occur - clear browser cache |

---

## 📞 Contact & Support

**Project Location**: Jinja, Uganda

**Contact Information:**
- 📞 Phone: +256 769320868
- 📧 Email: info@godsgraceproduce.com
- 📍 Location: Jinja, Uganda

---

## 📄 License

This project is open source and available under the **MIT License**.

```
MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction...
```

See LICENSE file for full details.

---

## 🤝 Contributing

Contributions are welcome! To contribute:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Guidelines
- Follow existing code style
- Add comments for complex functions
- Test all features before submitting PR
- Update documentation if needed

---

## 🚀 Future Enhancements

Planned features:
- [ ] Payment gateway integration (Paypal, Stripe)
- [ ] Mobile app (iOS/Android)
- [ ] Real-time notifications
- [ ] Advanced product filters
- [ ] Seller ratings system
- [ ] Admin dashboard
- [ ] Email notifications
- [ ] Product variants (size, quantity)
- [ ] Wishlist feature
- [ ] Seller analytics dashboard

---

## 📊 Project Statistics

- **Files**: 21 PHP pages
- **Database Tables**: 4
- **Features**: 30+
- **Lines of Code**: 5000+
- **Responsive**: Yes (Mobile, Tablet, Desktop)

---

## 🙏 Acknowledgments

- Built with ❤️ for Jinja farmers
- Inspired by modern e-commerce platforms
- Thanks to the open-source community
- Icon library: Font Awesome
- Fonts: Google Fonts

---

## 📜 Changelog

### Version 1.0.0 (Initial Release)
- Complete marketplace functionality
- Customer & seller roles
- Product management system
- Order tracking
- Testimonial system
- Responsive design

---

**Made with ❤️ for farmers in Jinja, Uganda**

---

*Last Updated: May 2026*  
*Maintained by: God's Grace Produce Team*
