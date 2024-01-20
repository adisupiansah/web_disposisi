<?php

// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "web_disposisi");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $conn;

    $tanggal = htmlspecialchars($data["tanggal"]);
    $no_surat = htmlspecialchars($data["no_surat"]);
    $no_disposisi= htmlspecialchars($data["no_disposisi"]);
    $perihal = htmlspecialchars($data["perihal"]);
    $satfung = htmlspecialchars($data["satfung"]);


    $query = "INSERT INTO mahasiswa
    VALUES
    ('', '$no_surat', '$perihal', '$no_disposisi', '$satfung', '$tanggal')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function upload() {

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar di upload
    if ($error === 4) {
        echo "<script>
                alert('pilih gambar terlebih dahulu');
             </script>";

        return false;
    }

    // cek apaakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
                alert('yang anda upload bukan gambar');
             </script>";

        return false;
    }

    // cek jika ukurann gambar terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('ukuran gambar terlalu besar');
            </script>";

        return false;
    }


    // generate nama baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    //lolos pengecakan, gambar siap di upload
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}


function ubah($data)
{

    global $conn;

    $id = $data["id"];
    $tanggal = htmlspecialchars($data["tanggal"]);
    $no_surat = htmlspecialchars($data["no_surat"]);
    $no_disposisi = htmlspecialchars($data["no_disposisi"]);
    $perihal = htmlspecialchars($data["perihal"]);
    $satfung = htmlspecialchars($data["satfung"]);



    $query = "UPDATE mahasiswa SET 
                no_surat = '$no_surat',
                perihal = '$perihal',
                no_disposisi = '$no_disposisi',
                satfung = '$satfung',
                tanggal = '$tanggal'
            WHERE id = $id
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function cari($keyword)
{
    $query = "SELECT * FROM mahasiswa 
                WHERE 
               no_surat LIKE '%$keyword%' OR 
               perihal LIKE '%$keyword%' OR
               satfung LIKE '%$keyword%' OR
               tanggal LIKE '%$keyword%'
                ";
    // pada retunr query saya memanfaatkan function query di atas,sehingga saya tidak membuat ulang untuk tampil mahasiswa
    return query($query);
}


function registrasi ($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");

    if ( mysqli_fetch_assoc($result) ) {
        echo "
            <script>
                alert('username sudah terdaftar');
            </script>";

        return false;
    }

    // cek konsfirmasi password
    if( $password !== $password2 ) {
        echo "
            <script>
                alert('password tidak sesuai');
            </script>
        ";

        return false;
    } 

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);


}
