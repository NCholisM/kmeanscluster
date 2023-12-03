<?php
include '../inc/koneksidb.php';
error_reporting(0);
$query = mysqli_query($host, "SELECT * FROM data_sd ");
$qu = mysqli_query($host, "SELECT td.*, tc.id_centroid FROM centroid tc JOIN data_sd td ON td.id_sd=tc.id_sd");
?>
<?php
$iterasi = 1;
$bool = true;
$lit = [];
$update_cluster = [];
$cNumber = [];
$hasil = [];
while ($bool) {
?>

        <?php
        if ($iterasi == 1) {
            while ($data = mysqli_fetch_array($qu, MYSQLI_ASSOC)) {
        ?>

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

        <?php }
        } ?>

            <?php
            $id = 1;
            $qa = mysqli_query($host, "SELECT * FROM centroid tc JOIN data_sd td ON td.id_sd=tc.id_sd");
            while ($qd = mysqli_fetch_array($qa, MYSQLI_ASSOC)) {
            ?>
            <?php $id++;
            } ?>
            <?php
            for ($i = 0; $i < $iterasi; $i++) {
            ?>
            <?php } ?>
            <?php
            $no = 1;
            $dataHasil = [];
            $query = mysqli_query($host, "SELECT * FROM data_sd ");
            $arrayCluster = [];
            $status_cluster = [];

            while ($data = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            ?>
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
                    <?php $index++;
                        $hasil = $dataHasil;
                    }

                    ?>
                    <?php
                    $arrayCluster[] = array_search(min($min), $min) + 1;
                    $s = array_search(min($min), $min) + 1;
                    $checkCluster = [];
                    for ($z = 0; $z < count($cNumber); $z++) {
                        $checkCluster[] = $cNumber[$z][$no - 1];
                        $noCluster = $cNumber[$z][$no - 1];
                    ?>
                    <?php }

                    if (count($cNumber) == $iterasi - 1) {
                        $checkCluster[] = $s; ?>
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
<?php
    $hasil = $dataHasil;
    $iterasi++;
}
?>

<?php
$qh = mysqli_query($host, "SELECT * FROM centroid");
$jumlahClusterHasil = mysqli_num_rows($qh);
for ($j = 1; $j <= $jumlahClusterHasil; $j++) {

    $jk = $j;
    $asd .= "'$jk'" . ", ";
?>

            <?php
            $no = 0;
            for ($x = 0; $x < count($hasil); $x++) {
                if ($hasil[$x]['clust'] == $j) {
                    $id_data = $hasil[$x]['id_sd'];
                    $qhasil = mysqli_query($host, "SELECT * FROM data_sd where id_sd='$id_data'");
                    $tampilHasil = mysqli_fetch_array($qhasil);

                    $hcc = $arrayCluster;
                    $hc .= "'$hcc'" . ", ";
                    $no++;
            ?>

            <?php }
            } ?>
<?php } ?>

<?php
// memanggil library FPDF
require('../library/fpdf.php');
include '../inc/koneksidb.php';
include 'centroid.php';

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(200, 10, 'DATA KARYAWAN', 0, 0, 'C');

$pdf->Cell(10, 15, '', 0, 1);
$pdf->SetFont('Times', 'B', 9);
$pdf->Cell(10, 7, 'NO', 1, 0, 'C');
$pdf->Cell(100, 7, 'NAMA', 1, 0, 'C');
$pdf->Cell(75, 7, 'ALAMAT', 1, 0, 'C');
$pdf->Cell(55, 7, 'EMAIL', 1, 0, 'C');


$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Times', '', 10);
$no = 1;
$data = mysqli_query($host, "SELECT  * FROM data_sd");
while ($d = mysqli_fetch_array($data)) {
    $pdf->Cell(10, 6, $no++, 1, 0, 'C');
    $pdf->Cell(100, 6, $d['nama'], 1, 0);
    $pdf->Cell(75, 6, $d['pd'], 1, 0);
    $pdf->Cell(55, 6, $d['rombel'], 1, 1);
}

$pdf->Output();

?>