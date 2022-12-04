<?php include 'session.php'; ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Create Order</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .scrollable-menu {
            height: auto;
            max-height: 200px;
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <!-- navigation bar -->
    <?php
    include 'menu.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Order</h1>
        </div>

        <!-- Customer -->
        <button class="btn btn-primary dropdown-toggle my-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Customer
        </button>
        <ul class="dropdown-menu scrollable-menu">
            <?php
            include 'config/database.php';

            $query = "SELECT customer_id ,username FROM customers ORDER BY customer_id DESC";
            $stmt = $con->prepare($query);
            $stmt->execute();

            $num = $stmt->rowCount();

            if ($num > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
            ?>
                    <option value="<?php echo $username ?>"><?php echo $username ?></option>
            <?php
                }
            }
            echo "</ul>";
            ?>

            <!-- Product 1 -->
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Product 1
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <?php
                    include 'config/database.php';

                    $query = "SELECT id ,name FROM products ORDER BY id DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();

                    $num = $stmt->rowCount();

                    if ($num > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                    ?>
                            <option value="<?php echo $name ?>"><?php echo $name ?></option>
                    <?php
                        }
                    }
                    echo "</ul>";
                    ?>
                    <form>
                        <div class="col-2">
                            <div class="mb-1">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="text" class="form-control" id="quantity">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="price" value='<?php  ?>'>
                            </div>
                    </form>

                    <!-- Product 2 -->
                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Product 2
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <?php
                            include 'config/database.php';

                            $query = "SELECT id ,name FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();

                            $num = $stmt->rowCount();

                            if ($num > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);
                            ?>
                                    <option value="<?php echo $name ?>"><?php echo $name ?></option>
                            <?php
                                }
                            }
                            echo "</ul>";
                            ?>
                        </ul>
                    </div>
                    <form>
                        <div class="mb-1">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity">
                        </div>
                        <div class="mb-1">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price">
                    </form>

                    <!-- Product 3 -->
                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle mt-3" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Product 3
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <?php
                            include 'config/database.php';

                            $query = "SELECT id ,name FROM products ORDER BY id DESC";
                            $stmt = $con->prepare($query);
                            $stmt->execute();

                            $num = $stmt->rowCount();

                            if ($num > 0) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    extract($row);
                            ?>
                                    <option value="<?php echo $name ?>"><?php echo $name ?></option>
                            <?php
                                }
                            }
                            echo "</ul>";
                            ?>
                        </ul>
                    </div>
                    <form>
                        <div class="mb-1">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" class="form-control" id="price">
                    </form>

                    <td>
                        <input type='submit' value='Save' class='btn btn-success mt-3' />
                    </td>
            </div> <!-- end .container -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
            <!-- confirm delete record will be here -->

</body>

</html>