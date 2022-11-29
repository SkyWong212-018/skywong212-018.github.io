<!DOCTYPE HTML>
<html>

<head>
    <title>Create a Record</title>
    <!-- Latest compiled and minified Bootstrap CSS (Apply your Bootstrap here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {
            font-weight: 400;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        .error {
            color: red;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<!-- Custom styles for this template -->
<link href="signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <?php
    //Set variable for Error message
    $usernameErr =  $passwordErr = $statusErr = "";

    if ($_POST) {

        include 'config/database.php';

        //Username
        $username = htmlspecialchars(strip_tags($_POST['username']));

        $query = "SELECT password, status FROM customers WHERE username=:username";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $num = $stmt->rowCount();

        //if num > 0 = found username from database
        if ($num > 0) {
            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $password = $row['password'];
            $status = $row['status'];

            //Password
            if ($password == md5($_POST['password'])) {
                if ($status == 'Active') {
                    session_start();
                    //store username key in by username
                    $_SESSION['username'] = $_POST['username'];
                    header("Location: http://localhost/webdev/online_store/home.php?login=success");
                } else {
                    $statusErr = "Your Account is suspended *";
                }
            } else {
                $passwordErr = "Incorrect Password*";
            }
        } else {
            $usernameErr = "User not found *";
        }
    }
    ?>

    <main class="form-signin">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <form>
                <img class="mb-4" src="img/dodge.png" alt="dodge" width="72">
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
                <?php //Error message 
                ?>
                <span class="error"><?php echo $usernameErr; ?></span>
                <span class="error"><?php echo $passwordErr; ?></span>
                <span class="error"><?php echo $statusErr; ?></span>

                <div class="form-floating ">
                    <input type="text" class="form-control" name="username" value='<?php if (isset($_POST['username'])) {
                                                                                        echo $_POST['username'];
                                                                                    } ?>'>
                    <label for="username">
                        Username
                        </span>
                    </label>
                </div>


                <div class="form-floating">
                    <input type="password" class="form-control" name="password" value='<?php if (isset($_POST['password'])) {
                                                                                            echo $_POST['password'];
                                                                                        } ?>'>
                    <label for="password ">
                        Password
                    </label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
            </form>
        </form>
    </main>
</body>

</html>