<?php
    require("function.php");

    if (!isset($_SESSION["users"])) {
        // agus, susi, dan budi
        $_SESSION["users"] = [];
        $acc = [
            "username" => "agus",
            "password" => "suga"
        ];
        array_push($_SESSION["users"],$acc);
        $acc = [
            "username" => "susi",
            "password" => "isus"
        ];
        array_push($_SESSION["users"],$acc);
        $acc = [
            "username" => "budi",
            "password" => "idub"
        ];
        array_push($_SESSION["users"],$acc);

        // echo "<br>";
        // var_dump($acc);
        // echo "<br>";
        // echo "<br>";
    }

    if (!isset($_SESSION["cases"])) {
        $_SESSION["cases"] = [];
    }

    if (!isset($_SESSION["noCase"])) {
        $_SESSION["noCase"] = 1;
    }

    if (!isset($_SESSION["adminNotifications"])) {
        $_SESSION["adminNotifications"] = [];
    }
    if (!isset($_SESSION["agusNotifications"])) {
        $_SESSION["agusNotifications"] = [];
    }
    if (!isset($_SESSION["susiNotifications"])) {
        $_SESSION["susiNotifications"] = [];
    }
    if (!isset($_SESSION["budiNotifications"])) {
        $_SESSION["budiNotifications"] = [];
    }

    if (isset($_POST["submit"])) {
        $safe = true;

        $judul = $_POST["judul"];
        $namaPelapor = $_POST["namaPelapor"];
        $noTelpPelapor = $_POST["noTelpPelapor"];
        $kategori = $_POST["kategoriCb"];
        $deskripsi = $_POST["deskripsi"];

        if ($judul == "" || $namaPelapor == "" || $noTelpPelapor == "" || $kategori == "none") {
            $safe = false;
            alert("Semua field harus terisi!");
        }

        if (!is_numeric($noTelpPelapor)) {
            $safe = false;
            alert("No.Telp harus angka!");
        }

        if ($safe) {

            $noCase = $_SESSION["noCase"];
            
            $case = [
                "noKasus" => $noCase,
                "judul" => $judul,
                "namaPelapor" => $namaPelapor,
                "noTelpPelapor" => $noTelpPelapor,
                "kategori" => $kategori,
                "status" => "Terbuka",
                "polisi" => ""
            ];
            
            array_push($_SESSION["cases"],$case);
            alert("Berhasil Lapor!");
            $_SESSION["noCase"] = $noCase += 1;
            
            $notif = [
                "message" => "Kasus baru dengan Kategori $kategori telah dilaporkan oleh $namaPelapor.",
                "kategori" => $kategori
            ];
            array_push($_SESSION["adminNotifications"],$notif);

            // echo "<br>";
            // var_dump($_SESSION["cases"]);
            // echo "<br>";
            // echo "<br>";
        }
    }

    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $safe = true;
        $exist = false;

        if ($username == "admin") {
            if ($password == "nimda") {
                header("Location: admin.php");
            } else {
                $safe = false;
                alert("Wrong Password!");
            }
        } else {
            if ($username == "" || $password == "") {
                $safe = false;
                alert("Semua field harus terisi!");
            }

            $users = $_SESSION["users"];
            for ($i=0; $i < count($users); $i++) { 
                $user = $users[$i];
                if ($username == $user["username"]) {
                    $exist = true;
                    if ($password != $user["password"]) {
                        $safe = false;
                        alert("Wrong Password!");
                    }
                }
            }
        }

        if ($exist == false) {
            $safe = false;
            alert("Username tidak terdaftar!");
        }
        
        if ($safe) {
            header("Location: user.php?user=$username");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor</title>
    <link rel="stylesheet" href="indexStyle.css">
</head>
<body>
    <!-- <a href="destroy.php">destroy</a> -->
    <div class="container">
        <div class="content">
            <div class="header">
                <div class="headerKiri">
                    <img src="img/logo.png" alt="Logo Dinas">
                </div>
                <div class="headerKanan">
                    <h1>Dinas Kepolisian</h1>
                    <p>Laporkan jika anda menemukan tindakan kejahatan dimana pun dan kapan pun!</p>
                </div>
            </div>
            
            <hr>

            <form action="" method="post" class="inputSection">
                <h1 class="headerLaporan">Laporan</h1>
                <div class="inputBox">
                    <div class="inputKiri">
                        <label class="labelInput" for="judul">Judul</label>
                    </div>
                    <div class="inputKanan">
                        <input class="inputComponent" type="text" name="judul" id="judul">
                    </div>
                </div>
                <div class="inputBox">
                    <div class="inputKiri">
                        <label class="labelInput" for="namaPelapor">Nama Pelapor</label>
                    </div>
                    <div class="inputKanan">
                        <input class="inputComponent" type="text" name="namaPelapor" id="namaPelapor">
                    </div>
                </div>
                <div class="inputBox">
                    <div class="inputKiri">
                        <label class="labelInput" for="noTelpPelapor">No. Telp Pelapor</label>
                    </div>
                    <div class="inputKanan">
                        <input class="inputComponent" type="text" name="noTelpPelapor" id="noTelpPelapor">
                    </div>
                </div>
                <div class="inputCombo">
                    <div class="inputKiri">
                        <label class="labelInput" for="kategori">Kategori</label>
                    </div>
                    <div class="inputKanan">
                        <select name="kategoriCb" id="kategori" class="inputCb">
                            <option value="none"><- Kategori -></option>
                            <option value="KejahatanRingan">Kejahatan Ringan</option>
                            <option value="KasusKekerasan">Kasus Kekerasan</option>
                            <option value="KasusDarurat">Kasus Darurat</option>
                        </select>
                    </div>
                </div>
                <div class="inputMulti">
                    <div class="inputKiriMulti">
                        <label class="labelInput" for="deskripsi">Deskripsi Kasus</label>
                    </div>
                    <div class="inputKanan">
                        <textarea name="deskripsi" id="deskripsi" cols="63" rows="22" class="inputTextArea"></textarea>
                    </div>
                </div>
                <button class="buttonSubmit" type="submit" name="submit">Submit</button>
            </form>

            <!-- <hr> -->

            <form action="" method="post" class="inputSectionLogin">
            <h1 class="headerLaporan">Login</h1>
                <div class="inputBox">
                    <div class="inputKiri">
                        <label class="labelInput" for="username">Username</label>
                    </div>
                    <div class="inputKanan">
                        <input class="inputComponent" type="text" name="username" id="username">
                    </div>
                </div>
                <div class="inputBox">
                    <div class="inputKiri">
                        <label class="labelInput" for="password">Password</label>
                    </div>
                    <div class="inputKanan">
                        <input class="inputComponent" type="password" name="password" id="password">
                    </div>
                </div>
                <button class="buttonSubmit" type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>

