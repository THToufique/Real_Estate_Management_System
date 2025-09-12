# Authentication System Setup Guide

## Database Setup

1. **Run the authentication tables SQL:**
   ```sql
   -- Execute the contents of auth_tables.sql in your MySQL database
   -- This adds Users, User_Favorites, and User_Searches tables
   ```

2. **Default Admin Account:**
   - Username: `admin`
   - Email: `admin@realestate.com`
   - Password: `admin123`

## Features Added

### User Features:
- **Registration/Login System** - Secure password hashing
- **User Dashboard** - Personal overview with favorites count
- **Property Search** - Advanced filtering (location, price, type, bedrooms)
- **Favorites System** - Save and manage favorite properties
- **Responsive Navigation** - Context-aware menu based on login status

### Admin Features:
- **Admin Dashboard** - System statistics and quick actions
- **Property Management** - View, edit, delete, toggle status
- **User Management** - View users, activate/deactivate accounts
- **Secure Access** - Admin-only areas with role-based protection

## File Structure Added:
```
├── auth_tables.sql          # Database tables for authentication
├── login.php               # User login page
├── register.php            # User registration page
├── includes/
│   └── auth.php           # Authentication functions
├── admin/
│   ├── dashboard.php      # Admin main dashboard
│   ├── manage_properties.php  # Property management
│   └── manage_users.php   # User management
└── user/
    ├── dashboard.php      # User main dashboard
    ├── search.php         # Advanced property search
    ├── favorites.php      # User's favorite properties
    └── add_favorite.php   # Add property to favorites
```

## Security Features:
- Password hashing with PHP's `password_hash()`
- Session-based authentication
- SQL injection protection with prepared statements
- Role-based access control (admin/user)
- CSRF protection on forms

## Usage:
1. Import `auth_tables.sql` into your database
2. Access the system via `index.php`
3. Register new users or login with admin credentials
4. Admin users get access to management panels
5. Regular users can search and favorite properties

## Next Steps:
- Add email verification for registration
- Implement password reset functionality  
- Add property viewing appointment system
- Create messaging system between users and agents
