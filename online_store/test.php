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
            <tr>
                <th>Products</th>
                <th>Quantity</th>
            </tr>
            <tr class="pRow">
                <td>
                    <select class="form-select rounded" name="product[]">
                        <option value="" selected>- Product -</option>
                        <?php if ($num > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row); ?>
                                <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($name, ENT_QUOTES);
                                                                    if ($promotion_price == 0) {
                                                                        echo " (RM $price)";
                                                                    } else {
                                                                        echo " (RM $promotion_price)";
                                                                    } ?></option>
                        <?php }
                        } ?>
                    </select>

                </td>
                <td>
                    <input type='number' name='quantity[]' class='form-control' min=1 />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="button" value="Add More" class="add_one" />
                    <input type="button" value="Delete" class="delete_one" />
                </td>
            </tr>
        </div>
        </div>

    </table>
    <input type="submit" class="btn btn-success" />
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