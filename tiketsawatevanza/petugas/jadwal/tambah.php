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

if (isset($_POST["tambah"])) {
    if (tambah($_POST) > 0) {
        echo "
            <script type='text/javascript'>
                alert('Data jadwal penerbangan berhasil ditambahkan!')
                window.location = 'index.php'
            </script>
        ";
    } else {
        echo "
            <script type='text/javascript'>
                alert('Data jadwal penerbangan gagal ditambahkan :(')
                window.location = 'index.php'
            </script>
        ";
    }
}

$rute = query("SELECT * FROM rute INNER JOIN maskapai ON maskapai.id_maskapai = rute.id_maskapai");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal Penerbangan</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        /* Custom animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        .delay-100 {
            animation-delay: 0.1s;
        }
        
        .delay-200 {
            animation-delay: 0.2s;
        }
        
        .delay-300 {
            animation-delay: 0.3s;
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
            border-color: #3b82f6;
        }
        
        .btn-hover {
            transition: all 0.3s ease;
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }
        
        .form-container {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen">
        <?php require '../../layouts/sidebarpetugas.php'; ?>
        
        <div class="flex-1 overflow-y-auto">
            <div class="p-8">
                <!-- Header -->
                <div class="mb-6 animate__animated animate__fadeIn">
                    <h1 class="text-2xl font-bold text-gray-800">Halo, <?= $_SESSION["nama_lengkap"]; ?>!</h1>
                    <h2 class="text-xl font-semibold text-gray-700 mt-1">Tambah Jadwal Penerbangan Baru</h2>
                </div>
                
                <!-- Form Container -->
                <div class="bg-white rounded-xl form-container p-6 animate__animated animate__fadeInUp">
                    <form action="" method="POST">
                        <!-- Route Selection -->
                        <div class="mb-6 fade-in">
                            <label for="id_rute" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-route text-blue-500 mr-2"></i> Pilih Rute Penerbangan
                            </label>
                            <select name="id_rute" id="id_rute" class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                                <?php foreach ($rute as $data) : ?>
                                    <option value="<?= $data["id_rute"]; ?>"><?= $data["nama_maskapai"]; ?> - <?= $data["rute_asal"]; ?> ke <?= $data["rute_tujuan"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Flight Times -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="fade-in delay-100">
                                <label for="waktu_berangkat" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-plane-departure text-blue-500 mr-2"></i> Waktu Berangkat
                                </label>
                                <input type="time" name="waktu_berangkat" id="waktu_berangkat" class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
                            </div>
                            
                            <div class="fade-in delay-150">
                                <label for="waktu_tiba" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-plane-arrival text-blue-500 mr-2"></i> Waktu Tiba
                                </label>
                                <input type="time" name="waktu_tiba" id="waktu_tiba" class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
                            </div>
                        </div>
                        
                        <!-- Price and Capacity -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="fade-in delay-200">
                                <label for="harga" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-tag text-blue-500 mr-2"></i> Harga Tiket
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                    <input type="number" name="harga" id="harga" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
                                </div>
                            </div>
                            
                            <div class="fade-in delay-250">
                                <label for="kapasitas_kursi" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-chair text-blue-500 mr-2"></i> Kapasitas Kursi
                                </label>
                                <input type="number" name="kapasitas_kursi" id="kapasitas_kursi" class="w-full px-4 py-2 border border-gray-300 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="mt-8 fade-in delay-300">
                            <button type="submit" name="tambah" class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg btn-hover hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all flex items-center justify-center">
                                <i class="fas fa-plus-circle mr-2"></i> Tambah Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to form elements
            const formElements = document.querySelectorAll('input, select, button');
            formElements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(10px)';
                el.style.animation = `fadeIn 0.5s ease-out ${index * 0.05 + 0.2}s forwards`;
            });
            
            // Add currency formatting to price input
            const hargaInput = document.getElementById('harga');
            if (hargaInput) {
                hargaInput.addEventListener('focus', function() {
                    this.value = this.value.replace(/\D/g, '');
                });
                
                hargaInput.addEventListener('blur', function() {
                    if (this.value) {
                        this.value = parseInt(this.value).toLocaleString('id-ID');
                    }
                });
            }
        });
    </script>
</body>
</html>