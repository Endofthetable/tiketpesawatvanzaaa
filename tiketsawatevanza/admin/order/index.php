<?php
$page = "Tiket";

session_start();
require 'functions.php';
require '../../koneksi.php';

if (!isset($_SESSION["username"])) {
    echo "
    <script type='text/javascript'>
        Swal.fire({
            icon: 'warning',
            title: 'Login Required',
            text: 'Silahkan login terlebih dahulu, ya!',
            confirmButtonColor: '#3b82f6'
        }).then(() => {
            window.location = '../auth/login/index.php';
        });
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
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary: #3b82f6;
            --primary-light: #eff6ff;
            --dark: #1f2937;
            --light: #f9fafb;
            --gray: #6b7280;
            --success: #10b981;
            --warning: #f59e0b;
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
        
        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
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
            background-color: #fef3c7;
            color: #92400e;
        }
        
        /* Action buttons */
        .action-btn {
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
        }
        
        .verify-btn {
            background-color: var(--success);
            color: white;
        }
        
        .verify-btn:hover {
            background-color: #0d9f6e;
            transform: translateY(-1px);
        }
        
        /* Header styling */
        .page-header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body class="flex bg-gray-50">
    <?php require '../../layouts/sidebar.php'; ?>
    
    <div class="flex-1 overflow-y-auto p-6 animate-slide">
        <!-- Header -->
        <div class="page-header animate-fade">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-user-circle mr-3 text-blue-500"></i>
                Halo, <?= $_SESSION["nama_lengkap"]; ?>!
            </h1>
            <h2 class="text-xl font-semibold text-gray-600 mt-2 flex items-center">
                <i class="fas fa-ticket-alt mr-2 text-blue-400"></i>
                Order Tiket Penerbangan
            </h2>
        </div>
        
        <!-- Table Container -->
        <div class="table-container animate-fade" style="animation-delay: 0.1s">
            <table class="min-w-full">
                <thead class="table-header">
                    <tr>
                        <th class="w-32">
                            <i class="fas fa-receipt mr-2"></i> No. Order
                        </th>
                        <th>
                            <i class="fas fa-user mr-2"></i> ID User
                        </th>
                        <th>
                            <i class="fas fa-user-tag mr-2"></i> Username
                        </th>
                        <th>
                            <i class="fas fa-file-invoice mr-2"></i> Struk
                        </th>
                        <th>
                            <i class="fas fa-check-circle mr-2"></i> Status
                        </th>
                        <th class="w-40">
                            <i class="fas fa-cog mr-2"></i> Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderTiket as $index => $data) : ?>
                    <tr class="table-row" style="animation: fadeIn 0.5s ease-out <?= $index * 0.05 + 0.2 ?>s forwards">
                        <td class="font-medium text-gray-900">
                            #<?= $data["id_order"]; ?>
                        </td>
                        <td class="text-gray-600">
                            <?= $data["id_user"]; ?>
                        </td>
                        <td class="text-gray-900">
                            <?= $data["username"]; ?>
                        </td>
                        <td class="text-gray-600">
                            <?= $data["struk"]; ?>
                        </td>
                        <td>
                            <span class="status-badge <?= strtolower($data["status"]) === 'approved' ? 'approved' : 'pending'; ?>">
                                <?= $data["status"]; ?>
                            </span>
                        </td>
                        <td>
                            <a href="verif.php?id=<?= $data["id_order"]; ?>" 
                               class="action-btn verify-btn"
                               onclick="return confirmVerification()">
                                <i class="fas fa-check-circle mr-1"></i> Verifikasi
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmVerification() {
            return Swal.fire({
                title: 'Verifikasi Order',
                text: "Apakah anda yakin ingin memverifikasi order ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Verifikasi',
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
            });
        });
    </script>
</body>
</html>