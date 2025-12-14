<?php

$server = "localhost";
$user = "root";
$password = "";
$database = "youtube_database_4";

$connection = new mysqli($server, $user, $password, $database);

if($connection->connect_error){
    die("<div style='font-family: Arial; padding: 20px; background: #ffeded; border-left: 5px solid #cc0000; margin: 20px;'>
        <h3 style='color: #cc0000;'>Database Connection Failed</h3>
        <p>Error: " . $connection->connect_error . "</p>
        <p>Please check your database configuration.</p>
    </div>");
}

?>