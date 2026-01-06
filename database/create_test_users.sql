-- Create default admin and warga users for testing
-- Admin: username = admin, password = admin123
-- Warga: username = warga1, password = warga123

-- Clear existing test users if any
DELETE FROM users WHERE username IN ('admin', 'warga1');

-- Insert Admin User
INSERT INTO users (username, password, role) VALUES 
('admin', '$2y$10$YourHashedPasswordHere', 'admin');

-- Set the user_id for admin (will be auto-generated, let's use LAST_INSERT_ID)
SET @admin_user_id = LAST_INSERT_ID();

-- Insert Admin Profile
INSERT INTO admins (user_id, nama_lengkap, jabatan) VALUES 
(@admin_user_id, 'Administrator FKKMBT', 'Admin Utama');

-- Insert Warga User  
INSERT INTO users (username, password, role) VALUES 
('warga1', '$2y$10$YourHashedPasswordHere', 'warga');

-- Set the user_id for warga
SET @warga_user_id = LAST_INSERT_ID();

-- Insert Warga Profile
INSERT INTO warga (user_id, nama_lengkap, blok, no_rumah, no_hp) VALUES 
(@warga_user_id, 'Budi Santoso', 'A', '12', '081234567890');
