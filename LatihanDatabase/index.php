<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mahasiswa';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "SELECT * FROM data_mahasiswa";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 style="text-align:center;">Daftar Mahasiswa</h1>
        <table class="table" style="text-align:center;">
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                    <td><a href="viewdata.php?NAMA=<?php echo $row['NAMA']; ?>" style="text-decoration: none; color: inherit;"><?php echo $row['NAMA']; ?></a></td>
                        <td>
                            <a href="edit.php?NAMA=<?php echo $row['NAMA']; ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                            <a href="delete.php?NAMA=<?php echo $row['NAMA']; ?>"><button class="btn btn-danger">Delete</button></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            <a href="create.php"><button class="btn btn-success">Tambah Data</button></a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
