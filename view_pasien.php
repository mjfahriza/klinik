<?php

include "koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
    SELECT *
    FROM pasien
    WHERE Pasien_ID = '$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data pasien tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Detail Data Pasien</title>

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
        Detail Data Pasien
    </h1>


    <div class="data">

        <div class="label">
            Pasien ID
        </div>

        <div class="value">
            <?= $data['Pasien_ID']; ?>
        </div>

    </div>


    <div class="data">

        <div class="label">
            Nama Pasien
        </div>

        <div class="value">
            <?= $data['Nama_Pasien']; ?>
        </div>

    </div>


    <div class="data">

        <div class="label">
            Tanggal Lahir
        </div>

        <div class="value">
            <?= $data['Tanggal_Lahir']; ?>
        </div>

    </div>


    <div class="data">

        <div class="label">
            Jenis Kelamin
        </div>

        <div class="value">
            <?= $data['Jenis_Kelamin']; ?>
        </div>

    </div>


    <div class="data">

        <div class="label">
            Alamat
        </div>

        <div class="value">
            <?= $data['Alamat']; ?>
        </div>

    </div>


    <a href="index.php#pasien" class="btn">
        Kembali
    </a>

</div>

</body>

</html>