## Real Estate Management System 🏠


 **A comprehensive web-based Real Estate Management System built with PHP & MySQL for managing properties, agents, customers, and transactions.**  
> *This is a university group project developed for educational purposes.*


## 📋 Overview

This system provides a **complete solution** for real estate agencies to:

- Manage property listings  
- Track agents and commissions  
- Register buyers and renters  
- Record transactions and offers  
- Monitor property viewings and maintenance  

It features a **modern glassmorphism UI** and **responsive design** for desktop and mobile devices.

---

## ✨ Features

- Property CRUD (Create, Read, Update, Delete)  
- Agent & Customer Management  
- Transaction Tracking (Sales & Rentals)  
- Property Viewings & Feedback  
- Offers & Negotiation Management  
- Property Maintenance Logs  
- Property Images & Documents Management  
- Interactive Database Inspector  

---

## 🛠️ Technology Stack

- **Frontend:** HTML5, CSS3 (Glassmorphism)  
- **Backend:** PHP  
- **Database:** MySQL  
- **Server:** Apache (XAMPP/WAMP recommended)

---

## 📁 File Structure
```
real-estate-system/
├── index.php              # Main property listing page
├── db\_connect.php         # Database connection
├── real\_estate\_system.sql # Database schema + sample data
├── db\_inspector.php       # SQL query console
├── add\_property.php       # Add property form
├── insert\_property.php    # Insert property backend
├── edit\_property.php      # Edit property form
├── update\_property.php    # Update property backend
├── delete\_property.php    # Delete property
├── add\_agent.php          # Add agent form
├── insert\_agent.php       # Insert agent backend
├── add\_customer.php       # Add customer form
├── insert\_customer.php    # Insert customer backend
└── css/
└── style.css                # Glassmorphism styling

```


---

## 🗄️ Database Schema

The system includes **11 normalized tables**:

- `Agents`, `Owners`, `Customers`  
- `Properties`, `Property_Viewings`, `Transactions`  
- `Property_Features`, `Property_Images`, `Property_Maintenance`  
- `Offers`, `Property_Documents`  

---

## 🚀 Installation

### Prerequisites

- PHP 7.0+  
- MySQL 5.7+  
- Apache server (XAMPP/WAMP recommended)

### Steps

1. Clone/download the repo to your server directory (`htdocs` for XAMPP).  
2. Create the database:

```sql
CREATE DATABASE RealEstateDB; 
```

1. Import `real_estate_system.sql` into MySQL. 
2. Configure database credentials in `db_connect.php`.
3. Start the server and open the project in your browser.

---
## 🎯 Usage

- **View Properties:** `index.php`

- **Add Property / Agent / Customer:** Use respective forms
- **Track Transactions, Offers, Viewings, Maintenance:** Built-in modules
- **Explore Database:** db_inspector.php for running SQL queries

---
## 🔒 Security Notes

For educational purposes only. Not production-ready.


- Use **prepared statements** for security
- Add **authentication & authorization** for production
- Validate all user inputs

---
## 👥 Development Team

University project for **Northern University Bangladesh**:

1. Md.Taslimul Hasan Toufique (github.com/THToufique)
2. Sadia Sultana Mim (github.com/sadia-s-mim)
3. Umma Kulsum Juthy (github.com/UMMAJUTHY36)
