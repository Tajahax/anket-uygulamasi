<?php


    // Veritabanı bağlantısı yapılacak
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "anket";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Bağlantı kontrolü
    if ($conn->connect_error) {
        die("Veritabanına bağlanılamadı: " . $conn->connect_error);
    }





?>