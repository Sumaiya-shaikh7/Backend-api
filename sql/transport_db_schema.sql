-- Database and tables for TransConnect (Agent + Driver)
CREATE DATABASE IF NOT EXISTS transconnect_db;
USE transconnect_db;

CREATE TABLE IF NOT EXISTS drivers (
    id INT AUTO_INCREMENT PRIMARY KEY,

    agent_id INT NOT NULL,               -- Driver belongs to which agent
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,

    image VARCHAR(255),                  -- Driver profile photo
    license_number VARCHAR(100),         -- Driving license
    license_image VARCHAR(255),          -- License photo
    vehicle_number VARCHAR(50),          -- Vehicle plate
    vehicle_type VARCHAR(50),            -- Truck/Car/Bike/etc

    status VARCHAR(20) DEFAULT 'offline',   -- online/offline/busy
    approval_status VARCHAR(20) DEFAULT 'pending', 
        -- pending / approved / rejected

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS loads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id INT,
    driver_id INT DEFAULT NULL,
    pickup_city VARCHAR(255),
    drop_city VARCHAR(255),
    distance VARCHAR(50),
    pay DECIMAL(10,2),
    eta VARCHAR(100),
    status VARCHAR(50) DEFAULT 'available',
    estimated_earnings DECIMAL(10,2) DEFAULT 0,
    vehicle_type VARCHAR(50) DEFAULT NULL,
    weight VARCHAR(50) DEFAULT NULL,
    special_requirements TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    accepted_at DATETIME NULL
);

CREATE TABLE IF NOT EXISTS wallet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    driver_id INT,
    available DECIMAL(10,2) DEFAULT 0,
    pending DECIMAL(10,2) DEFAULT 0,
    total_balance DECIMAL(10,2) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS performance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    driver_id INT,
    rating DECIMAL(3,1) DEFAULT 0,
    completed_jobs INT DEFAULT 0,
    ontime_rate INT DEFAULT 0,
    weekly_miles INT DEFAULT 0
);

-- sample data
INSERT INTO drivers (name,email,phone,password,image,status) VALUES
('John Driver','john@example.com','9876501234','uploads/driver/profile_images/john.png','online');

INSERT INTO wallet (driver_id,available,pending,total_balance) VALUES (1,4000.75,8450.00,12450.75);

INSERT INTO performance (driver_id,rating,completed_jobs,ontime_rate,weekly_miles) VALUES (1,4.8,24,96,1248);

INSERT INTO loads (agent_id,pickup_city,drop_city,distance,pay,eta,status,estimated_earnings,vehicle_type,weight,special_requirements) VALUES
(10,'Los Angeles, CA','San Francisco, CA','382 mi',860,'4 hours 30 mins','in_progress',860,'Dry Van','12000 lbs','Liftgate Required;Appointment Required;Secure Parking'),
(11,'Austin, TX','Dallas, TX','248 mi',5400,'3 hours','available',5400,'Dry Van','12000 lbs','Liftgate Required;Appointment Required');
