 <?php
    require_once dirname(__DIR__) . '\controllers\ProductController.php';
    $controller = new ProductController();
    $method = $_SERVER['REQUEST_METHOD'];
    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

    switch ($method) {
        case 'GET':
            if ($request[0] == 'products') {
                if (!empty($_GET)) {
                    $controller->getProductByFiled(key($_GET));
                    break;
                } else {
                    $controller->getAllProduct();
                    break;
                }
            }
            break;
        case 'POST':
            if ($request[0] == 'products') {
                $controller->addProduct();
            } else if ($request[0] == 'delete-product') {
                $controller->deleteProduct();
            } else if ($request[0] == 'update-product') {
                $controller->updateProduct();
            }
            break;
        default:
            break;
    }
