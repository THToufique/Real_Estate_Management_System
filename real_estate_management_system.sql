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