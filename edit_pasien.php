<?php

include "koneksi.php";


/* UPDATE DATA */

if (isset($_POST['update_pasien'])) {

    $Pasien_ID = $_POST['Pasien_ID'];
    $Nama_Pasien = $_POST['Nama_Pasien'];
    $Tanggal_Lahir = $_POST['Tanggal_Lahir'];
    $Jenis_Kelamin = $_POST['Jenis_Kelamin'];
    $Alamat = $_POST['Alamat'];

    $query_update = mysqli_query($koneksi, "
        UPDATE pasien
        SET
            Nama_Pasien = '$Nama_Pasien',
            Tanggal_Lahir = '$Tanggal_Lahir',
            Jenis_Kelamin = '$Jenis_Kelamin',
            Alamat = '$Alamat'
        WHERE Pasien_ID = '$Pasien_ID'
    ");

    if ($query_update) {

        header("Location: index.php#pasien");
        exit;

    } else {

        echo "Gagal mengupdate data: " . mysqli_error($koneksi);

    }
}


/* AMBIL DATA PASIEN */

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

    <title>Edit Data Pasien</title>

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
        select,
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
        Edit Data Pasien
    </h1>


    <form method="POST">


        <div class="form-group">

            <label>
                Pasien ID
            </label>

            <input
                type="text"
                name="Pasien_ID"
                value="<?= $data['Pasien_ID']; ?>"
                readonly
            >

        </div>


        <div class="form-group">

            <label>
                Nama Pasien
            </label>

            <input
                type="text"
                name="Nama_Pasien"
                value="<?= $data['Nama_Pasien']; ?>"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Tanggal Lahir
            </label>

            <input
                type="date"
                name="Tanggal_Lahir"
                value="<?= $data['Tanggal_Lahir']; ?>"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Jenis Kelamin
            </label>

            <select name="Jenis_Kelamin" required>

                <option value="Laki-Laki"
                    <?= $data['Jenis_Kelamin'] == 'Laki-Laki' ? 'selected' : ''; ?>>
                    Laki-Laki
                </option>

                <option value="Perempuan"
                    <?= $data['Jenis_Kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>
                    Perempuan
                </option>

            </select>

        </div>


        <div class="form-group">

            <label>
                Alamat
            </label>

            <textarea
                name="Alamat"
                required
            ><?= $data['Alamat']; ?></textarea>

        </div>


        <button
            type="submit"
            name="update_pasien"
            class="btn btn-simpan"
        >
            Update Data
        </button>


        <a
            href="index.php#pasien"
            class="btn btn-kembali"
        >
            Kembali
        </a>


    </form>

</div>


</body>

</html>
