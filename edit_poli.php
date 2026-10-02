<?php

include "koneksi.php";


/* UPDATE DATA */

if (isset($_POST['update_poli'])) {

    $Poli_ID = $_POST['Poli_ID'];
    $Nama_Poli = $_POST['Nama_Poli'];

    $query_update = mysqli_query($koneksi, "
        UPDATE poli
        SET
            Nama_Poli = '$Nama_Poli'
        WHERE Poli_ID = '$Poli_ID'
    ");

    if ($query_update) {

        header("Location: index.php#poli");
        exit;

    } else {

        echo "Gagal mengupdate data: " . mysqli_error($koneksi);

    }
}


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

    <title>Edit Data Poli</title>

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

        input {
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
        Edit Data Poli
    </h1>


    <form method="POST">


        <div class="form-group">

            <label>
                Poli ID
            </label>

            <input
                type="text"
                name="Poli_ID"
                value="<?= $data['Poli_ID']; ?>"
                readonly
            >

        </div>


        <div class="form-group">

            <label>
                Nama Poli
            </label>

            <input
                type="text"
                name="Nama_Poli"
                value="<?= $data['Nama_Poli']; ?>"
                required
            >

        </div>


        <button
            type="submit"
            name="update_poli"
            class="btn btn-simpan"
        >
            Update Data
        </button>


        <a
            href="index.php#poli"
            class="btn btn-kembali"
        >
            Kembali
        </a>


    </form>

</div>


</body>

</html>