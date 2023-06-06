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
    $hobby = isset($_POST['hobby']) ? $_POST['hobby'] : array(); // Ensure $hobby is always an array
    $prodi = $_POST['prodi'];
    $fakultas = $_POST['fakultas'];
    $jenisKelamin = $_POST['jenis_kelamin'];
    
    // Upload foto
    $foto = $_FILES['foto']['name'];
    $fotoTmp = $_FILES['foto']['tmp_name'];
    $fotoPath = 'src/' . $foto;
    move_uploaded_file($fotoTmp, $fotoPath);

    // Convert $hobby array to string
    $hobbyString = implode(', ', $hobby);
    
    // Escape special characters in the string values
    $nim = mysqli_real_escape_string($conn, $nim);
    $nama = mysqli_real_escape_string($conn, $nama);
    $alamat = mysqli_real_escape_string($conn, $alamat);
    $noTelp = mysqli_real_escape_string($conn, $noTelp);
    $hobbyString = mysqli_real_escape_string($conn, $hobbyString);
    $prodi = mysqli_real_escape_string($conn, $prodi);
    $fakultas = mysqli_real_escape_string($conn, $fakultas);
    $jenisKelamin = mysqli_real_escape_string($conn, $jenisKelamin);
    $fotoPath = mysqli_real_escape_string($conn, $fotoPath);

    // Query untuk menambahkan data ke database
    $query = "INSERT INTO data_mahasiswa (NIM, NAMA, Alamat, `No Telp`, Hobby, Prodi, Fakultas, `Jenis_Kelamin`, Foto)
              VALUES ('$nim', '$nama', '$alamat', '$noTelp', '$hobbyString', '$prodi', '$fakultas', '$jenisKelamin', '$fotoPath')";

    // Eksekusi query
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Terjadi kesalahan saat menambahkan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
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
        <h1 style="text-align:center;">Tambah Data</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nim" class="form-label">NIM :</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama :</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat :</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
            <div class="mb-3">
                <label for="no_telp" class="form-label">No. Telp :</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
            </div>
            <div class="mb-3">
            <label for="hobby" class="form-label">Hobby :</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Ngoding" id="hobbyNgoding">
                    <label class="form-check-label" for="hobbyNgoding">Ngoding</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Bermain Game" id="hobbyGame">
                    <label class="form-check-label" for="hobbyGame">Bermain Game</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="hobby[]" value="Membaca Buku" id="hobbyBuku">
                    <label class="form-check-label" for="hobbyBuku">Membaca Buku</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="prodi" class="form-label">Prodi :</label>
                <input type="text" class="form-control" id="prodi" name="prodi" required>
            </div>
            <div class="mb-3">
                <label for="fakultas" class="form-label">Fakultas :</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="fakultas" value="FTIB" id="fakultasFTIB" required>
                    <label class="form-check-label" for="fakultasFTIB">FTIB</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="fakultas" value="FTIEC" id="fakultasFTIEC" required>
                    <label class="form-check-label" for="fakultasFTIEC">FTIEC</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin :</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto :</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>
            <button type="submit" class="btn btn-primary">Tambah Data</button>
        </form>
        <a href="index.php"><button class="btn btn-primary">Kembali</button></a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
