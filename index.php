<?php
include "koneksi.php";

if (isset($_POST['tambah_poli'])) {

    $Poli_ID = $_POST['Poli_ID'];
    $Nama_Poli = $_POST['Nama_Poli'];

    $query_tambah_poli = mysqli_query($koneksi, "
        INSERT INTO poli
        (Poli_ID, Nama_Poli)
        VALUES
        ('$Poli_ID',
         '$Nama_Poli')
    ");

    if ($query_tambah_poli) {
        header("Location: index.php#poli");
        exit;
    } else {
        echo "Gagal menambahkan poli: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['tambah_dokter'])) {

    $Dokter_ID = $_POST['Dokter_ID'];
    $Nama_Dokter = $_POST['Nama_Dokter'];
    $Poli_ID = $_POST['Poli_ID'];

    $query_tambah_dokter = mysqli_query($koneksi, "
        INSERT INTO dokter
        (Dokter_ID, Nama_Dokter, Poli_ID)
        VALUES
        ('$Dokter_ID',
         '$Nama_Dokter',
         '$Poli_ID')
    ");

    if ($query_tambah_dokter) {

        header("Location: index.php#dokter");
        exit;

    } else {

        echo "Gagal menambahkan dokter: " . mysqli_error($koneksi);

    }
}

if (isset($_POST['tambah_pasien'])) {

    $Pasien_ID = $_POST['Pasien_ID'];
    $Nama_Pasien = $_POST['Nama_Pasien'];
    $Tanggal_Lahir = $_POST['Tanggal_Lahir'];
    $Jenis_Kelamin = $_POST['Jenis_Kelamin'];
    $Alamat = $_POST['Alamat'];

    $query_tambah_pasien = mysqli_query($koneksi, "
        INSERT INTO pasien
        (Pasien_ID, Nama_Pasien, Tanggal_Lahir, Jenis_Kelamin, Alamat)
        VALUES
        ('$Pasien_ID',
         '$Nama_Pasien',
         '$Tanggal_Lahir',
         '$Jenis_Kelamin',
         '$Alamat')
    ");

    if ($query_tambah_pasien) {

        header("Location: index.php#pasien");
        exit;

    } else {

        echo "Gagal menambahkan pasien: " . mysqli_error($koneksi);

    }
}

/* =========================================================
   PROSES TAMBAH DATA BEROBAT
   ========================================================= */

if (isset($_POST['tambah_berobat'])) {

    $No_Transaksi = $_POST['No_Transaksi'];
    $Pasien_ID = $_POST['Pasien_ID'];
    $Tanggal = $_POST['Tanggal'];
    $Bulan = $_POST['Bulan'];
    $Tahun = $_POST['Tahun'];

    $Tanggal_Berobat = $Tahun . '-' . $Bulan . '-' . $Tanggal;
    $Dokter_ID = $_POST['Dokter_ID'];
    $Keluhan = $_POST['Keluhan'];
    $Biaya_Adm = $_POST['Biaya_Adm'];

    $query_tambah = mysqli_query($koneksi, "
        INSERT INTO berobat
        (No_Transaksi, Pasien_ID, Tanggal_Berobat, Dokter_ID, Keluhan, Biaya_Adm)
        VALUES
        ('$No_Transaksi',
         '$Pasien_ID',
         '$Tanggal_Berobat',
         '$Dokter_ID',
         '$Keluhan',
         '$Biaya_Adm')
    ");

    if ($query_tambah) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
}


/* =========================================================
   QUERY DATA BEROBAT
   ========================================================= */

$query_berobat = mysqli_query($koneksi, "
    SELECT 
        berobat.No_Transaksi,
        berobat.Pasien_ID,
        pasien.Nama_Pasien,
        TIMESTAMPDIFF(YEAR, pasien.Tanggal_Lahir, CURDATE()) AS Usia,
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


/* =========================================================
   DATA UNTUK FORM PASIEN
   ========================================================= */

$pasien_form = mysqli_query($koneksi, "
    SELECT * FROM pasien
    ORDER BY Pasien_ID
");


/* =========================================================
   DATA UNTUK FORM DOKTER
   ========================================================= */

$dokter_form = mysqli_query($koneksi, "
    SELECT * FROM dokter
    ORDER BY Nama_Dokter
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Informasi Klinik</title>

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
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 270px;
            height: 100vh;
            background: #203f67;
            color: white;
            padding: 40px 25px;
        }

        .logo {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 45px;
        }

        .menu a {
            display: block;
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 17px 10px;
            margin-bottom: 8px;
            border-radius: 8px;
        }

        .menu a:hover {
            background: rgba(255,255,255,0.12);
        }

        /* CONTENT */

        .content {
            margin-left: 270px;
            padding: 45px;
        }

        .content h1 {
            font-size: 40px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #777;
            font-size: 20px;
            margin-bottom: 35px;
        }

        /* DASHBOARD */

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        .card h3 {
            color: #777;
            margin-bottom: 15px;
        }

        .card .number {
            font-size: 38px;
            font-weight: bold;
            color: #203f67;
        }

        /* TABLE */

        .table-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
            overflow-x: auto;
        }

        .table-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .table-title h2 {
            font-size: 32px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        th {
            background: #e7eef8;
            color: #203f67;
            padding: 18px;
            text-align: left;
            font-size: 17px;
        }

        td {
            padding: 18px;
            border-bottom: 1px solid #eee;
            color: #333;
        }

        tr:hover {
            background: #fafafa;
        }

        /* BUTTON */

        .btn-tambah {
            background: #203f67;
            color: white;
            text-decoration: none;
            padding: 15px 22px;
            border-radius: 8px;
            font-size: 17px;
        }

        .btn-tambah:hover {
            background: #162f4f;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
            color: white;
            margin-right: 5px;
            border: none;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-view {
            background: #55b85a;
        }

        .btn-edit {
            background: #f2a93b;
        }

        .btn-delete {
            background: #db5050;
        }

        /* FORM */

        .form-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 50px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.07);
        }

        .form-container h2 {
            font-size: 30px;
            margin-bottom: 25px;
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
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .btn-simpan {
            background: #203f67;
            color: white;
            padding: 13px 25px;
            border: none;
            border-radius: 7px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-simpan:hover {
            background: #162f4f;
        }

        @media (max-width: 1000px) {

            .sidebar {
                width: 220px;
            }

            .content {
                margin-left: 220px;
                padding: 25px;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

        }

    </style>

</head>

<body>


<!-- =====================================================
     SIDEBAR
     ===================================================== -->

<div class="sidebar">

    <div class="logo">
        🏥 KLINIK
    </div>

    <div class="menu">

        <a href="#dashboard">
            Dashboard
        </a>

        <a href="#pasien">
            Data Pasien
        </a>

        <a href="#dokter">
            Data Dokter
        </a>

        <a href="#poli">
            Data Poli
        </a>

        <a href="#berobat">
            Data Berobat
        </a>

        <a href="laporan.php">
            Laporan
        </a>

        <a href="list_dokter.php">
            List Dokter
        </a>

        <a href="list_pasien.php">
            List Pasien
        </a>

        <a href="list_berobat.php">
            List Data Berobat
        </a>

    </div>

</div>


<!-- =====================================================
     CONTENT
     ===================================================== -->

<div class="content">


    <!-- DASHBOARD -->

    <section id="dashboard">

        <h1>
            Sistem Informasi Klinik
        </h1>

        <p class="subtitle">
            Pengelolaan data operasional klinik
        </p>


        <div class="cards">

            <div class="card">

                <h3>
                    Total Pasien
                </h3>

                <div class="number">

                    <?php

                    $jumlah_pasien = mysqli_query(
                        $koneksi,
                        "SELECT * FROM pasien"
                    );

                    echo mysqli_num_rows($jumlah_pasien);

                    ?>

                </div>

            </div>


            <div class="card">

                <h3>
                    Total Dokter
                </h3>

                <div class="number">

                    <?php

                    $jumlah_dokter = mysqli_query(
                        $koneksi,
                        "SELECT * FROM dokter"
                    );

                    echo mysqli_num_rows($jumlah_dokter);

                    ?>

                </div>

            </div>


            <div class="card">

                <h3>
                    Total Poli
                </h3>

                <div class="number">

                    <?php

                    $jumlah_poli = mysqli_query(
                        $koneksi,
                        "SELECT * FROM poli"
                    );

                    echo mysqli_num_rows($jumlah_poli);

                    ?>

                </div>

            </div>


            <div class="card">

                <h3>
                    Total Transaksi
                </h3>

                <div class="number">

                    <?php

                    $jumlah_transaksi = mysqli_query(
                        $koneksi,
                        "SELECT * FROM berobat"
                    );

                    echo mysqli_num_rows($jumlah_transaksi);

                    ?>

                </div>

            </div>

        </div>

    </section>



    <!-- =================================================
         DATA BEROBAT
         ================================================= -->

    <section class="table-container" id="berobat">

        <div class="table-title">

            <h2>
                Data Berobat
            </h2>

            <a href="#form-berobat" class="btn-tambah">
                + Tambah Data
            </a>

        </div>


        <table>

            <thead>

                <tr>

                    <th>
                        No Transaksi
                    </th>

                    <th>
                        Pasien ID
                    </th>

                    <th>
                        Nama Pasien
                    </th>

                    <th>
                        Usia
                    </th>

                    <th>
                        Jenis Kelamin
                    </th>

                    <th>
                        Keluhan
                    </th>

                    <th>
                        Nama Poli
                    </th>

                    <th>
                        Dokter
                    </th>

                    <th>
                        Biaya Administrasi
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php while ($data = mysqli_fetch_assoc($query_berobat)) { ?>

                    <tr>

                        <td>
                            <?= $data['No_Transaksi']; ?>
                        </td>

                        <td>
                            <?= $data['Pasien_ID']; ?>
                        </td>

                        <td>
                            <?= $data['Nama_Pasien']; ?>
                        </td>

                        <td>
                            <?= $data['Usia']; ?>
                        </td>

                        <td>
                            <?= $data['Jenis_Kelamin']; ?>
                        </td>

                        <td>
                            <?= $data['Keluhan']; ?>
                        </td>

                        <td>
                            <?= $data['Nama_Poli']; ?>
                        </td>

                        <td>
                            <?= $data['Nama_Dokter']; ?>
                        </td>

                        <td>
                            <?= number_format(
                                $data['Biaya_Adm'],
                                0,
                                ',',
                                '.'
                            ); ?>
                        </td>

                        <td>

                            <a
                                href="view_berobat.php?id=<?= $data['No_Transaksi']; ?>"
                                class="btn btn-view"
                            >
                                View
                            </a>

                            <a href="edit_berobat.php?id=<?= $data['No_Transaksi']; ?>" class="btn btn-edit">
                                Edit
                            </a>

                            <a
                                href="hapus_berobat.php?id=<?= $data['No_Transaksi']; ?>"
                                class="btn btn-delete"
                                onclick="return confirm('Yakin ingin menghapus data ini?');"
                            >
                                Delete
                            </a>

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </section>



    <!-- =================================================
         FORM TAMBAH DATA BEROBAT
         ================================================= -->

    <section class="form-container" id="form-berobat">

        <h2>
            Tambah Data Berobat
        </h2>


        <form method="POST">


            <div class="form-group">

                <label>
                    No Transaksi
                </label>

                <input
                    type="text"
                    name="No_Transaksi"
                    placeholder="Contoh: TR004"
                    required
                >

            </div>


            <div class="form-group">

                <label>
                    Pasien
                </label>

                <select name="Pasien_ID" required>

                    <option value="">
                        -- Pilih Pasien --
                    </option>

                    <?php while ($pasien = mysqli_fetch_assoc($pasien_form)) { ?>

                        <option value="<?= $pasien['Pasien_ID']; ?>">

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

                    <option value="">
                        -- Pilih Tanggal --
                    </option>

                    <?php for ($i = 1; $i <= 31; $i++) { ?>

                        <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT); ?>">
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

        <option value="">
            -- Pilih Bulan --
        </option>

        <option value="01">Januari</option>
        <option value="02">Februari</option>
        <option value="03">Maret</option>
        <option value="04">April</option>
        <option value="05">Mei</option>
        <option value="06">Juni</option>
        <option value="07">Juli</option>
        <option value="08">Agustus</option>
        <option value="09">September</option>
        <option value="10">Oktober</option>
        <option value="11">November</option>
        <option value="12">Desember</option>

    </select>

</div>


<div class="form-group">

    <label>
        Tahun
    </label>

    <input
        type="number"
        name="Tahun"
        placeholder="Contoh: 2026"
        required
    >

</div>


            <div class="form-group">

                <label>
                    Dokter
                </label>

                <select name="Dokter_ID" required>

                    <option value="">
                        -- Pilih Dokter --
                    </option>

                    <?php while ($dokter = mysqli_fetch_assoc($dokter_form)) { ?>

                        <option value="<?= $dokter['Dokter_ID']; ?>">

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
                    placeholder="Masukkan keluhan pasien"
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label>
                    Biaya Administrasi
                </label>

                <input
                    type="number"
                    name="Biaya_Adm"
                    placeholder="Contoh: 125000"
                    required
                >

            </div>


            <button
                type="submit"
                name="tambah_berobat"
                class="btn-simpan"
            >
                Simpan Data
            </button>


        </form>

    </section>



    <!-- =================================================
         BAGIAN LAIN
         ================================================= -->

    <section class="table-container" id="pasien">

    <div class="table-title">

        <h2>
            Data Pasien
        </h2>

        <a href="#form-pasien" class="btn-tambah">
            + Tambah Data
        </a>

    </div>


    <table>

        <thead>

            <tr>

                <th>Pasien ID</th>
                <th>Nama Pasien</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Aksi</th>

            </tr>

        </thead>


        <tbody>

            <?php

            $query_pasien = mysqli_query($koneksi, "
                SELECT *
                FROM pasien
                ORDER BY Pasien_ID
            ");

            while ($pasien = mysqli_fetch_assoc($query_pasien)) {

            ?>

                <tr>

                    <td>
                        <?= $pasien['Pasien_ID']; ?>
                    </td>

                    <td>
                        <?= $pasien['Nama_Pasien']; ?>
                    </td>

                    <td>
                        <?= $pasien['Tanggal_Lahir']; ?>
                    </td>

                    <td>
                        <?= $pasien['Jenis_Kelamin']; ?>
                    </td>

                    <td>
                        <?= $pasien['Alamat']; ?>
                    </td>

                    <td>

                        <a href="view_pasien.php?id=<?= $pasien['Pasien_ID']; ?>"
                        class="btn btn-view">
                            View
                        </a>

                        <a href="edit_pasien.php?id=<?= $pasien['Pasien_ID']; ?>"
                        class="btn btn-edit">
                            Edit
                        </a>

                        <a  href="hapus_pasien.php?id=<?= $pasien['Pasien_ID']; ?>"
                        class="btn btn-delete"
                        onclick="return confirm('Yakin ingin menghapus data pasien ini?');">
                            Delete
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</section>

    <section class="form-container" id="form-pasien">

    <h2>
        Tambah Data Pasien
    </h2>

    <form method="POST">

        <div class="form-group">

            <label>
                Pasien ID
            </label>

            <input
                type="text"
                name="Pasien_ID"
                placeholder="Contoh: PS.004"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Nama Pasien
            </label>

            <input
                type="text"
                name="Nama_Pasien"
                placeholder="Masukkan nama pasien"
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
                required
            >

        </div>


        <div class="form-group">

            <label>
                Jenis Kelamin
            </label>

            <select name="Jenis_Kelamin" required>

                <option value="">
                    -- Pilih Jenis Kelamin --
                </option>

                <option value="Laki-Laki">
                    Laki-Laki
                </option>

                <option value="Perempuan">
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
                placeholder="Masukkan alamat pasien"
                required
            ></textarea>

        </div>


        <button
            type="submit"
            name="tambah_pasien"
            class="btn-simpan"
        >
            Simpan Data
        </button>

    </form>

</section>
    <section class="table-container" id="dokter">

    <div class="table-title">

        <h2>
            Data Dokter
        </h2>

        <a href="#form-dokter" class="btn-tambah">
            + Tambah Data
        </a>

    </div>


    <table>

        <thead>

            <tr>

                <th>Dokter ID</th>
                <th>Nama Dokter</th>
                <th>Poli</th>
                <th>Aksi</th>

            </tr>

        </thead>


        <tbody>

            <?php

            $query_dokter = mysqli_query($koneksi, "
                SELECT
                    dokter.Dokter_ID,
                    dokter.Nama_Dokter,
                    dokter.Poli_ID,
                    poli.Nama_Poli
                FROM dokter
                JOIN poli
                    ON dokter.Poli_ID = poli.Poli_ID
                ORDER BY dokter.Dokter_ID
            ");

            while ($dokter = mysqli_fetch_assoc($query_dokter)) {

            ?>

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

                    <td>

                        <a href="view_dokter.php?id=<?= $dokter['Dokter_ID']; ?>"
                        class="btn btn-view">
                            View
                        </a>

                        <a href="edit_dokter.php?id=<?= $dokter['Dokter_ID']; ?>"
                        class="btn btn-edit">
                            Edit
                        </a>

                        <a href="hapus_dokter.php?id=<?= $dokter['Dokter_ID']; ?>"
                        class="btn btn-delete"
                        onclick="return confirm('Yakin ingin menghapus data dokter ini?');">
                            Delete
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</section>
<section class="form-container" id="form-dokter">

    <h2>
        Tambah Data Dokter
    </h2>


    <form method="POST">


        <div class="form-group">

            <label>
                Dokter ID
            </label>

            <input
                type="text"
                name="Dokter_ID"
                placeholder="Contoh: D04"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Nama Dokter
            </label>

            <input
                type="text"
                name="Nama_Dokter"
                placeholder="Contoh: dr. Andi"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Poli
            </label>

            <select name="Poli_ID" required>

                <option value="">
                    -- Pilih Poli --
                </option>

                <?php

                $poli_dokter = mysqli_query($koneksi, "
                    SELECT *
                    FROM poli
                    ORDER BY Poli_ID
                ");

                while ($poli = mysqli_fetch_assoc($poli_dokter)) {

                ?>

                    <option value="<?= $poli['Poli_ID']; ?>">

                        <?= $poli['Poli_ID']; ?>
                        -
                        <?= $poli['Nama_Poli']; ?>

                    </option>

                <?php } ?>

            </select>

        </div>


        <button
            type="submit"
            name="tambah_dokter"
            class="btn-simpan"
        >
            Simpan Data
        </button>


    </form>

</section>
    <section class="table-container" id="poli">

    <div class="table-title">

        <h2>
            Data Poli
        </h2>

        <a href="#form-poli" class="btn-tambah">
            + Tambah Data
        </a>

    </div>


    <table>

        <thead>

            <tr>

                <th>Poli ID</th>
                <th>Nama Poli</th>
                <th>Aksi</th>

            </tr>

        </thead>


        <tbody>

            <?php

            $query_poli = mysqli_query($koneksi, "
                SELECT *
                FROM poli
                ORDER BY Poli_ID
            ");

            while ($poli = mysqli_fetch_assoc($query_poli)) {

            ?>

                <tr>

                    <td>
                        <?= $poli['Poli_ID']; ?>
                    </td>

                    <td>
                        <?= $poli['Nama_Poli']; ?>
                    </td>

                    <td>

                        <a href="view_poli.php?id=<?= $poli['Poli_ID']; ?>"
                        class="btn btn-view">
                            View
                        </a>

                        <a href="edit_poli.php?id=<?= $poli['Poli_ID']; ?>" class="btn btn-edit">
                            Edit
                        </a>

                        <a href="hapus_poli.php?id=<?= $poli['Poli_ID']; ?>"
                        class="btn btn-delete"
                        onclick="return confirm('Yakin ingin menghapus data poli ini?');">
                            Delete
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</section>

<section class="form-container" id="form-poli">

    <h2>
        Tambah Data Poli
    </h2>

    <form method="POST">

        <div class="form-group">

            <label>
                Poli ID
            </label>

            <input
                type="text"
                name="Poli_ID"
                placeholder="Contoh: P04"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Nama Poli
            </label>

            <input
                type="text"
                name="Nama_Poli"
                placeholder="Contoh: Mata"
                required
            >

        </div>


        <button
            type="submit"
            name="tambah_poli"
            class="btn-simpan"
        >
            Simpan Data
        </button>

    </form>

</section>

</div>

</body>

</html>