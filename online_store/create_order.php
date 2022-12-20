<?php
include 'session.php';
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Create Order</title>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <?php
    include 'menu.php';
    include 'config/database.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="row fluid">
            <div class="col-md-10">
                <div class="page-header top_text mt-5 mb-3">
                    <h2>Create Order</h2>
                </div>

                <?php
                $error_msg = "";

                if ($_POST) {
                    $customer_id = htmlspecialchars(strip_tags($_POST['username']));
                    $product = $_POST["product"];
                    $quantity = $_POST["quantity"];
                    //how many times the product has been choosen
                    $value = array_count_values($product);

                    // var_dump($product);
                    // echo "<br>";
                    // var_dump($quantity);
                    // echo "<br>";
                    // echo print_r($value);

                    if (empty($_POST["username"])) {
                        $error_msg .= "<div class='alert alert-danger'>Need to select customer.</div>";
                    }

                    if ($product[0] == "") {
                        $error_msg .= "<div class='alert alert-danger'>Please at least choose a product.</div>";
                    }

                    //if 3 product slot is empty print error message
                    for ($x = 0; $x < count($product); $x++) {
                        if ($x == 0) {
                            if ($product[$x] == "" or $quantity[$x] == "") {
                                $error_msg .= "<div class='alert alert-danger'>Choose product $x with quantity.</div>";
                            }
                        } else {
                            if ($product[$x] != "") {
                                if ($quantity[$x] == "") {
                                    $error_msg .= "<div class='alert alert-danger'>Choose product $x with quantity.</div>";
                                }

                                if ($value[$product[$x]] > 1) {
                                    $error_msg .= "<div class='alert alert-danger'>Cannot choose same product.</div>";
                                }
                            }
                        }
                    }

                    if (empty($error_msg)) {
                        $total_amount = 0;
                        for ($x = 0; $x < 3; $x++) {
                            $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                            $stmt = $con->prepare($query);
                            $stmt->bindParam(':id', $product[$x]);
                            $stmt->execute();
                            $num = $stmt->rowCount();
                            $price = 0;

                            //if database pro price is 0/no promo, price = row price
                            if ($num > 0) {
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                if ($row['promotion_price'] == 0) {
                                    $price = $row['price'];
                                } else {
                                    $price = $row['promotion_price'];
                                }
                            }

                            //combine prvious total_amount with new ones, loop (3 times)
                            $total_amount = $total_amount + ((float)$price * (int)$quantity[$x]);
                        }

                        $order_date = date('Y-m-d');
                        $query = "INSERT INTO order_summary SET customer_id=:customer_id, order_date=:order_date, total_amount=:total_amount";
                        $stmt = $con->prepare($query);
                        $stmt->bindParam(':customer_id', $customer_id);
                        $stmt->bindParam(':order_date', $order_date);
                        $stmt->bindParam(':total_amount', $total_amount);
                        if ($stmt->execute()) {
                            $order_id = $con->lastInsertId();
                            for ($x = 0; $x < count($product); $x++) {

                                $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                                $stmt = $con->prepare($query);
                                //bind user choose product(id) with order details product id
                                $stmt->bindParam(':id', $product[$x]);
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                $num = $stmt->rowCount();
                                $price = 0;

                                if ($num > 0) {
                                    if ($row['promotion_price'] == 0) {
                                        $price = $row['price'];
                                    } else {
                                        $price = $row['promotion_price'];
                                    }
                                }
                                $price_each = ((float)$price * (int)$quantity[$x]);

                                //send data to 'order_details'
                                $query = "INSERT INTO order_details SET product_id=:product_id, quantity=:quantity,order_id=:order_id, price_each=:price_each";
                                $stmt = $con->prepare($query);
                                //product & quantity is array, [0,1,2]
                                $stmt->bindParam(':product_id', $product[$x]);
                                $stmt->bindParam(':quantity', $quantity[$x]);
                                $stmt->bindParam(':order_id', $order_id);
                                $stmt->bindParam(':price_each', $price_each);
                                $stmt->execute();
                            }
                            echo "<div class='alert alert-success'>Create order successful.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>$error_msg</div>";
                    }
                }
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                    <?php
                    $query = "SELECT customer_id, username FROM customers ORDER BY customer_id DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $num = $stmt->rowCount();
                    ?>

                    <table class='table table-hover table-responsive table-bordered mb-5'>
                        <div class="row">
                            <label class="order-form-label">Username</label>
                        </div>

                        <div class="col-6 mb-3 mt-2">
                            <select class="form-select" name="username" aria-label="form-select-lg example">
                                <option value='' selected>- Customer -</option>
                                <?php
                                if ($num > 0) {
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row); ?>
                                        <option value="<?php echo $customer_id; ?>"><?php echo htmlspecialchars($username, ENT_QUOTES); ?></option>
                                <?php }
                                }
                                ?>

                            </select>

                        </div>

                        <?php
                        $query = "SELECT id, name, price, promotion_price FROM products ORDER BY id DESC";
                        $stmt = $con->prepare($query);
                        $stmt->execute();
                        $num = $stmt->rowCount();
                        ?>

                        <div class="row">
                            <label class="order-form-label">Product</label>
                            <div class="pRow">
                                <div class="col-3 mb-2 mt-2">
                                    <span class="error"></span>
                                    <select class="form-select" name="product[]" aria-label="form-select-lg example">
                                        <option value='' selected>- Product -</option>
                                        <?php
                                        if ($num > 0) {
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row); ?>
                                                <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($name, ENT_QUOTES);
                                                                                    if ($promotion_price == 0) {
                                                                                        echo " (RM$price)";
                                                                                    } else {
                                                                                        echo " (RM$promotion_price)";
                                                                                    } ?></option>
                                        <?php }
                                        }
                                        ?>

                                    </select>
                                </div>

                                <input class="col-3 mb-2 mt-2" type="number" id="quantity[]" name="quantity[]" min=1>
                            </div>
                        </div>
                        <input type="button" value="Add More" class="add_one btn btn-info mt-2 me-2" />
                        <input type="button" value="Delete" class="delete_one btn btn-danger mt-2" />
                    </table>

                    <input type="submit" class="btn btn-primary" />
                </form>

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
            <!-- confirm delete record will be here -->

</body>

</html>