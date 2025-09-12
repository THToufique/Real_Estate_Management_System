# Real Estate Management System 🏠

**A comprehensive web-based Real Estate Management System built with PHP & MySQL featuring complete user authentication, role-based access control, and modern UI design.**  
> *University group project for Northern University Bangladesh*

---

## 📋 Overview

This system provides a **complete solution** for real estate agencies with:

- **🔐 Secure Authentication System** - User registration, login, role-based access
- **🏠 Property Management** - Complete CRUD operations with advanced search
- **👥 User Management** - Admin controls, user profiles, favorites system
- **📊 Analytics Dashboard** - Real-time statistics and insights
- **🎨 Modern UI** - Glassmorphism design with responsive layout

---

## ✨ Key Features

### 🔒 **Authentication & Security**
- User registration and secure login system
- Password hashing with PHP's `password_hash()`
- Role-based access control (Admin/User)
- Session management and CSRF protection
- SQL injection protection with prepared statements

### 👤 **User Features**
- Personal dashboard with favorites overview
- Advanced property search with filters
- Property favorites system
- User profile management
- Public property browsing (no login required)

### 🛠️ **Admin Features**
- Admin dashboard with system statistics
- Complete property management (CRUD)
- User management (activate/deactivate accounts)
- Agent and customer management
- Interactive database inspector
- Bulk operations and status updates

### 🏠 **Property System**
- Property listings with detailed information
- Image and document management
- Property status tracking (Available/Sold)
- Agent and owner associations
- Property viewings and maintenance logs

---

## 🛠️ Technology Stack

- **Frontend:** HTML5, CSS3 (Glassmorphism), JavaScript
- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Authentication:** Session-based with password hashing
- **Security:** Prepared statements, input validation
- **Server:** Apache (XAMPP/WAMP recommended)

---

## 📁 Complete File Structure
```
real-estate-system/
├── 📄 Authentication System
│   ├── login.php              # User login page
│   ├── register.php           # User registration
│   └── includes/
│       └── auth.php           # Authentication functions
│
├── 👑 Admin Panel
│   ├── admin/
│   │   ├── dashboard.php      # Admin dashboard
│   │   ├── manage_properties.php  # Property management
│   │   └── manage_users.php   # User management
│
├── 👤 User System
│   ├── user/
│   │   ├── dashboard.php      # User dashboard
│   │   ├── search.php         # Advanced property search
│   │   ├── favorites.php      # User favorites
│   │   ├── profile.php        # Profile management
│   │   └── add_favorite.php   # Favorite operations
│
├── 🏠 Property System
│   ├── index.php              # Main dashboard (login required)
│   ├── properties.php         # Public property browsing
│   ├── property_details.php   # Detailed property view
│   ├── add_property.php       # Add property (admin only)
│   ├── edit_property.php      # Edit property (admin only)
│   └── delete_property.php    # Delete property (admin only)
│
├── 👥 Management System
│   ├── add_agent.php          # Add agent (admin only)
│   ├── add_customer.php       # Add customer (admin only)
│   ├── add_owner.php          # Add owner (admin only)
│   └── db_inspector.php       # Database console (admin only)
│
├── 🗄️ Database
│   ├── real_estate_management_system.sql  # Main database schema
│   ├── auth_tables.sql        # Authentication tables
│   └── db_connect.php         # Database connection
│
└── 🎨 Assets
    └── css/
        └── style.css          # Glassmorphism styling
```

---

## 🗄️ Database Schema

The system includes **14 normalized tables**:

### Core Tables:
- `Properties`, `Agents`, `Owners`, `Customers`
- `Property_Viewings`, `Transactions`, `Offers`
- `Property_Features`, `Property_Images`, `Property_Documents`
- `Property_Maintenance`

### Authentication Tables:
- `Users` - User accounts with role management
- `User_Favorites` - User's favorite properties
- `User_Searches` - Search history tracking

---

## 🚀 Installation & Setup

### Prerequisites
- **PHP 7.4+** with mysqli extension
- **MySQL 5.7+** or MariaDB
- **Apache Server** (XAMPP/WAMP/LAMP)
- **Web Browser** (Chrome, Firefox, Safari)

### Installation Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/THToufique/Real_Estate_Management_System.git
   cd Real_Estate_Management_System
   ```

2. **Database Setup:**
   ```sql
   CREATE DATABASE RealEstateDB;
   USE RealEstateDB;
   
   -- Import main schema
   SOURCE real_estate_management_system.sql;
   
   -- Import authentication tables
   SOURCE auth_tables.sql;
   ```

3. **Configure Database Connection:**
   ```php
   // Edit db_connect.php
   $host = "localhost";
   $user = "root";
   $password = "your_password";
   $database = "RealEstateDB";
   ```

4. **Start Server:**
   - Start Apache and MySQL services
   - Access via `http://localhost/Real_Estate_Management_System`

---

## 🎯 Usage Guide

### 🔐 **Getting Started**
1. **Browse Properties:** Visit `properties.php` (no login required)
2. **Register Account:** Create new user account via `register.php`
3. **Login:** Access system via `login.php`

### 👤 **For Users**
- **Dashboard:** View favorites and quick actions
- **Search:** Advanced filtering by location, price, type, bedrooms
- **Favorites:** Save and manage favorite properties
- **Profile:** Update personal information

### 👑 **For Admins**
- **Default Admin:** Username: `admin`, Password: `admin123`
- **Dashboard:** System statistics and management tools
- **Properties:** Add, edit, delete, and manage property status
- **Users:** View, activate, deactivate user accounts
- **Database:** Advanced SQL query console

---

## 🔒 Security Features

- ✅ **Password Hashing** - Secure bcrypt hashing
- ✅ **SQL Injection Protection** - Prepared statements
- ✅ **Session Security** - Proper session management
- ✅ **Role-Based Access** - Admin/User permission levels
- ✅ **Input Validation** - Server-side validation
- ✅ **CSRF Protection** - Form token validation

---

## 🎨 UI/UX Features

- **🌟 Glassmorphism Design** - Modern translucent UI elements
- **📱 Responsive Layout** - Mobile-friendly design
- **🎯 Intuitive Navigation** - Role-based menu system
- **⚡ Fast Loading** - Optimized database queries
- **🔍 Advanced Search** - Multiple filter options
- **❤️ Favorites System** - One-click property saving

---

## 🚀 Future Enhancements

- [ ] Email verification for registration
- [ ] Password reset functionality
- [ ] Property viewing appointments
- [ ] Real-time messaging system
- [ ] Payment integration
- [ ] Property comparison tool
- [ ] Mobile app development
- [ ] API development for third-party integration

---

## 👥 Development Team

**Northern University Bangladesh** - Computer Science & Engineering

1. **Md. Taslimul Hasan Toufique** - [GitHub](https://github.com/THToufique)
2. **Sadia Sultana Mim** - [GitHub](https://github.com/sadia-s-mim)  
3. **Umma Kulsum Juthy** - [GitHub](https://github.com/UMMAJUTHY36)

---

## 📄 License

This project is developed for educational purposes as part of university coursework.

---

## 🤝 Contributing

This is an educational project. For suggestions or improvements, please create an issue or submit a pull request.

---

**⭐ If you find this project helpful, please give it a star!**
