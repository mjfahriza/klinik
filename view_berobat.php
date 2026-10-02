<?php

include "koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
    SELECT
        berobat.*,
        pasien.Nama_Pasien,
        pasien.Tanggal_Lahir,
        pasien.Jenis_Kelamin,
        pasien.Alamat,
        dokter.Nama_Dokter,
        poli.Nama_Poli
    FROM berobat
    JOIN pasien
        ON berobat.Pasien_ID = pasien.Pasien_ID
    JOIN dokter
        ON berobat.Dokter_ID = dokter.Dokter_ID
    JOIN poli
        ON dokter.Poli_ID = poli.Poli_ID
    WHERE berobat.No_Transaksi = '$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Detail Data Berobat</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6fa;
            padding: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        h1 {
            color: #203f67;
            margin-bottom: 30px;
        }

        .data {
            margin-bottom: 18px;
        }

        .label {
            font-weight: bold;
            color: #203f67;
            margin-bottom: 5px;
        }

        .value {
            color: #333;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 13px 20px;
            background: #203f67;
            color: white;
            text-decoration: none;
            border-radius: 7px;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>
        Detail Data Berobat
    </h1>


    <div class="data">
        <div class="label">No Transaksi</div>
        <div class="value">
            <?= $data['No_Transaksi']; ?>
        </div>
    </div>


    <div class="data">
        <div class="label">Pasien ID</div>
        <div class="value">
            <?= $data['Pasien_ID']; ?>
        </div>
    </div>


    <div class="data">
        <div class="label">Nama Pasien</div>
        <div class="value">
            <?= $data['Nama_Pasien']; ?>
        </div>
    </div>


    <div class="data">
        <div class="label">Tanggal Berobat</div>
        <div class="value">
            <?= $data['Tanggal_Berobat']; ?>
        </div>
    </div>


    <div class="data">
        <div class="label">Jenis Kelamin</div>
        <div class="value">
            <?= $data['Jenis_Kelamin']; ?>
        </div>
    </div>


    <div class="data">
        <div class="label">Poli</div>
        <div class="value">
            <?= $data['Nama_Poli']; ?>
        </div>
    </div>


    <div class="data">
        <div class="label">Dokter</div>
        <div class="value">
            <?= $data['Nama_Dokter']; ?>
        </div>
    </div>


    <div class="data">
        <div class="label">Keluhan</div>
        <div class="value">
            <?= $data['Keluhan']; ?>
        </div>
    </div>


    <div class="data">
        <div class="label">Biaya Administrasi</div>
        <div class="value">
            Rp <?= number_format($data['Biaya_Adm'], 0, ',', '.'); ?>
        </div>
    </div>


    <a href="index.php" class="btn">
        Kembali
    </a>

</div>

</body>

</html>