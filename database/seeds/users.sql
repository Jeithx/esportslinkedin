-- Admin kullanıcısı (şifre: admin123)
INSERT INTO `users` (`username`, `email`, `password`, `role`, `full_name`) VALUES
('admin', 'admin@boscaler.com', '$2y$12$QGZOt0UYy6Gl8eMfMcJ.7.KRGkGbaDoSKCyNr9C7cUlw7OfBPrk3a', 'admin', 'Site Yöneticisi');

-- Normal kullanıcı (şifre: test123)
INSERT INTO `users` (`username`, `email`, `password`, `role`, `full_name`) VALUES
('testuser', 'test@boscaler.com', '$2y$12$BnKQV0Z1KR9QiX9QN1MqSeIh1ztk1eZ.ftxZOBOKLYQzOTZEd2v/e', 'user', 'Test Kullanıcı');