<?php

include "koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
    DELETE FROM berobat
    WHERE No_Transaksi = '$id'
");

if ($query) {

    header("Location: index.php");
    exit;

} else {

    echo "Gagal menghapus data: " . mysqli_error($koneksi);

}

?>