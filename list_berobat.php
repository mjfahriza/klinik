<?php

include "koneksi.php";

$query_berobat = mysqli_query($koneksi, "
    SELECT
        berobat.No_Transaksi,
        berobat.Tanggal_Berobat,
        pasien.Nama_Pasien,
        pasien.Jenis_Kelamin,
        berobat.Keluhan,
        poli.Nama_Poli,
        dokter.Nama_Dokter,
        berobat.Biaya_Adm
    FROM berobat
    JOIN pasien
        ON berobat.Pasien_ID = pasien.Pasien_ID
    JOIN dokter
        ON berobat.Dokter_ID = dokter.Dokter_ID
    JOIN poli
        ON dokter.Poli_ID = poli.Poli_ID
    ORDER BY berobat.No_Transaksi
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>List Data Berobat</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6fa;
            color: #1f3f67;
            padding: 40px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
            overflow-x: auto;
        }

        h1 {
            margin-bottom: 25px;
        }

        .btn-kembali {
            display: inline-block;
            background: #203f67;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 7px;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th,
        td {
            padding: 13px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #203f67;
            color: white;
        }

        tr:nth-child(even) {
            background: #f7f7f7;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>
        List Data Berobat
    </h1>

    <a href="index.php" class="btn-kembali">
        ← Kembali
    </a>

    <table>

        <thead>

            <tr>
                <th>No Transaksi</th>
                <th>Tanggal Berobat</th>
                <th>Nama Pasien</th>
                <th>Jenis Kelamin</th>
                <th>Keluhan</th>
                <th>Poli</th>
                <th>Dokter</th>
                <th>Biaya Administrasi</th>
            </tr>

        </thead>

        <tbody>

            <?php while ($berobat = mysqli_fetch_assoc($query_berobat)) { ?>

                <tr>

                    <td>
                        <?= $berobat['No_Transaksi']; ?>
                    </td>

                    <td>
                        <?= $berobat['Tanggal_Berobat']; ?>
                    </td>

                    <td>
                        <?= $berobat['Nama_Pasien']; ?>
                    </td>

                    <td>
                        <?= $berobat['Jenis_Kelamin']; ?>
                    </td>

                    <td>
                        <?= $berobat['Keluhan']; ?>
                    </td>

                    <td>
                        <?= $berobat['Nama_Poli']; ?>
                    </td>

                    <td>
                        <?= $berobat['Nama_Dokter']; ?>
                    </td>

                    <td>
                        Rp <?= number_format($berobat['Biaya_Adm'], 0, ',', '.'); ?>
                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

</body>

</html>