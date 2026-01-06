# DATABASE SCHEMA DOCUMENTATION

## Table: users
- **id**: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- **name**: VARCHAR(255) NOT NULL
- **email**: VARCHAR(255) UNIQUE NOT NULL
- **password**: VARCHAR(255) NOT NULL
- **phone**: VARCHAR(20)
- **address**: TEXT
- **role**: ENUM('admin', 'seller', 'buyer') NOT NULL DEFAULT 'buyer'
- **email_verified_at**: TIMESTAMP NULL
- **remember_token**: VARCHAR(100)
- **created_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP
- **updated_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

## Table: categories
- **id**: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- **name**: VARCHAR(255) NOT NULL
- **slug**: VARCHAR(255) UNIQUE NOT NULL
- **description**: TEXT
- **created_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP
- **updated_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

## Table: auction_items
- **id**: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- **seller_id**: BIGINT UNSIGNED NOT NULL (FK to users.id)
- **category_id**: BIGINT UNSIGNED NOT NULL (FK to categories.id)
- **title**: VARCHAR(255) NOT NULL
- **description**: TEXT NOT NULL
- **starting_price**: DECIMAL(15, 2) NOT NULL
- **current_price**: DECIMAL(15, 2) NOT NULL
- **start_time**: DATETIME NOT NULL
- **end_time**: DATETIME NOT NULL
- **status**: ENUM('pending', 'active', 'completed', 'rejected', 'cancelled') DEFAULT 'pending'
- **verification_note**: TEXT
- **created_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP
- **updated_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

## Table: auction_images
- **id**: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- **auction_item_id**: BIGINT UNSIGNED NOT NULL (FK to auction_items.id)
- **image_path**: VARCHAR(255) NOT NULL
- **is_primary**: BOOLEAN DEFAULT FALSE
- **created_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP
- **updated_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

## Table: bids
- **id**: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- **auction_item_id**: BIGINT UNSIGNED NOT NULL (FK to auction_items.id)
- **user_id**: BIGINT UNSIGNED NOT NULL (FK to users.id)
- **bid_amount**: DECIMAL(15, 2) NOT NULL
- **created_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP

## Table: transactions
- **id**: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- **auction_item_id**: BIGINT UNSIGNED NOT NULL (FK to auction_items.id)
- **winner_id**: BIGINT UNSIGNED NOT NULL (FK to users.id)
- **seller_id**: BIGINT UNSIGNED NOT NULL (FK to users.id)
- **final_price**: DECIMAL(15, 2) NOT NULL
- **payment_status**: ENUM('pending', 'paid', 'verified') DEFAULT 'pending'
- **payment_proof**: VARCHAR(255)
- **shipping_receipt**: VARCHAR(255)
- **shipping_status**: ENUM('waiting_payment', 'processing', 'shipped', 'delivered', 'completed') DEFAULT 'waiting_payment'
- **created_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP
- **updated_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

## Table: notifications
- **id**: BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
- **user_id**: BIGINT UNSIGNED NOT NULL (FK to users.id)
- **title**: VARCHAR(255) NOT NULL
- **message**: TEXT NOT NULL
- **type**: ENUM('bid', 'winner', 'payment', 'shipping', 'verification') NOT NULL
- **is_read**: BOOLEAN DEFAULT FALSE
- **created_at**: TIMESTAMP DEFAULT CURRENT_TIMESTAMP