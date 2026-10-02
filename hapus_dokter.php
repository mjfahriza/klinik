<?php

include "koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
    DELETE FROM dokter
    WHERE Dokter_ID = '$id'
");

if ($query) {

    header("Location: index.php#dokter");
    exit;

} else {

    echo "Gagal menghapus data dokter: " . mysqli_error($koneksi);

}

?>