<?php

include "koneksi.php";


/* AMBIL DATA POLI */

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
    SELECT *
    FROM poli
    WHERE Poli_ID = '$id'
");

$data = mysqli_fetch_assoc($query);


if (!$data) {
    die("Data poli tidak ditemukan.");
}

?>


<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Detail Data Poli</title>

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
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        h1 {
            color: #203f67;
            margin-bottom: 30px;
        }

        .data {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
            color: #203f67;
            margin-bottom: 5px;
        }

        .value {
            font-size: 17px;
        }

        .btn {
            display: inline-block;
            padding: 13px 20px;
            border-radius: 7px;
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-kembali {
            background: #777;
        }

    </style>

</head>


<body>


<div class="container">

    <h1>
        Detail Data Poli
    </h1>


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


    <a
        href="index.php#poli"
        class="btn btn-kembali"
    >
        Kembali
    </a>


</div>


</body>

</html>