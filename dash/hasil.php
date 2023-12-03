<?php include "../inc/header.php" ?>
<?php include "centroid.php" ?>
<style>
  .my-custom-scrollbar {
    position: relative;
    height: 550px;
    overflow: auto;
  }

  .table-wrapper-scroll-y {
    display: block;
  }
</style>
<div class="main-panel">
  <div class="col-lg-max col-md-12">
    <div class="card">
      <div class="card-header card-header-success">
        <h4 class="card-title">HASIL CLUSTERING</h4>
      </div>
      <?php
      include '../inc/koneksidb.php';
      error_reporting(0);
      $query = mysqli_query($host, "SELECT * FROM data_sd ");
      $qu = mysqli_query($host, "SELECT td.*, tc.id_centroid FROM centroid tc JOIN data_sd td ON td.id_sd=tc.id_sd");
      ?>
      <div class="card-body table-responsive">

        <div class="tab-content">
          <?php
          $iterasi = 1;
          $bool = true;
          $lit = [];
          $update_cluster = [];
          $cNumber = [];
          $hasil = [];
          while ($bool) {
          ?>
            <div class="tab-pane fade show <?= ($iterasi == 1 ? 'active' : '') ?>" id="tab<?= $iterasi ?>" role="tabpanel" aria-labelledby="home-tab">
              <h3>Iterasi <?= $iterasi ?></h3>
              <table class="table table-striped">
                <thead class="text-success">
                  <th>ID Data</th>
                  <th>Peserta Didik</th>
                  <th>Rombongan Belajar</th>
                  <th>Guru</th>
                  <th>Pegawai</th>
                  <th>Ruang Kelas</th>
                  <th>Ruang Lab</th>
                  <th>Ruang Perpustakaan</th>
                </thead>
                <tbody>
                  <?php
                  if ($iterasi == 1) {
                    while ($data = mysqli_fetch_array($qu, MYSQLI_ASSOC)) {
                  ?>
                      <tr>
                        <td><?php echo $data["id_sd"]; ?></td>
                        <td><?php echo $data["pd"]; ?></td>
                        <td><?php echo $data["rombel"]; ?></td>
                        <td><?php echo $data["guru"]; ?></td>
                        <td><?php echo $data["pegawai"]; ?></td>
                        <td><?php echo $data["kelas"]; ?></td>
                        <td><?php echo $data["lab"]; ?></td>
                        <td><?php echo $data["perpus"]; ?></td>

                      </tr>
                    <?php }
                  } else {
                    usort($update_cluster, function ($a, $b) {
                      return $a['clust'] <=> $b['clust'];
                    });

                    $qa = mysqli_query($host, "SELECT * FROM centroid tc JOIN data_sd td ON td.id_sd=tc.id_sd");
                    $cc = [];

                    while ($dupdate = mysqli_fetch_array($qa, MYSQLI_ASSOC)) {
                      $rd = search($update_cluster, 'clust', $dupdate['id_centroid']);
                      $clusterID = [];

                      for ($i = 0; $i < count($rd); $i++) {
                        if ($rd[$i]['iterasi'] == $iterasi - 1) {
                          $clusterID[] = $rd[$i]['id_sd'];
                        }
                      }
                      $res = queryFromArray($clusterID);
                      $cc[] = $res;
                    ?>
                      <tr>
                        <td><?php echo $dupdate["id_sd"]; ?></td>
                        <td><?php echo $res["pd"]; ?></td>
                        <td><?php echo $res["rombel"]; ?></td>
                        <td><?php echo $res["guru"]; ?></td>
                        <td><?php echo $res["pegawai"]; ?></td>
                        <td><?php echo $res["kelas"]; ?></td>
                        <td><?php echo $res["lab"]; ?></td>
                        <td><?php echo $res["perpus"]; ?></td>

                      </tr>
                  <?php }
                  } ?>
                </tbody>
              </table>
              <table class="table table-hover table-wrapper-scroll-y my-custom-scrollbar">
                <thead class="text-success">
                  <th>No</th>
                  <?php
                  $id = 1;
                  $qa = mysqli_query($host, "SELECT * FROM centroid tc JOIN data_sd td ON td.id_sd=tc.id_sd");
                  while ($qd = mysqli_fetch_array($qa, MYSQLI_ASSOC)) {
                  ?>
                    <th>C<?= $id ?></th>
                  <?php $id++;
                  } ?>
                  <th>MIN</th>
                  <?php
                  for ($i = 0; $i < $iterasi; $i++) {
                  ?>
                    <th>Hasil Iterasi <?= $i + 1 ?></th>
                  <?php } ?>
                  <th>Status</th>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $dataHasil = [];
                  $query = mysqli_query($host, "SELECT * FROM data_sd ");
                  $arrayCluster = [];
                  $status_cluster = [];

                  while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                  ?>
                    <tr>
                      <td><?php echo $no ?></td>
                      <?php
                      $qq = mysqli_query($host, "SELECT * FROM centroid");
                      $min = []; //
                      $index = 0;
                      $noCluster = 0;
                      while ($qr = mysqli_fetch_array($qq, MYSQLI_ASSOC)) {
                        $d = mysqli_query($host, "SELECT td.* FROM centroid tc JOIN data_sd td ON tc.id_sd=td.id_sd where td.id_sd='$qr[id_sd]'");
                        if ($iterasi == 1) {
                          $dd = mysqli_fetch_array($d, MYSQLI_ASSOC);
                          $penghitungan = sqrt(pow(($data['pd'] - $dd['pd']), 2) + pow(($data['rombel'] - $dd['rombel']), 2) + pow(($data['guru'] - $dd['guru']), 2) + pow(($data['pegawai'] - $dd['pegawai']), 2) + pow(($data['kelas'] - $dd['kelas']), 2) + pow(($data['lab'] - $dd['lab']), 2) + pow(($data['perpus'] - $dd['perpus']), 2));
                        } else {
                          $dd = $cc[$index];
                          $penghitungan = sqrt(pow(($data['pd'] - $dd['pd']), 2) + pow(($data['rombel'] - $dd['rombel']), 2) + pow(($data['guru'] - $dd['guru']), 2) + pow(($data['pegawai'] - $dd['pegawai']), 2) + pow(($data['kelas'] - $dd['kelas']), 2) + pow(($data['lab'] - $dd['lab']), 2) + pow(($data['perpus'] - $dd['perpus']), 2));
                        }
                        $min[] = nilai($penghitungan);


                      ?>
                        <td><?php echo nilai($penghitungan) ?></td>
                      <?php $index++;
                        $hasil = $dataHasil;
                      }

                      ?>
                      <td><?= min($min); ?></td>
                      <?php
                      $arrayCluster[] = array_search(min($min), $min) + 1;
                      $s = array_search(min($min), $min) + 1;
                      $checkCluster = [];
                      for ($z = 0; $z < count($cNumber); $z++) {
                        $checkCluster[] = $cNumber[$z][$no - 1];
                        $noCluster = $cNumber[$z][$no - 1];
                      ?>
                        <td><?= $cNumber[$z][$no - 1] ?></td>
                      <?php }

                      if (count($cNumber) == $iterasi - 1) {
                        $checkCluster[] = $s; ?>
                        <td><?= $s ?></td>
                      <?php }
                      $array2 = checkSameValue($checkCluster) ? "1" : "0";
                      if ($array2 == '1') {
                        echo "<td>Selesai</td>";
                        $status_cluster[] = 1;
                      } else {
                        $status_cluster[] = 0;
                        echo "<td>Belum Selesai</td>";
                      }
                      ?>
                    </tr>
                  <?php
                    $dataHasil[] = ['clust' => $cNumber[count($cNumber) - 1][$no - 1], 'id_sd' => $data["id_sd"]];
                    $update_cluster[] = ['id_sd' => $data['id_sd'], 'min' => min($min), 'clust' => array_search(min($min), $min) + 1, 'iterasi' => $iterasi];
                    $no++;
                  };
                  $cNumber[] = $arrayCluster;
                  if ($iterasi != 1) {
                    if (in_array("0", $status_cluster)) {
                      $bool = true;
                    } else {
                      $bool = false;
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          <?php
            $hasil = $dataHasil;
            $iterasi++;
          }
          ?>
          <div class="tab-pane fade show " id="hasil" role="tabpanel" aria-labelledby="home-tab">

            <?php
            $qh = mysqli_query($host, "SELECT * FROM centroid");
            $jumlahClusterHasil = mysqli_num_rows($qh);
            for ($j = 1; $j <= $jumlahClusterHasil; $j++) {
            ?>
              <h3>Kelompok <?= $j ?></h3>
              <table class="table table-striped table-wrapper-scroll-y my-custom-scrollbar">
                <thead class="text-success">
                  <th >No</th>
                  <th >ID Data</th>
                  <th >Nama Sekolah</th>
                  <th >Peserta Didik</th>
                  <th >Rombongan Belajar</th>
                  <th >Guru</th>
                  <th >Pegawai</th>
                  <th >Ruang Kelas</th>
                  <th >Ruang Lab</th>
                  <th >Ruang Perpustakaan</th>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  for ($x = 0; $x < count($hasil); $x++) {
                    if ($hasil[$x]['clust'] == $j) {
                      $id_data = $hasil[$x]['id_sd'];
                      $qhasil = mysqli_query($host, "SELECT * FROM data_sd where id_sd='$id_data'");
                      $tampilHasil = mysqli_fetch_array($qhasil);
                      $no++;
                  ?>
                      <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $tampilHasil["id_sd"]; ?></td>
                        <td><?php echo $tampilHasil["nama"]; ?></td>
                        <td><?php echo $tampilHasil["pd"]; ?></td>
                        <td><?php echo $tampilHasil["rombel"]; ?></td>
                        <td><?php echo $tampilHasil["guru"]; ?></td>
                        <td><?php echo $tampilHasil["pegawai"]; ?></td>
                        <td><?php echo $tampilHasil["kelas"]; ?></td>
                        <td><?php echo $tampilHasil["lab"]; ?></td>
                        <td><?php echo $tampilHasil["perpus"]; ?></td>

                      </tr>
                  <?php }
                  } ?>
                </tbody>
              </table>

            <?php } ?>
          </div>
          <br><br>
          <div class="nav-tabs-navigation" style="position:fixed!important;bottom:0!important;">
            <div class="nav-tabs-wrapper">
              <span class="nav-tabs-title">Halaman:</span>
              <ul class="nav nav-tabs" data-tabs="tabs">
                <?php
                $bool1 = true;
                $iterasi1 = 1;
                for ($i = 1; $i < $iterasi; $i++) {
                ?>
                  <li class="nav-item" style="background:#4CAF50">
                    <a class="nav-link <?= ($i == 0 ? 'active' : '') ?>" href="#tab<?= $i ?>" data-toggle="tab">
                      Iterasi <?= $i ?>
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                <?php } ?>
                <li class="nav-item" style="background:#4CAF50">
                  <a class="nav-link" href="#hasil" data-toggle="tab">
                    Hasil
                    <div class="ripple-container"></div>
                  </a>
                </li>

              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<?php include "../inc/footer.php" ?>