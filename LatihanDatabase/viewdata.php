<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mahasiswa';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Periksa apakah parameter id diberikan
if (isset($_GET['NAMA'])) {
    $nama = mysqli_real_escape_string($conn, $_GET['NAMA']);

    $query = "SELECT * FROM data_mahasiswa WHERE NAMA LIKE '%$nama%'"; // Ganti 'nama_tabel' dengan nama tabel Anda
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Terjadi kesalahan saat mengambil data: " . mysqli_error($conn);
        exit;
    }

    // Periksa apakah data ditemukan
    if (mysqli_num_rows($result) == 0) {
        echo "Data tidak ditemukan.";
        exit;
    }

    $row = mysqli_fetch_assoc($result);
} else {
    echo "Nama tidak diberikan.";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 style="text-align:center;">Data <?php echo $row['NAMA']; ?></h1>
                <p>NIM : <?php echo $row['NIM']; ?></p>
                <p>Nama : <?php echo $row['NAMA']; ?></p>
                <p>Alamat : <?php echo $row['Alamat']; ?></p>
                <p>No Telp : <?php echo $row['No Telp']; ?></p>
                <p>Hobby : <?php echo $row['Hobby']; ?></p>
                <p>Prodi : <?php echo $row['Prodi']; ?></p>
                <p>Fakultas : <?php echo $row['Fakultas']; ?></p>
                <p>Jenis Kelamin : <?php echo $row['Jenis_Kelamin']; ?></p>
                <p>Foto : </p>
                <?php
                // Mendapatkan ekstensi file dari nama file
                $extension = pathinfo($row['Foto'], PATHINFO_EXTENSION);
                if ($extension === 'jpeg' || $extension === 'jpg') {
                    $imageData = file_get_contents($row['Foto']);
                    $base64Image = base64_encode($imageData);
                    $src = 'data:image/jpeg;base64,' . $base64Image;
                    echo '<img src="' . $src . '" height="200" width="200" alt="Foto">';
                } else if ($extension === 'png') {
                    $imageData = file_get_contents($row['Foto']);
                    $base64Image = base64_encode($imageData);
                    $src = 'data:image/png;base64,' . $base64Image;
                    echo '<img src="' . $src . '" height="200" width="200" alt="Foto">';
                }
                ?>
                <br><br>
        <a href="index.php"><button class="btn btn-primary">Kembali</button></a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
