<?php
include "../inc/koneksidb.php";
function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}
function queryFromArray($array = [])
{
    global $host;
    $where = "";
    if (count($array) > 0) {
        $where = " WHERE ";
        for ($i = 0; $i < count($array); $i++) {
            $where .= " td.id_sd= $array[$i] ";
            if ($i < count($array) - 1) {
                $where .= " || ";
            }
        }
    }
    $q = "SELECT AVG(pd) pd, AVG(rombel) rombel, AVG(guru) guru, AVG(pegawai) pegawai , AVG(kelas) kelas, AVG(lab) lab, AVG(perpus) perpus 
    FROM data_sd td  $where";
    $query = mysqli_query($host, $q);
    $d = mysqli_fetch_array($query, MYSQLI_ASSOC);
    return $d;
}
function checkSameValue($array)
{
    if (count($array) > 1) {
        if ($array[count($array) - 1] == $array[count($array) - 2]) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function nilai($string)
{
    $output = number_format($string, 2, '.', '');
    return $output;
}
