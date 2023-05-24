<?php

session_start();

include 'baglan.php';
include 'navbar.php';

if(isset($_POST['btn3'])){

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Bağlantı hatası: " . $e->getMessage();
    }
    
    // Kullanıcının gönderdiği anket verilerini almak
    $anketBasligi = $_POST['baslik'];
    $soru1 = $_POST['soru1'];
    $soru2 = $_POST['soru2'];
    // Diğer soruları ve verileri buraya ekleyebilirsiniz
    
    // Anket verilerini veritabanına kaydetmek için sorgu hazırlama ve çalıştırma
    try {
        $stmt = $conn->prepare("INSERT INTO anketler (soru, cevap1, cevap2) VALUES (:baslik, :soru1, :soru2)");
        $stmt->bindParam(':baslik', $anketBasligi);
        $stmt->bindParam(':soru1', $soru1);
        $stmt->bindParam(':soru2', $soru2);
        // Diğer soruları ve verileri buraya ekleyebilirsiniz
    
        $stmt->execute();
        $alert = "Anket verileri başarıyla kaydedildi!";
        

    } catch(PDOException $e) {
        echo "Hata: " . $e->getMessage();
        
    }
    
    // PDO bağlantısını kapatma
    $conn = null;

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

        
            <div class="row">
                <?php
                if (isset($alert)) {
                    echo '<div class="alert alert-danger" role="alert">' . $alert . '</div>';
                }
                ?>
            </div>
            <div class="row">



            <form action="" method="post">

                
                    
                    <label for="inputBaslik">Soru:</label>
                    <input type="text" id="inputBaslik" class="form-control" aria-describedby="passwordHelpBlock" name="baslik">
                    <small id="passwordHelpBlock" class="form-text text-muted">
                    
                    </small>
                    <br>

                    <label for="inputSoru1">Cevap 1</label>
                    <input type="text" id="inputBaslik" class="form-control" aria-describedby="passwordHelpBlock" name="soru1">
                    <small id="passwordHelpBlock" class="form-text text-muted">
                    
                    </small>
                    <br>

                    <label for="inputSoru2">Cevap 2</label>
                    <input type="text" id="inputBaslik" class="form-control" aria-describedby="passwordHelpBlock" name="soru2">
                    <small id="passwordHelpBlock" class="form-text text-muted">
                    
                    </small>
                    <br>

                    <button type="submit" class="btn btn-secondary" name="btn3">Gönder</button>





                    </form>








            </div>

            <div class="row"><?php echo "Hoşgeldin: " . $_SESSION['username']; ?></div>
                

        

        
    </div>
    
</body>
</html>