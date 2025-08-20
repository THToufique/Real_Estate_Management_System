-- ===============================================
-- REAL ESTATE MANAGEMENT SYSTEM - COMPLETE SQL PROJECT
-- ===============================================

-- DATABASE CREATION
-- CREATE DATABASE RealEstateDB;
USE RealEstateDB;

-- ===============================================
-- TABLE CREATION
-- ===============================================

-- 1. AGENTS TABLE
CREATE TABLE Agents (
    agent_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    commission_rate DECIMAL(5,2) DEFAULT 2.5,
    hire_date DATE NOT NULL,
    experience_years INT DEFAULT 0,
    status ENUM('Active', 'Inactive') DEFAULT 'Active'
);

-- 2. OWNERS TABLE
CREATE TABLE Owners (
    owner_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    address TEXT,
    registration_date DATE DEFAULT (CURRENT_DATE)
);

-- 3. CUSTOMERS TABLE
CREATE TABLE Customers (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    budget_min DECIMAL(12,2),
    budget_max DECIMAL(12,2),
    preferred_location VARCHAR(100),
    customer_type ENUM('Buyer', 'Renter') NOT NULL,
    registration_date DATE DEFAULT (CURRENT_DATE)
);

-- 4. PROPERTIES TABLE
CREATE TABLE Properties (
    property_id INT PRIMARY KEY AUTO_INCREMENT,
    owner_id INT NOT NULL,
    agent_id INT,
    address TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    zipcode VARCHAR(10),
    property_type ENUM('House', 'Apartment', 'Commercial', 'Land') NOT NULL,
    bedrooms INT DEFAULT 0,
    bathrooms INT DEFAULT 0,
    area_sqft DECIMAL(10,2),
    price DECIMAL(12,2) NOT NULL,
    status ENUM('Available', 'Sold', 'Rented', 'Under Contract') DEFAULT 'Available',
    listing_date DATE DEFAULT (CURRENT_DATE),
    description TEXT,
    FOREIGN KEY (owner_id) REFERENCES Owners(owner_id),
    FOREIGN KEY (agent_id) REFERENCES Agents(agent_id)
);

-- 5. PROPERTY VIEWINGS TABLE
CREATE TABLE Property_Viewings (
    viewing_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    customer_id INT NOT NULL,
    agent_id INT NOT NULL,
    viewing_date DATETIME NOT NULL,
    feedback TEXT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    interested ENUM('Yes', 'No', 'Maybe') DEFAULT 'Maybe',
    FOREIGN KEY (property_id) REFERENCES Properties(property_id),
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
    FOREIGN KEY (agent_id) REFERENCES Agents(agent_id)
);

-- 6. TRANSACTIONS TABLE
CREATE TABLE Transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    buyer_id INT NOT NULL,
    seller_id INT NOT NULL,
    agent_id INT NOT NULL,
    sale_price DECIMAL(12,2) NOT NULL,
    commission_amount DECIMAL(10,2),
    transaction_date DATE DEFAULT (CURRENT_DATE),
    transaction_type ENUM('Sale', 'Rent') NOT NULL,
    payment_method ENUM('Cash', 'Loan', 'Installment') DEFAULT 'Loan',
    FOREIGN KEY (property_id) REFERENCES Properties(property_id),
    FOREIGN KEY (buyer_id) REFERENCES Customers(customer_id),
    FOREIGN KEY (seller_id) REFERENCES Owners(owner_id),
    FOREIGN KEY (agent_id) REFERENCES Agents(agent_id)
);

-- 7. PROPERTY_FEATURES TABLE
CREATE TABLE Property_Features (
    feature_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    feature_name VARCHAR(100) NOT NULL,
    feature_value VARCHAR(255),
    FOREIGN KEY (property_id) REFERENCES Properties(property_id)
);

-- 8. PROPERTY_IMAGES TABLE
CREATE TABLE Property_Images (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    image_description VARCHAR(255),
    upload_date DATE DEFAULT (CURRENT_DATE),
    is_primary BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (property_id) REFERENCES Properties(property_id)
);

-- 9. PROPERTY_MAINTENANCE TABLE
CREATE TABLE Property_Maintenance (
    maintenance_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    description TEXT NOT NULL,
    maintenance_date DATE NOT NULL,
    cost DECIMAL(10,2),
    status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    contractor_name VARCHAR(100),
    FOREIGN KEY (property_id) REFERENCES Properties(property_id)
);

-- 10. OFFERS TABLE
CREATE TABLE Offers (
    offer_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    customer_id INT NOT NULL,
    offer_amount DECIMAL(12,2) NOT NULL,
    offer_date DATE DEFAULT (CURRENT_DATE),
    status ENUM('Pending', 'Accepted', 'Rejected') DEFAULT 'Pending',
    notes TEXT,
    FOREIGN KEY (property_id) REFERENCES Properties(property_id),
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id)
);

-- 11. PROPERTY_DOCUMENTS TABLE
CREATE TABLE Property_Documents (
    document_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    document_type ENUM('Title', 'Deed', 'Survey', 'Tax Record', 'Other') NOT NULL,
    document_url VARCHAR(255) NOT NULL,
    upload_date DATE DEFAULT (CURRENT_DATE),
    description TEXT,
    FOREIGN KEY (property_id) REFERENCES Properties(property_id)
);
