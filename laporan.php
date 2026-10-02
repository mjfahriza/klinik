<?php

include "koneksi.php";

$tanggal_awal = "";
$tanggal_akhir = "";

$query_laporan = null;

if (isset($_POST['tampilkan'])) {

    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $query_laporan = mysqli_query($koneksi, "
        SELECT
            berobat.No_Transaksi,
            berobat.Tanggal_Berobat,
            pasien.Nama_Pasien,
            dokter.Nama_Dokter,
            poli.Nama_Poli,
            berobat.Keluhan,
            berobat.Biaya_Adm
        FROM berobat

        JOIN pasien
            ON berobat.Pasien_ID = pasien.Pasien_ID

        JOIN dokter
            ON berobat.Dokter_ID = dokter.Dokter_ID

        JOIN poli
            ON dokter.Poli_ID = poli.Poli_ID

        WHERE berobat.Tanggal_Berobat
        BETWEEN '$tanggal_awal' AND '$tanggal_akhir'

        ORDER BY berobat.Tanggal_Berobat ASC
    ");
}

?>


<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Data Berobat</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6fa;
            padding: 40px;
        }

        .container {
            max-width: 1100px;
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

        .filter {
            display: flex;
            gap: 20px;
            align-items: end;
            margin-bottom: 30px;
        }

        .form-group {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #203f67;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            box-sizing: border-box;
        }

        button,
        .btn-kembali {
            padding: 12px 20px;
            border: none;
            border-radius: 7px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 15px;
        }

        button {
            background: #203f67;
        }

        .btn-kembali {
            background: #777;
            display: inline-block;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #203f67;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
            color: #203f67;
        }

    </style>

</head>


<body>


<div class="container">

    <h1>
        Laporan Data Berobat
    </h1>


    <form method="POST">

        <div class="filter">

            <div class="form-group">

                <label>
                    Tanggal Awal
                </label>

                <input
                    type="date"
                    name="tanggal_awal"
                    value="<?= $tanggal_awal; ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Tanggal Akhir
                </label>

                <input
                    type="date"
                    name="tanggal_akhir"
                    value="<?= $tanggal_akhir; ?>"
                    required
                >

            </div>


            <button
                type="submit"
                name="tampilkan"
            >
                Tampilkan
            </button>

        </div>

    </form>


    <?php if ($query_laporan) { ?>


        <table>

            <thead>

                <tr>

                    <th>No</th>
                    <th>No Transaksi</th>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>Dokter</th>
                    <th>Poli</th>
                    <th>Keluhan</th>
                    <th>Biaya</th>

                </tr>

            </thead>


            <tbody>

                <?php

                $no = 1;
                $total_biaya = 0;

                while ($data = mysqli_fetch_assoc($query_laporan)) {

                    $total_biaya += $data['Biaya_Adm'];

                ?>

                    <tr>

                        <td>
                            <?= $no++; ?>
                        </td>

                        <td>
                            <?= $data['No_Transaksi']; ?>
                        </td>

                        <td>
                            <?= $data['Tanggal_Berobat']; ?>
                        </td>

                        <td>
                            <?= $data['Nama_Pasien']; ?>
                        </td>

                        <td>
                            <?= $data['Nama_Dokter']; ?>
                        </td>

                        <td>
                            <?= $data['Nama_Poli']; ?>
                        </td>

                        <td>
                            <?= $data['Keluhan']; ?>
                        </td>

                        <td>
                            Rp <?= number_format($data['Biaya_Adm'], 0, ',', '.'); ?>
                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>


        <div class="total">

            Total Biaya:
            Rp <?= number_format($total_biaya, 0, ',', '.'); ?>

        </div>


    <?php } ?>


    <a
        href="index.php"
        class="btn-kembali"
    >
        Kembali ke Dashboard
    </a>


</div>


</body>

</html>