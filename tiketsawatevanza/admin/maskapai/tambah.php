<?php
$page = "Maskapai";

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
              text: 'Data maskapai berhasil ditambahkan',
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
            text: 'Data maskapai gagal ditambahkan',
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
    <title>Tambah Maskapai</title>
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
        
        /* File upload styling */
        .file-upload {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }
        
        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border: 2px dashed #e5e7eb;
            border-radius: 8px;
            background-color: #f9fafb;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-label:hover {
            border-color: var(--primary);
            background-color: var(--primary-light);
        }
        
        .file-upload-label i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .file-upload-label span {
            color: var(--gray);
            text-align: center;
        }
        
        .file-name {
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: var(--primary);
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
                Tambah Maskapai Baru
            </h2>
        </div>

        <form action="" method="POST" enctype="multipart/form-data" class="form-container p-6 animate-fade">
            <div class="mb-6">
                <label class="form-label block font-medium mb-2">
                    <i class="fas fa-image mr-2 text-blue-500"></i>
                    Logo Maskapai
                </label>
                <div class="file-upload">
                    <input type="file" name="logo_maskapai" id="logo_maskapai" class="file-upload-input" required>
                    <label for="logo_maskapai" class="file-upload-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Klik untuk mengunggah logo maskapai<br>atau drag and drop file di sini</span>
                        <span id="file-name" class="file-name"></span>
                    </label>
                </div>
            </div>

            <div class="mb-6">
                <label for="nama_maskapai" class="form-label block font-medium mb-2">
                    <i class="fas fa-building mr-2 text-blue-500"></i>
                    Nama Maskapai
                </label>
                <input type="text" name="nama_maskapai" id="nama_maskapai" 
                    class="form-input w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Masukkan nama maskapai" required>
            </div>

            <div class="mb-8">
                <label for="kapasitas" class="form-label block font-medium mb-2">
                    <i class="fas fa-users mr-2 text-blue-500"></i>
                    Kapasitas Penumpang
                </label>
                <input type="number" name="kapasitas" id="kapasitas" 
                    class="form-input w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Masukkan kapasitas penumpang" required>
                <p class="text-sm text-gray-500 mt-1">Masukkan jumlah maksimal penumpang yang dapat diangkut</p>
            </div>

            <div class="flex space-x-4">
                <a href="index.php" 
                   class="flex-1 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-center">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                <button type="submit" name="tambah" 
                    class="flex-1 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i> Simpan Maskapai
                </button>
            </div>
        </form>
    </div>

    <script>
        // Show selected file name
        document.getElementById('logo_maskapai').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'Belum ada file dipilih';
            document.getElementById('file-name').textContent = fileName;
        });
        
        // Add animation to form elements
        document.addEventListener('DOMContentLoaded', function() {
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