<?php
include 'session.php';
?>
<!DOCTYPE HTML>
<html>

<head>
    <title> Create a Record </title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Read order details </title>

    <style>
        .error {
            color: red;
        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    include 'menu.php';
    ?>

    <!-- container -->
    <div class="container mt-5 p-5">
        <div class="page-header text-center">
            <h1>Read order details </h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/databased.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT order_detail_id, o.product_id, p.name ,quantity, s.order_id ,price_each,s.total_amount FROM order_detail o

            INNER JOIN products p  
            ON o.product_id=p.id 
            INNER JOIN order_summary s
            ON o.order_id=s.order_id
            WHERE o.order_id = ?";

            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $order_id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable

            $num = $stmt->rowCount();
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }


        ?>


        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <?php

        //creating our table heading


        ?>
        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Order Detail ID</th>
                    <th scope="col">Product ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price Each </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($num > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row); ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($order_id, ENT_QUOTES); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($order_detail_id, ENT_QUOTES); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($product_id, ENT_QUOTES); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($product_name = $row['name'], ENT_QUOTES); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($quantity, ENT_QUOTES); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars("RM$price_each", ENT_QUOTES); ?>
                            </td>

                        </tr>
                <?php }
                } ?>
                <td>
                    <h3>Total Amount:
                        <?php echo htmlspecialchars("RM$total_amount", ENT_QUOTES); ?>
                    </h3>
                </td>


                <div class="col-12 mb-2">
                    <a href='order_read.php' class='btn btn-danger'>Back to read order</a>

                </div>
            </tbody>
        </table>


    </div> <!-- end .container -->
    <!--  <div class="container-fluid p-1 pt-3 bg-info text-white text-center">
        <p>Copyrights &copy; 2022 Online Shop. All rights reserved.</p>
    </div> -->
</body>

</html>