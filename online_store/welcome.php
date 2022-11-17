<!DOCTYPE HTML>
<html>

<body>

    <form action="welcome.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
        Welcome <?php echo $_POST[“name”]; ?><br>
        Your Email: <?php echo $_POST[“email”]; ?><br>
    </form>

</body>

</html>