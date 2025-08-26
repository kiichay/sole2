create database soletech;

USE soletech;
SHOW TABLES;
CREATE TABLE BUYER (
    buyer_id VARCHAR(10) PRIMARY KEY,                     -- Unique identifier for each buyer with prefix (e.g., BY000001)
    buyer_username VARCHAR(100) NOT NULL,                 -- Username for login
    buyer_password VARCHAR(100) NOT NULL,                 -- Encrypted password for the buyer
    buyer_firstname VARCHAR(100) NOT NULL,                -- First name of the buyer
    buyer_lastname VARCHAR(100) NOT NULL,                 -- Last name of the buyer
    buyer_contactnumber VARCHAR(15) NOT NULL,             -- Contact number for communication
    buyer_address VARCHAR(255) NOT NULL,                  -- Shipping or billing address
    buyer_profileimage TEXT,                              -- Path to profile image
    buyer_email VARCHAR(150) NOT NULL,                    -- Email address for communication
    buyer_verified BOOLEAN DEFAULT 0,                     -- Whether the buyer's email is verified (0 = no, 1 = yes)
    buyer_created_at DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Account creation timestamp
    buyer_status ENUM('Active', 'Inactive') NOT NULL,     -- Account status (Active or Inactive)
    buyer_last_login DATETIME                              -- Last login timestamp
);

-- (Storing Items Not Ordered Yet)
CREATE TABLE CART (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,        -- Unique identifier for each cart item
    buyer_id VARCHAR(10) NOT NULL,                  -- Foreign Key referencing the BUYER table
    shoe_id VARCHAR(10) NOT NULL,                   -- Foreign Key referencing the SHOES table
    quantity INT DEFAULT 1,                         -- Number of shoes selected by the buyer
    shoe_size VARCHAR(20),                          -- Size selected by the buyer
    shoe_color VARCHAR(50),                         -- Color selected by the buyer
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP,    -- Timestamp when the item was added to the cart
    FOREIGN KEY (buyer_id) REFERENCES BUYER(buyer_id) ON DELETE CASCADE, -- Foreign Key to BUYER table
    FOREIGN KEY (shoe_id) REFERENCES SHOES(shoe_id) ON DELETE CASCADE    -- Foreign Key to SHOES table
);


-- (For Storing Finalized Orders)
CREATE TABLE SHOES_ORDER (
    order_id INT AUTO_INCREMENT PRIMARY KEY,              -- Unique identifier for each order
    buyer_id VARCHAR(10) NOT NULL,                         -- Foreign Key to BUYER table
    total_price DECIMAL(10,2) NOT NULL,                    -- Total price of the order
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,         -- Date when the order was placed
    order_status ENUM('Pending', 'Shipped', 'Delivered', 'Cancelled') DEFAULT 'Pending', -- Order status
    payment_status ENUM('Pending', 'Completed', 'Failed') DEFAULT 'Pending', -- Payment status
    shipping_address VARCHAR(255) NOT NULL,                -- Shipping address for the order
    FOREIGN KEY (buyer_id) REFERENCES BUYER(buyer_id) ON DELETE CASCADE  -- Foreign Key to BUYER table
);

-- (For Storing Products in the Order)
CREATE TABLE ORDER_ITEMS (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,         -- Unique identifier for each item in the order
    order_id INT NOT NULL,                                -- Foreign Key to ORDER table
    shoe_id VARCHAR(10) NOT NULL,                         -- Foreign Key to SHOES table
    quantity INT DEFAULT 1,                               -- Number of shoes ordered
    shoe_size VARCHAR(20),                                -- Size of the shoe selected
    shoe_color VARCHAR(50),                               -- Color of the shoe selected
    item_price DECIMAL(10,2) NOT NULL,                    -- Price of the shoe at the time of the order
    FOREIGN KEY (order_id) REFERENCES SHOES_ORDER(order_id) ON DELETE CASCADE,  -- Foreign Key to ORDER table
    FOREIGN KEY (shoe_id) REFERENCES SHOES(shoe_id) ON DELETE CASCADE    -- Foreign Key to SHOES table
);



CREATE TABLE FEEDBACK (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    shoe_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    review TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (buyer_id) REFERENCES BUYER(buyer_id),
    FOREIGN KEY (shoe_id) REFERENCES SHOES(shoe_id)
);


CREATE TABLE CHAT_SUPPORT (
    chat_id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    seller_id INT NOT NULL,
    message TEXT NOT NULL,
    response TEXT,
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (buyer_id) REFERENCES BUYER(buyer_id),
    FOREIGN KEY (seller_id) REFERENCES BUYER(buyer_id)  -- Assuming sellers are also part of the BUYER table
);



CREATE TABLE SHOES (
    shoe_id VARCHAR(10) PRIMARY KEY,                      -- Unique identifier for each shoe with prefix (e.g., SH000001)
    shoe_name VARCHAR(100) NOT NULL,                       -- Name of the shoe
    shoe_description TEXT NOT NULL,                        -- Description of the shoe
    shoe_price DECIMAL(10,2) NOT NULL,                     -- Price of the shoe
    shoe_category ENUM('Slippers','Slipper', 'Shoes', 'Boots', 'Sandal', 'Sneaker', 'Heels', 'Other') NOT NULL, -- Type of shoe
    shoe_size VARCHAR(20) NOT NULL,                        -- Available sizes for the shoe (comma-separated, e.g., '6, 7, 8')
    shoe_color VARCHAR(50) NOT NULL,                       -- Color(s) of the shoe
    shoe_stock INT NOT NULL,                               -- Available stock for the shoe
    shoe_material TEXT NOT NULL,                           -- Material used in the shoe
    shoe_image TEXT NOT NULL,                              -- Path to the main image of the shoe
    shoe_status ENUM('Active', 'Inactive') NOT NULL,       -- Whether the shoe is available or not
    shoe_rating DECIMAL(3,2) NOT NULL DEFAULT 0.00,        -- Average rating from buyers
    shoe_checkouts INT DEFAULT 0,                          -- Number of times the shoe has been purchased
    shoe_gender ENUM('Men', 'Women', 'Kids', 'Unisex') NOT NULL,     -- Gender-specific category
    shoe_customization_options TEXT DEFAULT NULL,          -- Available customization options (like color/material)
    shoe_sale_price DECIMAL(10,2) DEFAULT NULL,            -- Sale price if the product is on sale
    shoe_discount_percentage DECIMAL(5,2) DEFAULT 0.00,    -- Discount percentage for the shoe
    shoe_reorder_level INT DEFAULT 10,                     -- Minimum stock level before reordering
    shoe_material_composition TEXT DEFAULT NULL,           -- Specific materials used in the shoe (e.g., leather, rubber)
    shoe_type VARCHAR(50) DEFAULT NULL,                    -- Type of shoe (e.g., running, formal, casual)
    shoe_images JSON DEFAULT NULL,                         -- Store multiple image URLs for the shoe (e.g., front, side, close-up)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,         -- Date the shoe was added to the database
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  -- Last update timestamp
);





-- Insert sample buyers
INSERT INTO BUYER (buyer_id, buyer_username, buyer_password, buyer_firstname, buyer_lastname, buyer_contactnumber, buyer_address, buyer_profileimage, buyer_email, buyer_verified, buyer_status, buyer_last_login)
VALUES
    ('BY000001', 'john_doe', 'encrypted_password1', 'John', 'Doe', '123-456-7890', '123 Elm St, Springfield', './images/profile.png', 'john.doe@example.com', 1, 'Active', '2025-08-15 10:30:00'),
    ('BY000002', 'jane_smith', 'encrypted_password2', 'Jane', 'Smith', '987-654-3210', '456 Oak Rd, Rivertown', './images/jane_profile.jpg', 'jane.smith@example.com', 0, 'Inactive', '2025-08-14 15:45:00'),
    ('BY000003', 'robert_brown', 'encrypted_password3', 'Robert', 'Brown', '555-111-2233', '789 Pine St, Lakeview', './images/robert_profile.jpg', 'robert.brown@example.com', 1, 'Active', '2025-08-17 12:00:00');

-- Insert sample shoes data
INSERT INTO SHOES (shoe_id, shoe_name, shoe_description, shoe_price, shoe_category, shoe_size, shoe_color, shoe_stock, shoe_material, shoe_image, shoe_status, shoe_rating, shoe_checkouts, shoe_gender, shoe_customization_options, shoe_sale_price, shoe_discount_percentage, shoe_reorder_level, shoe_material_composition, shoe_type, shoe_images)
VALUES
    ('SH000001', 'Running Shoes', 'Comfortable running shoes for long-distance jogging.', 59.99, 'Shoes', '8, 9, 10, 11', 'Red', 50, 'Mesh', './img/sandal1.png', 'Active', 3.5, 100, 'Men', 'Color: Red, Size: Custom', 49.99, 10.00, 10, 'Mesh, Rubber', 'Running', '["./img/sandal1.png", "./img/sandal2.png"]'),
    ('SH000002', 'Leather Boots', 'Stylish leather boots with great durability for cold weather.', 89.99, 'Boots', '6, 7, 8, 9', 'Black', 30, 'Leather', './img/sandal2.png', 'Active', 3.5, 500, 'Men', 'Color: Black, Size: Custom', null, 12.50, 8, 'Leather, Rubber', 'Casual', '["./img/sandal2.png", "./img/sandal3.png"]'),
    ('SH000003', 'Summer Sandals', 'Breathable sandals for hot summer days, perfect for beach walks.', 29.99, 'Sandal', '7, 8, 9, 10', 'Blue', 100, 'Plastic', './img/sandal3.png', 'Active', 4.4, 200, 'Women', 'Color: Blue, Size: Custom', 24.99, 16.67, 20, 'Plastic', 'Casual', '["./img/sandal3.png", "./img/sandal4.png"]'),
    ('SH000004', 'Casual Sneakers', 'Casual sneakers that can be worn every day for comfort and style.', 49.99, 'Sneaker', '6, 7, 8, 9, 10', 'White', 75, 'Canvas', './img/sandal4.png', 'Active', 4.3, 120, 'Men', 'Color: White, Size: Custom', 44.99, 10.00, 15, 'Canvas, Rubber', 'Casual', '["./img/sandal4.png", "./img/sandal5.png"]'),
    ('SH000005', 'High Heels', 'Elegant high heels for formal occasions and parties.', 119.99, 'Heels', '5, 6, 7, 8', 'Pink', 20, 'Leather', './img/sandal5.png', 'Active', 4.8, 50, 'Women', 'Color: Pink, Size: Custom', null, 8.33, 5, 'Leather', 'Formal', '["./img/sandal5.png", "./img/sandal6.png"]'),
    ('SH000006', 'Winter Boots', 'Durable winter boots with insulation for harsh cold weather.', 120.99, 'Boots', '8, 9, 10', 'Brown', 40, 'Wool', './img/sandal6.png', 'Active', 5.0, 90, 'Women', 'Color: Brown, Size: Custom', null, 8.25, 12, 'Wool, Rubber', 'Casual', '["./img/sandal6.png", "./img/sandal2.png"]'),
    ('SH000007', 'Slip-On Shoes', 'Easy-to-wear slip-on shoes for casual outings.', 39.99, 'Slippers', '6, 7, 8, 9, 10', 'Gray', 60, 'Canvas', './img/sandal5.png', 'Active', 4.4, 150, 'Men', 'Color: Gray, Size: Custom', 34.99, 12.50, 18, 'Canvas, Rubber', 'Casual', '["./img/sandal1.png", "./img/sandal3.png"]'),
    ('SH000008', 'Sport Sandals', 'Sporty sandals for outdoor activities and hiking.', 54.99, 'Sandal', '8, 9, 10', 'Green', 40, 'Rubber', './img/sandal3.png', 'Active', 2.5, 110, 'Men', 'Color: Green, Size: Custom', 49.99, 9.09, 10, 'Rubber', 'Outdoor', '["./img/sandal6.png", "./img/sandal1.png"]'),

    -- New 6 sample shoes
    ('SH000009', 'Barefoot Shoes', 'Lightweight barefoot shoes for natural walking.', 75.00, 'Shoes', '6, 7, 8, 9, 10', 'Beige', 30, 'Leather', './img/barefootshoes.jpg', 'Active', 4.85, 800, 'Unisex', 'Color: Beige, Size: Custom', 50.00, 0, 5, 'Leather, Rubber', 'Casual', '["./img/barefootshoes.jpg"]'),
    ('SH000010', 'Clogs', 'Comfortable slip-on clogs for casual wear.', 65.00, 'Shoes', '6, 7, 8, 9, 10', 'Brown', 25, 'Wood', './img/clogs.jpg', 'Active', 3.5, 80, 'Unisex', 'Color: Brown, Size: Custom', null, 0, 5, 'Wood, Rubber', 'Casual', '["./img/clogs.jpg"]'),
    ('SH000011', 'Flipflops', 'Light flipflops for everyday casual use.', 20.00, 'Slippers', '7, 8, 9, 10', 'Black', 100, 'Rubber', './img/fliplops.jpg', 'Active', 3.8, 60, 'Unisex', 'Color: Black, Size: Custom', null, 0, 10, 'Rubber', 'Casual', '["./img/fliplops.jpg"]'),
    ('SH000012', 'Boat Shoes', 'Classic boat shoes perfect for casual outings.', 85.00, 'Shoes', '7, 8, 9, 10', 'Navy', 20, 'Leather', './img/boatshoes.jpg', 'Active', 3.9, 30, 'Men', 'Color: Navy, Size: Custom', null, 0, 5, 'Leather, Rubber', 'Casual', '["./img/boatshoes.jpg"]'),
    ('SH000013', 'Riding Boots', 'Durable riding boots for horseback riding and outdoor activities.', 150.00, 'Boots', '8, 9, 10, 11', 'Brown', 15, 'Leather', './img/ridingboots.jpg', 'Active', 4.1, 15, 'Unisex', 'Color: Brown, Size: Custom', null, 0, 5, 'Leather, Rubber', 'Outdoor', '["./img/ridingboots.jpg"]'),
    ('SH000014', 'Slide Sandals', 'Easy-to-wear slide sandals for casual wear.', 130.00, 'Sandal', '6, 7, 8, 9, 10', 'Gray', 50, 'Rubber', './img/slidesandals.jpg', 'Active', 3.7, 40, 'Unisex', 'Color: Gray, Size: Custom', 105.5, 0, 10, 'Rubber', 'Casual', '["./img/slidesandals.jpg"]');

UPDATE shoes
SET created_at = '2025-08-01 10:30:00'
WHERE shoe_id IN ('SH000001', 'SH000002', 'SH000003', 'SH000004');

UPDATE shoes
SET created_at = '2025-08-15 08:15:03'
WHERE shoe_id IN ('SH000005', 'SH000006', 'SH000007', 'SH000008');

TRUNCATE TABLE SHOES;
show tables;

DROP TABLE IF EXISTS BUYER;
DROP TABLE IF EXISTS ORDERS;
DROP TABLE IF EXISTS ORDER_ITEMS;
DROP TABLE IF EXISTS FEEDBACK;
DROP TABLE IF EXISTS CHAT_SUPPORT;
DROP TABLE IF EXISTS TRANSACTIONS;
DROP TABLE IF EXISTS NOTIFICATIONS;
DROP TABLE IF EXISTS SHOES;
DROP TABLE IF EXISTS SHOES_order;


