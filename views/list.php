<h1>Danh sách Sản phẩm</h1>
<ul id="productList"></ul>
<h2>Thêm Người dùng</h2>
<form id="AddProduct">
    <input type="text" id="name">
    <input type="number" id="price">
    <button type="submit">Thêm người dùng</button>
    <p id="mess"></p>
</form>

<div class="searchForm">
    <p>tìm kiếm theo tên sản phẩm</p>
    <input type="text" id="name_search">
    <button class="searchBt" type="submit">Search</button>
    <p id="search_result"></p>
</div>
<script>
    $(document).ready(async function() {
        function fetchUsers() {
            $.ajax({
                url: 'api/product_route.php/products',
                method: 'GET',
                success: function(responseJson) {
                    let response = JSON.parse(responseJson);
                    let products = response.data;

                    let productList = '';
                    products.forEach(product => {
                        productList += `<li>${product.name}-- giá ${product.price} Đ
            <a href="index.php?page=form-edit&id=${product.id}">update</a>
            <button class="deleteBT" data-id="${product.id}">delete</button> </li>`;
                    });
                    $('#productList').html(productList);
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        $('#productList').text(respone.message);
                    }

                }
            });
        }
        fetchUsers();
        $('#AddProduct').on('submit', function(e) {
            e.preventDefault();
            let name = $('#name').val();
            let price = $('#price').val();
            $.ajax({
                url: 'api/product_route.php/products',
                method: 'POST',
                data: {
                    name: name,
                    price: price
                },
                success: function(responseJson) {
                    let response = JSON.parse(responseJson);
                    $('#mess').text(response.message);
                    $('#name').val('');
                    $('#price').val('');
                    fetchUsers();
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        $('#mess').text(respone.message);
                    }

                }
            });
        });

        $(document).on('click', '.deleteBT', function() {
            let productId = $(this).attr('data-id');
            $.ajax({
                url: 'api/product_route.php/delete-product',
                method: 'POST',
                data: {
                    id: productId
                },
                success: function(responseDeleteJson) {
                    let responseDelete = JSON.parse(responseDeleteJson);
                    alert(responseDelete.message);
                    fetchUsers();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        alert(respone.message);
                    }
                }
            });
        });

        $('.searchBt').on('click', function() {
            $.ajax({
                url: 'api/product_route.php/products',
                method: 'GET',
                data: {
                    name: $('#name_search').val()
                },
                success: function(responseJson) {
                    let response = JSON.parse(responseJson);
                    let products = response.data;
                    let html = '';
                    products.forEach(function(element, index) {

                        html += `<p>Tên : ${element.name} giá :${element.price} </p>`

                    })
                    $('#search_result').html(html);
                },
                error: function(jqXHR, textStatus, errorThrown) {

                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        alert(respone.message);
                    }

                }
            });
        })

    });
</script>