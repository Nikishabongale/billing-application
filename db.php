<?php
    $servername = "localhost";
    $username = "root";
    $pass = "";
    $dbname = "billing_application";
    
    // Create connection
    $conn = mysqli_connect($servername, $username, $pass, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        }

?>