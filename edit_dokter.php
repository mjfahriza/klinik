<?php

include "koneksi.php";


/* UPDATE DATA */

if (isset($_POST['update_dokter'])) {

    $Dokter_ID = $_POST['Dokter_ID'];
    $Nama_Dokter = $_POST['Nama_Dokter'];
    $Poli_ID = $_POST['Poli_ID'];

    $query_update = mysqli_query($koneksi, "
        UPDATE dokter
        SET
            Nama_Dokter = '$Nama_Dokter',
            Poli_ID = '$Poli_ID'
        WHERE Dokter_ID = '$Dokter_ID'
    ");

    if ($query_update) {

        header("Location: index.php#dokter");
        exit;

    } else {

        echo "Gagal mengupdate data dokter: " . mysqli_error($koneksi);

    }
}


/* AMBIL DATA DOKTER */

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
    SELECT *
    FROM dokter
    WHERE Dokter_ID = '$id'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data dokter tidak ditemukan.");
}


/* AMBIL DATA POLI */

$query_poli = mysqli_query($koneksi, "
    SELECT *
    FROM poli
    ORDER BY Poli_ID
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Edit Data Dokter</title>

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
        select {
            width: 100%;
            padding: 13px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .btn {
            display: inline-block;
            padding: 13px 20px;
            border: none;
            border-radius: 7px;
            color: white;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
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
        Edit Data Dokter
    </h1>


    <form method="POST">


        <div class="form-group">

            <label>
                Dokter ID
            </label>

            <input
                type="text"
                name="Dokter_ID"
                value="<?= $data['Dokter_ID']; ?>"
                readonly
            >

        </div>


        <div class="form-group">

            <label>
                Nama Dokter
            </label>

            <input
                type="text"
                name="Nama_Dokter"
                value="<?= $data['Nama_Dokter']; ?>"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Poli
            </label>

            <select name="Poli_ID" required>

                <?php while ($poli = mysqli_fetch_assoc($query_poli)) { ?>

                    <option
                        value="<?= $poli['Poli_ID']; ?>"
                        <?= $data['Poli_ID'] == $poli['Poli_ID'] ? 'selected' : ''; ?>
                    >

                        <?= $poli['Poli_ID']; ?>
                        -
                        <?= $poli['Nama_Poli']; ?>

                    </option>

                <?php } ?>

            </select>

        </div>


        <button
            type="submit"
            name="update_dokter"
            class="btn btn-simpan"
        >
            Update Data
        </button>


        <a
            href="index.php#dokter"
            class="btn btn-kembali"
        >
            Kembali
        </a>


    </form>

</div>

</body>

</html>