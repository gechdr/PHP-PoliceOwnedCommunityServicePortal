<?php
    require("function.php");

    if (isset($_POST["assign"])) {
        $safe = true;

        $key = $_POST["key"];
        $cases = $_SESSION["cases"];
        $curCase = $cases[$key];
        $noCase = $curCase["noKasus"];
        $judul = $curCase["judul"];
        $namaPelapor = $curCase["namaPelapor"];
        $noTelpPelapor = $curCase["noTelpPelapor"];
        $kategori = $curCase["kategori"];
        $status = $curCase["status"];
        $polisi = $_POST["polisi"];
        $polisi = strtolower($polisi);

        if ($polisi == "none") {
            $safe = false;
        }

        if ($safe) {
            $cases[$key] = [
                "noKasus" => $noCase,
                "judul" => $judul,
                "namaPelapor" => $namaPelapor,
                "noTelpPelapor" => $noTelpPelapor,
                "kategori" => $kategori,
                "status" => $status,
                "polisi" => strtolower($polisi) 
            ];
            $_SESSION["cases"] = $cases;
    
            $message = "Anda Menerima pekerjaan baru!";
            $notif = [
                "message" => $message,
                "kategori" => $kategori
            ];

            if ($polisi == "agus") {
                array_push($_SESSION["agusNotifications"],$notif);
            } else if ($polisi == "susi") {
                array_push($_SESSION["susiNotifications"],$notif);
            } else if ($polisi == "budi") {
                array_push($_SESSION["budiNotifications"],$notif);
            }
        }
    }

    if (isset($_POST["logout"])) {
        unset($_SESSION["adminNotifications"]);
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="adminStyle.css">
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
                    $notif = $_SESSION["adminNotifications"];
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
                        <th>Status</th>
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

                            if ($kategori == "KejahatanRingan") {
                                ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="key" value="<?= $key ?>">
                                        <tr class="caseRingan">
                                            <td><?= $noCase ?></td>
                                            <td><?= $judul ?></td>
                                            <td><?= $namaPelapor ?></td>
                                            <td><?= $noTelpPelapor ?></td>
                                            <td><?= $kategori?></td>
                                            <td><?= $status?></td>
                                            <?php
                                            if ($status == "Terbuka" && $polisi == "") {
                                                ?>
                                                <td>
                                                    <select name="polisi" id="" class="cbAssign">
                                                        <option value="none"><- Polisi -></option>
                                                        <option value="agus">Agus</option>
                                                        <option value="susi">Susi</option>
                                                        <option value="budi">Budi</option>
                                                    </select>
                                                    <button class="btnAssign" name="assign">Assign</button>
                                                </td>
                                                <?php
                                            } else if ($status == "Sedang Ditangani" || ($polisi != "" && $status == "Terbuka")) {
                                                ?>
                                                <td>Waiting</td>
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
                            } else if ($kategori == "KasusKekerasan") {
                                ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="key" value="<?= $key ?>">
                                        <tr class="caseKekerasan">
                                            <td><?= $noCase ?></td>
                                            <td><?= $judul ?></td>
                                            <td><?= $namaPelapor ?></td>
                                            <td><?= $noTelpPelapor ?></td>
                                            <td><?= $kategori?></td>
                                            <td><?= $status?></td>
                                            <?php
                                            if ($status == "Terbuka" && $polisi == "") {
                                                ?>
                                                <td>
                                                    <select name="polisi" id="" class="cbAssign">
                                                        <option value="none"><- Polisi -></option>
                                                        <option value="Agus">Agus</option>
                                                        <option value="Susi">Susi</option>
                                                        <option value="Budi">Budi</option>
                                                    </select>
                                                    <button class="btnAssign" name="assign">Assign</button>
                                                </td>
                                                <?php
                                            } else if ($status == "Sedang Ditangani" || ($polisi != "" && $status == "Terbuka")) {
                                                ?>
                                                <td>Waiting</td>
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
                            } else if ($kategori == "KasusDarurat") {
                                ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="key" value="<?= $key ?>">
                                        <tr class="caseDarurat">
                                            <td><?= $noCase ?></td>
                                            <td><?= $judul ?></td>
                                            <td><?= $namaPelapor ?></td>
                                            <td><?= $noTelpPelapor ?></td>
                                            <td><?= $kategori?></td>
                                            <td><?= $status?></td>
                                            <?php
                                            if ($status == "Terbuka" && $polisi == "") {
                                                ?>
                                                <td>
                                                    <select name="polisi" id="" class="cbAssign">
                                                        <option value="none"><- Polisi -></option>
                                                        <option value="Agus">Agus</option>
                                                        <option value="Susi">Susi</option>
                                                        <option value="Budi">Budi</option>
                                                    </select>
                                                    <button class="btnAssign" name="assign">Assign</button>
                                                </td>
                                                <?php
                                            } else if ($status == "Sedang Ditangani" || ($polisi != "" && $status == "Terbuka")) {
                                                ?>
                                                <td>Waiting</td>
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
                <button class="btnLogout" name="logout">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>

