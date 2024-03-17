<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "projectcrud";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die ("Tidak bisa terkoneksi ke database");
}
$tanggal = "";
$wali_kelas = "";
$anggota_piket = "";
$kelas = "";
$status_piket = "";
$sukses = "";
$error = "";

if (isset ($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "delete from absensi_piket where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "select * from absensi_piket where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $tanggal = $r1['tanggal'];
    $wali_kelas = $r1['wali_kelas'];
    $anggota_piket = $r1['anggota_piket'];
    $kelas = $r1['kelas'];
    $status_piket = $r1['status_piket'];

    if ($tanggal == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset ($_POST['simpan'])) { //untuk create
    $tanggal = $_POST['tanggal'];
    $wali_kelas = $_POST['wali_kelas'];
    $anggota_piket = $_POST['anggota_piket'];
    $kelas = $_POST['kelas'];
    $status_piket = $_POST['status_piket'];

    if ($tanggal && $wali_kelas && $anggota_piket && $kelas && $status_piket) {
        if ($op == 'edit') { //untuk update
            $sql1 = "update absensi_piket set tanggal = '$tanggal',wali_kelas='$wali_kelas',anggota_piket = '$anggota_piket',kelas = '$kelas',status_piket='$status_piket' where id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1 = "insert into absensi_piket(tanggal,wali_kelas,anggota_piket,kelas,status_piket) values ('$tanggal','$wali_kelas','$anggota_piket','$kelas','$status_piket')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                    <?php
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?php echo $nama = DATE('y-m-d h:m:s') ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="wali_kelas" class="col-sm-2 col-form-label">Wali Kelas</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="wali_kelas" name="wali_kelas" value="<?php echo $wali_kelas?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="anggota_piket" class="col-sm-2 col-form-label">Anggota Piket</label>
                            <div class="col-sm-10">
                            <input type="text" class="form-control" id="anggota_piket" name="anggota_piket" value="<?php echo $anggota_piket?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="kelas" id="kelas">
                                    <option value="">- Pilih kelas -</option>
                                    <!-- x rekayasa perangkat lunak -->
                                    <option value="X-RPL-1" <?php if ($kelas == "X-RPL-1")
                                    echo "selected" ?>>X-RPL-1</option>
                                    <option value="X-RPL-2" <?php if ($kelas == "X-RPL-2")
                                    echo "selected" ?>>X-RPL-2</option>
                                    <option value="X-RPL-3" <?php if ($kelas == "X-RPL-3")
                                    echo "selected" ?>>X-RPL-3</option>
                                    <!-- x teknik komputer jaringan -->
                                    <option value="X-TKJ-1" <?php if ($kelas == "X-TKJ-1")
                                    echo "selected" ?>>X-TKJ-1</option>
                                    <option value="X-TKJ-2" <?php if ($kelas == "X-TKJ-2")
                                    echo "selected" ?>>X-TKJ-2</option>
                                    <!-- x multimedia -->
                                    <option value="X-MM-1" <?php if ($kelas == "X-MM-1")
                                    echo "selected" ?>>X-MM-1</option>
                                    <option value="X-MM-2" <?php if ($kelas == "X-MM-2")
                                    echo "selected" ?>>X-MM-2</option>
                                    <option value="X-MM-3" <?php if ($kelas == "X-MM-3")
                                    echo "selected" ?>>X-MM-3</option>
                                    <option value="X-MM-4" <?php if ($kelas == "X-MM-4")
                                    echo "selected" ?>>X-MM-4</option>
                                    <!-- x perbankan keuangan mikro -->
                                    <option value="X-PKM-1" <?php if ($kelas == "X-PKM-1")
                                    echo "selected" ?>>X-PKM-1</option>
                                    <option value="X-PKM-2" <?php if ($kelas == "X-PKM-2")
                                    echo "selected" ?>>X-PKM-2</option>
                                    <!-- xi rekayasa perangkat lunak -->
                                    <option value="XI-RPL-1" <?php if ($kelas == "XI-RPL-1")
                                    echo "selected" ?>>XI-RPL-1</option>
                                    <option value="XI-RPL-2" <?php if ($kelas == "XI-RPL-2")
                                    echo "selected" ?>>XI-RPL-2</option>
                                    <option value="XI-RPL-3" <?php if ($kelas == "XI-RPL-3")
                                    echo "selected" ?>>XI-RPL-3</option>
                                    <!-- xi teknik komputer jaringan -->
                                    <option value="XI-TKJ-1" <?php if ($kelas == "XI-TKJ-1")
                                    echo "selected" ?>>XI-TKJ-1</option>
                                    <option value="XI-TKJ-2" <?php if ($kelas == "XI-TKJ-2")
                                    echo "selected" ?>>XI-TKJ-2</option>
                                    <!-- xi multimedia -->
                                    <option value="XI-MM-1" <?php if ($kelas == "XI-MM-1")
                                    echo "selected" ?>>XI-MM-1</option>
                                    <option value="XI-MM-2" <?php if ($kelas == "XI-MM-2")
                                    echo "selected" ?>>XI-MM-2</option>
                                    <option value="XI-MM-3" <?php if ($kelas == "XI-MM-3")
                                    echo "selected" ?>>XI-MM-3</option>
                                    <option value="XI-MM-4" <?php if ($kelas == "XI-MM-4")
                                    echo "selected" ?>>XI-MM-4</option>
                                    <!-- xi perbankan keuangan mikro -->
                                    <option value="XI-PKM-1" <?php if ($kelas == "XI-PKM-1")
                                    echo "selected" ?>>X-PKM-1</option>
                                    <option value="XI-PKM-2" <?php if ($kelas == "XI-PKM-2")
                                    echo "selected" ?>>XI-PKM-2</option>
                                    <!-- xii rekayasa perangkat lunak -->
                                    <option value="XII-RPL-1" <?php if ($kelas == "XII-RPL-1")
                                    echo "selected" ?>>XII-RPL-1</option>
                                    <option value="XII-RPL-2" <?php if ($kelas == "XII-RPL-2")
                                    echo "selected" ?>>XII-RPL-2</option>
                                    <!-- xii teknik komputer jaringan -->
                                    <option value="XII-TKJ-1" <?php if ($kelas == "XII-TKJ-1")
                                    echo "selected" ?>>XII-TKJ-1</option>
                                    <option value="XII-TKJ-2" <?php if ($kelas == "XII-TKJ-2")
                                    echo "selected" ?>>XII-TKJ-2</option>
                                    <!-- xii multimedia -->
                                    <option value="XII-MM-1" <?php if ($kelas == "XII-MM-1")
                                    echo "selected" ?>>XII-MM-1</option>
                                    <option value="XII-MM-2" <?php if ($kelas == "XII-MM-2")
                                    echo "selected" ?>>XII-MM-2</option>
                                    <option value="XII-MM-3" <?php if ($kelas == "XII-MM-3")
                                    echo "selected" ?>>XII-MM-3</option>                     
                                    <!-- xii perbankan keuangan mikro -->
                                    <option value="XII-PKM-1" <?php if ($kelas == "XII-PKM-1")
                                    echo "selected" ?>>XII-PKM-1</option>
                                    <option value="XII-PKM-2" <?php if ($kelas == "XII-PKM-2")
                                    echo "selected" ?>>XII-PKM-2</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="status_piket" class="col-sm-2 col-form-label">Status Piket</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="status_piket" id="status_piket">
                                    <option value="">- Pilih status -</option>
                                    <!-- x rekayasa perangkat lunak -->
                                    <option value="sudah" <?php if ($kelas == "sudah")
                                    echo "selected" ?>>sudah</option>
                                    <option value="tidak-piket" <?php if ($kelas == "tidak-piket")
                                    echo "selected" ?>>tidak-piket</option>                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- untuk mengeluarkan data -->
            <div class="card">
                <div class="card-header text-white bg-secondary">
                    Data siswa
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Wali kelas</th>
                                <th scope="col">Anggota Piket</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Status Piket</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql2 = "select * from absensi_piket order by id desc";
                                $q2 = mysqli_query($koneksi, $sql2);
                                $urut = 1;
                                while ($r2 = mysqli_fetch_array($q2)) {
                                    $id = $r2['id'];
                                    $tanggal = $r2['tanggal'];
                                    $wali_kelas = $r2['wali_kelas'];
                                    $anggota_piket = $r2['anggota_piket'];
                                    $kelas = $r2['kelas'];
                                    $status_piket = $r2['status_piket'];

                                    ?>
                            <tr>
                                <th scope="row">
                                    <?php echo $urut++ ?>
                                </th>
                                <td scope="row">
                                    <?php echo $tanggal ?>
                                </td>
                                <td scope="row">
                                    <?php echo $wali_kelas ?>
                                </td>
                                <td scope="row">
                                    <?php echo $anggota_piket ?>
                                </td>
                                <td scope="row">
                                    <?php echo $kelas ?>
                                </td>
                                <td scope="row">
                                    <?php echo $status_piket ?>
                                </td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button"
                                            class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>"
                                        onclick="return confirm('Yakin mau delete data?')"><button type="button"
                                            class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                            <?php
                                }
                                ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</body>

</html>
