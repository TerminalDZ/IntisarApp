-- Create uniform_inventory table
CREATE TABLE IF NOT EXISTS `uniform_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `item_type` varchar(100) NOT NULL,
  `size` varchar(50) NOT NULL,
  `quantity_in_stock` int(11) NOT NULL DEFAULT 0,
  `min_stock_level` int(11) NOT NULL DEFAULT 10,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `supplier` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_item_type` (`item_type`),
  KEY `idx_size` (`size`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create uniform_transactions table
CREATE TABLE IF NOT EXISTS `uniform_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(50) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `transaction_type` enum('بيع','استلام','إرجاع','تلف','فقدان') NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` enum('مدفوع','مدفوع جزئياً','غير مدفوع') NOT NULL DEFAULT 'غير مدفوع',
  `amount_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(50) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_member_id` (`member_id`),
  KEY `idx_inventory_id` (`inventory_id`),
  KEY `idx_transaction_type` (`transaction_type`),
  KEY `idx_payment_status` (`payment_status`),
  KEY `idx_transaction_date` (`transaction_date`),
  CONSTRAINT `fk_uniform_transactions_inventory` FOREIGN KEY (`inventory_id`) REFERENCES `uniform_inventory` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert some sample data for uniform_inventory
INSERT INTO `uniform_inventory` (`item_name`, `item_type`, `size`, `quantity_in_stock`, `min_stock_level`, `unit_price`, `supplier`, `purchase_date`, `notes`) VALUES
('قميص كشفي أزرق', 'قميص', 'صغير', 50, 10, 25.00, 'مورد الأزياء الكشفية', '2024-01-15', 'قميص كشفي رسمي باللون الأزرق'),
('قميص كشفي أزرق', 'قميص', 'متوسط', 75, 10, 25.00, 'مورد الأزياء الكشفية', '2024-01-15', 'قميص كشفي رسمي باللون الأزرق'),
('قميص كشفي أزرق', 'قميص', 'كبير', 60, 10, 25.00, 'مورد الأزياء الكشفية', '2024-01-15', 'قميص كشفي رسمي باللون الأزرق'),
('بنطلون كشفي كحلي', 'بنطلون', 'صغير', 40, 10, 35.00, 'مورد الأزياء الكشفية', '2024-01-20', 'بنطلون كشفي رسمي باللون الكحلي'),
('بنطلون كشفي كحلي', 'بنطلون', 'متوسط', 55, 10, 35.00, 'مورد الأزياء الكشفية', '2024-01-20', 'بنطلون كشفي رسمي باللون الكحلي'),
('بنطلون كشفي كحلي', 'بنطلون', 'كبير', 45, 10, 35.00, 'مورد الأزياء الكشفية', '2024-01-20', 'بنطلون كشفي رسمي باللون الكحلي'),
('قبعة كشفية', 'قبعة', 'موحد', 30, 5, 15.00, 'مورد الأزياء الكشفية', '2024-02-01', 'قبعة كشفية رسمية'),
('حزام كشفي', 'حزام', 'موحد', 25, 5, 20.00, 'مورد الأزياء الكشفية', '2024-02-01', 'حزام كشفي جلدي'),
('شارة كشفية', 'شارة', 'موحد', 100, 20, 5.00, 'مورد الأزياء الكشفية', '2024-02-01', 'شارة كشفية رسمية للصدر');