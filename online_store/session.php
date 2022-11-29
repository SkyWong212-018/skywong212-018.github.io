
<?php
//check is user have pass or not
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/webdev/online_store/login.php");
}
?>