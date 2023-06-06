<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mahasiswa';

$conn = mysqli_connect($host, $username, $password, $database);

// Periksa apakah parameter id diberikan
if (isset($_GET['NAMA'])) {
    $nama = $_GET['NAMA'];
    // Hapus data dari database
    $query = "DELETE FROM data_mahasiswa WHERE NAMA LIKE '%$nama%'"; // Ganti 'nama_tabel' dengan nama tabel Anda
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Terjadi kesalahan saat menghapus data: " . mysqli_error($conn);
    }
} else {
    echo "Nama tidak diberikan.";
}
?>

<!DOCTYPE html>
<html>
    <head>
    <head>
        <title>Daftar Mahasiswa</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    </head>
    </head>
    <body>
        <div class="d-flex justify-content-center">
            <a href="index.php"><button class="btn btn-success">Kembali</button></a>
        </div>
    </body>
</html>
