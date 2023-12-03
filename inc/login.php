<?php
session_start();
include 'koneksidb.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "gagal") {
            echo "<script> alert('Gagal Login');</script>";
        } else if ($_GET['pesan'] == "belum") {
            echo "<script> alert('Anda Belum Login');</script>";
        }
    }
    ?>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-transparent mb-0">
                        <h5 class="text-center"><span class="font-weight-bold text-black">LOGIN</span></h5>
                    </div>
                    <div class="card-body">
                        <form action="cek_login.php" method="post" class="form-horizontal">

                            <div class="form-group">
                                <label class="control-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="control-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>

                            <br>
                            <center>
                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button class="btn btn-success" name="login">Login</button>
                                    </div>
                                </div>
                            </center>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>