<?php
session_start();
$page = "Maskapai";

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

$maskapai = query("SELECT * FROM maskapai");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Maskapai</title>
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
        
        .airline-logo {
            width: 100px;
            height: 60px;
            object-fit: contain;
            border-radius: 4px;
            background-color: #f9fafb;
            padding: 8px;
        }
        
        /* Action buttons */
        .action-btn {
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        /* Add button */
        .add-btn {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        }
        
        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(59, 130, 246, 0.4);
        }
        
        .add-btn:active {
            transform: translateY(0);
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
                <i class="fas fa-plane mr-2 text-blue-400"></i>
                Daftar Maskapai Penerbangan
            </h2>
        </div>

        <div class="flex justify-between items-center mb-6">
            <a href="tambah.php" class="add-btn inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-plus-circle mr-2"></i>
                Tambah Maskapai
            </a>
        </div>

        <div class="table-container animate-fade">
            <table class="min-w-full">
                <thead>
                    <tr class="table-header">
                        <th>No</th>
                        <th>Logo</th>
                        <th>Nama Maskapai</th>
                        <th>Kapasitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($maskapai as $data) : ?>
                    <tr class="table-row">
                        <td><?= $no; ?></td>
                        <td>
                            <img src="../../assets/images/<?= $data["logo_maskapai"]; ?>" 
                                 class="airline-logo" 
                                 alt="<?= $data["nama_maskapai"]; ?>">
                        </td>
                        <td class="font-medium"><?= $data["nama_maskapai"]; ?></td>
                        <td>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                                <i class="fas fa-users mr-1"></i>
                                <?= $data["kapasitas"]; ?>
                            </span>
                        </td>
                        <td>
                            <div class="flex space-x-2">
                                <a href="edit.php?id=<?= $data["id_maskapai"]; ?>" 
                                   class="action-btn bg-blue-500 text-white px-3 py-1 rounded-lg inline-flex items-center">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
                                <a href="hapus.php?id=<?= $data["id_maskapai"]; ?>" 
                                   class="action-btn bg-red-100 text-red-600 px-3 py-1 rounded-lg inline-flex items-center"
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
                text: "Data maskapai akan dihapus permanen!",
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
                row.style.transform = 'translateY(10px)';
                row.style.animation = `fadeIn 0.5s ease-out ${index * 0.05}s forwards`;
            });
        });
    </script>
</body>
</html>