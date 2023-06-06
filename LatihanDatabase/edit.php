<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mahasiswa';

$conn = mysqli_connect($host, $username, $password, $database);

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $noTelp = $_POST['no_telp'];
    $hobby = $_POST['hobby'];
    $prodi = $_POST['prodi'];
    $fakultas = $_POST['fakultas'];
    $jenisKelamin = $_POST['jenis_kelamin'];
    // Join array hobby menjadi string
    $hobbyString = implode(', ', $hobby);
    
    // Query untuk memperbarui data di database
    $query = "UPDATE data_mahasiswa SET NAMA = '$nama', Alamat = '$alamat', `No Telp` = '$noTelp', Hobby = '$hobbyString', Prodi = '$prodi', Fakultas = '$fakultas', `Jenis_Kelamin` = '$jenisKelamin'";

    // Check if a file is uploaded
    if (!empty($_FILES['foto']['name'])) {
        // Ambil file content dari file foto yang diupload
        $foto = $_FILES['foto']['name'];
        $fotoTmp = $_FILES['foto']['tmp_name'];
        $fotoPath = 'src/' . $foto;
        move_uploaded_file($fotoTmp, $fotoPath);

        $query .= ", Foto = '$fotoPath'";
    }

    $query .= " WHERE NIM = '$nim'";

    $stmt = mysqli_prepare($conn, $query);

    // Execute the statement
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Terjadi kesalahan saat memperbarui data: " . mysqli_error($conn);
    }
}

// Ambil data dari database
if (isset($_GET['NAMA'])) {
    $nama = mysqli_real_escape_string($conn, $_GET['NAMA']);

    $query = "SELECT * FROM data_mahasiswa WHERE NAMA LIKE '%$nama%'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Terjadi kesalahan saat mengambil data: " . mysqli_error($conn);
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    $row['Hobby'] = explode(', ', $row['Hobby']);
} else {
    echo "Nama tidak diberikan.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script>
        // Mendapatkan elemen checkbox yang dipilih
        var checkboxes = document.querySelectorAll('input[name="hobby[]"]:checked');

        // Mendapatkan nilai-nilai yang dipilih
        var selectedHobbies = Array.from(checkboxes).map(function(checkbox) {
            return checkbox.value;
        });

        // Menggabungkan nilai-nilai menjadi sebuah string
        var result = selectedHobbies.join(", ");

        // Menampilkan hasil di elemen dengan ID "result"
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("hobbyResult").textContent = result;
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Edit Data</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM :</label>
                <input type="text" class="form-control" id="nim" name="nim" value="<?php echo isset($row['NIM']) ? $row['NIM'] : ''; ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama :</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo isset($row['NAMA']) ? $row['NAMA'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat :</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo isset($row['Alamat']) ? $row['Alamat'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_telp" class="form-label">No. Telp :</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php echo isset($row['No Telp']) ? $row['No Telp'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="hobby" class="form-label">Hobby :</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Ngoding" id="hobbyNgoding" <?php if (isset($row['Hobby']) && in_array('Ngoding', $row['Hobby'])) echo 'checked'; ?>>
                    <label class="form-check-label" for="hobbyNgoding">Ngoding</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Bermain Game" id="hobbyGame" <?php if (isset($row['Hobby']) && in_array('Bermain Game', $row['Hobby'])) echo 'checked'; ?>>
                    <label class="form-check-label" for="hobbyGame">Bermain Game</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Membaca Buku" id="hobbyBuku" <?php if (isset($row['Hobby']) && in_array('Membaca Buku', $row['Hobby'])) echo 'checked'; ?>>
                    <label class="form-check-label" for="hobbyBuku">Membaca Buku</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="prodi" class="form-label">Prodi :</label>
                <input type="text" class="form-control" id="prodi" name="prodi" value="<?php echo isset($row['Prodi']) ? $row['Prodi'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="fakultas" class="form-label">Fakultas :</label>
                <input type="text" class="form-control" id="fakultas" name="fakultas" value="<?php echo isset($row['Fakultas']) ? $row['Fakultas'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin :</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki" <?php if (isset($row['Jenis_Kelamin']) && $row['Jenis_Kelamin'] === 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                    <option value="Perempuan" <?php if (isset($row['Jenis_Kelamin']) && $row['Jenis_Kelamin'] === 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto :</label>
                <br>
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
                <input type="file" class="form-control" id="foto" name="foto" accept="src/*">
            </div>
            <button type="submit" class="btn btn-primary">Update Data</button>
        </form>
        <a href="index.php"><button class="btn btn-primary">Kembali</button></a>
    </div>
</body>
</html>
