<?php

include "koneksi.php";

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
    SELECT
        dokter.Dokter_ID,
        dokter.Nama_Dokter,
        dokter.Poli_ID,
        poli.Nama_Poli
    FROM dokter
    JOIN poli
        ON dokter.Poli_ID = poli.Poli_ID
    WHERE dokter.Dokter_ID = '$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data dokter tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Detail Data Dokter</title>

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
        Detail Data Dokter
    </h1>


    <div class="data">

        <div class="label">
            Dokter ID
        </div>

        <div class="value">
            <?= $data['Dokter_ID']; ?>
        </div>

    </div>


    <div class="data">

        <div class="label">
            Nama Dokter
        </div>

        <div class="value">
            <?= $data['Nama_Dokter']; ?>
        </div>

    </div>


    <div class="data">

        <div class="label">
            Poli ID
        </div>

        <div class="value">
            <?= $data['Poli_ID']; ?>
        </div>

    </div>


    <div class="data">

        <div class="label">
            Nama Poli
        </div>

        <div class="value">
            <?= $data['Nama_Poli']; ?>
        </div>

    </div>


    <a href="index.php#dokter" class="btn">
        Kembali
    </a>

</div>

</body>

</html>