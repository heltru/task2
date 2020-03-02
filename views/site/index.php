<?php

/* @var $this yii\web\View */

$this->title = 'ProductList';
?>
<style>
    .product-list {
        width: 100%;
    }

    .info {
        width: 80%;
        float: left;
    }

    .actions {
        width: 20%;
        float: right;
    }

    .btnProductRemove {
        float: right;
    }

    .item {
        width: 100%;
        display: inline-block;

        padding: 0.5em;

        border: 1px solid gray;
        border-radius: 2px;
    }

    .edit-block {
        margin-bottom: 1em;
    }
</style>
<script
        src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
        crossorigin="anonymous"></script>
<script>

    $(document).ready(function () {



        const product_list = {items: []};

        productListGridLoad();

        function productListGridLoad() {
            $.ajax({
                url: "/api/product/index",
                success: data => {
                    product_list.items = data;
                    productListGridDraw();
                }
            });
        }

        function productListGridDraw() {
            $('.product-list').html('');
            product_list.items.forEach((item, index) => {
                let item_html = " <div class=\"item\">\n" +
                    "                        <div class=\"info\">\n" +
                    "                            <label>\n" +
                    "                                Name:\n" +
                    "                            </label>\n" +
                    "                            <p>" + item.name + "</p>\n" +
                    "                            <label>\n" +
                    "                                Description:\n" +
                    "                            </label>\n" +
                    "                            <p>" + item.description + "</p>\n" +
                    "                            <label>\n" +
                    "                                Price:\n" +
                    "                            </label>\n" +
                    "                            <p>" + item.price + "</p>\n" +
                    "                            <label>\n" +
                    "                                Creation date:\n" +
                    "                            </label>\n" +
                    "                            <p>" + item.date_cr + "</p>\n" +
                    "                        </div>\n" +
                    "                        <div  class=\"actions\">\n" +
                    "                            <a data-num=" + index + " data-id=" + item.id + " class=\"btn btn-danger btnProductRemove\">Delete</a>\n" +
                    "                        </div>";

                $('.product-list').append(item_html);
            });

        }


        $('.btnAddProduct').click(e => {

            let product_name = $('.product_name').val();
            let product_description = $('.product_description').val();
            let product_price = parseInt($('.product_price').val());
            let date = new Date().toISOString().slice(0, 19).replace('T', ' ');

            let item = {name: product_name, description: product_description, price: product_price, date_cr: date};

            if (!(product_name && product_description && product_price)) {
                alert('Ошибка данных!');
                return;
            }


            $.ajax({
                url: "/api/product/create",
                type: "POST",
                data: item,
                success: data => {
                    if ('id' in data) {

                        product_list.items.unshift(data);
                        productListGridDraw();

                        $('.alert-text').html('Элемент успешно добавлен');
                        $('.alert-sc').show();


                        $('.product_name').val('');
                        $('.product_description').val('');
                        $('.product_price').val('');

                    }
                }
            });


        });

        $('body').on('click', '.btnProductRemove', function (e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            let num = $(this).attr('data-num');


            $.ajax({
                url: "/api/product/" + id,
                type: "DELETE",
                success: data => {

                    product_list.items.splice(num, 1);
                    productListGridDraw();

                    $('.alert-text').html('Элемент успешно удалён!');
                    $('.alert-sc').show();

                }
            });

        });


    });


</script>
<div class="site-index">


    <div class="body-content">

        <div class="row edit-block">
            <div class="col-xs-12">
                <form class="form-inline">

                    <div class="form-group">
                        <input placeholder="Name" type="text" class="form-control field product_name">
                        <input placeholder="Description" type="text" class="form-control field product_description">
                        <div class="input-group">
                            <input placeholder="price" type="text" class="form-control field product_price">
                            <span class="input-group-addon">$</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <button type="button" class="  btn btn-primary btnAddProduct">Add</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="row alert-sc" style="display: none">
            <div class="col-xs-12">
                <div class="alert alert-success alert-dismissable alert-text "  role="alert">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="product-list">
                    <div class="item">
                        <div class="info">
                            <label>
                                Name:
                            </label>
                            <p>Snickers</p>
                            <label>
                                Description:
                            </label>
                            <p>Big snickers</p>
                            <label>
                                Price:
                            </label>
                            <p>5%</p>
                            <label>
                                Creation date:
                            </label>
                            <p>4/3/19, 12:40PM</p>
                        </div>
                        <div class="actions">
                            <a class="btn btn-danger btnProductRemove">Delete</a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="info">
                            <label>
                                Name:
                            </label>
                            <p>Snickers</p>
                            <label>
                                Description:
                            </label>
                            <p>Big snickers</p>
                            <label>
                                Price:
                            </label>
                            <p>5%</p>
                            <label>
                                Creation date:
                            </label>
                            <p>4/3/19, 12:40PM</p>
                        </div>
                        <div class="actions">
                            <a class="btn btn-danger btnProductRemove">Delete</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
