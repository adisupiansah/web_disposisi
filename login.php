<?php
// jalankan session
session_start();
require 'functions.php';

// cek cookie
// if (isset($_COOKIE['login'])) {
//     if($_COOKIE['login'] == 'true') {
//         $_SESSION['login'] = true;
//     }
// }
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE
                 username = '$username'");


    // cek username
    if (mysqli_num_rows($result) === 1) {

        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {

            // set Sesiion-nya
            $_SESSION["login"] = true;

            // cek remember me
            if (isset($_POST['remember'])) {
                // buat cookie

                setcookie('id', $row['id'], time() + 60);
                setcookie('key', hash('sha256', $row['username']), time() + 60);


                // setcookie('login', 'true', time() + 60 );
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
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
    <link rel="stylesheet" href="css/login.css">

    <!-- logo title -->
    <link rel="icon" href="img/logo-title.png">

    <!-- icon bootstrap v.5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="kartulogin">
                <div class="col-md-6">
                    <div class="card p-3 mb-3 mt-5">
                        <div class="card-body p-4">

                            <?php if (isset($error)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    Username / password salah
                                </div>
                            <?php endif; ?>

                            <form action="" method="post">

                                <ul>

                                    <label for="username">Username : </label>
                                    <input type="text" name="username" id="username" class="form form-control">

                                    <label for="password">Password : </label>
                                    <input type="password" name="password" id="password" class="form form-control">

                                    <br>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="remember" name="remember" checked>
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>

                                    <button type="submit" name="login" class="btn btn-success col-12 mt-3">Login</button>

                                </ul>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <style>
        body {
            background-image: url(img/background-login.png);
            min-height: 100vh;
       
            background-size: cover;
        }
    </style>


    <!-- java script bootstrap v5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>