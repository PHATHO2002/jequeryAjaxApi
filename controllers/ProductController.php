<?php
require_once dirname(__DIR__) . '/models/ProductModel.php';
include_once dirname(__DIR__) . '/config/database.php';
class ProductController
{
    private $model;
    private $db;
    public function __construct()
    {
        try {
            $this->db = getDatabaseConnection();
            $this->model = new ProductModel($this->db);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Không thể kết nối với cơ sở dữ liệu. Chi tiết lỗi: ' . $e->getMessage(),
                'data' => null
            ]);
            exit();
        }
    }
    private function sendRespone($httpCode, $message, $data)
    {
        http_response_code($httpCode);
        echo json_encode([
            'message' => $message,
            'data' =>  $data
        ]);
    }
    public function getAllProduct()
    {
        $respone = $this->model->selectAll();
        $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
    }
    public function addProduct()
    {
        $respone = $this->model->addOne($_POST);
        $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
    }
    public function deleteProduct()
    {
        $respone = $this->model->deleteOne($_POST['id']);
        $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
    }
    public function getProductByFiled($filedName)
    {

        $respone = $this->model->selectByfiled($filedName, $_GET[$filedName] ?? null);
        $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
    }
    public function updateProduct()
    {
        $respone = $this->model->update($_POST);
        $this->sendRespone($respone['httpcode'], $respone['message'], $respone['data']);
    }
}
