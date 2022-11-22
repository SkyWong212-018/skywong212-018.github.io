<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <!-- navigation bar -->
    <?php
    include 'menu.php';
    ?>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Customers</h1>
        </div>

        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        $flag = false;

        //$_GET['action'] = action' will display in url
        //If url have 'action'
        if (isset($_GET['action'])) {
            //If action = success print out 'Record was saved'
            if ($_GET['action'] == 'success') {
                echo "<div class='alert alert-success'>Record was saved.</div>";
            }
        }

        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $password = htmlspecialchars(strip_tags($_POST['password']));
                $first_name = htmlspecialchars(strip_tags($_POST['first_name']));
                $last_name = htmlspecialchars(strip_tags($_POST['last_name']));
                $gender = htmlspecialchars(strip_tags($_POST['gender']));
                $date_of_birth = htmlspecialchars(strip_tags($_POST['date_of_birth']));
                $confirm_password = htmlspecialchars(strip_tags($_POST['confirm_password']));

                //if user didn't insert something, $flag will change to true (default $flag = false) 
                if (empty($username)) {
                    echo "<div class='alert alert-danger'>Username is empty.</div><br>";
                    $flag = true;
                } else {
                    $username = $_POST["username"];
                }

                //if username character not more then 6
                if (strlen($username) < 6) {
                    echo "<div class='alert alert-danger'>Username must be more than 6 characters.</div><br>";
                    $flag = true;
                } else {
                    $username = $_POST["username"];
                }

                if (empty($password)) {
                    echo "<div class='alert alert-danger'>Please insert the Password.</div>";
                    $flag = true;
                } else {
                    $password = md5('password');
                }

                if (empty($confirm_password)) {
                    echo "<div class='alert alert-danger'>Please insert the Confirm Password.</div>";
                    $flag = true;
                } else if ($_POST['password'] == $_POST['confirm_password']) {
                    $password = md5('password');
                } else {
                    echo "<div class='alert alert-danger'>Password not match.</div>";
                    $flag = true;
                }

                if (empty($first_name)) {
                    echo "<div class='alert alert-danger'>First name is empty.</div><br>";
                    $flag = true;
                } else {
                    $first_name = $_POST["first_name"];
                }

                if (empty($last_name)) {
                    echo "<div class='alert alert-danger'>Last name is empty.</div><br>";
                    $flag = true;
                } else {
                    $last_name = $_POST["last_name"];
                }

                if (empty($gender)) {
                    echo "<div class='alert alert-danger'>Gender is empty.</div><br>";
                    $flag = true;
                } else {
                    $gender = $_POST["gender"];
                }

                if (empty($date_of_birth)) {
                    echo "<div class='alert alert-danger'>Date of birth is empty.</div><br>";
                    $flag = true;
                } else {
                    $date_of_birth = $_POST["date_of_birth"];
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
                }

                //Username
                $query = "SELECT username FROM customers WHERE username=:username";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $num = $stmt->rowCount();

                //if num > 0 = found username from database, print out error message
                if ($num > 0) {
                    echo "<div class='alert alert-danger'>The username is taken.</div><br>";
                    $flag = true;
                }

                if ($flag == false) {
                    //109-134 put all things (name, description...) into correct place
                    // insert query
                    $query = "INSERT INTO customers SET username=:username, password=:password, first_name=:first_name, last_name=:last_name, gender=:gender, date_of_birth=:date_of_birth, registration=:registration";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':date_of_birth', $date_of_birth);

                    // specify when this record was inserted to the database
                    $created = date('Y-m-d H:i:s');
                    $stmt->bindParam(':registration', $created);

                    // Execute the query
                    if ($stmt->execute()) {
                        header("Location: http://localhost/webdev/online_store/create_customer.php?action=success");
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>



        <!-- html form here where the product information will be entered -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><input type='text' name='username' class='form-control' value='<?php
                                                                                        if (isset($_POST["username"])) {
                                                                                            echo $_POST["username"];
                                                                                        }
                                                                                        ?>' /></td>
                </tr>

                <tr>
                    <td>Password</td>
                    <td><input type='password' name='password' class='form-control' /></td>
                </tr>

                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='confirm_password' class='form-control' /></td>
                </tr>

                <tr>
                    <td>First name</td>
                    <td><input type='text' name='first_name' class='form-control' value='<?php
                                                                                            if (isset($_POST["first_name"])) {
                                                                                                echo $_POST["first_name"];
                                                                                            }
                                                                                            ?>' /></td>
                </tr>

                <tr>
                    <td>Last name</td>
                    <td><input type='text' name='last_name' class='form-control' value='<?php
                                                                                        if (isset($_POST["last_name"])) {
                                                                                            echo $_POST["last_name"];
                                                                                        }
                                                                                        ?>' /></td>
                </tr>

                <tr>
                    <td>Gender</td>
                    <td>
                        <input type="radio" id="male" name="gender" value="MALE" <?php
                                                                                    if (isset($_POST["gender"])) {
                                                                                        if ($gender == 'MALE') {
                                                                                            echo "checked";
                                                                                        }
                                                                                    } ?> />
                        <label for="male">Male</label>

                        <input type="radio" id="female" name="gender" value="FEMALE" <?php
                                                                                        if (isset($_POST["gender"])) {
                                                                                            if ($gender == 'FEMALE') {
                                                                                                echo "checked";
                                                                                            }
                                                                                        } ?> />
                        <label for="female">Female</label>
                    </td>
                </tr>

                <tr>
                    <td>Date of birth</td>
                    <td><input type="date" id="date_of_birth" name="date_of_birth" value='<?php
                                                                                            if (isset($_POST["date_of_birth"])) {
                                                                                                echo $_POST["date_of_birth"];
                                                                                            }
                                                                                            ?>'>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>