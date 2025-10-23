<?php
// Konfigurasi database
$host = "localhost";
$user = "root";      // ganti sesuai user MySQL Anda
$pass = "";          // ganti sesuai password MySQL Anda
$db   = "ellezza_bakes"; // ubah sesuai nama database Anda

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama    = isset($_POST['nama']) ? $_POST['nama'] : '';
$telepon = isset($_POST['telepon']) ? $_POST['telepon'] : '';
$menu    = isset($_POST['menu']) ? $_POST['menu'] : '';
$alamat  = isset($_POST['alamat']) ? $_POST['alamat'] : '';

// Validasi sederhana
if ($nama && $telepon && $menu && $alamat) {
    // Simpan ke database
    $sql = "INSERT INTO pesanan (nama, telepon, menu, alamat) 
            VALUES ('$nama', '$telepon', '$menu', '$alamat')";
    if ($conn->query($sql) === TRUE) {
        // Kirim email
        $to      = "hello@ellezza-bakes.com";  // email tujuan Anda
        $subject = "Pesanan Baru dari $nama";
        $message = "
            <h2>Pesanan Baru - Ellezza Bakes</h2>
            <p><strong>Nama:</strong> $nama</p>
            <p><strong>Telepon:</strong> $telepon</p>
            <p><strong>Menu:</strong> $menu</p>
            <p><strong>Alamat:</strong> $alamat</p>
        ";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Ellezza Bakes <no-reply@ellezza-bakes.com>" . "\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo "<script>alert('Pesanan berhasil dikirim!'); window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('Pesanan tersimpan, tapi email gagal terkirim.'); window.location.href='index.html';</script>";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "<script>alert('Semua field harus diisi!'); window.location.href='index.html';</script>";
}

$conn->close();
?>
