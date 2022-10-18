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
    ?>
</body>

</html>