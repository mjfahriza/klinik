<?php

include "koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
    DELETE FROM pasien
    WHERE Pasien_ID = '$id'
");

if ($query) {

    header("Location: index.php#pasien");
    exit;

} else {

    echo "Gagal menghapus data pasien: " . mysqli_error($koneksi);

}

?>