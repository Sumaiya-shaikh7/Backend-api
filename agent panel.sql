-- Create Database
CREATE DATABASE IF NOT EXISTS transport_db;
USE transport_db;

-- ===============================
-- USER / AUTH MANAGEMENT
-- ===============================

-- User roles: admin, agent, driver, customer
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO roles(role_name) VALUES
('admin'), ('agent'), ('driver'), ('customer');

-- All users login table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(120) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- ===============================
-- AGENTS PANEL TABLES
-- ===============================
CREATE TABLE agents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,
    company_name VARCHAR(150),
    gst_number VARCHAR(40),
    address TEXT,
    city VARCHAR(60),
    state VARCHAR(60),
    pincode VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE My_Loads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id INT NOT NULL,
    load_code VARCHAR(50) UNIQUE, -- Load #1, #2, etc.
    category VARCHAR(100), -- Refrigerated, Electronics, etc.
    pickup_city VARCHAR(120),
    pickup_state VARCHAR(120),
    drop_city VARCHAR(120),
    drop_state VARCHAR(120),
    distance_km DECIMAL(10,2),
    freight_amount DECIMAL(10,2),
    pickup_date DATE,
    status ENUM('pending','active','completed','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES agents(id)
);

CREATE TABLE Post_Loads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id INT NOT NULL,
    -- From UI
    pickup_city VARCHAR(100),
    pickup_state VARCHAR(100),
    delivery_city VARCHAR(100),
    delivery_state VARCHAR(100),
    load_weight VARCHAR(50),
    freight_amount DECIMAL(10,2),
    freight_range VARCHAR(100),
    pickup_date DATE,
    pickup_time VARCHAR(50),
    vehicle_required VARCHAR(100),
    vehicle_type_required VARCHAR(100),
    additional_charges JSON,
    special_instructions TEXT,
    status ENUM('pending','active','assigned','completed','cancelled') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES users(id)
);


CREATE TABLE After_Posting (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- linked load
    load_id INT NOT NULL,
    -- Reference number shown to user: #TC12478
    reference_code VARCHAR(30) NOT NULL UNIQUE,
    -- Summary Values
    total_distance_km INT,
    expected_freight DECIMAL(10,2),
    driver_matches INT DEFAULT 0,
    avg_response_minutes INT DEFAULT 0,
    -- Tracking Status
    is_tracking_enabled TINYINT DEFAULT 0,
    -- Route Summary (city names or formatted string)
    pickup_location VARCHAR(120),
    delivery_location VARCHAR(120),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES My_Loads(id)
);

CREATE TABLE Wallet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Agent who owns the wallet
    agent_id INT NOT NULL,
    -- Current Amount visible in UI
    total_balance DECIMAL(12,2) DEFAULT 0,
    -- Monthly earnings summary
    monthly_earnings DECIMAL(12,2) DEFAULT 0,
    -- Withdrawn amount summary
    withdrawn_amount DECIMAL(12,2) DEFAULT 0,
    -- Pending payment summary
    pending_amount DECIMAL(12,2) DEFAULT 0,
    -- % growth or decline for display (+12.5%)
    monthly_growth_percent DECIMAL(5,2) DEFAULT 0,
    last_updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES agents(id),
    available_balance DECIMAL(10,2) DEFAULT 0.00,
    in_transit_balance DECIMAL(10,2) DEFAULT 0.00,
    pending_balance DECIMAL(10,2) DEFAULT 0.00,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE Reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    activity_type VARCHAR(50) NOT NULL,      -- New Load, Commission Earned, Job Completed, Payment Received
    description VARCHAR(255) NOT NULL,       -- e.g., "New load posted", "Job completed"
    amount DECIMAL(10,2) DEFAULT NULL,       -- ₹25,000 / ₹1,200 / ₹18,500 (if applicable)
    route_info VARCHAR(100) DEFAULT NULL,    -- e.g., "Mumbai → Delhi" (only for job completion)
    created_at DATETIME NOT NULL,            -- e.g., "2 hours ago", "1 day ago"
    -- KPI Data (for Dashboard)
    total_revenue DECIMAL(12,2) DEFAULT 0,   -- e.g., 185000
    completed_jobs INT DEFAULT 0,            -- e.g., 28
    driver_partners INT DEFAULT 0,           -- e.g., 15
    avg_commission DECIMAL(10,2) DEFAULT 0   -- e.g., 6200
);



CREATE TABLE live_route_tracker (
    id INT AUTO_INCREMENT PRIMARY KEY,
    source_location VARCHAR(255) NOT NULL,
    destination_location VARCHAR(255) NOT NULL,
    travel_mode ENUM('driving', 'walking') DEFAULT 'driving',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


