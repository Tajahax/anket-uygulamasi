<?php
session_start();
include 'baglan.php';
include 'navbar.php';



if (isset($_POST["btn2"])) {
    // Formdan gelen verileri al
    $kullaniciAdi = $_POST['username'];
    $sifre = $_POST['password'];

    // Veritabanında kullanıcıyı kontrol et
    $sql = "SELECT * FROM uyeler WHERE kadi = '$kullaniciAdi' AND sifre = '$sifre'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Giriş başarılı, oturum oluştur
        $_SESSION['username'] = $kullaniciAdi;
        header("Location: index.php");
        exit();
    } else {
        $alert = "Hatalı kullanıcı adı veya şifre.";
    }
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
                    <label for="inputPassword5">Username</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">@</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="username">
                    </div>
                    <label for="inputPassword5">Password</label>
                    <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" name="password">
                    <small id="passwordHelpBlock" class="form-text text-muted"></small><br>
                    <button type="submit" class="btn btn-secondary" name="btn2">Login</button>
                </form>

            </div>

    </div>
</body>
</html>





