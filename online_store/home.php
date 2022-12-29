<?php include 'session.php'; ?>
<!DOCTYPE HTML>
<html>

<head>
    <style>
        .centered {
            color: white;
            position: absolute;
            top: 70%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <title>Home</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <!-- navigation bar -->
    <?php
    include 'menu.php';
    include 'config/database.php';

    //Total customer
    $query = "SELECT * FROM customers";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $total_customer = $stmt->rowCount();

    //Total product
    $query = "SELECT * FROM products";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $total_product = $stmt->rowCount();

    //Total order
    $query = "SELECT * FROM order_summary";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $total_order = $stmt->rowCount();
    ?>

    <img src="img/nightcity 1.png" alt="nightcity" style="width:100%;">
    <div class="centered">
        <h1 class="display-1">Sky E-Shop</h1>
    </div>

    <div class="card card border-dark rounded-0">
        <ul class="list-group list-group-flush">
            <!-- Total customer -->
            <li class="list-group-item text-white bg-dark rounded-0">
                <h1 class="display-6">Total Number of Customers: <b><?php echo "$total_customer" ?></b></h1>
                <a href="http://localhost/webdev/online_store/customer_read.php" class="btn btn-primary col-1 mb-3">Customer List</a>
            </li>

            <!-- Total product -->
            <li class="list-group-item text-white bg-dark rounded-0">
                <h1 class="display-6">Total Number of Products: <b><?php echo "$total_product" ?></b></h1>
                <a href="http://localhost/webdev/online_store/product_read.php" class="btn btn-primary col-1 mb-3">Product List</a>
            </li>

            <!-- Total order -->
            <li class="list-group-item text-white bg-dark rounded-0">
                <h1 class="display-6">Total Number of Orders: <b><?php echo "$total_order" ?></b></h1>
                <a href="http://localhost/webdev/online_store/order_read.php" class="btn btn-primary col-1 mb-3">Order List</a>
            </li>

            <!-- Latest Order ID & Summary -->
            <li class="list-group-item text-white bg-dark rounded-0">
                <h1 class="display-6">Latest Order ID & Summary</br></h1>
                <hr>
                <?php
                $query = "SELECT c.first_name, c.last_name, c.username, o.order_date, o.total_amount 
                FROM order_summary o 
                INNER JOIN customers c 
                ON c.customer_id = o.customer_id 
                ORDER BY order_id DESC";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                // values to fill up our form
                $username = $row['username'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $order_date = $row['order_date'];
                $total_amount = $row['total_amount'];
                ?>

                <h3 class="lead"><?php echo "Username: $username" ?></h3>
                <h3 class="lead"><?php echo "Customer Name: $first_name $last_name" ?></h3>
                <h3 class="lead"><?php echo "Total Amount: RM $total_amount" ?></h3>
                <h3 class="lead"><?php echo "Transaction Date: $order_date" ?></h3>
                <a href="http://localhost/webdev/online_store/order_read.php" class="btn btn-primary col-1 mt-2 mb-4">Order List</a>
            </li>
        </ul>
    </div>

    <div class="card-group">

        <!-- Top 5 selling Products -->
        <div class="card text-white bg-dark rounded-0 border-dark">
            <img class="card-img-top" src="img/nightcity 2.png" alt="Card image cap" height="630" width="auto">
            <div class="card-body">
                <h5 class="card-title text-center">Top 5 selling Products</h5>
                <hr>
                <p class="card-text text-center">
                    <?php
                    $query = "SELECT o.product_id, SUM(o.quantity) as totalquantity ,p.name as productname 
                    FROM order_details o 
                    INNER JOIN products p 
                    ON o.product_id = p.id 
                    GROUP BY o.product_id 
                    ORDER BY totalquantity DESC LIMIT 5";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();

                    if ($num > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo $productname . "<br>";
                            echo "<b>" . $totalquantity . "</b>" . "<br>";
                        }
                    }
                    ?></p>
            </div>
            <div class="card-footer text-center">
                <a href="http://localhost/webdev/online_store/product_read.php" class="btn btn-primary">Product List</a>
            </div>
        </div>

        <!-- 3 Products that never purchased -->
        <div class="card text-white bg-dark rounded-0">
            <img class="card-img-top" src="img/nightcity 3.png" alt="Card image cap" height="630" width="auto">
            <div class="card-body">
                <h5 class="card-title text-center">3 Products that never purchased</h5>
                <hr>
                <h4 class="card-text text-center lead">
                    <?php
                    $query = "SELECT p.name FROM products p
                    LEFT JOIN order_details o ON o.product_id = p.id
                    WHERE o.product_id iS NULL LIMIT 3";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $num = $stmt->rowCount();

                    if ($num > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                            echo $name . "</br>" . "</br>";
                        }
                    }
                    ?>
                </h4>
            </div>
            <div class="card-footer text-center">
                <a href="http://localhost/webdev/online_store/product_read.php" class="btn btn-primary">Product List</a>
            </div>
        </div>

        <!-- Order Summary with highest purchased amount -->
        <div class="card text-white bg-dark rounded-0">
            <img class="card-img-top" src="img/nightcity 4.png" alt="Card image cap" height="630" width="auto">
            <div class="card-body">
                <h5 class="card-title text-center">Order Summary with highest purchased amount</h5>
                <hr>
                <h4 class="card-text text-center lead">
                    <?php
                    $query = "SELECT c.first_name, c.last_name, c.username, SUM(o.total_amount) as total_amount
                    FROM order_summary o 
                    INNER JOIN customers c 
                    ON c.customer_id = o.customer_id 
                    ORDER BY total_amount DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // values to fill up our form
                    $username = $row['username'];
                    $first_name = $row['first_name'];
                    $last_name = $row['last_name'];
                    $total_amount = $row['total_amount'];

                    echo "Username: " . "<b>" . $username . "</b>";
                    echo "</br>";
                    echo "</br>";
                    echo "Customer Name: " . "<b>" . $first_name . ' ' . $last_name . "</b>";
                    echo "</br>";
                    echo "</br>";
                    echo "Total Amount: <b>RM </b>" .  "<b>" . $total_amount . "</b>";
                    ?>
                </h4>
            </div>
            <div class="card-footer text-center">
                <a href="http://localhost/webdev/online_store/order_read.php" class="btn btn-primary">Order List</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>