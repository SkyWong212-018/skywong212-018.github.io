<?php
// used to connect to the database
$host = "localhost";
$db_name = "online_store";
$username = "online_store";
$password = "_xa6Rjn0IzV1)Z1M";

try {
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
    //echo "Connected successfully";
}

// show error
catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
