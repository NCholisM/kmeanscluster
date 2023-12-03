<?php include "../inc/header.php" ?>
<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
?>
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
                <h4 class="card-title">UPLOAD FILE DATA SEKOLAH DASAR</h4>
            </div>
            <div style="padding: 10px 20px;">
                <h3 style="margin-top: 5px;">Form Import Data</h3>
                <hr style="margin-top: 5px;margin-bottom: 15px;">

                <form method="post" action="upload.php" enctype="multipart/form-data">

                    <div class="clearfix">
                        <div class="float-left" style="margin-right: 5px;">
                            <input type="file" name="file" class="form-control">
                        </div>
                        <button type="submit" name="preview" class="btn btn-success">PREVIEW</button>
                    </div>
                </form>
                <hr>

                <?php
                if (isset($_POST['preview'])) {
                    $tgl_sekarang = date('YmdHis');
                    $nama_file_baru = 'data' . $tgl_sekarang . '.xlsx';

                    if (is_file('../tmp/' . $nama_file_baru))
                        unlink('../tmp/' . $nama_file_baru);

                    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $tmp_file = $_FILES['file']['tmp_name'];

                    if ($ext == "xlsx") {
                        move_uploaded_file($tmp_file, '../tmp/' . $nama_file_baru);

                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        $spreadsheet = $reader->load('../tmp/' . $nama_file_baru);
                        $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                        echo "<form method='post' action='import.php'>";

                        echo "<input type='hidden' name='namafile' value='" . $nama_file_baru . "'>";

                        echo "<h3 class='float-left'>File Excel Siap Di Import</h3><button type='submit' name='import' class='btn btn-success float-right'>IMPORT</button>";

                        echo "<div class='table-responsive'>
                    <table class='table table-bordered table-wrapper-scroll-y my-custom-scrollbar'>
                        <tr>
                            <th colspan='8' class='text-left'>Preview Data</th>
                        </tr>
                        <tr>
                            <th>Nama Sekolah</th>
                            <th>Peserta Didik</th>
                            <th>Rombongan Belajar</th>
                            <th>Guru</th>
                            <th>Pegawai</th>
                            <th>Ruang Kelas</th>
                            <th>Ruang Lab</th>
                            <th>Ruang Perpustakaan</th>
                        </tr>";

                        $numrow = 1;
                        $kosong = 0;
                        foreach ($sheet as $row) {
                            $nama = $row['A'];
                            $pd = $row['B'];
                            $rombel = $row['C'];
                            $guru = $row['D'];
                            $pegawai = $row['E'];
                            $kelas = $row['F'];
                            $lab = $row['G'];
                            $perpus = $row['H'];

                            if (
                                $nama == "" && $pd == "" && $rombel == "" && $guru == "" && $pegawai == "" && $kelas == ""
                                && $lab == "" && $perpus == ""
                            )
                                continue;

                            if ($numrow > 1) {
                                $nama_td = (!empty($nama)) ? "" : "";
                                $pd_td = (!empty($pd)) ? "" : "";
                                $rombel_td = (!empty($rombel)) ? "" : "";
                                $guru_td = (!empty($guru)) ? "" : "";
                                $pegawai_td = (!empty($pegawai)) ? "" : "";
                                $kelas_td = (!empty($kelas)) ? "" : "";
                                $lab_td = (!empty($lab)) ? "" : "";
                                $perpus_td = (!empty($perpus)) ? "" : "";

                                if (
                                    $nama == "" && $pd == "" && $rombel == "" && $guru == "" && $pegawai == "" && $kelas == ""
                                    && $lab == "" && $perpus == ""
                                ) {
                                    $kosong++;
                                }

                                echo "<tr>";
                                echo "<td" . $nama_td . ">" . $nama . "</td>";
                                echo "<td" . $pd_td . ">" . $pd . "</td>";
                                echo "<td" . $rombel_td . ">" . $rombel . "</td>";
                                echo "<td" . $guru_td . ">" . $guru . "</td>";
                                echo "<td" . $pegawai_td . ">" . $pegawai . "</td>";
                                echo "<td" . $kelas_td . ">" . $kelas . "</td>";
                                echo "<td" . $lab_td . ">" . $lab . "</td>";
                                echo "<td" . $perpus_td . ">" . $perpus . "</td>";
                                echo "</tr>";
                            }

                            $numrow++;
                        }

                        echo "</table></div>";

                        if ($kosong > 0) {
                ?>
                            <script>
                                $(document).ready(function() {
                                    $("#jumlah_kosong").html('<?php echo $kosong; ?>');

                                    $("#kosong").show();
                                });
                            </script>
                <?php
                        } 
                        echo "</form>";
                    } else {
                        echo "<div class='alert alert-danger'>
					FILE BELUM DIMASUKKAN
                </div>";
                    }
                }
                ?>
            </div>
         

        </div>
    </div>
</div>
<?php include "../inc/footer.php" ?>