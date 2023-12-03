<?php include "../inc/header.php" ?>
<div class="main-panel">
  <div class="col-lg-max col-md-12">
    <div class="card">
      <div class="card-header card-header-success">
        <h4 class="card-title">INPUT JUMLAH CLUSTER</h4>
      </div>

      <form action="" method="post">
        <div class="container">
          </br>
          <div class="form-group">
            <label class="text-success">Jumlah Cluster</label>
            <input type="number" min="2" max="5" step="1" name="jumlah" class="form-control" placeholder="Masukkan Jumlah Cluster" value="" required>
          </div>
          <div class="form-group">
            <input type="submit" name="kirim" class="btn btn-success" value="Kirim">
          </div>
        </div>
      </form>
      <?php
      include '../inc/koneksidb.php';
      $dd = $_POST;
      $jumlah = 0;
      if (isset($_POST['kirim'])) {
        $jumlah = $dd['jumlah'];
      }
      $query = mysqli_query($host, "SELECT * FROM  (SELECT * FROM data_sd ORDER BY RAND() LIMIT $jumlah) pd ORDER BY pd");
      ?>
      <div class="card-body table-responsive">

        <table class="table table-hover">
          <thead class="text-success">
            <th>Centroid</th>
            <th>Nama Sekolah</th>
            <th>Peserta Didik</th>
            <th>Rombongan Belajar</th>
            <th>Guru</th>
            <th>Pegawai</th>
            <th>Ruang Kelas</th>
            <th>Ruang Lab</th>
            <th>Ruang Perpustakaan</th>
          </thead>
          <?php
          $no = 0;
          while ($d = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $cek = mysqli_query($host, "SELECT * FROM centroid");
            if (mysqli_num_rows($cek) != $jumlah) {
              if ($no == 0) {
                $q = mysqli_query($host, "TRUNCATE TABLE centroid");
              }
              $q = mysqli_query($host, "INSERT INTO centroid(id_sd) VALUES('$d[id_sd]')");
              $no++;
            } else {
            }
          }
          $queryD = mysqli_query($host, "SELECT * FROM centroid tc JOIN data_sd tp ON tp.id_sd=tc.id_sd");
          while ($data = mysqli_fetch_array($queryD, MYSQLI_ASSOC)) {
          ?>
            <tr>
              <td><?php echo $data["id_centroid"]; ?></td>
              <td><?php echo $data["nama"]; ?></td>
              <td><?php echo $data["pd"]; ?></td>
              <td><?php echo $data["rombel"]; ?></td>
              <td><?php echo $data["guru"]; ?></td>
              <td><?php echo $data["pegawai"]; ?></td>
              <td><?php echo $data["kelas"]; ?></td>
              <td><?php echo $data["lab"]; ?></td>
              <td><?php echo $data["perpus"]; ?></td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include "../inc/footer.php" ?>