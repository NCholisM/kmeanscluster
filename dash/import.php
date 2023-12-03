<?php
include "../inc/koneksidb.php";

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (isset($_POST['import'])) {
	$nama_file_baru = $_POST['namafile'];
	$path = '../tmp/' . $nama_file_baru;

	$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
	$spreadsheet = $reader->load($path);
	$sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

	$numrow = 1;
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
			$query = "INSERT INTO data_sd VALUES('','" . $nama . "','" . $pd . "','" . $rombel . "','" . $guru . "','" . $pegawai . "'
            ,'" . $kelas . "','" . $lab . "','" . $perpus . "')";

			mysqli_query($host, $query);
		}

		$numrow++;
	}

	unlink($path);
}

header('location: tabel.php');
