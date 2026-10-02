<?php

include "koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
    DELETE FROM poli
    WHERE Poli_ID = '$id'
");

if ($query) {

    header("Location: index.php#poli");
    exit;

} else {

    echo "Gagal menghapus data: " . mysqli_error($koneksi);

}

?>