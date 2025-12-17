CREATE DATABASE IF NOT EXISTS transpot_db;
USE transpot_db;

-- =============================
-- AGENTS TABLE
-- =============================
CREATE TABLE IF NOT EXISTS agents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    password VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- =============================
-- DRIVERS TABLE
-- =============================
CREATE TABLE IF NOT EXISTS drivers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    license_number VARCHAR(100),
    license_image VARCHAR(255),
    vehicle_number VARCHAR(50),
    vehicle_type VARCHAR(50),
    status VARCHAR(20) DEFAULT 'offline',
    approval_status VARCHAR(20) DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES agents(id)
);

-- =============================
-- VEHICLES TABLE
-- =============================
CREATE TABLE IF NOT EXISTS vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    driver_id INT NOT NULL,
    vehicle_number VARCHAR(50),
    vehicle_type VARCHAR(50),
    rc_image VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (driver_id) REFERENCES drivers(id)
);

-- =============================
-- LOADS TABLE
-- =============================
CREATE TABLE IF NOT EXISTS loads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id INT NOT NULL,
    load_code VARCHAR(50) UNIQUE,
    pickup_location VARCHAR(255),
    drop_location VARCHAR(255),
    material VARCHAR(255),
    weight VARCHAR(50),
    truck_type VARCHAR(50),
    budget VARCHAR(50),
    status VARCHAR(20) DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES agents(id)
);

-- =============================
-- DRIVER LOADS (Accepted/Rejected)
-- =============================
CREATE TABLE IF NOT EXISTS driver_loads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    load_id INT NOT NULL,
    driver_id INT NOT NULL,
    status VARCHAR(20) DEFAULT 'pending', 
    -- pending / accepted / rejected / completed
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (load_id) REFERENCES loads(id),
    FOREIGN KEY (driver_id) REFERENCES drivers(id)
);

-- =============================
-- DRIVER NOTIFICATIONS
-- =============================
CREATE TABLE IF NOT EXISTS driver_notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    driver_id INT NOT NULL,
    title VARCHAR(255),
    message TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (driver_id) REFERENCES drivers(id)
);
