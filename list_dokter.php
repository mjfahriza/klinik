<?php

include "koneksi.php";

$query_dokter = mysqli_query($koneksi, "
    SELECT
        dokter.Dokter_ID,
        dokter.Nama_Dokter,
        poli.Nama_Poli
    FROM dokter
    JOIN poli
        ON dokter.Poli_ID = poli.Poli_ID
    ORDER BY dokter.Dokter_ID
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>List Dokter</title>

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
        List Dokter
    </h1>

    <a href="index.php" class="btn-kembali">
        ← Kembali
    </a>

    <table>

        <thead>

            <tr>
                <th>Dokter ID</th>
                <th>Nama Dokter</th>
                <th>Poli</th>
            </tr>

        </thead>

        <tbody>

            <?php while ($dokter = mysqli_fetch_assoc($query_dokter)) { ?>

                <tr>

                    <td>
                        <?= $dokter['Dokter_ID']; ?>
                    </td>

                    <td>
                        <?= $dokter['Nama_Dokter']; ?>
                    </td>

                    <td>
                        <?= $dokter['Nama_Poli']; ?>
                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>

</body>

</html>