<?php
session_start();

echo $anket_id;

// Oturumda kullanıcı adı kontrolü
if (!isset($_SESSION['username'])) {
    // Kullanıcı giriş yapmamış, yönlendirme yapabilirsiniz
    header("Location: giris.php"); // Giriş sayfasına yönlendir
    exit; // Kodun devamını çalıştırmamak için çıkış yap
}

include 'baglan.php';
include 'navbar.php';


// PDO bağlantısı için gerekli bilgiler
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "anket";

// PDO bağlantısını oluşturma
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
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

    <script>
    // Sayfa yüklendikten sonra çalışacak kod
    window.onload = function() {
        // URL'yi al
        var url = window.location.href;
        // URL'de '?id=' parametresi var mı kontrol et
        if (url.indexOf('?id=') > -1) {
            // Parametreleri al
            var params = new URLSearchParams(window.location.search);
            // 'id' parametresinin değerini al
            var anket_id = params.get('id');
            // Anketi paylaşma fonksiyonunu çağır
            shareAnket(anket_id);
        }
    };

    function shareAnket(anket_id) {
        var url = window.location.href.split('?')[0];  // Mevcut sayfanın URL'sini al
        var sharedUrl = url + '?id=' + anket_id;  // Anket ID'sini URL'ye ekle

        // '#' işaretini kaldırma
        sharedUrl = sharedUrl.replace('#', '');

        copyValue(sharedUrl);  // Değeri panoya kopyala
    }

    function copyValue(value) {
        // Metni panoya kopyala
        navigator.clipboard.writeText(value);

        // Kopyalandı mesajını göster
        alert("Değer kopyalandı: " + value);
    }
</script>
   


    <title>Anket</title>
</head>
<body>
    <a href="giris.php" class="girisYap">Giriş Yap</a>
    <a href="cikis.php" class="cikisYap">Çıkış Yap</a>
    <div class="container bg-light mt-5 p-5 mb-5">
        <?php
        // Oy verme işlemi
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kullanıcının oyu
            $oy = $_POST['oy'];
            // Seçilen anketin ID'si
            $anket_id = $_POST['anket_id'];

            // Kullanıcının daha önce oy kullandığını kontrol et
            $stmt = $conn->prepare("SELECT * FROM oy_kullananlar WHERE anket_id = :anket_id AND username = :username");
            $stmt->bindParam(':anket_id', $anket_id);
            $stmt->bindParam(':username', $_SESSION['username']);
            $stmt->execute();
            $oy_kullanan = $stmt->fetch();

            if ($oy_kullanan) {
                $alert = "Zaten oy kullandınız!";
            } else {
                // Veritabanını güncelleme
                try {
                    $conn->beginTransaction(); // İşlemi başlat

                    // Oy sayısını güncelleme işlemini gerçekleştir
                    if ($oy == 'secenek1') {
                        $stmt = $conn->prepare("UPDATE anketler SET secenek1_oy = secenek1_oy + 1 WHERE anket_id = :anket_id");
                        $stmt->bindParam(':anket_id', $anket_id);
                        $stmt->execute();
                        $alert = "Oyunuz başarıyla kaydedildi!";
                    } elseif ($oy == 'secenek2') {
                        $stmt = $conn->prepare("UPDATE anketler SET secenek2_oy = secenek2_oy + 1 WHERE anket_id = :anket_id");
                        $stmt->bindParam(':anket_id', $anket_id);
                        $stmt->execute();
                        $alert = "Oyunuz başarıyla kaydedildi!";
                    }

                    // Oy kullanma işlemini gerçekleştir
                    $stmt = $conn->prepare("INSERT INTO oy_kullananlar (anket_id, username) VALUES (:anket_id, :username)");
                    $stmt->bindParam(':anket_id', $anket_id);
                    $stmt->bindParam(':username', $_SESSION['username']);
                    $stmt->execute();

                    $conn->commit(); // İşlemi tamamla
                } catch(PDOException $e) {
                    $conn->rollBack(); // İşlemi geri al
                    echo "Hata: " . $e->getMessage();
                }
            }
        }

        // Anketi almak için kimliği kontrol et
        if (isset($_GET['id'])) {
            $anket_id = $_GET['id'];

            // Anketi veritabanından al
            try {
                $stmt = $conn->prepare("SELECT * FROM anketler WHERE anket_id = :anket_id");
                $stmt->bindParam(':anket_id', $anket_id);
                $stmt->execute();
                $anket = $stmt->fetch();

                if ($anket) {
                    // Anket bulundu, içeriği göster
                    if (isset($alert)) {
                        echo '<div class="alert alert-success" role="alert">' . $alert . '</div>';
                        $alert = ""; // Alert sıfırlama
                    }

                    echo '<div class="row">'; // Satır başlangıcı
    
                    echo '<div class="col">';
                    echo '<div class="baslik">Soru: ' . $anket['soru'] . '</div>';
                    echo '<form method="POST">';
                    echo '<input type="hidden" name="anket_id" value="' . $row['anket_id'] . '">';
                    echo '<input type="radio" name="oy" value="secenek1"> ' . $anket['cevap1'] . '<br>';
                    echo '<input type="radio" name="oy" value="secenek2"> ' . $anket['cevap2'] . '<br>';
                    echo '<button type="submit">Oy Ver</button>';
                    echo '</form>';
                    echo '</div>';
    
                    echo '<div class="col">';
                    echo '<div class="oySayisi1">Oy Sayısı 1: ' . $anket['secenek1_oy'] . "<br></div>";
                    echo '<div class="oySayisi2">Oy Sayısı 2: ' . $anket['secenek2_oy'] . "<br></div>";
                    echo '<a href="#" onclick="shareAnket(' . $anket['anket_id'] . ')">Anketi Paylaş</a>';
                    echo '</div>';
    
                    echo '</div>'; // Satır sonu
                    echo '<br>';
                    echo '<hr>';
                    
                } else {
                    echo "Anket bulunamadı!";
                }
            } catch(PDOException $e) {
                echo "Hata: " . $e->getMessage();
            }
        } else {
            try {
                $stmt = $conn->prepare("SELECT * FROM anketler");
                $stmt->execute();

                // Sonuçları döngüyle alıp ekrana yazdırma
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    if (isset($alert)) {
                        echo '<div class="alert alert-success" role="alert">' . $alert . '</div>';
                        $alert = ""; // Alert sıfırlama
                    }

                    echo '<div class="row">'; // Satır başlangıcı
    
                    echo '<div class="col">';
                    echo '<div class="baslik">Soru: ' . $row['soru'] . '</div>';
                    echo '<form method="POST">';
                    echo '<input type="hidden" name="anket_id" value="' . $row['anket_id'] . '">';
                    echo '<input type="radio" name="oy" value="secenek1"> ' . $row['cevap1'] . '<br>';
                    echo '<input type="radio" name="oy" value="secenek2"> ' . $row['cevap2'] . '<br>';
                    echo '<button type="submit">Oy Ver</button>';
                    echo '</form>';
                    echo '</div>';
    
                    echo '<div class="col">';
                    echo '<div class="oySayisi1">Oy Sayısı 1: ' . $row['secenek1_oy'] . "<br></div>";
                    echo '<div class="oySayisi2">Oy Sayısı 2: ' . $row['secenek2_oy'] . "<br></div>";
                    echo '<a href="#" onclick="shareAnket(' . $row['anket_id'] . ')">Anketi Paylaş</a>';
                    echo '</div>';
    
                    echo '</div>'; // Satır sonu
                    echo '<br>';
                    echo '<hr>';
                    
                    
                }
            } catch(PDOException $e) {
                echo "Hata: " . $e->getMessage();
            }
        }
    

        

        // PDO bağlantısını kapatma
        $conn = null;
        ?>
    </div>
</body>
</html>
