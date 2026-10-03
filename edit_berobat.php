<?php

include "koneksi.php";


/* =========================================================
   AMBIL DATA BEROBAT
   ========================================================= */

$No_Transaksi = $_GET['id'];

$query_data = mysqli_query($koneksi, "
    SELECT *
    FROM berobat
    WHERE No_Transaksi = '$No_Transaksi'
");

$data = mysqli_fetch_assoc($query_data);

if (!$data) {
    die("Data berobat tidak ditemukan.");
}


/* =========================================================
   PECAH TANGGAL
   ========================================================= */

$tanggal_lama = $data['Tanggal_Berobat'];

$Tanggal = date('d', strtotime($tanggal_lama));
$Bulan = date('m', strtotime($tanggal_lama));
$Tahun = date('Y', strtotime($tanggal_lama));


/* =========================================================
   DATA PASIEN
   ========================================================= */

$pasien_form = mysqli_query($koneksi, "
    SELECT *
    FROM pasien
    ORDER BY Pasien_ID
");


/* =========================================================
   DATA DOKTER
   ========================================================= */

$dokter_form = mysqli_query($koneksi, "
    SELECT *
    FROM dokter
    ORDER BY Nama_Dokter
");


/* =========================================================
   PROSES UPDATE
   ========================================================= */

if (isset($_POST['update_berobat'])) {

    $Pasien_ID = $_POST['Pasien_ID'];

    $Tanggal = $_POST['Tanggal'];
    $Bulan = $_POST['Bulan'];
    $Tahun = $_POST['Tahun'];

    $Tanggal_Berobat = $Tahun . '-' . $Bulan . '-' . $Tanggal;

    $Dokter_ID = $_POST['Dokter_ID'];
    $Keluhan = $_POST['Keluhan'];
    $Biaya_Adm = $_POST['Biaya_Adm'];


    $query_update = mysqli_query($koneksi, "
        UPDATE berobat
        SET
            Pasien_ID = '$Pasien_ID',
            Tanggal_Berobat = '$Tanggal_Berobat',
            Dokter_ID = '$Dokter_ID',
            Keluhan = '$Keluhan',
            Biaya_Adm = '$Biaya_Adm'
        WHERE No_Transaksi = '$No_Transaksi'
    ");


    if ($query_update) {

        header("Location: index.php#berobat");
        exit;

    } else {

        echo "Gagal mengubah data: " . mysqli_error($koneksi);

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Data Berobat</title>


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
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        h1 {
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 15px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn-simpan {
            background: #203f67;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-kembali {
            display: inline-block;
            background: #777;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 7px;
            margin-left: 8px;
        }

    </style>

</head>

<body>


<div class="container">

    <h1>
        Edit Data Berobat
    </h1>


    <form method="POST">


        <div class="form-group">

            <label>
                No Transaksi
            </label>

            <input
                type="text"
                value="<?= $data['No_Transaksi']; ?>"
                readonly
            >

        </div>


        <div class="form-group">

            <label>
                Pasien
            </label>

            <select name="Pasien_ID" required>

                <?php while ($pasien = mysqli_fetch_assoc($pasien_form)) { ?>

                    <option
                        value="<?= $pasien['Pasien_ID']; ?>"
                        <?= ($pasien['Pasien_ID'] == $data['Pasien_ID']) ? 'selected' : ''; ?>
                    >

                        <?= $pasien['Pasien_ID']; ?>
                        -
                        <?= $pasien['Nama_Pasien']; ?>

                    </option>

                <?php } ?>

            </select>

        </div>


        <div class="form-group">

            <label>
                Tanggal
            </label>

            <select name="Tanggal" required>

                <?php for ($i = 1; $i <= 31; $i++) { ?>

                    <option
                        value="<?= str_pad($i, 2, '0', STR_PAD_LEFT); ?>"
                        <?= ($Tanggal == str_pad($i, 2, '0', STR_PAD_LEFT)) ? 'selected' : ''; ?>
                    >

                        <?= $i; ?>

                    </option>

                <?php } ?>

            </select>

        </div>


        <div class="form-group">

            <label>
                Bulan
            </label>

            <select name="Bulan" required>

                <option value="01" <?= ($Bulan == '01') ? 'selected' : ''; ?>>
                    Januari
                </option>

                <option value="02" <?= ($Bulan == '02') ? 'selected' : ''; ?>>
                    Februari
                </option>

                <option value="03" <?= ($Bulan == '03') ? 'selected' : ''; ?>>
                    Maret
                </option>

                <option value="04" <?= ($Bulan == '04') ? 'selected' : ''; ?>>
                    April
                </option>

                <option value="05" <?= ($Bulan == '05') ? 'selected' : ''; ?>>
                    Mei
                </option>

                <option value="06" <?= ($Bulan == '06') ? 'selected' : ''; ?>>
                    Juni
                </option>

                <option value="07" <?= ($Bulan == '07') ? 'selected' : ''; ?>>
                    Juli
                </option>

                <option value="08" <?= ($Bulan == '08') ? 'selected' : ''; ?>>
                    Agustus
                </option>

                <option value="09" <?= ($Bulan == '09') ? 'selected' : ''; ?>>
                    September
                </option>

                <option value="10" <?= ($Bulan == '10') ? 'selected' : ''; ?>>
                    Oktober
                </option>

                <option value="11" <?= ($Bulan == '11') ? 'selected' : ''; ?>>
                    November
                </option>

                <option value="12" <?= ($Bulan == '12') ? 'selected' : ''; ?>>
                    Desember
                </option>

            </select>

        </div>


        <div class="form-group">

            <label>
                Tahun
            </label>

            <input
                type="number"
                name="Tahun"
                value="<?= $Tahun; ?>"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Dokter
            </label>

            <select name="Dokter_ID" required>

                <?php while ($dokter = mysqli_fetch_assoc($dokter_form)) { ?>

                    <option
                        value="<?= $dokter['Dokter_ID']; ?>"
                        <?= ($dokter['Dokter_ID'] == $data['Dokter_ID']) ? 'selected' : ''; ?>
                    >

                        <?= $dokter['Nama_Dokter']; ?>

                    </option>

                <?php } ?>

            </select>

        </div>


        <div class="form-group">

            <label>
                Keluhan
            </label>

            <textarea
                name="Keluhan"
                required
            ><?= $data['Keluhan']; ?></textarea>

        </div>


        <div class="form-group">

            <label>
                Biaya Administrasi
            </label>

            <input
                type="number"
                name="Biaya_Adm"
                value="<?= $data['Biaya_Adm']; ?>"
                required
            >

        </div>


        <button
            type="submit"
            name="update_berobat"
            class="btn-simpan"
        >
            Simpan Perubahan
        </button>


        <a
            href="index.php#berobat"
            class="btn-kembali"
        >
            Kembali
        </a>


    </form>

</div>


</body>

</html>