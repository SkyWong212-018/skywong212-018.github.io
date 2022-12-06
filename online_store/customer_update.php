<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Update Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <?php
        $flag = false;
        //include database connection
        include 'config/database.php';
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : die('ERROR: Record Username not found.');

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT customer_id, username, password, first_name, last_name, gender, date_of_birth FROM customers WHERE customer_id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $customer_id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            if ($row) {
                $customer_id = $row['customer_id'];
                $username = $row['username'];
                $password = $row['password'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $gender = $row['gender'];
                $date_of_birth = $row['date_of_birth'];
            }
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                //posted values

                //if 3 section is not empty, then do checking
                if (!empty($_POST['old_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
                    //confirm old password is same with previous password that user set, same = proceed, diff = error
                    if (md5($_POST['old_password']) == $password) {
                        //if new password diff with old password can proceed, same = error
                        if (!md5($_POST['new_password']) == md5($_POST['old_password'])) {
                            //if confirm password same with new password can proceed, diff = error
                            if (md5($_POST['confirm_password']) == md5($_POST['new_password'])) {
                                $password = md5($new_password);
                            } else {
                                echo "<div class='alert alert-danger'>Confirm password is not match with new password.</div>";
                                $flag = true;
                            }
                        } else {
                            echo "<div class='alert alert-danger'>New password cannot same with old password.</div>";
                            $flag = true;
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Old password is wrong.</div>";
                        $flag = true;
                    }
                }

                //empty first name
                if (empty($first_name)) {
                    echo "<div class='alert alert-danger'>First name is empty.</div><br>";
                    $flag = true;
                } else {
                    $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                }

                //empty last name
                if (empty($last_name)) {
                    echo "<div class='alert alert-danger'>Last name is empty.</div><br>";
                    $flag = true;
                } else {
                    $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                }

                $gender = htmlspecialchars(strip_tags($_POST['gender']));

                $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                //date2 = Today date
                $date2 = date("Y-m-d");
                //abs = let the result answer become positive no matter answer is negative or positive
                //strtotime = let english text become Unix timestamp
                $diff = strtotime($date2) - strtotime($date_of_birth);
                //floor is a function let 小数点 become 整数
                $years = floor($diff / (365 * 60 * 60 * 24));

                if ($years < 18) {
                    echo "<div class='alert alert-danger'>Your age should be 18 and above</div><br>";
                    $flag = true;
                }

                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                if ($flag == false) {
                    $query = "UPDATE customers
                    SET password=:password, first_name=:first_name, last_name=:last_name, gender=:gender, date_of_birth=:date_of_birth  WHERE customer_id=:customer_id";
                    // prepare query for excecution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':customer_id', $customer_id);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } ?>


        <!--we have our html form here where new record information can be updated-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?customer_id={$customer_id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><?php echo htmlspecialchars($username, ENT_QUOTES);  ?></td>
                </tr>
                </tr>
                <tr>
                    <td>Old password</td>
                    <td><input type='password' name='old_password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>New password</td>
                    <td><input type='password' name='password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Confirm new password</td>
                    <td><input type='password' name='confirm_password' class='form-control' /></td>
                </tr>
                <tr>
                    <td>First name</td>
                    <td><input type='text' name='first_name' value="<?php echo htmlspecialchars($first_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last name</td>
                    <td><input type='text' name='last_name' value="<?php echo htmlspecialchars($last_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><input type='radio' id=male name='gender' value="male" <?php
                                                                                if ($gender == 'male') {
                                                                                    echo "checked";
                                                                                }
                                                                                ?> /> <label for="male">Male</label>

                        <input type='radio' id=female name='gender' value="female" <?php
                                                                                    if ($gender == 'female') {
                                                                                        echo "checked";
                                                                                    }
                                                                                    ?> /> <label for="female">Female</label>
                    </td>
                </tr>
                <tr>
                    <td>Date of birth</td>
                    <td><input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($date_of_birth, ENT_QUOTES);  ?>" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customer_read.php' class='btn btn-danger'>Back to read customers</a>
                    </td>
                </tr>
            </table>
        </form>

    </div>
    <!-- end .container -->
</body>

</html>