<?php include 'session.php'; ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Order Details</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Order Details</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT order_details_id, o.order_id, product_id, p.name, price, promotion_price, quantity, price_each, total_amount
            FROM order_details o 
            INNER JOIN products p 
            ON o.product_id = p.id
            INNER JOIN order_summary s
            ON o.order_id = s.order_id
            WHERE o.order_id = ?";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $order_id);

            // execute our query
            $stmt->execute();

            // this is how to get number of rows returned
            $num = $stmt->rowCount();
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <thead>
                <tr>
                    <th scope="col">Order Detail ID</th>
                    <th scope="col">Order ID</th>
                    <th scope="col">Product ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price (/unit) (RM)</th>
                    <th scope="col">Promotion Price (RM)</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price Each (RM)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($num > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row); ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order_details_id, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($order_id, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($product_id, ENT_QUOTES);  ?></td>
                            <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
                            <td><?php echo number_format((float)$price, 2, '.', '') ?> </td>
                            <td><?php echo number_format((float)$promotion_price, 2, '.', '') ?> </td>
                            <td><?php echo htmlspecialchars($quantity, ENT_QUOTES);  ?></td>
                            <td><?php echo number_format((float)$price_each, 2, '.', '') ?> </td>
                        </tr>
                <?php }
                } ?>
                <div>
                    <tr>
                        <th scope="row">
                            <h3>Total Amount</h3>
                        </th>
                        <td colspan="6"></td>
                        <td>
                            <h3>
                                <?php echo htmlspecialchars("RM$total_amount", ENT_QUOTES); ?>
                            </h3>
                        </td>
                    </tr>
                </div>
            </tbody>
        </table>
        <tr>
            <td>
                <br>
                <a href='order_read.php' class='btn btn-danger'>Back to read order summary</a>
            </td>
        </tr>

    </div> <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>