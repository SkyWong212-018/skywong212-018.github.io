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
    $flag = false;
    ?>

    <!-- container -->
    <div class="container">
        <div class="row fluid">
            <div class="col-md-10">
                <div class="page-header top_text mt-5 mb-3">
                    <h2>Create Order</h2>
                </div>

                <?php

                if ($_POST) {
                    if (empty($_POST["username"])) {
                        echo "<div class='alert alert-danger'>Need to select customer.</div>";
                        $flag = true;
                    } else {
                        $customer_id = htmlspecialchars(strip_tags($_POST['username']));
                    }

                    $product = $_POST["product"];
                    //how many times the product has been choosen
                    $value = array_count_values($product);
                    $quantity = $_POST["quantity"];

                    // var_dump($product);
                    // echo "<br>";
                    // var_dump($quantity);
                    // echo "<br>";
                    // echo print_r($value);

                    //if 3 product slot is empty print error message
                    if ($product[0] == "" && $product[1] == "" && $product[2] == "") {
                        echo "<div class='alert alert-danger'>Choose at least one product.</div>";
                        $flag = true;
                    } else {
                        //if choose product and no select quantity print error message
                        if ((!empty($product[0]) && empty($quantity[0])) or (!empty($product[1]) && empty($quantity[1])) or (!empty($product[2]) && empty($quantity[2]))) {
                            echo "<div class='alert alert-danger'>Quantity is empty.</div>";
                            $flag = true;
                        } else {
                            for ($x = 0; $x < count($product); $x++) {
                                //if choose product & quantity, proceed, else print error message
                                if (!empty($product[$x]) && !empty($quantity[$x])) {
                                    //if choosen product no duplicate, proceed, else print error message
                                    if ($value[$product[$x]] == 1) {
                                        if ($flag == false) {
                                            //send data to 'order_summary'
                                            $order_date = date('Y-m-d');
                                            $query = "INSERT INTO order_summary SET customer_id=:customer_id, order_date=:order_date";
                                            $stmt = $con->prepare($query);
                                            $stmt->bindParam(':customer_id', $customer_id);
                                            $stmt->bindParam(':order_date', $order_date);
                                            if ($stmt->execute()) {
                                                echo "<div class='alert alert-success'>Create order successful.</div>";
                                                //if success > insert 'order_id' put into 'order_details' table
                                                $order_id = $con->lastInsertId();

                                                //send data to 'order_details'
                                                $query = "INSERT INTO order_details SET product_id=:product_id, quantity=:quantity,order_id=:orderid";
                                                $stmt = $con->prepare($query);
                                                //product & quantity is array, [0,1,2]
                                                $stmt->bindParam(':product_id', $product[$x]);
                                                $stmt->bindParam(':quantity', $quantity[$x]);
                                                $stmt->bindParam(':orderid', $order_id);
                                                $stmt->execute();
                                            } else {
                                                echo "<div class='alert alert-danger'>Create order failed.</div>";
                                                $flag = true;
                                            }
                                        } else {
                                            echo "<div class='alert alert-danger'>Create order failed.</div>";
                                            $flag = true;
                                        }
                                    } else {
                                        echo "<div class='alert alert-danger'>Cannot select same product.</div>";
                                        $flag = true;
                                    }
                                }
                            }
                        }
                    }
                } ?>

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
                        //forloop, for 3 product
                        for ($x = 0; $x < 3; $x++) {
                            $query = "SELECT id, name, price, promotion_price FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $num = $stmt->rowCount();
                        ?>

                            <div class="row">
                                <label class="order-form-label">Product</label>

                                <div class="col-3 mb-2 mt-2">
                                    <span class="error"><?php //echo $userErr; 
                                                        ?></span>
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

                                <input class="col-1 mb-2 mt-2" type="number" id="quantity[]" name="quantity[]" min=1>
                            </div>
                        <?php } ?>

                    </table>
                    <input type="submit" class="btn btn-success" />
                </form>

            </div> <!-- end .container -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
            <!-- confirm delete record will be here -->

</body>

</html>