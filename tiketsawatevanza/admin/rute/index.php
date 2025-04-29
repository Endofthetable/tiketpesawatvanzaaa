<?php
$page = "Rute";
session_start();
require 'functions.php';

if (!isset($_SESSION["username"])) {
    echo "
    <script type='text/javascript'>
        Swal.fire({
            icon: 'warning',
            title: 'Login Required',
            text: 'Silahkan login terlebih dahulu, ya!',
            confirmButtonColor: '#3b82f6'
        }).then(() => {
            window.location = '../../auth/login/index.php';
        });
    </script>
    ";
}

$rute = query("SELECT * FROM rute INNER JOIN maskapai ON maskapai.id_maskapai = rute.id_maskapai ORDER BY rute_asal");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Rute Penerbangan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #3b82f6;
            --primary-light: #eff6ff;
            --dark: #1f2937;
            --light: #f9fafb;
            --gray: #6b7280;
        }
        
        body {
            background-color: #f3f4f6;
            color: var(--dark);
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-fade {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .animate-slide {
            animation: slideIn 0.6s ease-out forwards;
        }
        
        /* Table styling */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .table-header {
            background-color: var(--primary);
            color: white;
        }
        
        .table-header th {
            padding: 12px 16px;
            font-weight: 600;
            text-align: left;
        }
        
        .table-row {
            transition: all 0.2s ease;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .table-row:hover {
            background-color: var(--primary-light);
        }
        
        .table-row td {
            padding: 12px 16px;
            vertical-align: middle;
        }
        
        /* Route visualization */
        .route-visual {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 200px;
        }
        
        .route-point {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .route-point .city {
            font-weight: 600;
            color: var(--dark);
        }
        
        .route-point .airport {
            font-size: 0.75rem;
            color: var(--gray);
        }
        
        .route-arrow {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: var(--primary);
        }
        
        .route-arrow i {
            font-size: 1.25rem;
            margin: 4px 0;
        }
        
        .route-arrow .duration {
            font-size: 0.75rem;
            color: var(--gray);
        }
        
        /* Action buttons */
        .action-container {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }
        
        .action-btn {
            transition: all 0.2s ease;
            min-width: 80px;
            text-align: center;
            padding: 6px 8px;
            font-size: 14px;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        /* Add button */
        .add-btn {
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
        }
        
        .add-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.4);
        }
        
        /* Airline badge */
        .airline-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 9999px;
            background-color: #f0f9ff;
            color: #0369a1;
        }
        
        .airline-badge i {
            margin-right: 4px;
        }
    </style>
</head>
<body class="flex">
    <?php require '../../layouts/sidebar.php'; ?>

    <div class="flex-1 p-6 animate-slide">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-user-circle mr-3 text-blue-500"></i>
                Halo, <?= $_SESSION["nama_lengkap"]; ?>!
            </h1>
            <h2 class="text-xl font-semibold text-gray-600 mt-2 flex items-center">
                <i class="fas fa-route mr-2 text-blue-400"></i>
                Manajemen Rute Penerbangan
            </h2>
        </div>

        <div class="flex justify-between items-center mb-6">
            <a href="tambah.php" class="add-btn inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-plus-circle mr-2"></i>
                Tambah Rute
            </a>
        </div>

        <div class="table-container animate-fade">
            <table class="min-w-full">
                <thead>
                    <tr class="table-header">
                        <th class="w-16">No</th>
                        <th>Maskapai</th>
                        <th>Rute</th>
                        <th>Tanggal Pergi</th>
                        <th class="w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($rute as $data) : ?>
                    <tr class="table-row">
                        <td><?= $no; ?></td>
                        <td>
                            <div class="airline-badge">
                                <i class="fas fa-plane"></i>
                                <?= $data["nama_maskapai"]; ?>
                            </div>
                        </td>
                        <td>
                            <div class="route-visual">
                                <div class="route-point">
                                    <span class="city"><?= $data["rute_asal"]; ?></span>
                                    <span class="airport"><?= substr($data["rute_asal"], 0, 3); ?> Airport</span>
                                </div>
                                <div class="route-arrow">
                                    <i class="fas fa-long-arrow-alt-right"></i>
                                </div>
                                <div class="route-point">
                                    <span class="city"><?= $data["rute_tujuan"]; ?></span>
                                    <span class="airport"><?= substr($data["rute_tujuan"], 0, 3); ?> Airport</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?= date('d M Y', strtotime($data["tanggal_pergi"])); ?>
                            <div class="text-sm text-gray-500">
                                <!-- <?= date('H:i', strtotime($data["tanggal_pergi"])); ?> WIB -->
                            </div>
                        </td>
                        <td>
                            <div class="action-container">
                                <a href="edit.php?id=<?= $data["id_rute"]; ?>" 
                                   class="action-btn bg-blue-500 text-white rounded-lg inline-flex items-center justify-center">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                <a href="hapus.php?id=<?= $data["id_rute"]; ?>" 
                                   class="action-btn bg-red-100 text-red-600 rounded-lg inline-flex items-center justify-center"
                                   onClick="return confirmDelete()">
                                    <i class="fas fa-trash-alt mr-1"></i>
                                    Hapus
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

    <script>
        // Custom delete confirmation
        function confirmDelete() {
            return Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data rute akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                return result.isConfirmed;
            });
        }
        
        // Add animation to table rows
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.table-row');
            rows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(8px)';
                row.style.animation = `fadeIn 0.4s ease-out ${index * 0.04}s forwards`;
            });
            
            // Simple search functionality
            const searchInput = document.querySelector('.search-bar');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.table-row');
                
                rows.forEach(row => {
                    const routeInfo = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    const airline = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    if (routeInfo.includes(searchTerm) || airline.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>