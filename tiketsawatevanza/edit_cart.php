<?php
session_start();  // Pastikan session_start() berada di paling atas

require 'koneksi.php'; // Mengimpor koneksi database

// Menangani edit kuantitas
if (isset($_POST['edit'])) {
    $id_jadwal = $_POST['id_jadwal'];
    $kuantitas = $_POST['kuantitas'];

    // Update kuantitas dalam cart
    $_SESSION['cart'][$id_jadwal] = $kuantitas;

    // Redirect kembali ke halaman cart
    header('Location: cart.php');
    exit;
}

// Ambil ID jadwal untuk edit kuantitas
if (isset($_GET['id_jadwal'])) {
    $id_jadwal = $_GET['id_jadwal'];

    // Ambil detail penerbangan untuk ID jadwal
    $jadwalPenerbangan = query("SELECT * FROM jadwal_penerbangan 
        INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
        INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai 
        WHERE id_jadwal = '$id_jadwal'")[0];
} else {
    // Redirect jika tidak ada id_jadwal
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kuantitas</title>
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-semibold">

<?php require 'layouts/navbar.php'; ?> <!-- Mengimpor navbar -->

<div class="container mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Edit Kuantitas Tiket</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Tiket yang Akan Diedit</h2>
        <div class="mb-4">
            <p><strong>Maskapai:</strong> <?= $jadwalPenerbangan['nama_maskapai']; ?></p>
            <p><strong>Rute:</strong> <?= $jadwalPenerbangan['rute_asal']; ?> → <?= $jadwalPenerbangan['rute_tujuan']; ?></p>
            <p><strong>Tanggal Berangkat:</strong> <?= date('d M Y', strtotime($jadwalPenerbangan['tanggal_pergi'])); ?></p>
            <p><strong>Waktu Keberangkatan:</strong> <?= date('H:i', strtotime($jadwalPenerbangan['waktu_berangkat'])); ?></p>
            <p><strong>Harga:</strong> Rp <?= number_format($jadwalPenerbangan['harga']); ?></p>
        </div>

        <!-- Form untuk mengedit kuantitas -->
        <form action="edit_cart.php" method="POST" class="flex justify-center">
            <input type="number" name="kuantitas" value="<?= $_SESSION['cart'][$id_jadwal]; ?>" min="1" class="w-20 text-center border p-2 rounded-md" required>
            <input type="hidden" name="id_jadwal" value="<?= $id_jadwal; ?>">
            <button type="submit" name="edit" class="ml-4 px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300">Update Kuantitas</button>
        </form>
    </div>

</div>

</body>
</html>
