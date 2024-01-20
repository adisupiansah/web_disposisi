<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

// pagination
// konfigurasi pagination
$jumlahDataPerhalaman = 5;
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

// note : untuk sintax SELECT * FROM mahasiswa ORDER BY id DESC itu adalah untuk menampilkan mahasiswa yang terbaru / yang baru input
// sedangkan sintax ASC adlaah mahasiswa yang berhasil input data, akan tampil di data paling bawah
$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerhalaman");

// jika tombol cari di klik, maka kita akan timpa $mahasiswa dengan data mahasiswa sesuai pencariannya
if (isset($_POST["cari"])) {

    $mahasiswa = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>

    <!-- css bootstrap v.5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- fonts google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">


    <!-- css Custom -->
    <link rel="stylesheet" href="style.css">

    <!-- logo title -->
    <link rel="icon" href="img/logo-title.png">

    <!-- icon bootstrap v.5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm p-3 mb-3">
        <div class="container">
            <!-- Logo (Kiri) -->
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Logo" height="40">
                Disposisi logistik
            </a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigasi (Kanan) -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="tambah.php">Input</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- logo presisi -->
    <div class="container">
        <div class="card jumbotron p-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="card-title">Disposisi Surat</h2>
                        <p class="card-subtitle">Halaman input nomor Disposisi surat masuk Tahun Anggaran 2024</p>
                    </div>
                    <div class="col-md-4">
                        <img src="img/logo_presisi.png" alt="" width="90%">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- dashboard jam hari tanggal -->
    <section>
        <div class="container mt-5">
            <div class="card kartu p-2 mb-3 rounded">
                <div class="card-body">
                    <h2 class="card-title">Dashboard</h2>
                    <div class="row p-3">
                        <div class="col-md-4">
                            <div class="card p-2 shadow-sm bg-body">
                                <div class="card-body">
                                    <h2 class="text-danger"><i class="bi bi-alarm"></i></h2>
                                    <h4 class="card-title">Jam</h4>
                                    <p class="card-text" id="clock">00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-2 shadow-sm bg-body">
                                <div class="card-body">
                                    <h2 class="text-success"><i class="bi bi-calendar3"></i></h2>
                                    <h4 class="card-title">Tanggal</h4>
                                    <p class="card-text" id="date">00</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card p-2 shadow-sm bg-body">
                                <div class="card-body">
                                    <h2 class="text-warning"><i class="bi bi-calendar2-day"></i></h2>
                                    <h4 class="card-title">Hari</h4>
                                    <p class="card-text" id="day">00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <br>

    <!-- tombol search -->
    <div class="container">
        <div class="row custom-search">
            <div class="col-md-8">
                <form action="" method="post" class="d-flex">
                    <input type="text" class="form form-control me-2" name="keyword" size="50" autofocus placeholder="cari nomor disposisi" autocomplete="off">
                    <button class="btn btn-success" type="submit" name="cari">Cari</button>
                </form>

            </div>
        </div>
    </div>

    <br>

    <!-- navigasi -->
    <div class="container">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
            <?php if ($halamanAktif > 1) : ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>">previos</a></li>
            <?php endif; ?>


            <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                <?php if ($i == $halamanAktif) : ?>
                    <li class="page-itemm"><a class="page-link" href="?halaman=<?= $i; ?>" style="font-weight: bold; color:red;"><?= $i; ?></a></li>
                <?php else : ?>
                    <li class="page-item">
                        <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>

                    </li>
                <?php endif; ?>

            <?php endfor; ?>

            <?php if ($halamanAktif < $jumlahHalaman) : ?>
                <li class="page-item">
                    <a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">next</a>

                </li>

            <?php endif; ?>
            </ul>
        </nav>
    </div>

    <!-- table -->
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped mb-5 mt-2">
                <tr>
                    <th>No.</th>
                    <th>Aksi</th>
                    <th>Tanggal</th>
                    <th>No.surat</th>
                    <th>No.Disposisi</th>
                    <th>Perihal</th>
                    <th>Satfung</th>
                </tr>

                <?php $i = 1; ?>
                <?php foreach ($mahasiswa as $row) : ?>

                    <tr>
                        <td><?= $i; ?></td>
                        <td>
                            <a class="text-decoration-none text-success" href="ubah.php?id=<?= $row["id"]; ?>"><i class="bi bi-pencil-fill"></i></a>
                            <a class="text-decoration-none text-danger" href="hapus.php?id=<?= $row["id"];  ?>" onclick="return confirm('Yakin?');"><i class="bi bi-trash3"></i></a>
                        </td>
                        <td><?= $row['tanggal']; ?></td>
                        <td><?= $row["no_surat"]; ?></td>
                        <td><?= $row["no_disposisi"]; ?></td>
                        <td><?= $row["perihal"]; ?></td>
                        <td><?= $row["satfung"]; ?></td>
                    </tr>

                    <?php $i++; ?>
                <?php endforeach; ?>

            </table>
        </div>
    </div>

    <style>
        .jumbotron {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .kartu {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
        }
    </style>

    <!-- java script timer -->
    <script src="time.js"></script>

    <!-- Js Bootstrap v.5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>