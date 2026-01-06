-- Migration for transactions table
CREATE TABLE transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    auction_item_id BIGINT UNSIGNED NOT NULL,
    winner_id BIGINT UNSIGNED NOT NULL,
    seller_id BIGINT UNSIGNED NOT NULL,
    final_price DECIMAL(15, 2) NOT NULL,
    payment_status ENUM('pending', 'paid', 'verified') DEFAULT 'pending',
    payment_proof VARCHAR(255),
    shipping_receipt VARCHAR(255),
    shipping_status ENUM('waiting_payment', 'processing', 'shipped', 'delivered', 'completed') DEFAULT 'waiting_payment',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (auction_item_id) REFERENCES auction_items(id) ON DELETE CASCADE,
    FOREIGN KEY (winner_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);