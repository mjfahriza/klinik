<?php

include "koneksi.php";

if (isset($_POST['update_berobat'])) {

    $No_Transaksi = $_POST['No_Transaksi'];
    $Pasien_ID = $_POST['Pasien_ID'];
    $Tanggal_Berobat = $_POST['Tanggal_Berobat'];
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

        header("Location: index.php");
        exit;

    } else {

        echo "Gagal mengupdate data: " . mysqli_error($koneksi);

    }
}


// Ambil ID transaksi dari URL
$id = $_GET['id'];


// Ambil data berobat berdasarkan ID
$query = mysqli_query($koneksi, "
    SELECT *
    FROM berobat
    WHERE No_Transaksi = '$id'
");


// Ambil hasil query
$data = mysqli_fetch_assoc($query);


// Kalau data tidak ditemukan
if (!$data) {
    die("Data tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Edit Data Berobat</title>

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

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #203f67;
        }

        input,
        textarea {
            width: 100%;
            padding: 13px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 16px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 100px;
        }

        .btn {
            padding: 13px 20px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            color: white;
            font-size: 16px;
            text-decoration: none;
        }

        .btn-simpan {
            background: #203f67;
        }

        .btn-kembali {
            background: #777;
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
                name="No_Transaksi"
                value="<?= $data['No_Transaksi']; ?>"
                readonly
            >

        </div>


        <div class="form-group">

            <label>
                Pasien ID
            </label>

            <input
                type="text"
                name="Pasien_ID"
                value="<?= $data['Pasien_ID']; ?>"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Tanggal Berobat
            </label>

            <input
                type="date"
                name="Tanggal_Berobat"
                value="<?= $data['Tanggal_Berobat']; ?>"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Dokter ID
            </label>

            <input
                type="text"
                name="Dokter_ID"
                value="<?= $data['Dokter_ID']; ?>"
                required
            >

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
            class="btn btn-simpan"
        >
            Update Data
        </button>


        <a
            href="index.php"
            class="btn btn-kembali"
        >
            Kembali
        </a>


    </form>

</div>


</body>

</html>