<?php 

include 'navbar.php';

if(isset($_POST['btn1'])){
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
        
        // Formdan gelen verileri al
        $kullaniciAdi = $_POST['username'];
        $sifre = $_POST['password'];
        $tekrarSifre = $_POST['re-password'];
        
        // Şifreleri kontrol et
        if ($sifre != $tekrarSifre) {
            die("Hata: Şifreler eşleşmiyor.");
        }
        
        // Veritabanına kullanıcıyı ekle
        $sql = "INSERT INTO uyeler (kadi, sifre, tekrarsifre) VALUES ('$kullaniciAdi', '$sifre', '$tekrarSifre')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Kayıt başarıyla eklendi.";
        } else {
            echo "Hata: " . $sql . "<br>" . $conn->error;
        }
        
        $conn->close();

}

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
        


        <form action="" method="post">

                <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">@</span>
        </div>
        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="username">
        </div>

        <label for="inputPassword5">Password</label>
        <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" name="password">
        <small id="passwordHelpBlock" class="form-text text-muted">
        Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
        </small>
        <br>

        <label for="inputPassword5">Re-Password</label>
        <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" name="re-password">
        
        <br>

        <button type="submit" class="btn btn-secondary" name="btn1">Gönder</button>

        

        

        </form>
</div>
    
</body>
</html>