<?php require 'layouts/navbar.php'; ?>
<?php 
// Get airlines data with flight count
$maskapai = query("
    SELECT m.*, COUNT(j.id_jadwal) as jumlah_penerbangan 
    FROM maskapai m
    LEFT JOIN rute r ON m.id_maskapai = r.id_maskapai
    LEFT JOIN jadwal_penerbangan j ON r.id_rute = j.id_rute
    GROUP BY m.id_maskapai
    ORDER BY jumlah_penerbangan DESC
    LIMIT 8
");

// Initialize variables
$pendingOrders = [];
$recentApprovedOrders = [];
$riwayatPemesanan = [];

if(isset($_SESSION['user'])) {
    $id_user = $_SESSION['user']['id_user'];
    
    // Get pending and recent approved orders (within 12 hours) from order_tiket table
    $pendingOrders = query("
        SELECT ot.id_order, ot.struk, ot.tanggal_transaksi, ot.status 
        FROM order_tiket ot
        INNER JOIN order_detail od ON ot.id_order = od.id_order
        WHERE od.id_user = $id_user AND ot.status = 'proses'
        ORDER BY ot.tanggal_transaksi DESC
    ");
    
    $recentApprovedOrders = query("
        SELECT ot.id_order, ot.struk, ot.tanggal_transaksi, ot.status 
        FROM order_tiket ot
        INNER JOIN order_detail od ON ot.id_order = od.id_order
        WHERE od.id_user = $id_user 
        AND ot.status = 'Approved'
        AND ot.tanggal_transaksi >= NOW() - INTERVAL 12 HOUR
        ORDER BY ot.tanggal_transaksi DESC
    ");
    
    // Get booking history from pemesanan table
    $riwayatPemesanan = query("
        SELECT p.*, j.*, m.nama_maskapai, r.rute_asal, r.rute_tujuan
        FROM pemesanan p
        JOIN jadwal_penerbangan j ON p.id_jadwal = j.id_jadwal
        JOIN rute r ON j.id_rute = r.id_rute
        JOIN maskapai m ON r.id_maskapai = m.id_maskapai
        WHERE p.id_user = $id_user
        ORDER BY p.tanggal_pemesanan DESC
        LIMIT 3
    ");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Sistem Pemesanan Tiket</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .row-hover-animation {
            transition: all 0.3s ease;
        }
        
        .row-hover-animation:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        
        .status-approved {
            background-color: #ecfdf5;
            color: #10b981;
        }
        
        .status-pending {
            background-color: #fffbeb;
            color: #f59e0b;
        }
        
        .detail-link {
            transition: all 0.2s ease;
        }
        
        .detail-link:hover {
            color: #2563eb;
            transform: translateX(2px);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Hero Section with Carousel -->
    <div class="relative h-96 mb-12 overflow-hidden fade-in">
        <!-- Carousel Images -->
        <div class="absolute inset-0 z-0">
            <div class="carousel">
                <img src="https://wallpapercave.com/wp/wp10448214.jpg" alt="Airport" class="w-full h-full object-cover opacity-70 transition-opacity duration-1000">
                <img src="https://wallpapercave.com/wp/wp12052724.jpg" alt="Plane" class="w-full h-full object-cover opacity-70 transition-opacity duration-1000 hidden">
                <img src="https://wallpapercave.com/wp/wp12052737.jpg" alt="Travel" class="w-full h-full object-cover opacity-70 transition-opacity duration-1000 hidden">
            </div>
        </div>
        
        <!-- Welcome Message -->
        <div class="relative z-10 h-full flex flex-col justify-center items-center text-center px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">
                Selamat Datang<?= isset($_SESSION['user']) ? ', ' . htmlspecialchars($_SESSION['user']['nama_lengkap']) : '' ?>!
            </h1>
            <p class="text-xl md:text-2xl text-white mb-8 drop-shadow-md max-w-2xl">
                Temukan pengalaman terbang terbaik dengan berbagai pilihan maskapai
            </p>
            <a href="#maskapai" class="px-8 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-full transition duration-300 transform hover:scale-105 shadow-lg">
                Jelajahi Maskapai
            </a>
        </div>
    </div>

    <!-- Maskapai Section -->
    <section id="maskapai" class="py-12 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto fade-in">
            <h2 class="text-3xl font-bold text-center mb-4 text-gray-800">Pilihan Maskapai</h2>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                Kami bekerja sama dengan berbagai maskapai terbaik untuk memberikan Anda pengalaman terbang yang nyaman
            </p>
            
            <!-- Airlines Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php foreach($maskapai as $data) : ?>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group card-hover">
                        <a href="jadwal.php?maskapai=<?= $data['id_maskapai'] ?>" class="block">
                            <div class="p-6 flex flex-col items-center">
                                <div class="w-32 h-32 mb-4 flex items-center justify-center">
                                    <img src="assets/images/<?= $data["logo_maskapai"]; ?>" alt="<?= $data["nama_maskapai"]; ?>" class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2 text-center"><?= $data["nama_maskapai"]; ?></h3>
                                <div class="text-sm text-gray-600 mb-4 text-center"><?= $data["deskripsi_maskapai"] ?? 'Maskapai penerbangan terpercaya'; ?></div>
                                <div class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                    <i class="fas fa-plane-departure mr-1"></i>
                                    <?= $data["jumlah_penerbangan"] ?> Jadwal
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="jadwal.php" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300">
                    <i class="fas fa-list mr-2"></i> Lihat Semua Jadwal
                </a>
            </div>
        </div>
    </section>

    <!-- Recent Orders Section (12 hours) -->
    <?php if(isset($_SESSION['user']) && (!empty($pendingOrders) || !empty($recentApprovedOrders))) : ?>
    <section class="py-12 px-4 bg-white fade-in">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-semibold text-gray-800">
                    <i class="fas fa-clock mr-2 text-blue-500"></i> Pesanan 12 Jam Terakhir
                </h2>
                <div class="flex items-center space-x-2">
                    <i class="fas fa-sync-alt text-gray-400 animate-spin"></i>
                    <span class="text-sm text-gray-500">Diperbarui: <?= date('H:i') ?></span>
                </div>
            </div>
            
            <p class="text-gray-600 mb-6 max-w-2xl">
                Berikut adalah pesanan Anda yang sedang diproses atau baru disetujui dalam 12 jam terakhir
            </p>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-hashtag mr-2 text-gray-400"></i>
                                        No Order
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-receipt mr-2 text-gray-400"></i>
                                        Struk
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="far fa-clock mr-2 text-gray-400"></i>
                                        Waktu Transaksi
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle mr-2 text-gray-400"></i>
                                        Status
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <i class="fas fa-ellipsis-h mr-2 text-gray-400"></i>
                                        Aksi
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php 
                            // Combine pending and recent approved orders
                            $allRecentOrders = array_merge($pendingOrders, $recentApprovedOrders);
                            
                            foreach($allRecentOrders as $index => $order) : 
                                $statusClass = $order['status'] === 'Approved' ? 'status-approved' : 'status-pending';
                            ?>
                                <tr class="row-hover-animation <?= $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' ?>">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #<?= $order['id_order'] ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $order['struk'] ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('d M Y H:i', strtotime($order['tanggal_transaksi'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium <?= $statusClass ?>">
                                            <i class="fas <?= $order['status'] === 'Approved' ? 'fa-check-circle' : 'fa-hourglass-half' ?> mr-1"></i>
                                            <?= $order['status'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="detailPemesanan.php?id=<?= $order['id_order'] ?>" class="detail-link text-blue-500 hover:text-blue-700 flex items-center">
                                            <i class="fas fa-eye mr-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if(count($allRecentOrders) > 3) : ?>
                <div class="px-6 py-4 bg-gray-50 text-right">
                    <a href="riwayat.php" class="text-sm font-medium text-blue-600 hover:text-blue-500 flex items-center justify-end">
                        Lihat semua pesanan <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if(isset($_SESSION['user'])) : ?>
    <!-- Recent Bookings Section -->
    <section class="py-12 px-4 bg-gray-50 fade-in">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">
                <i class="fas fa-history mr-2 text-blue-500"></i> Riwayat Pemesanan Terakhir
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php foreach($riwayatPemesanan as $pemesanan) : ?>
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-300 card-hover">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-800 flex items-center">
                                        <i class="fas fa-plane mr-2 text-blue-500"></i>
                                        <?= $pemesanan['nama_maskapai'] ?>
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <i class="fas fa-route mr-1 text-gray-400"></i>
                                        <?= $pemesanan['rute_asal'] ?> → <?= $pemesanan['rute_tujuan'] ?>
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium <?= $pemesanan['status_pemesanan'] == 'selesai' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                    <i class="fas <?= $pemesanan['status_pemesanan'] == 'selesai' ? 'fa-check-circle' : 'fa-spinner' ?> mr-1"></i>
                                    <?= ucfirst($pemesanan['status_pemesanan']) ?>
                                </span>
                            </div>
                            
                            <div class="space-y-3 text-sm mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 flex items-center">
                                        <i class="far fa-calendar mr-2 text-gray-400"></i> Tanggal:
                                    </span>
                                    <span class="font-medium"><?= date('d M Y', strtotime($pemesanan['tanggal_pergi'])) ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 flex items-center">
                                        <i class="far fa-clock mr-2 text-gray-400"></i> Waktu:
                                    </span>
                                    <span class="font-medium"><?= date('H:i', strtotime($pemesanan['waktu_berangkat'])) ?> - <?= date('H:i', strtotime($pemesanan['waktu_tiba'])) ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 flex items-center">
                                        <i class="fas fa-users mr-2 text-gray-400"></i> Penumpang:
                                    </span>
                                    <span class="font-medium"><?= $pemesanan['jumlah_penumpang'] ?></span>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <span class="font-bold text-blue-600">
                                    <i class="fas fa-tag mr-1"></i>
                                    Rp <?= number_format($pemesanan['total_harga'], 0, ',', '.') ?>
                                </span>
                                <a href="detail_pemesanan.php?id=<?= $pemesanan['id_pemesanan'] ?>" class="text-sm text-blue-500 hover:text-blue-700 font-medium flex items-center">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center mt-8">
                <a href="history.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 transition duration-300">
                    <i class="fas fa-list-ul mr-2"></i> Lihat Semua Riwayat
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Carousel Animation Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const carouselImages = document.querySelectorAll('.carousel img');
        let currentImage = 0;
        
        function showNextImage() {
            carouselImages[currentImage].classList.add('hidden');
            currentImage = (currentImage + 1) % carouselImages.length;
            carouselImages[currentImage].classList.remove('hidden');
        }
        
        // Start carousel
        setInterval(showNextImage, 5000);
        
        // Add animation to elements with fade-in class
        const fadeElements = document.querySelectorAll('.fade-in');
        fadeElements.forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });
    });
    </script>
</body>
</html>