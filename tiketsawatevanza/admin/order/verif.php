<?php
require '../../koneksi.php'; // Pastikan koneksi ke database

// Ambil id_order dari URL
$id_order = $_GET['id'];

// Pastikan ID valid
if ($id_order) {
    // Update status menjadi 'Approved'
    $query = "UPDATE order_tiket SET status = 'Approved' WHERE id_order = '$id_order'";
    
    // Jalankan query
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "
        <script type='text/javascript'>
            alert('Data telah terverifikasi dan status berhasil diperbarui!');
            window.location = '../order/index.php'; // Redirect ke halaman tiket setelah berhasil
        </script>
        ";
    } else {
        echo "
        <script type='text/javascript'>
            alert('Terjadi kesalahan saat memverifikasi data');
            window.location = '../order/index.php'; // Tetap redirect meskipun ada error
        </script>
        ";
    }
}
?>
