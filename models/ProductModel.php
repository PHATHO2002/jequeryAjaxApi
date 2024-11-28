<?php

class ProductModel
{

    private $db;
    private $table_name = 'products';
    public function __construct($db)
    {
        $this->db = $db;
    }
    private function createResponse($httpCode, $message, $data = null)
    {
        return [
            'httpcode' => $httpCode,
            'message' => $message,
            'data' => $data
        ];
    }
    private function validateEmpty($fieldName, &$value)
    {
        $value = trim($value);

        if (empty($value)) {
            return "$fieldName cannot be empty.";
        }
        return null;
    }
    public function selectAll()
    {
        try {

            $query = 'SELECT * FROM ' . $this->table_name;
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $this->createResponse(200, 'Get all successful', $result);
            } else {
                return $this->createResponse(404, 'No data found');
            }
        } catch (PDOException $e) {

            return $this->createResponse(500, 'Database error:' . $e->getMessage());
        }
    }
    public function addOne($data)
    {
        try {
            if (empty($data)) {
                return $this->createResponse(404, 'data cannot be empty');
            }
            if ($err = $this->validateEmpty('name', $data['name'])) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('price', $data['price'])) {
                return $this->createResponse(404, $err);
            }
            $query = "INSERT INTO " . $this->table_name . " SET name = :name,  price = :price";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":name", $data['name']);
            $stmt->bindParam(":price", $data['price']);
            $stmt->execute();
            return $this->createResponse(200, 'add product successful');
        } catch (PDOException $e) {

            return $this->createResponse(500, 'Database error: ' . $e->getMessage());
        }
    }

    public function deleteOne($id)
    {
        try {

            if ($err = $this->validateEmpty('id', $id)) {
                return $this->createResponse(404, $err);
            }
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $this->createResponse(200, 'delete product successful');
        } catch (PDOException $e) {

            return $this->createResponse(500, 'Database error: ' . $e->getMessage());
        }
    }
    public function selectByfiled($filedName, $value)
    {
        try {
            if ($err = $this->validateEmpty($filedName, $value)) {
                return $this->createResponse(404, $err);
            }
            $query = 'SELECT * FROM ' . $this->table_name . " WHERE $filedName = :$filedName";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":$filedName", $value);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
                return $this->createResponse(200, 'Get one successful', $result);
            } else {
                return $this->createResponse(404, 'No data found');
            }
        } catch (PDOException $e) {
            return $this->createResponse(500, 'Database error:' . $e->getMessage());
        }
    }

    public function update($data)
    {
        try {
            if (empty($data)) {
                return $this->createResponse(404, 'data cannot be empty');
            }
            if ($err = $this->validateEmpty('name', $data['name'])) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('price', $data['price'])) {
                return $this->createResponse(404, $err);
            }
            if ($err = $this->validateEmpty('id', $data['id'])) {
                return $this->createResponse(404, $err);
            }
            $query = "UPDATE " . $this->table_name . " 
            SET name = :name, price = :price 
            WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":name", $data['name']);
            $stmt->bindParam(":price", $data['price']);
            $stmt->bindParam(":id", $data['id']);

            $stmt->execute();
            return $this->createResponse(200, 'update product successful');
        } catch (PDOException $e) {
            return $this->createResponse(500, 'Database error: ' . $e->getMessage());
        }
    }
}
