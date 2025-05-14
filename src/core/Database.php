<?php
class Database {
    protected $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    // Tablo var mı kontrol etme
    public function tableExists($table) {
        try {
            // Doğrudan tablo adıyla sorgu yapmayı deneyin
            $result = $this->pdo->query("SHOW TABLES LIKE '{$table}'");
            return $result && $result->rowCount() > 0;
        } catch (PDOException $e) {
            // Hata durumunda false döndür
            return false;
        }
    }
    
    // Sorgu çalıştırma ve sonuçları getirme
    public function query($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
    
    // Tek bir satır getir
    public function fetch($query, $params = []) {
        $stmt = $this->query($query, $params);
        return $stmt->fetch();
    }
    
    // Tüm sonuçları getir
    public function fetchAll($query, $params = []) {
        $stmt = $this->query($query, $params);
        return $stmt->fetchAll();
    }
    
    // Ekleme, güncelleme veya silme işlemi yap
    public function execute($query, $params = []) {
        $stmt = $this->query($query, $params);
        return $stmt->rowCount();
    }
    
    // ID ile veri ekleme
    public function insert($table, $data) {
        $keys = array_keys($data);
        $fields = implode(", ", $keys);
        $placeholders = ":" . implode(", :", $keys);
        
        $query = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";
        $this->query($query, $data);
        
        return $this->pdo->lastInsertId();
    }
    
    // Veri güncelleme
    public function update($table, $data, $conditions) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "{$key} = :{$key}, ";
        }
        $fields = rtrim($fields, ", ");
        
        $where = "";
        foreach ($conditions as $key => $value) {
            $where .= "{$key} = :where_{$key} AND ";
            $data["where_{$key}"] = $value;
        }
        $where = rtrim($where, " AND ");
        
        $query = "UPDATE {$table} SET {$fields} WHERE {$where}";
        
        return $this->execute($query, $data);
    }
    
    // Veri silme
    public function delete($table, $conditions) {
        $where = "";
        $params = [];
        
        foreach ($conditions as $key => $value) {
            $where .= "{$key} = :{$key} AND ";
            $params[$key] = $value;
        }
        $where = rtrim($where, " AND ");
        
        $query = "DELETE FROM {$table} WHERE {$where}";
        
        return $this->execute($query, $params);
    }

    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    // Transaction tamamlama
    public function commit() {
        return $this->pdo->commit();
    }

    // Transaction geri alma
    public function rollback() {
        return $this->pdo->rollBack();
    }
}