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

$id = $_GET["id"];
$rute = query("SELECT * FROM rute INNER JOIN maskapai ON maskapai.id_maskapai = rute.id_maskapai WHERE id_rute = '$id'")[0];

$maskapai = query("SELECT * FROM maskapai");
$kota = query("SELECT * FROM kota");

if (isset($_POST["edit"])) {
    if (edit($_POST) > 0) {
        echo "<script type='text/javascript'>
        setTimeout(function () { 
          Swal.fire({
              title: 'Berhasil!',
              text: 'Rute penerbangan berhasil diperbarui',
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
            text: 'Rute penerbangan gagal diperbarui',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3b82f6'
        }).then(() => {
            window.location = 'index.php';
        });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rute Penerbangan</title>
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
        
        /* Route visualization */
        .route-preview {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin: 20px 0;
            padding: 16px;
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px dashed #e2e8f0;
        }
        
        .route-city {
            padding: 8px 16px;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            text-align: center;
            min-width: 120px;
        }
        
        .route-city .city-name {
            font-weight: 600;
            color: var(--dark);
        }
        
        .route-city .airport-code {
            font-size: 0.75rem;
            color: var(--gray);
            text-transform: uppercase;
        }
        
        .route-arrow {
            color: var(--primary);
            font-size: 1.5rem;
        }
        
        /* Select dropdown styling */
        .select-container {
            position: relative;
        }
        
        .select-container i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--gray);
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
                Edit Rute Penerbangan
            </h2>
        </div>

        <form action="" method="POST" class="form-container p-6 animate-fade">
            <input type="hidden" name="id_rute" value="<?= $rute["id_rute"]; ?>">

            <div class="mb-6">
                <label for="id_maskapai" class="form-label block font-medium mb-2">
                    <i class="fas fa-plane mr-2 text-blue-500"></i>
                    Maskapai Penerbangan
                </label>
                <div class="select-container">
                    <select name="id_maskapai" id="id_maskapai" 
                        class="form-input w-full p-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="<?= $rute["id_maskapai"]; ?>"><?= $rute["nama_maskapai"]; ?></option>
                        <?php foreach ($maskapai as $data) : ?>
                            <option value="<?= $data["id_maskapai"]; ?>"><?= $data["nama_maskapai"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>

            <div class="mb-6">
                <label for="rute_asal" class="form-label block font-medium mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                    Kota Asal
                </label>
                <div class="select-container">
                    <select name="rute_asal" id="rute_asal" 
                        class="form-input w-full p-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="<?= $rute["rute_asal"]; ?>"><?= $rute["rute_asal"]; ?></option>
                        <?php foreach ($kota as $data) : ?>
                            <option value="<?= $data["nama_kota"]; ?>"><?= $data["nama_kota"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>

            <div class="mb-6">
                <label for="rute_tujuan" class="form-label block font-medium mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                    Kota Tujuan
                </label>
                <div class="select-container">
                    <select name="rute_tujuan" id="rute_tujuan" 
                        class="form-input w-full p-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="<?= $rute["rute_tujuan"]; ?>"><?= $rute["rute_tujuan"]; ?></option>
                        <?php foreach ($kota as $data) : ?>
                            <option value="<?= $data["nama_kota"]; ?>"><?= $data["nama_kota"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>

            <!-- Route Preview -->
            <div class="route-preview" id="routePreview">
                <div class="route-city">
                    <div class="city-name" id="previewAsal"><?= $rute["rute_asal"]; ?></div>
                    <div class="airport-code" id="previewAsalCode"><?= substr($rute["rute_asal"], 0, 3); ?></div>
                </div>
                <div class="route-arrow">
                    <i class="fas fa-long-arrow-alt-right"></i>
                </div>
                <div class="route-city">
                    <div class="city-name" id="previewTujuan"><?= $rute["rute_tujuan"]; ?></div>
                    <div class="airport-code" id="previewTujuanCode"><?= substr($rute["rute_tujuan"], 0, 3); ?></div>
                </div>
            </div>

            <div class="mb-6">
                <label for="tanggal_pergi" class="form-label block font-medium mb-2">
                    <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                    Tanggal & Waktu Keberangkatan
                </label>
                <input type="datetime-local" name="tanggal_pergi" id="tanggal_pergi" 
                    value="<?= date('Y-m-d\TH:i', strtotime($rute["tanggal_pergi"])); ?>" 
                    class="form-input w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="flex space-x-4">
                <a href="index.php" 
                   class="flex-1 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <button type="submit" name="edit" 
                    class="flex-1 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        // Update route preview
        function updateRoutePreview() {
            const asalSelect = document.getElementById('rute_asal');
            const tujuanSelect = document.getElementById('rute_tujuan');
            
            document.getElementById('previewAsal').textContent = asalSelect.value;
            document.getElementById('previewTujuan').textContent = tujuanSelect.value;
            
            // Update airport codes
            document.getElementById('previewAsalCode').textContent = asalSelect.value.substring(0, 3).toUpperCase();
            document.getElementById('previewTujuanCode').textContent = tujuanSelect.value.substring(0, 3).toUpperCase();
        }
        
        // Initialize and add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Set up route preview
            updateRoutePreview();
            document.getElementById('rute_asal').addEventListener('change', updateRoutePreview);
            document.getElementById('rute_tujuan').addEventListener('change', updateRoutePreview);
            
            // Add animation to form elements
            const formInputs = document.querySelectorAll('.form-input');
            formInputs.forEach((input, index) => {
                input.style.opacity = '0';
                input.style.transform = 'translateY(10px)';
                input.style.animation = `fadeIn 0.5s ease-out ${index * 0.1}s forwards`;
            });
        });
    </script>
</body>
</html>