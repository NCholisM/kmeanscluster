<!DOCTYPE html>
<html lang="en">


<head>
  <title>K-MEANS</title>

  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
</head>

<body>
  <?php
  session_start();

  if ($_SESSION['status'] != "login") {
    header("location:login.php?pesan=belum");
  }

  ?>

  <div class="wrapper">
    <div class="sidebar" data-color="green" data-background-color="white">
      <div class="logo"><a href="../inc/home.php" class="simple-text logo-normal">
          K-MEANS
        </a></div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          
          <li class="nav-item active  ">
            <a class="nav-link" href="../inc/home.php">
              <p>Home</p>
            </a>
          </li>
          <li class="nav-item active  ">
            <a class="nav-link" href="../dash/upload.php">
              <p>Upload</p>
            </a>
          </li>
          <li class="nav-item active  ">
            <a class="nav-link" href="../dash/tabel.php">
              <p>Tabel</p>
            </a>
          </li>
          <li class="nav-item active  ">
            <a class="nav-link" href="../dash/cluster.php">
              <p>Centroid</p>
            </a>
          </li>
          <li class="nav-item active  ">
            <a class="nav-link" href="../dash/hasil.php">
              <p>Hasil</p>
            </a>
          </li>

          <li class="nav-item active  ">
            <a class="nav-link" href="../inc/logout.php">
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </div>
    </div>