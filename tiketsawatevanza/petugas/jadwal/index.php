<?php
$page = "Jadwal";

session_start();
require 'functions.php';

if (!isset($_SESSION["username"])) {
    echo "
    <script type='text/javascript'>
        alert('Silahkan login terlebih dahulu, ya!');
        window.location = '../../auth/login/index.php';
    </script>
    ";
}

$jadwal = query("SELECT * FROM jadwal_penerbangan 
INNER JOIN rute ON rute.id_rute = jadwal_penerbangan.id_rute 
INNER JOIN maskapai ON rute.id_maskapai = maskapai.id_maskapai ORDER BY tanggal_pergi, waktu_berangkat");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jadwal Penerbangan</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Custom animations */
        @keyframes fadeIn {
            from { 
                opacity: 0;
                transform: translateY(15px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes floatIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            60% {
                opacity: 1;
                transform: translateY(-5px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-float-in {
            animation: floatIn 0.8s cubic-bezier(0.22, 0.61, 0.36, 1) forwards;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .hover-scale {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        .hover-scale:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .table-row {
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(15px);
        }
        
        .action-link {
            transition: all 0.2s ease;
            display: inline-block;
        }
        
        .action-link:hover {
            transform: translateX(3px);
        }
        
        /* Smooth scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <?php require '../../layouts/sidebarpetugas.php'; ?>
        
        <div class="flex-1 overflow-y-auto overflow-x-hidden">
            <div class="p-8">
                <!-- Header -->
                <div class="mb-8 animate-float-in" style="animation-delay: 0.1s">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Halo, <?= $_SESSION["nama_lengkap"]; ?>!</h1>
                            <h2 class="text-xl font-semibold text-gray-700 mt-1">Data Jadwal Penerbangan</h2>
                        </div>
                        <a href="tambah.php" class="mt-4 md:mt-0 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all hover:shadow-md flex items-center animate-float-in" style="animation-delay: 0.2s">
                            <i class="fas fa-plus mr-2"></i> Tambah Jadwal
                        </a>
                    </div>
                </div>
                
                <!-- Table Container -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden animate-float-in" style="animation-delay: 0.3s">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-hashtag mr-1"></i> No
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-plane mr-1"></i> Maskapai
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-users mr-1"></i> Kapasitas
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-route mr-1"></i> Rute
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="far fa-calendar-alt mr-1"></i> Tanggal
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="far fa-clock mr-1"></i> Waktu
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-money-bill-wave mr-1"></i> Harga
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase tracking-wider">
                                        <i class="fas fa-cog mr-1"></i> Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $no = 1; ?>
                                <?php foreach ($jadwal as $data) : ?>
                                <tr class="table-row hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $no; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center hover-scale">
                                                <i class="fas fa-plane text-blue-600"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?= $data["nama_maskapai"]; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $data["kapasitas_kursi"]; ?> Kursi
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= $data["rute_asal"]; ?></div>
                                        <div class="text-xs text-gray-500">
                                            <i class="fas fa-long-arrow-alt-right mr-1"></i> <?= $data["rute_tujuan"]; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('d M Y', strtotime($data["tanggal_pergi"])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= $data["waktu_berangkat"]; ?></div>
                                        <div class="text-xs text-gray-500">
                                            <i class="fas fa-arrow-down mr-1"></i> <?= $data["waktu_tiba"]; ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        Rp <?= number_format($data["harga"]); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <a href="edit.php?id=<?= $data["id_jadwal"]; ?>" class="text-blue-600 hover:text-blue-800 action-link">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            <a href="hapus.php?id=<?= $data["id_jadwal"]; ?>" class="text-red-600 hover:text-red-800 action-link" onClick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $no++; ?>
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
                row.style.transform = 'translateY(15px)';
                
                // Animate with delay
                setTimeout(() => {
                    row.style.transition = 'opacity 0.6s ease-out, transform 0.6s cubic-bezier(0.22, 0.61, 0.36, 1)';
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