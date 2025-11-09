# 🍽️ EatOut - Restaurant Management System

**Dine With Ease** - A modern restaurant reservation and management platform built with Symfony 7.

## ✨ Features

### For Users
- 🏪 Browse restaurants and explore menus
- 🍽️ View dishes with images and categories
- 📅 Make reservations easily
- 👤 Manage personal profile
- 📊 Track reservation history
- ✅ View reservation status (Pending, Confirmed, Completed, Cancelled)

### For Administrators
- 🎛️ Admin dashboard with statistics
- 🏪 Full restaurant management (CRUD)
- 🍽️ Dish management with image uploads
- 📅 Reservation management and status control
- 👥 User management
- 📊 Reservation status breakdown

## 🛠️ Tech Stack

- **Framework:** Symfony 7.3
- **Database:** MySQL/MariaDB
- **PHP:** 8.2+
- **Authentication:** Symfony Security
- **Frontend:** Twig templates with custom CSS
- **File Upload:** Symfony File component

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- MySQL/MariaDB

## 🚀 Installation

1. **Clone the repository**
```bash
git clone <your-repo-url>
cd gestion-restaurant
```

2. **Install dependencies**
```bash
composer install
```

3. **Configure environment**
```bash
cp .env .env.local
# Edit .env.local with your database credentials
```

4. **Create database**
```bash
php bin/console doctrine:database:create
```

5. **Run migrations** (or use the SQL schema)
```bash
# Create tables manually or run migrations
```

6. **Create admin user**
```bash
php bin/console app:create-admin
```
This creates:
- Admin: `admin@admin.com` / `admin123`
- User: `user@user.com` / `user123`

7. **Start the server**
```bash
symfony server:start
# or
php -S localhost:8000 -t public
```

8. **Access the application**
```
http://localhost:8000
```

## 📁 Project Structure

```
gestion-restaurant/
├── config/              # Configuration files
├── public/              # Public assets
│   ├── css/            # Stylesheets
│   ├── images/         # Static images
│   └── uploads/        # User uploads (dishes)
├── src/
│   ├── Controller/     # Controllers
│   ├── Entity/         # Doctrine entities
│   ├── Form/           # Form types
│   ├── Repository/     # Repositories
│   └── Command/        # Console commands
├── templates/          # Twig templates
└── var/                # Cache and logs
```

## 🎨 Features Overview

### Reservation Status Workflow
1. **Pending** - User creates reservation
2. **Confirmed** - Admin approves
3. **Completed** - Service fulfilled
4. **Cancelled** - User/Admin cancels

### Dish Categories
- Appetizer
- Main Course
- Dessert
- Beverage
- Side Dish

### User Roles
- **ROLE_USER** - Can browse, reserve, manage own reservations
- **ROLE_ADMIN** - Full system access

## 📝 Database Schema

Main entities:
- **User** - Authentication and profile
- **Restaurant** - Restaurant information
- **Dish** - Menu items with categories and images
- **Reservation** - Bookings with status tracking

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request


**EatOut** - Making restaurant reservations simple and efficient! 🍽️
