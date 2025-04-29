<?php
$page = "Tiket";

session_start();
require 'functions.php';
require '../../koneksi.php';

if (!isset($_SESSION["username"])) {
    echo "
    <script type='text/javascript'>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = '../auth/login/index.php';
    </script>
    ";
}

$orderTiket = query("SELECT ot.*, od.id_user, u.username 
                     FROM order_tiket ot
                     JOIN order_detail od ON ot.id_order = od.id_order
                     JOIN user u ON od.id_user = u.id_user");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tiket</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Custom animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes floatIn {
            0% { opacity: 0; transform: translateY(15px); }
            60% { opacity: 1; transform: translateY(-3px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .animate-float-in {
            animation: floatIn 0.6s cubic-bezier(0.22, 0.61, 0.36, 1) forwards;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .table-row {
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(10px);
        }
        
        .hover-scale {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        .hover-scale:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .action-link {
            transition: all 0.2s ease;
        }
        
        .action-link:hover {
            transform: translateX(3px);
        }
        
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .approved {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .pending {
            background-color: #fef9c3;
            color: #854d0e;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <?php require '../../layouts/sidebarpetugas.php'; ?>
        
        <div class="flex-1 overflow-y-auto">
            <div class="p-8">
                <!-- Header -->
                <div class="mb-8 animate-float-in" style="animation-delay: 0.1s">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Halo, <?= $_SESSION["nama_lengkap"]; ?>!</h1>
                            <h2 class="text-xl font-semibold text-gray-700 mt-1">Order Tiket Penerbangan</h2>
                        </div>
                    </div>
                </div>
                
                <!-- Table Container -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden animate-float-in" style="animation-delay: 0.2s">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-receipt mr-1"></i> Nomor Order
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-user mr-1"></i> ID User
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-user-tag mr-1"></i> Username
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-file-invoice mr-1"></i> Struk
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-check-circle mr-1"></i> Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-cog mr-1"></i> Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($orderTiket as $data) : ?>
                                <tr class="table-row hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        #<?= $data["id_order"]; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $data["id_user"]; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?= $data["username"]; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $data["struk"]; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="status-badge <?= $data["status"] === 'Approved' ? 'approved' : 'pending'; ?>">
                                            <?= $data["status"]; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="verif.php?id=<?= $data["id_order"]; ?>" class="text-blue-600 hover:text-blue-800 action-link" onClick="return confirm('Apakah anda yakin ingin memverifikasi data ini?')">
                                            <i class="fas fa-check-circle mr-1"></i> Verifikasi
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate table rows with staggered delay
            const rows = document.querySelectorAll('.table-row');
            rows.forEach((row, index) => {
                // Set initial state
                row.style.opacity = '0';
                row.style.transform = 'translateY(10px)';
                
                // Animate with delay
                setTimeout(() => {
                    row.style.transition = 'opacity 0.5s ease-out, transform 0.5s cubic-bezier(0.22, 0.61, 0.36, 1)';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, 100 + (index * 50));
            });
            
            // Smooth scroll to top on page load
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</body>
</html>