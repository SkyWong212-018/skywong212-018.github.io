<?php include 'session.php'; ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Order Details</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <?php
    include 'menu.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Order Details</h1>
            <hr />
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
            $query = "SELECT p.name, price, promotion_price, quantity, price_each, total_amount, c.first_name, c.last_name, s.order_date
            FROM order_details o
            INNER JOIN products p 
            ON o.product_id = p.id
            INNER JOIN order_summary s
            ON o.order_id = s.order_id
            INNER JOIN customers c
            ON c.customer_id = s.customer_id
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
                    <th scope="col">Product Name</th>
                    <th scope="col">Orginal Price (/unit) (RM)</th>
                    <th scope="col">Promotion Price (/unit) (RM)</th>
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
                            <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
                            <td>
                                <div class='text-end'>
                                    <?php echo $price ?>
                                </div>
                            </td>
                            <td>
                                <div class='text-end'>
                                    <?php echo $promotion_price ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($quantity, ENT_QUOTES);  ?></td>
                            <td>
                                <div class='text-end'>
                                    <?php echo $price_each ?>
                                </div>
                            </td>
                        </tr>
                <?php }
                    echo "<h5 primary > Customer Name: $first_name $last_name </h5>";
                    echo "<h5 primary > Order Date: $order_date </h5>";
                } ?>
                <div>
                    <tr>
                        <th scope="row">
                            <h3>Total Amount (RM)</h3>
                        </th>
                        <td colspan="3"></td>
                        <td>
                            <div class='text-end'>
                                <h3>
                                    <?php echo $total_amount ?>
                                </h3>
                            </div>
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