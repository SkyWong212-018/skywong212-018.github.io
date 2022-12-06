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
                    $quantity = $_POST["quantity"];

                    //if 'array_unique'(count duplicate 'product') smaller than 'product', error
                    if (count(array_unique($product)) < count($product)) {
                        echo "<div class='alert alert-danger'>Need to select different product.</div>";
                        $flag = true;
                    } else {
                        for ($x = 0; $x < count($product); $x++) {
                            if (!empty($product[$x]) && !empty($quantity[$x])) {
                                if ($flag == false) {
                                    $total_amount = 0;

                                    // can do 3 product in 1 'for loop'
                                    ////'count($product)' product里面有多少个就loop多少次
                                    for ($x = 0; $x < count($product); $x++) {

                                        $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                                        $stmt = $con->prepare($query);
                                        $stmt->bindParam(':id', $product[$x]);
                                        $stmt->execute();
                                        $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                        //if promotion_price = 0, show 'price', else show 'promotion price'
                                        if ($row['promotion_price'] == 0) {
                                            $price = $row['price'];
                                        } else {
                                            $price = $row['promotion_price'];
                                        }

                                        //combine prvious total_amount (total_amount = 0) with new ones
                                        $total_amount = $total_amount + ($price * $quantity[$x]);
                                    }

                                    //send data to 'order_summary'
                                    $order_date = date('Y-m-d');
                                    $query = "INSERT INTO order_summary SET customer_id=:customer_id, order_date=:order_date, total_amount=:total_amount";
                                    $stmt = $con->prepare($query);
                                    $stmt->bindParam(':customer_id', $customer_id);
                                    $stmt->bindParam(':order_date', $order_date);
                                    $stmt->bindParam(':total_amount', $total_amount);
                                    if ($stmt->execute()) {
                                        echo "<div class='alert alert-success'>Create order successful.</div>";
                                        //if success > insert 'order_id' put into 'order_details' table
                                        $order_id = $con->lastInsertId();

                                        //calculate 'price each'
                                        for ($x = 0; $x < count($product); $x++) {
                                            $query = "SELECT price, promotion_price FROM products WHERE id = :id";
                                            $stmt = $con->prepare($query);
                                            $stmt->bindParam(':id', $product[$x]);
                                            $stmt->execute();
                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                            if ($row['promotion_price'] == 0) {
                                                $price = $row['price'];
                                            } else {
                                                $price = $row['promotion_price'];
                                            }
                                            $price_each = $price * $quantity[$x];

                                            //send data to 'order_details'
                                            $query = "INSERT INTO order_details SET product_id=:product_id, quantity=:quantity,order_id=:orderid, price_each=:price_each";
                                            $stmt = $con->prepare($query);
                                            //product & quantity is array, [0,1,2]
                                            $stmt->bindParam(':product_id', $product[$x]);
                                            $stmt->bindParam(':quantity', $quantity[$x]);
                                            $stmt->bindParam(':orderid', $order_id);
                                            $stmt->bindParam(':price_each', $price_each);
                                            $stmt->execute();
                                        }
                                    } else {
                                        echo "<div class='alert alert-danger'>Create order failed.</div>";
                                    }
                                } else {
                                    echo "<div class='alert alert-danger'>Create order failed.</div>";
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
                            $query = "SELECT id, name FROM products ORDER BY id DESC";
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
                                        <option selected>- Product -</option>
                                        <?php
                                        if ($num > 0) {
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                extract($row); ?>
                                                <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($name, ENT_QUOTES); ?></option>
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