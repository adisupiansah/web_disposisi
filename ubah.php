<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


require 'functions.php';


// ambil data di url
$id  = $_GET["id"];

// query data mahasiswa berdasarkan id-nya
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];




// cek apakaah tombol submit sudah di tekan atau belum
if (isset($_POST["submit"])) {

    // cek apakah data berhasil di ubah atau tidak
    if (ubah($_POST) > 0) {
        echo "
        <script>
            alert('data berhasil di ubah');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('data gagal di ubah');
            document.location.href = 'index.php';
        </script>
        ";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css bootstrap v.5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- fonts google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

    <!-- css Custom -->
    <link rel="stylesheet" href="css/ubah.css">

    <!-- logo title -->
    <link rel="icon" href="img/logo-title.png">

    <!-- icon bootstrap v.5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <title>Tambah Data Mahasiswa</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm p-3 mb-3">
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
                        <a class="nav-link active" aria-current="page" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- dashboard -->
    <section>
        <div class="container mb-4">
            <h2>Disposisi</h2>
            <p class="text-secondary">Dashboard | Disposisi | edit</p>
        </div>
    </section>

    <!-- form edit -->
    <section>
        <div class="container">
            <div class="card p-3 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
                                <div class="mb-4 row">
                                    <label for="tanggal" class="col-sm-6 col-form-label">Tanggal</label>
                                    <div class="col-sm-6">
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required value="<?= $mhs['tanggal']; ?>">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="no_surat" class="col-sm-6 col-form-label">No surat</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="no_surat" name="no_surat" required value="<?= $mhs['no_surat']; ?>">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="no_disposisi" class="col-sm-6 col-form-label">No disposisi</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="no_disposisi" name="no_disposisi" required value="<?= $mhs['no_disposisi']; ?>">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="perihal" class="col-sm-6 col-form-label">Perihal</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="perihal" name="perihal" required value="<?= $mhs['perihal']; ?>">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="satfung" class="col-sm-6 col-form-label">Satfung</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" id="satfung" name="satfung" required value="<?= $mhs['satfung']; ?>">
                                    </div>
                                </div>
                                <button class="btn btn-success text-end d-flex" type="submit" name="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>



    <!-- <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"]; ?>">

        <ul>
            <li>
                <label for="nrp">Nrp :</label>
                <input type="text" name="nrp" id="nrp" required value="<?= $mhs["nrp"]; ?>">


            </li>
            <li>
                <label for="nama">Nama :</label>
                <input type="text" name="nama" id="nama" required value="<?= $mhs["nama"]; ?>">
            </li>
            <li>
                <label for="email">Email :</label>
                <input type="text" name="email" id="email" required value="<?= $mhs["email"]; ?>">
            </li>
            <li>
                <label for="jurusan">Jurusan :</label>
                <input type="text" name="jurusan" id="jurusan" required value="<?= $mhs["jurusan"]; ?>">
            </li>
            <li>
                <label for="gambar">Gambar :</label>
                <img src="img/<?= $mhs["gambar"]; ?>" width="30"> <br></br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah data</button>
            </li>
        </ul>

    </form> -->


    <!-- java script bootstrap v5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>