<?php include "../inc/header.php" ?>
<div class="main-panel">
  <div class="col-lg-max col-md-12">
    <div class="card">
      <div class="card-header card-header-success">
        <h4 class="card-title">TABEL DATA SEKOLAH DASAR</h4>
      </div>
      <?php
      include '../inc/koneksidb.php';
      $query = mysqli_query($host, "SELECT * FROM data_sd");

      $batas = 10;
      $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
      $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
      $previous = $halaman - 1;
      $next = $halaman + 1;
      $jumlah_data = mysqli_num_rows($query);
      $total_halaman = ceil($jumlah_data / $batas);
      $data_sd = mysqli_query($host, "SELECT * FROM data_sd ORDER BY nama limit $halaman_awal, $batas");
      $nomor = $halaman_awal + 1;

      ?>
      <div class="card-body table-responsive">
        <table class="table table-hover">
          <thead class="text">
            <th>No</th>
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
          while ($data = mysqli_fetch_array($data_sd, MYSQLI_ASSOC)) {
            $no++;
          ?>
            <tr>
              <td><?php echo $nomor++ ?></td>
              <td><?php echo $data["nama"]; ?></td>
              <td><?php echo $data["pd"]; ?></td>
              <td><?php echo $data["rombel"]; ?></td>
              <td><?php echo $data["guru"]; ?></td>
              <td><?php echo $data["pegawai"]; ?></td>
              <td><?php echo $data["kelas"]; ?></td>
              <td><?php echo $data["lab"]; ?></td>
              <td><?php echo $data["perpus"]; ?></td>
              <td><Button data-toggle="modal" data-target="#exampleModal<?= $data['id_sd'] ?>" class="btn btn-warning" class="">Edit</Button></a></td>

              <div class="modal fade" id="exampleModal<?= $data['id_sd'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="" method="POST">
                        <div class="box-body">
                          <input type="hidden" name="id_sd" class="form-control" value="<?php echo $data['id_sd']; ?>">
                          <div class="form-group">
                            <label class="text-dark">Nama Sekolah</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo $data['nama']; ?>">
                          </div>
                          <div class="form-group">
                            <label class="text-dark">Peserta Didik</label>
                            <input type="text" name="pd" class="form-control" value="<?php echo $data['pd']; ?>">
                          </div>
                          <div class="form-group">
                            <label class="text-dark">Rombongan Belajar</label>
                            <input type="text" name="rombel" class="form-control" value="<?php echo $data['rombel']; ?>">
                          </div>
                          <div class="form-group">
                            <label class="text-dark">Guru</label>
                            <input type="text" name="guru" class="form-control" value="<?php echo $data['guru']; ?>">
                          </div>
                          <div class="form-group">
                            <label class="text-dark">Pegawai</label>
                            <input type="text" name="pegawai" class="form-control" value="<?php echo $data['pegawai']; ?>">
                          </div>
                          <div class="form-group">
                            <label class="text-dark">Ruang Kelas</label>
                            <input type="text" name="kelas" class="form-control" value="<?php echo $data['kelas']; ?>">
                          </div>
                          <div class="form-group">
                            <label class="text-dark">Ruang Lab</label>
                            <input type="text" name="lab" class="form-control" value="<?php echo $data['lab']; ?>">
                          </div>
                          <div class="form-group">
                            <label class="text-dark">Ruang Perpustakaan</label>
                            <input type="text" name="perpus" class="form-control" value="<?php echo $data['perpus']; ?>">
                          </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                    </div>
                    </form>
                    <?php
                    if (isset($_POST['simpan'])) {
                      $id_sd = $_POST['id_sd'];
                      $nama = $_POST['nama'];
                      $pd = $_POST['pd'];
                      $rombel = $_POST['rombel'];
                      $guru = $_POST['guru'];
                      $pegawai = $_POST['pegawai'];
                      $kelas = $_POST['kelas'];
                      $lab = $_POST['lab'];
                      $perpus = $_POST['perpus'];
                      $simpan = mysqli_query($host, "UPDATE data_sd SET nama='$nama', pd='$pd',rombel='$rombel',guru='$guru',pegawai='$pegawai',
                      kelas='$kelas',lab='$lab',perpus='$perpus' WHERE id_sd='$id_sd'");
                      echo "<script>alert('Data Berhasil Diubah');</script>";
                      echo "<script>location='tabel.php';</script>";
                    } ?>
                  </div>
                </div>
              </div>

            </tr>

          <?php } ?>
        </table>

        <nav>
          <ul class="pagination flex-wrap justify-content-center">
            <li class="page-item">
              <a class="page-link" <?php if ($halaman > 1) {
                                      echo "href='?halaman=$previous'";
                                    } ?>><span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span></a>
            </li>
            <?php
            for ($x = 1; $x <= $total_halaman; $x++) {
            ?>
              <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
            <?php
            }
            ?>
            <li class="page-item">
              <a class="page-link" <?php if ($halaman < $total_halaman) {
                                      echo "href='?halaman=$next'";
                                    } ?>><span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span></a>
            </li>

          </ul>
        </nav>
        <?php
        if (isset($_POST['submit_button'])) {
          mysqli_query($host, 'TRUNCATE TABLE `data_sd`');
          echo "<script>alert('Data Berhasil Dihapus');</script>";
          echo "<script>location='tabel.php';</script>";
        }

        ?>
        <form method="post" action="">
          <button class="btn btn-danger" name="submit_button" type="submit" onclick="return confirm('Apakah Anda Yakin Menghapus Data?')">Hapus Data</button>
        </form>
      </div>


    </div>
  </div>
</div>

<?php include "../inc/footer.php" ?>