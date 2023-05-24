<?php

session_start();
ob_start();

require 'baglan.php';
include 'navbar.php';




if (!isset($_SESSION['username'])) {
    header("Location: giris.php");
    exit();
}


// Oturum zaman aşımı süresi (saniye cinsinden)
$timeout_duration = 600; // Örneğin 30 dakika

// Oturum süresini kontrol et
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) {
    // Oturum zaman aşımı, oturumu sonlandır
    session_unset();
    session_destroy();
    header("Location: giris.php");
    exit();
}

// Oturumun son etkinlik zamanını güncelle
$_SESSION['last_activity'] = time();







?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <a href="giris.php" class="girisYap">Giriş Yap</a>
    <a href="cikis.php" class="cikisYap">Çıkış Yap</a>


    <div class="container bg-light mt-5 p-5 mb-5">

        
            

            <div class="row d-flex">
                <div class="col">
                <a href="anket-olustur.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Anket Oluştur</a>
                </div>


                <div class="col">
                <a href="anket-oyla.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Ankete Katıl</a>
                </div>
            </div>
            <div class="row">
                <div class="col"></div>
                <div class="col"></div>
            </div>

            <div class="row"><?php echo "Hoşgeldin: " . $_SESSION['username']; ?></div>

        

        
    </div>

    
</body>
</html>