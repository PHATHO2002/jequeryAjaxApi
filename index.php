<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET["page"])) {
            switch ($_GET["page"]) {
                case "form-edit":
                    include_once("views/editForm.php");
                    break;
            }
        } else {
            include_once 'views/list.php';
        }
    }
    ?>

</body>


</html>