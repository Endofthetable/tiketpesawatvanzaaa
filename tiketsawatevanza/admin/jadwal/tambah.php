<?php
$page = "Jadwal";

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

if (isset($_POST["tambah"])) {
    if (tambah($_POST) > 0) {
        echo "<script type='text/javascript'>
        setTimeout(function () { 
          Swal.fire({
              title: 'Berhasil!',
              text: 'Jadwal penerbangan berhasil ditambahkan',
              icon: 'success',
              showConfirmButton: false,
              timer: 2000,
              timerProgressBar: true,
              didOpen: () => {
                  const popup = Swal.getPopup();
                  popup.style.animation = 'fadeIn 0.5s ease-out';
              }
          });   
        },10);  
        window.setTimeout(function(){ 
          window.location.replace('index.php');
        }, 2000); 
        </script>";
    } else {
        echo "<script type='text/javascript'>
        Swal.fire({
            title: 'Gagal!',
            text: 'Jadwal penerbangan gagal ditambahkan',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3b82f6'
        }).then(() => {
            window.location = 'index.php';
        });
        </script>";
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
        
        /* Form styling */
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .form-container:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-input {
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }
        
        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        
        .form-label {
            color: var(--dark);
            transition: all 0.3s ease;
        }
        
        .submit-btn {
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        /* Select dropdown arrow */
        .select-arrow {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
        
        /* Time input styling */
        .time-input-container {
            position: relative;
        }
        
        .time-input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            pointer-events: none;
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
                <i class="fas fa-calendar-plus mr-2 text-blue-400"></i>
                Tambah Jadwal Penerbangan
            </h2>
        </div>

        <form action="" method="POST" class="form-container p-6 animate-fade">
            <div class="mb-6">
                <label for="id_rute" class="form-label block font-medium mb-2">
                    <i class="fas fa-route mr-2 text-blue-500"></i>
                    Rute Penerbangan
                </label>
                <select name="id_rute" id="id_rute" 
                    class="form-input w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 select-arrow" required>
                    <?php foreach ($rute as $data) : ?>
                        <option value="<?= $data["id_rute"]; ?>">
                            <?= $data["nama_maskapai"]; ?> - <?= $data["rute_asal"]; ?> ke <?= $data["rute_tujuan"]; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="waktu_berangkat" class="form-label block font-medium mb-2">
                        <i class="fas fa-plane-departure mr-2 text-blue-500"></i>
                        Waktu Berangkat
                    </label>
                    <div class="time-input-container">
                        <input type="time" name="waktu_berangkat" id="waktu_berangkat" 
                            class="form-input w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            required>
                        <i class="fas fa-clock time-input-icon"></i>
                    </div>
                </div>
                
                <div>
                    <label for="waktu_tiba" class="form-label block font-medium mb-2">
                        <i class="fas fa-plane-arrival mr-2 text-blue-500"></i>
                        Waktu Tiba
                    </label>
                    <div class="time-input-container">
                        <input type="time" name="waktu_tiba" id="waktu_tiba" 
                            class="form-input w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            required>
                        <i class="fas fa-clock time-input-icon"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label for="harga" class="form-label block font-medium mb-2">
                        <i class="fas fa-tag mr-2 text-blue-500"></i>
                        Harga Tiket
                    </label>
                    <input type="number" name="harga" id="harga" 
                        class="form-input w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        placeholder="Masukkan harga tiket" required>
                    <p class="text-sm text-gray-500 mt-1">Masukkan harga dalam rupiah (tanpa titik)</p>
                </div>
                
                <div>
                    <label for="kapasitas_kursi" class="form-label block font-medium mb-2">
                        <i class="fas fa-users mr-2 text-blue-500"></i>
                        Kapasitas Kursi
                    </label>
                    <input type="number" name="kapasitas_kursi" id="kapasitas_kursi" 
                        class="form-input w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        placeholder="Masukkan kapasitas kursi" required>
                    <p class="text-sm text-gray-500 mt-1">Jumlah kursi tersedia pada penerbangan ini</p>
                </div>
            </div>

            <div class="flex space-x-4">
                <a href="index.php" 
                   class="flex-1 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <button type="submit" name="tambah" 
                    class="flex-1 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i> Simpan Jadwal
                </button>
            </div>
        </form>
    </div>

    <script>
        // Add animation to form elements
        document.addEventListener('DOMContentLoaded', function() {
            const formInputs = document.querySelectorAll('.form-input, select');
            formInputs.forEach((input, index) => {
                input.style.opacity = '0';
                input.style.transform = 'translateY(10px)';
                input.style.animation = `fadeIn 0.5s ease-out ${index * 0.1}s forwards`;
            });
            
            // Time validation
            const departureTime = document.getElementById('waktu_berangkat');
            const arrivalTime = document.getElementById('waktu_tiba');
            
            departureTime.addEventListener('change', function() {
                if (arrivalTime.value && this.value >= arrivalTime.value) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Waktu tiba harus setelah waktu berangkat',
                        confirmButtonColor: '#3b82f6'
                    });
                    this.focus();
                }
            });
            
            arrivalTime.addEventListener('change', function() {
                if (departureTime.value && this.value <= departureTime.value) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Waktu tiba harus setelah waktu berangkat',
                        confirmButtonColor: '#3b82f6'
                    });
                    this.focus();
                }
            });
        });
    </script>
</body>
</html>