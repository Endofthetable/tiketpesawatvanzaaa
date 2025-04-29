<?php 
require 'layouts/navbar.php'; 

// Pastikan user sudah login
if (!isset($_SESSION["username"])) {
    echo "<script>
        alert('Silahkan login terlebih dahulu!');
        window.location = '../auth/login/index.php';
    </script>";
    exit;
}

// Koneksi ke database
$conn = mysqli_connect('localhost', 'root', '', 'daffa_tiket');
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Tangkap ID order dari URL dan lakukan sanitasi
$id = mysqli_real_escape_string($conn, $_GET["id"]);
$id_user = $_SESSION["id_user"];

// Pastikan kolom yang digunakan benar (ubah jika id_jadwal tidak ada)
$query = "SELECT 
    order_detail.id_order_detail, 
    order_detail.id_user, 
    order_detail.id_penerbangan, 
    order_tiket.id_order, 
    order_tiket.tanggal_transaksi, 
    order_detail.jumlah_tiket, 
    order_detail.total_harga, 
    order_tiket.status 
FROM order_detail 
INNER JOIN order_tiket ON order_tiket.id_order = order_detail.id_order 
WHERE order_tiket.id_order = '$id'";

// Jalankan query dan tangani error jika ada
$detailTiket = mysqli_query($conn, $query);
if (!$detailTiket) {
    die("Query Error: " . mysqli_error($conn));
}

// Fetch all data for summary
$data = mysqli_fetch_assoc($detailTiket);
// Reset pointer to use again in table
mysqli_data_seek($detailTiket, 0);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesanan - E Ticketing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .ticket-card {
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            transition: all 0.3s ease;
        }
        .ticket-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .status-badge {
            transition: all 0.3s ease;
        }
        .hover-scale {
            transition: transform 0.2s ease;
        }
        .hover-scale:hover {
            transform: scale(1.02);
        }
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Header with back button -->
    <div class="flex items-center mb-8 animate__animated animate__fadeIn">
        <a href="history.php" class="hover-scale inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            <span>Kembali ke Riwayat</span>
        </a>
    </div>

    <!-- Main ticket card -->
    <div class="ticket-card rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8 animate__animated animate__fadeInUp">
        <div class="bg-white p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-ticket-alt text-blue-500 mr-3"></i>
                        Detail Pemesanan Tiket
                    </h1>
                    <p class="text-gray-500 mt-1">Nomor Order: <span class="font-medium text-gray-700"><?= $id; ?></span></p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="status-badge inline-flex items-center px-4 py-2 rounded-full text-sm font-medium 
                        <?= $data["status"] === 'Approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                        <i class="fas <?= $data["status"] === 'Approved' ? 'fa-check-circle' : 'fa-clock'; ?> mr-2"></i>
                        <?= $data["status"]; ?>
                    </span>
                </div>
            </div>

            <!-- Order summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 fade-in">
                    <div class="flex items-center">
                        <div class="bg-blue-100 p-3 rounded-full mr-4">
                            <i class="fas fa-calendar-day text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Transaksi</p>
                            <p class="font-medium text-gray-800"><?= $data["tanggal_transaksi"]; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 fade-in">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-full mr-4">
                            <i class="fas fa-ticket text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jumlah Tiket</p>
                            <p class="font-medium text-gray-800"><?= $data["jumlah_tiket"]; ?> Tiket</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 fade-in">
                    <div class="flex items-center">
                        <div class="bg-purple-100 p-3 rounded-full mr-4">
                            <i class="fas fa-user text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">ID Pengguna</p>
                            <p class="font-medium text-gray-800"><?= $data["id_user"]; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order details table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-2"></i>No
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-barcode mr-2"></i>ID Order
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-user mr-2"></i>ID User
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="far fa-calendar mr-2"></i>Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-ticket mr-2"></i>Jumlah
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-info-circle mr-2"></i>Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($detailTiket)) : ?>
                        <tr class="hover:bg-gray-50 transition-colors animate__animated animate__fadeIn">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $no++; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?= $row["id_order"]; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $row["id_user"]; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $row["tanggal_transaksi"]; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $row["jumlah_tiket"]; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?= $row["status"] === 'Approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                    <i class="fas <?= $row["status"] === 'Approved' ? 'fa-check' : 'fa-clock'; ?> mr-1 mt-0.5"></i>
                                    <?= $row["status"]; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>

<!-- Confetti effect for approved tickets -->
<?php if ($data["status"] === 'Approved') : ?>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { y: 0.6 }
            });
        }, 1000);
    });
</script>
<?php endif; ?>

</body>
</html>