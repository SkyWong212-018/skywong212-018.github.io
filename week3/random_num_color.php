<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <?php
    $x = rand(100, 200);
    $y = rand(100, 200);

    if ($x > $y) {
        echo "<div class=\"container text-center\">";
        echo "<div class=\"row justify-content-center\">";
        echo "<div class=\"col-4 text-primary\">";
        echo "<span class=\"num1\">";
        echo "<strong class=\"fs-1\">";
        echo $x . "<br>";
        echo "</strong>";
        echo "</span>";
        echo "</div> ";

        echo "<div class=\"col-4 text-secondary\">";
        echo "<span class=\"num2\">";
        echo $y . "<br>";
        echo "</span>";
        echo "</div> ";
        echo "</div> ";
        echo "</div> ";
    } else {
        echo "<div class=\"container text-center\">";
        echo "<div class=\"row justify-content-center\">";
        echo "<div class=\"col-4 text-primary\">";
        echo "<span class=\"num1\">";
        echo $x . "<br>";
        echo "</span>";
        echo "</div> ";

        echo "<div class=\"col-4 text-secondary\">";
        echo "<span class=\"num2\">";
        echo "<strong class=\"fs-1\">";
        echo $y . "<br>";
        echo "</strong>";
        echo "</span>";
        echo "</div> ";
        echo "</div> ";
        echo "</div> ";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>