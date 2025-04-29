<?php require 'layouts/navbar.php'; ?>
<?php 
$id_user = $_SESSION["id_user"];
$orderTiket = mysqli_query($conn, "SELECT order_tiket.id_order, order_tiket.struk, order_tiket.tanggal_transaksi, order_tiket.status 
FROM order_tiket 
INNER JOIN order_detail ON order_tiket.id_order = order_detail.id_order
WHERE order_detail.id_user = '$id_user' 
GROUP BY order_tiket.id_order, order_tiket.struk, order_tiket.tanggal_transaksi, order_tiket.status");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Pemesanan</title>
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
    </style>
</head>
<body>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 fade-in">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">Riwayat Pemesanan</h1>
            <div class="flex items-center space-x-2">
                <i class="fas fa-history text-blue-500"></i>
                <span class="text-sm text-gray-500">Terakhir diperbarui: <?= date('H:i') ?></span>
            </div>
        </div>
        
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
                                    <i class="far fa-calendar-alt mr-2 text-gray-400"></i>
                                    Tanggal
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
                                    <i class="fas fa-cog mr-2 text-gray-400"></i>
                                    Opsi
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php foreach($orderTiket as $index => $data) : ?> 
                            <tr class="row-hover-animation <?= $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' ?>">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #<?= $data["id_order"]; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $data["struk"]; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= date('d M Y', strtotime($data["tanggal_transaksi"])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium <?= $data["status"] === 'Approved' ? 'status-approved' : 'status-pending' ?>">
                                        <i class="fas <?= $data["status"] === 'Approved' ? 'fa-check-circle' : 'fa-clock' ?> mr-1"></i>
                                        <?= $data["status"]; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="detailPemesanan.php?id=<?= $data["id_order"]; ?>" class="detail-link text-blue-500 hover:text-blue-700 flex items-center">
                                        <i class="fas fa-eye mr-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php if(mysqli_num_rows($orderTiket) === 0): ?>
            <div class="text-center py-12 fade-in">
                <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">Belum ada riwayat pemesanan</h3>
                <p class="mt-1 text-sm text-gray-500">Semua pemesanan Anda akan muncul di sini.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        // Add animation to table rows with delay
        document.addEventListener('DOMContentLoaded', () => {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.05}s`;
            });
        });
    </script>
</body>
</html>