--create database 
CREATE DATABASE ecommerce_db;

-- 1. User Table for Registration and Login
CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL, -- Store hashed passwords for security
    Email VARCHAR(100) UNIQUE NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Insert sample data into Users table
INSERT INTO Users (Username, Password, Email) VALUES
('john_doe', 'hashed_password1', 'john@example.com'),
('jane_smith', 'hashed_password2', 'jane@example.com'),
('alice_williams', 'hashed_password3', 'alice.williams@example.com'),
('michael_jones', 'hashed_password4', 'michael.jones@example.com'),
('emily_brown', 'hashed_password5', 'emily.brown@example.com'),
('david_clark', 'hashed_password6', 'david.clark@example.com'),
('sarah_davis', 'hashed_password7', 'sarah.davis@example.com'),
('chris_miller', 'hashed_password8', 'chris.miller@example.com'),
('olivia_garcia', 'hashed_password9', 'olivia.garcia@example.com'),
('daniel_rodriguez', 'hashed_password10', 'daniel.rodriguez@example.com');







-- 2. JSON Data Table for Orders and Customers
CREATE TABLE Orders_Customers (
    DataID INT PRIMARY KEY AUTO_INCREMENT,
    JSONData JSON NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert JSON data into Orders_Customers table
INSERT INTO Orders_Customers (JSONData)
VALUES
(
    '{
        "customers": [
            {"customer_id": 1, "name": "John Doe", "email": "john@example.com"},
            {"customer_id": 2, "name": "Jane Smith", "email": "jane@example.com"}
        ],
        "orders": [
            {"order_id": 101, "customer_id": 1, "product": "Laptop", "amount": 1200.50, "order_date": "2024-11-25"},
            {"order_id": 102, "customer_id": 2, "product": "Smartphone", "amount": 800.00, "order_date": "2024-11-26"}
        ]
    }'
),
(
    '{
        "customers": [
            {"customer_id": 3, "name": "Alice Johnson", "email": "alice@example.com"},
            {"customer_id": 4, "name": "Bob Brown", "email": "bob@example.com"}
        ],
        "orders": [
            {"order_id": 103, "customer_id": 3, "product": "Tablet", "amount": 500.00, "order_date": "2024-11-27"},
            {"order_id": 104, "customer_id": 4, "product": "Monitor", "amount": 300.00, "order_date": "2024-11-28"}
        ]
    }'
),
(
    '{
        "customers": [
            {"customer_id": 5, "name": "Charlie White", "email": "charlie@example.com"},
            {"customer_id": 6, "name": "Diana Green", "email": "diana@example.com"}
        ],
        "orders": [
            {"order_id": 105, "customer_id": 5, "product": "Keyboard", "amount": 75.00, "order_date": "2024-11-29"},
            {"order_id": 106, "customer_id": 6, "product": "Headphones", "amount": 150.00, "order_date": "2024-11-30"}
        ]
    }'
),
(
    '{
        "customers": [
            {"customer_id": 7, "name": "Ethan Clark", "email": "ethan@example.com"},
            {"customer_id": 8, "name": "Fiona Adams", "email": "fiona@example.com"}
        ],
        "orders": [
            {"order_id": 107, "customer_id": 7, "product": "Mouse", "amount": 50.00, "order_date": "2024-12-01"},
            {"order_id": 108, "customer_id": 8, "product": "Printer", "amount": 200.00, "order_date": "2024-12-02"}
        ]
    }'
),
(
    '{
        "customers": [
            {"customer_id": 9, "name": "George Hill", "email": "george@example.com"},
            {"customer_id": 10, "name": "Hannah Scott", "email": "hannah@example.com"}
        ],
        "orders": [
            {"order_id": 109, "customer_id": 9, "product": "Router", "amount": 120.00, "order_date": "2024-12-03"},
            {"order_id": 110, "customer_id": 10, "product": "Camera", "amount": 600.00, "order_date": "2024-12-04"}
        ]
    }'
),
(
    '{
        "customers": [
            {"customer_id": 11, "name": "Ian Carter", "email": "ian@example.com"},
            {"customer_id": 12, "name": "Julia Lopez", "email": "julia@example.com"}
        ],
        "orders": [
            {"order_id": 111, "customer_id": 11, "product": "TV", "amount": 900.00, "order_date": "2024-12-05"},
            {"order_id": 112, "customer_id": 12, "product": "Soundbar", "amount": 250.00, "order_date": "2024-12-06"}
        ]
    }'
);







-- 3. Sales Report Table
CREATE TABLE SalesReport (
    ReportID INT PRIMARY KEY AUTO_INCREMENT,
    ProductID INT NOT NULL,
    ProductName VARCHAR(100),
    TotalSales DECIMAL(10, 2),
    TotalOrders INT,
    ReportDate DATE DEFAULT CURRENT_DATE
);

-- Insert sample data into SalesReport table
INSERT INTO SalesReport (ProductID, ProductName, TotalSales, TotalOrders, ReportDate) 
VALUES 
(1, 'Product A', 5000.00, 200, '2024-11-01'),
(2, 'Product B', 3000.00, 150, '2024-11-01'),
(3, 'Product C', 7000.00, 300, '2024-11-01'),
(4, 'product D', 5000.00, 400, '2024-11-01'),
(6, 'Product F', 6200.00, 300, '2024-11-02'),
(7, 'Product G', 4500.00, 250, '2024-11-02'),
(8, 'Product H', 7000.00, 500, '2024-11-03'),
(9, 'Product I', 5600.00, 350, '2024-11-03'),
(10, 'Product J', 4800.00, 280, '2024-11-04');




--Joints

--This query joins Users and SalesReport tables to find the total sales per user.

SELECT 
    U.Username,
    SUM(SR.TotalSales) AS TotalSales
FROM 
    Users U
JOIN 
    SalesReport SR ON U.UserID = SR.ProductID
GROUP BY 
    U.UserID;



--This query joins Users and SalesReport to show which products have been sold by each user.


SELECT 
    U.Username,
    SR.ProductName
FROM 
    Users U
JOIN 
    SalesReport SR ON U.UserID = SR.ProductID;





--Sub Queries

--Total Sales by Product (Subquery) This query uses a subquery to calculate the total sales for each product.

SELECT 
    ProductName,
    (SELECT SUM(TotalSales) 
     FROM SalesReport SR 
     WHERE SR.ProductName = PR.ProductName) AS TotalSales
FROM 
    (SELECT DISTINCT ProductName FROM SalesReport) AS PR
ORDER BY 
    TotalSales DESC;


--Top Customer by Total Sales (Subquery) This query uses a subquery to find the customer with the highest total sales.

SELECT 
    Username,
    Email,
    (SELECT SUM(TotalSales) 
     FROM SalesReport SR 
     WHERE SR.ProductID = U.UserID) AS TotalSpent
FROM 
    Users U
ORDER BY 
    TotalSpent DESC
LIMIT 1;







--PL/SQL
DELIMITER $$

CREATE PROCEDURE GetSalesByProduct()
BEGIN
    DECLARE done INT DEFAULT 0;
    DECLARE prod_name VARCHAR(100);
    DECLARE total_sales DECIMAL(10, 2);
    DECLARE product_cursor CURSOR FOR
        SELECT ProductName FROM SalesReport GROUP BY ProductName;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    OPEN product_cursor;
    
    read_loop: LOOP
        FETCH product_cursor INTO prod_name;
        IF done THEN
            LEAVE read_loop;
        END IF;

        -- Calculate the total sales for each product
        SELECT SUM(TotalSales) INTO total_sales
        FROM SalesReport
        WHERE ProductName = prod_name;

        -- Output the result for this product
        SELECT prod_name AS Product_Name, total_sales AS Total_Sales;

    END LOOP;

    CLOSE product_cursor;
END$$

DELIMITER ;

--triggers
CREATE TABLE UserAuditLog (
    LogID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT,
    Action VARCHAR(50),
    LogTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

DELIMITER //
CREATE TRIGGER after_user_insert
AFTER INSERT ON Users
FOR EACH ROW
BEGIN
    INSERT INTO UserAuditLog (UserID, Action)
    VALUES (NEW.UserID, 'User Registered');
END;
//
DELIMITER ;






-- xml data


<product>
        <id>13</id>
        <name>Printer</name>
        <price>250.00</price>
        <description>All-in-one printer with wireless printing and scanning.</description>
        <image>printer.jpg</image>
    </product>
    <product>
        <id>14</id>
        <name>Router</name>
        <price>100.00</price>
        <description>Dual-band Wi-Fi router with high-speed connectivity.</description>
        <image>router.jpg</image>
    </product>
    <product>
        <id>15</id>
        <name>Fitness Tracker</name>
        <price>80.00</price>
        <description>Waterproof fitness tracker with heart rate monitoring.</description>
        <image>fitness.jpg</image>
    </product>
    <product>
        <id>16</id>
        <name>Desk Lamp</name>
        <price>30.00</price>
        <description>LED desk lamp with adjustable brightness levels.</description>
        <image>desk.jpg</image>
    </product>
    <product>
        <id>17</id>
        <name>Power Bank</name>
        <price>50.00</price>
        <description>10000mAh power bank with fast charging support.</description>
        <image>powerbank.jpg</image>
    </product>
    <product>
        <id>18</id>
        <name>Webcam</name>
        <price>80.00</price>
        <description>HD webcam with built-in microphone for video calls.</description>
        <image>webcam.jpg</image>
    </product>
    <product>
        <id>19</id>
        <name>VR Headset</name>
        <price>300.00</price>
        <description>Immersive VR headset with motion controllers.</description>
        <image>vrheadset.jpg</image>
    </product>
    <product>
        <id>20</id>
        <name>Electric Kettle</name>
        <price>40.00</price>
        <description>1.5L electric kettle with auto shut-off feature.</description>
        <image>kettle.jpg</image>
    </product>
</products>




-- triggers


