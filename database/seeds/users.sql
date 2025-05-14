-- Admin kullanıcısı (şifre: admin123)
INSERT INTO `users` (`username`, `email`, `password`, `role`, `full_name`) VALUES
('admin', 'admin@boscaler.com', '$2a$12$TgdwNo/rO/jzx7p7zhjT5eTlAg37VE6MtZtDAWhPCBYGqgn0.zMTm', 'admin', 'Site Yöneticisi');

-- Normal Kullanıcı (şifre: testpass/testpass2)
INSERT INTO `users` (`username`, `email`, `password`, `role`, `full_name`) VALUES
('testuser', 'test@boscaler.com', '$2a$12$en27fJHs6sHjObHMedzIpOqzIrz6CsBRaEOmlayVluTHaNNpuDvu6', 'user', 'Test Kullanıcı');

INSERT INTO `users` (`username`, `email`, `password`, `role`, `full_name`) VALUES
('testuser2', 'test2@boscaler.com', '$2a$12$A36z2WNg6.7jSl5GcGbE3esX7v.xBWxY7GPpVml6nQmc3s0j81h9W', 'user', 'Test Kullanıcı2');