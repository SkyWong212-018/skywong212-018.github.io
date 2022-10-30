<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <div class="row p-4 col-md-2">
        <?php
        $month = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

        $userinfo = '011025141031';
        echo "IC: $userinfo <br>";

        //print out gender
        //-1 = only print out last number
        $g = substr($userinfo, -1);
        if ($g % 2 == 0) {
            echo "Mrs. <br>";
        } else {
            echo "Mr. <br>";
        }

        //print out month
        //2, 2 = delete first 2 number & print out 2 number after deleted 2 number
        $m = substr($userinfo, 2, 2);
        if ($m == "01") {
            echo $month[0];
        } else if ($m == "02") {
            echo $month[1];
        } else if ($m == "03") {
            echo $month[2];
        } else if ($m == "04") {
            echo $month[3];
        } else if ($m == "05") {
            echo $month[4];
        } else if ($m == "06") {
            echo $month[5];
        } else if ($m == "07") {
            echo $month[6];
        } else if ($m == "08") {
            echo $month[7];
        } else if ($m == "09") {
            echo $month[8];
        } else if ($m == "10") {
            echo $month[9];
        } else if ($m == "11") {
            echo $month[10];
        } else if ($m == "12") {
            echo $month[11];
        }

        echo " ";
        //print out date
        echo substr($userinfo, 4, 2);
        echo ", ";

        //print out year
        $y = substr($userinfo, 0, 2);
        if ($y > "22" and $y <= "99") {
            echo "19";
            echo substr($userinfo, 0, 2);
            echo "<br>";
        } else if ($y >= "00" and $y <= "22") {
            echo "20";
            echo substr($userinfo, 0, 2);
            echo "<br>";
        }

        //create variable for "day"
        $d = substr($userinfo, 4, 2);
        //print out zodiac
        if ($m == "12") {
            if ($d < 22)
                echo "Sagittarius <img src=\"img/sagittarius.png\" alt=\"sagittarius\">";
            else
                echo "Capricorn <img src=\"img/capricorn.png\" alt=\"capricorn\">";
        } else if ($m == "01") {
            if ($d < 20)
                echo "Capricorn <img src=\"img/capricorn.png\" alt=\"capricorn\">";
            else
                echo "Aquarius <img src=\"img/aquarius.png\" alt=\"aquarius\">";
        } else if ($m == "02") {
            if ($d < 19)
                echo "Aquarius <img src=\"img/aquarius.png\" alt=\"aquarius\">";
            else
                echo "Pisces <img src=\"img/pisces.png\" alt=\"pisces\">";
        } else if ($m == "03") {
            if ($d < 21)
                echo "Pisces <img src=\"img/pisces.png\" alt=\"pisces\">";
            else
                echo "Aries <img src=\"img/aries.png\" alt=\"aries\">";
        } else if ($m == "04") {
            if ($d < 20)
                echo "Aries <img src=\"img/aries.png\" alt=\"aries\">";
            else
                echo "Taurus <img src=\"img/taurus.png\" alt=\"taurus\">";
        } else if ($m == "05") {
            if ($d < 21)
                echo "Taurus <img src=\"img/taurus.png\" alt=\"taurus\">";
            else
                echo "Gemini <img src=\"img/gemini.png\" alt=\"gemini\">";
        } else if ($m == "06") {
            if ($d < 21)
                echo "Gemini <img src=\"img/gemini.png\" alt=\"gemini\">";
            else
                echo "Cancer <img src=\"img/cancer.png\" alt=\"cancer\">";
        } else if ($m == "07") {
            if ($d < 23)
                echo "Cancer <img src=\"img/cancer.png\" alt=\"cancer\">";
            else
                echo "Leo <img src=\"img/leo.png\" alt=\"leo\">";
        } else if ($m == "08") {
            if ($d < 23)
                echo "Leo <img src=\"img/leo.png\" alt=\"leo\">";
            else
                echo "Virgo <img src=\"img/virgo.png\" alt=\"virgo\">";
        } else if ($m == "09") {
            if ($d < 23)
                echo "Virgo <img src=\"img/virgo.png\" alt=\"virgo\">";
            else
                echo "Libra <img src=\"img/libra.png\" alt=\"libra\">";
        } else if ($m == "10") {
            if ($d < 23)
                echo "Libra <img src=\"img/libra.png\" alt=\"libra\">";
            else
                echo "Scorpio <img src=\"img/scorpio.png\" alt=\"scorpio\">";
        } else if ($m == "11") {
            if ($d < 22)
                echo "Scorpio <img src=\"img/scorpio.png\" alt=\"scorpio\">";
            else
                echo "Sagittarius <img src=\"img/sagittarius.png\" alt=\"sagittarius\">";
        }
        ?>


    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>