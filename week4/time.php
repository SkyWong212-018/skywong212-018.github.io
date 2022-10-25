<!DOCTYPE html>

<html>

<head>
</head>

<body>
    <?php
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $t = date("H");
    echo $t . "<br>";

    if ($t >= "06" and $t < "12") {
        echo " <br>Good Morning";
    } else if ($t >= "12" and $t < "18") {
        echo " <br>Good Afternoon";
        if ($t == 12) {
            echo " <br>Is Lunch Time.";
        }
    } else if ($t >= "18") {
        echo " <br>Good Night";
    }
    ?>
</body>

</html>