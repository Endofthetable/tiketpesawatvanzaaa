<?php
require '../../koneksi.php'; // Pastikan file koneksi ada

// Fungsi query untuk mengambil data
function query($query) {
    global $conn;

    $rows = [];
    $result = mysqli_query($conn, $query);

    // Ambil data dan masukkan ke dalam array
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;    
}
?>
