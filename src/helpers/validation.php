<?php
class Validation {
    private $errors = [];
    private $data = [];
    
    public function __construct($data) {
        $this->data = $data;
    }
    
    // Gerekli alan kontrolü
    public function required($field, $message = null) {
        if (empty($this->data[$field])) {
            $this->errors[$field] = $message ?: "{$field} alanı gereklidir.";
        }
        
        return $this;
    }
    
    // Minimum uzunluk kontrolü
    public function minLength($field, $length, $message = null) {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field] = $message ?: "{$field} alanı en az {$length} karakter olmalıdır.";
        }
        
        return $this;
    }
    
    // Maksimum uzunluk kontrolü
    public function maxLength($field, $length, $message = null) {
        if (isset($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->errors[$field] = $message ?: "{$field} alanı en fazla {$length} karakter olmalıdır.";
        }
        
        return $this;
    }
    
    // E-posta formatı kontrolü
    public function email($field, $message = null) {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = $message ?: "Geçerli bir e-posta adresi giriniz.";
        }
        
        return $this;
    }
    
    // İki alanın eşleşme kontrolü
    public function matches($field, $matchField, $message = null) {
        if (isset($this->data[$field], $this->data[$matchField]) && 
            $this->data[$field] !== $this->data[$matchField]) {
            $this->errors[$field] = $message ?: "{$field} alanı {$matchField} alanı ile eşleşmiyor.";
        }
        
        return $this;
    }
    
    // Doğrulama hatası var mı kontrolü
    public function fails() {
        return !empty($this->errors);
    }
    
    // Doğrulama başarılı mı kontrolü
    public function passes() {
        return empty($this->errors);
    }
    
    // Hataları döndür
    public function getErrors() {
        return $this->errors;
    }
    
    // İlk hatayı döndür
    public function getFirstError() {
        return reset($this->errors);
    }
}