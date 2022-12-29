<?php
//security guard, need to be at the very first
//usually placed here
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>OrderUpdate</title>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>


<body>
    <?php
    include 'menu.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="row fluid bg-color justify-content-center">
            <div class="col-md-10">
                <div class="page-header top_text mt-5 mb-3">
                    <h2>Order Update</h2>
                </div>

                <!-- PHP read one record will be here -->
                <?php
                // get passed parameter value, in this case, the record ID
                // isset() is a PHP function used to verify if a value is there or not
                $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

                //include database connection
                include 'config/database.php';

                // select id, quantity, price each from order_detail
                $query = "SELECT product_id, quantity, price_each, id, name, price, promotion_price, total_amount, c.customer_id, c.first_name, c.last_name, s.order_date
                FROM order_details o 
                INNER JOIN products p
                ON o.product_id = p.id
                INNER JOIN order_summary s
                ON o.order_id = s.order_id
                INNER JOIN customer c
                ON s.customer_id = c.customer_id
                WHERE o.order_id = ?";

                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $order_id);
                $stmt->execute();
                $num = $stmt->rowCount();

                ?>

                <!-- HTML read one record table will be here -->
                <!--we have our html table here where the record will be displayed-->

                <table class="table table-bordered mt-4">

                    <tbody>
                        <?php
                        if ($num > 0) {

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row); ?>
                        <?php }
                            echo "<b>Order ID :</b> $order_id<br>";
                            echo "<b>Customer Name :</b> $first_name $last_name<br>";
                            echo "<b>Order Date :</b> $order_date";
                        } ?>

                        <table class='table table-hover table-responsive table-bordered'>
                            <?php
                            // select pro_id + name
                            $query = "SELECT id, name, price, promotion_price FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            // this is how to get number of rows returned
                            $num = $stmt->rowCount();
                            ?>

                            <div class="pRow">
                                <div class="row">
                                    <div class="col-8 mb-2 ">
                                        <label class="order-form-label">Product</label>
                                    </div>

                                    <div class="col-4 mb-2"><label class="order-form-label">Quantity</label>
                                    </div>
                                    <div class="col-8 mb-2">
                                        <select class="form-select mb-3" id="" name="product[]" aria-label="form-select-lg example">
                                            <option value='' selected>Choose your product </option>

                                            <?php if ($num > 0) {
                                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    extract($row); ?>
                                                    <option value="<?php echo $id; ?>">
                                                        <?php echo htmlspecialchars($name, ENT_QUOTES);
                                                        if ($promotion_price == 0) {
                                                            echo " (RM$price)";
                                                        } else {
                                                            echo " (RM$promotion_price)";
                                                        } ?>

                                                    </option>
                                            <?php }
                                            }
                                            ?>

                                        </select>

                                    </div>

                                    <div class="col-4 mb-3">
                                        <input type='number' id='quantity[]' name='quantity[]' class='form-control' min=1 />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <input type="button" value="Add More" class="add_one btn btn-outline-primary" />
                                <input type="button" value="Delete" class="delete_one btn btn-outline-danger" />
                                <hr>
                                <input type='submit' value='Save Changes' class=' btn btn-primary' />
                                <a href='order_read.php' class='btn btn-danger'>Back to order list</a>
                            </div>



                        </table>

                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('click', function(event) {
            if (event.target.matches('.add_one')) {
                var element = document.querySelector('.pRow');
                var clone = element.cloneNode(true);
                element.after(clone);
            }
            if (event.target.matches('.delete_one')) {
                var total = document.querySelectorAll('.pRow').length;
                if (total > 1) {
                    var element = document.querySelector('.pRow');
                    element.remove(element);
                }
            }
        }, false);
    </script>

</body>

</html>