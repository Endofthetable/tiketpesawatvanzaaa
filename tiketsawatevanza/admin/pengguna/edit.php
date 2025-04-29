<?php
$page = "Data Pengguna";
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

$id = $_GET["id"];
$pengguna = query("SELECT * FROM user WHERE id_user = '$id'")[0];

if (isset($_POST["edit"])) {
    if (edit($_POST) > 0) {
        echo "<script type='text/javascript'>
        setTimeout(function () { 
          Swal.fire({
              title: 'Berhasil!',
              text: 'Data pengguna berhasil diedit',
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
            text: 'Data pengguna gagal diedit',
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
    <title>Edit Pengguna</title>
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
        
        /* Role badge */
        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .role-badge.petugas {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .role-badge.penumpang {
            background-color: #dcfce7;
            color: #166534;
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
                <i class="fas fa-user-edit mr-2 text-blue-400"></i>
                Edit Data Pengguna
            </h2>
        </div>

        <form action="" method="POST" class="form-container p-6 animate-fade">
            <input type="hidden" name="id_user" value="<?= $pengguna["id_user"]; ?>">
            
            <div class="mb-6">
                <label for="username" class="form-label block font-medium mb-2">
                    <i class="fas fa-user mr-2 text-blue-500"></i>
                    Username
                </label>
                <input type="text" name="username" id="username" 
                    class="form-input w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    value="<?= $pengguna["username"]; ?>" required>
            </div>

            <div class="mb-6">
                <label for="nama_lengkap" class="form-label block font-medium mb-2">
                    <i class="fas fa-id-card mr-2 text-blue-500"></i>
                    Nama Lengkap
                </label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" 
                    class="form-input w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    value="<?= $pengguna["nama_lengkap"]; ?>" required>
            </div>

            <div class="mb-6">
                <label for="password" class="form-label block font-medium mb-2">
                    <i class="fas fa-lock mr-2 text-blue-500"></i>
                    Password
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password" 
                        class="form-input w-full p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        placeholder="Kosongkan jika tidak ingin mengubah password">
                    <button type="button" onclick="togglePassword()" 
                        class="absolute right-3 top-3 text-gray-500 hover:text-blue-500">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                <p class="text-sm text-gray-500 mt-1">Biarkan kosong untuk mempertahankan password saat ini</p>
            </div>

            <div class="mb-8">
                <label for="roles" class="form-label block font-medium mb-2">
                    <i class="fas fa-user-tag mr-2 text-blue-500"></i>
                    Role Pengguna
                </label>
                <div class="flex items-center space-x-4">
                    <span class="role-badge <?= $pengguna["roles"] === 'Petugas' ? 'petugas' : 'penumpang' ?>">
                        <i class="fas <?= $pengguna["roles"] === 'Petugas' ? 'fa-user-shield' : 'fa-user' ?> mr-1"></i>
                        <?= $pengguna["roles"]; ?>
                    </span>
                    <select name="roles" id="roles" 
                        class="form-input flex-1 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="<?= $pengguna["roles"]; ?>">Pilih role baru...</option>
                        <option value="Petugas">Petugas</option>
                        <option value="Penumpang">Penumpang</option>
                    </select>
                </div>
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
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.querySelector('#password + button i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        
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