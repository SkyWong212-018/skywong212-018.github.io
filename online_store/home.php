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
    ?>

    <img src="img/nightcity 1.png" alt="nightcity" style="width:100%;">
    <div class="centered">
        <h1>Sky E-Shop</h1>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>