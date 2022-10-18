<!DOCTYPE html>

<html>

<head>
    <style>
        .num1 {
            color: green;
            font-style: italic;
        }

        .num2 {
            color: blue;
            font-style: italic;
        }

        .num3 {
            color: red;
            font-weight: bold;
        }

        .num4 {
            font-style: italic;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    $x = rand(100, 200);
    $y = rand(100, 200);

    echo "<span class=\"num1\">";
    echo $x . "<br>";
    echo "</span>";

    echo "<span class=\"num2\">";
    echo $y . "<br>";
    echo "</span>";

    echo "<span class=\"num3\">";
    echo ($x + $y . "<br>");
    echo "</span>";

    echo "<span class=\"num4\">";
    echo ($x * $y . "<br>");
    echo "</span>";
    ?>
</body>

</html>