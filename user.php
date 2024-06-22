<?php
    require("function.php");

    if (isset($_GET["user"])) {
        $user = $_GET["user"];
    }

    if (isset($_POST["kerjakan"])) {
        $key = $_POST["key"];
        $user = $_POST["user"];
        $cases = $_SESSION["cases"];
        $curCase = $cases[$key];
        $noCase = $curCase["noKasus"];
        $judul = $curCase["judul"];
        $namaPelapor = $curCase["namaPelapor"];
        $noTelpPelapor = $curCase["noTelpPelapor"];
        $kategori = $curCase["kategori"];
        $status = "Sedang Ditangani";
        $polisi = strtolower($user);

        $cases[$key] = [
            "noKasus" => $noCase,
            "judul" => $judul,
            "namaPelapor" => $namaPelapor,
            "noTelpPelapor" => $noTelpPelapor,
            "kategori" => $kategori,
            "status" => $status,
            "polisi" => $polisi 
        ];
        $_SESSION["cases"] = $cases;
    }
    
    if (isset($_POST["selesaikan"])) {
        $key = $_POST["key"];
        $user = $_POST["user"];
        $cases = $_SESSION["cases"];
        $curCase = $cases[$key];
        $noCase = $curCase["noKasus"];
        $judul = $curCase["judul"];
        $namaPelapor = $curCase["namaPelapor"];
        $noTelpPelapor = $curCase["noTelpPelapor"];
        $kategori = $curCase["kategori"];
        $status = "Selesai";
        $polisi = strtolower($user);

        $cases[$key] = [
            "noKasus" => $noCase,
            "judul" => $judul,
            "namaPelapor" => $namaPelapor,
            "noTelpPelapor" => $noTelpPelapor,
            "kategori" => $kategori,
            "status" => $status,
            "polisi" => $polisi 
        ];
        $_SESSION["cases"] = $cases;
    }

    if (isset($_POST["logout"])) {
        $user = $_POST["user"];
        if ($user == "agus") {
            unset($_SESSION["agusNotifications"]);
        } else if ($user == "susi") {
            unset($_SESSION["susiNotifications"]);
        } else if ($user == "budi") {
            unset($_SESSION["budiNotifications"]);
        }
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="userStyle.css">
    <!-- CDN ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
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

            <div class="notification">
                <?php
                    if (strtolower($user) == "agus") {
                        $notif = $_SESSION["agusNotifications"];
                    } else if (strtolower($user) == "susi") {
                        $notif = $_SESSION["susiNotifications"];
                    } else if (strtolower($user) == "budi") {
                        $notif = $_SESSION["budiNotifications"];
                    }
                    
                    for ($i=0; $i < count($notif); $i++) { 
                        $tempNotif = $notif[$i];
                        $message = $tempNotif["message"];
                        $kategori = $tempNotif["kategori"];

                        if ($kategori == "KejahatanRingan") {
                            ?>
                            <div class="notifBox">
                                <i class="fa fa-bell font15 colorBurlywoord"></i>                            
                                <span class="caseRingan font15 margin15"><?= $message ?></span>
                            </div>
                            <br>
                            <?php
                        } else if ($kategori == "KasusKekerasan") {
                            ?>
                            <div class="notifBox">
                                <i class="fa fa-bell font15 colorBurlywoord"></i>
                                <span class="caseKekerasan font15 margin15"><?= $message ?></span>
                            </div>
                            <br>
                            <?php
                        } else if ($kategori == "KasusDarurat") {
                            ?>
                            <div class="notifBox">
                                <i class="fa fa-bell font15 colorBurlywoord"></i>
                                <span class="caseDarurat font15 margin15"><?= $message ?></span>
                            </div>
                            <br>
                            <?php
                        }
                    }
                ?>
            </div>

            <div class="inputSection">
                <h1 class="headerLaporan">Kasus</h1>
                
                <table class="caseTable">
                    <tr>
                        <th>No Kasus</th>
                        <th>Judul</th>
                        <th>Nama Pelapor</th>
                        <th>No. Telp Pelapor</th>
                        <th>Kategori</th>
                        <th>Action</th>
                    </tr>
                    <?php
                        $cases = $_SESSION["cases"];
                        // for ($i=0; $i < count($cases); $i++) {
                        foreach ($cases as $key => $case) { 
                            // $case = $cases[$i];
                            // $key = $i;
                            $noCase = $case["noKasus"];
                            $judul = $case["judul"];
                            $namaPelapor = $case["namaPelapor"];
                            $noTelpPelapor = $case["noTelpPelapor"];
                            $kategori = $case["kategori"];
                            $status = $case["status"];
                            $polisi = $case["polisi"];

                            if ($kategori == "KejahatanRingan" && $polisi == $user) {
                                ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="key" value="<?= $key ?>">
                                        <input type="hidden" name="user" value="<?= $user ?>">
                                        <tr class="caseRingan">
                                            <td><?= $noCase ?></td>
                                            <td><?= $judul ?></td>
                                            <td><?= $namaPelapor ?></td>
                                            <td><?= $noTelpPelapor ?></td>
                                            <td><?= $kategori?></td>
                                            <?php
                                            if ($status == "Terbuka") {
                                                ?>
                                                <td>
                                                    <button class="btnAction" name="kerjakan">Kerjakan</button>
                                                </td>
                                                <?php
                                            } else if ($status == "Sedang Ditangani" && $polisi == strtolower($user)) {
                                                ?>
                                                <td>
                                                    <button class="btnAction" name="selesaikan">Selesaikan</button>
                                                </td>
                                                <?php
                                            } else {
                                                ?>
                                                <td></td>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                    </form>
                                <?php
                            } else if ($kategori == "KasusKekerasan" && $polisi == $user) {
                                ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="key" value="<?= $key ?>">
                                        <input type="hidden" name="user" value="<?= $user ?>">
                                        <tr class="caseKekerasan">
                                        <td><?= $noCase ?></td>
                                            <td><?= $judul ?></td>
                                            <td><?= $namaPelapor ?></td>
                                            <td><?= $noTelpPelapor ?></td>
                                            <td><?= $kategori?></td>
                                            <?php
                                            if ($status == "Terbuka") {
                                                ?>
                                                <td>
                                                    <button class="btnAction" name="kerjakan">Kerjakan</button>
                                                </td>
                                                <?php
                                            } else if ($status == "Sedang Ditangani" && $polisi == strtolower($user)) {
                                                ?>
                                                <td>
                                                    <button class="btnAction" name="selesaikan">Selesaikan</button>
                                                </td>
                                                <?php
                                            } else {
                                                ?>
                                                <td></td>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                    </form>
                                <?php
                            } else if ($kategori == "KasusDarurat" && $polisi == $user) {
                                ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="key" value="<?= $key ?>">
                                        <input type="hidden" name="user" value="<?= $user ?>">
                                        <tr class="caseDarurat">
                                        <td><?= $noCase ?></td>
                                            <td><?= $judul ?></td>
                                            <td><?= $namaPelapor ?></td>
                                            <td><?= $noTelpPelapor ?></td>
                                            <td><?= $kategori?></td>
                                            <?php
                                            if ($status == "Terbuka") {
                                                ?>
                                                <td>
                                                    <button class="btnAction" name="kerjakan">Kerjakan</button>
                                                </td>
                                                <?php
                                            } else if ($status == "Sedang Ditangani" && $polisi == strtolower($user)) {
                                                ?>
                                                <td>
                                                    <button class="btnAction" name="selesaikan">Selesaikan</button>
                                                </td>
                                                <?php
                                            } else {
                                                ?>
                                                <td></td>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                    </form>
                                <?php
                            }
                        }
                    ?>
                </table>
            </div>


            <form action="" method="post" class="formLogout">
                <input type="hidden" name="user" value="<?= $user ?>">
                <button class="btnLogout" name="logout">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>

