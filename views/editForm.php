<?php

?>
<div style="display: flex;
    flex-direction: column;
    width: 200px;" class="">

    <input style="display: none;" id="product_id" type="text" value="<?php
                                                                        if (isset($_GET['id'])) {
                                                                            echo $_GET['id'];
                                                                        } ?>">
    <label for="name">tên sản phẩm</label>
    <input id="name_update" type="text" name="name">
    <label for="price">giá sản phẩm</label>
    <input id="price_update" type="number" name="price">
    <button id="updateBT">UPDATE</button>
    <p class="mess"></p>
    <a href="index.php">về trang chính</a>
</div>

<script>
    $(document).ready(function() {
        function feshUser() {
            $.ajax({
                url: 'api/product_route.php/products',
                method: 'GET',
                data: {
                    id: $('#product_id').val()
                },
                success: function(responseJson) {
                    let response = JSON.parse(responseJson);
                    let products = response.data;
                    products.forEach(element => {
                        $('#name_update').val(element.name);
                        $('#price_update').val(element.price);
                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        alert(respone.message)
                    }
                }

            })
        }
        $('#updateBT').on('click', function() {
            $.ajax({
                url: 'api/product_route.php/update-product',
                method: 'POST',
                data: {
                    id: $('#product_id').val(),
                    name: $('#name_update').val(),
                    price: $('#price_update').val()

                },
                success: function(responseJson) {
                    let response = JSON.parse(responseJson);
                    $('.mess').text(response.message);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseText) {
                        let respone = JSON.parse(jqXHR.responseText);
                        alert(respone.message)
                    }
                }

            })
        })

        feshUser();

    })
</script>